<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    public function addJobs(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'service_id' => 'required|exists:services,id',
            'title' => 'required',
        ]);
        $vendor = Vendor::where('user_id', Auth::user()->id)->first();

        $jobs = new Job();
        $jobs->vendor_id = $vendor->id;
        $jobs->service_id = $request->service_id;
        $jobs->category_id = $request->category_id;
        $jobs->title = $request->title;
        $jobs->desc = $request->desc;
        $jobs->bid = $request->bid ?? 0;
        if ($request->hasFile('image')) {
            $jobs->image = $request->image->store('image/jobs');
        }
        $jobs->idk = $request->idk == 'true';
        $jobs->save();
        return response([
            'jobs' => $jobs,
            'status' => true
        ]);
    }

    public function editJobs(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'service_id' => 'required|exists:services,id',
            'title' => 'required',
        ]);

        $vendor = Vendor::where('user_id', Auth::user()->id)->first();

        $jobs = Job::where('id', $request->id)->first();

        if ($jobs->vendor_id == $vendor->id) {

            $jobs->vendor_id = $vendor->id;
            $jobs->service_id = $request->service_id;
            $jobs->title = $request->title;
            $jobs->desc = $request->desc;
            $jobs->bid = $request->bid;

            if ($request->hasFile('image')) {
                // unlink($jobs->image);
                $jobs->image = $request->image->store('image/jobs');
            }
            $jobs->idk = $request->idk == 'true';
            $jobs->save();
            return response([
                'jobs' => $jobs,
                'message' => 'Updated sucessfully',
                'status' => true
            ]);
        } else {
            return response([
                'message' => 'you dont have premission',
                'status' => false
            ]);
        }
    }

    public function deleteJob(Request $request)
    {
        $vendor = Vendor::where('user_id', Auth::user()->id)->first();
        $jobs = Job::where('id', $request->id)->first();
        if ($jobs->vendor_id == $vendor->id) {
            $jobs->delete();
            // unlink('$jobs->image');
            return response([
                'message' => 'delete sucessfully',
                'status' => true
            ]);
        } else {
            return response([
                'message' => 'you dont have premission',
                'status' => false
            ]);
        }
    }

    public function myJob()
    {
        $user = Auth::user();
        $vendor = Vendor::where('user_id', $user->id)->first();
        if($vendor->type==2){
            $localJobs = DB::select('select j.*,(Select count(*) from job_bids where job_id=j.id) as bids from jobs j where j.vendor_id in (select id from vendors where city_id=?) and j.service_id=?',[$vendor->city_id,$vendor->service_id]);
            return response([
                'job' => $localJobs,
                'status' => true
            ]);
        }else{
            $jobs = DB::select('select j.*,(Select count(*) from job_bids where job_id=j.id) as bids from jobs j where j.vendor_id= ?',[$vendor->id]);
            return response([
                'jobs' => $jobs,
                'status' => true
            ]);
        }
    }

    public function jobBids(Request $request){
        $vendor_id = getVendor()->id;
        $checkBids = JobBid::where(['vendor_id' => $vendor_id,'job_id' => $request->job_id])->first();
        if($checkBids!=null){
            $checkBids->amount = $request->amount;
            $checkBids->save();
            return response([
                'status' => true,
                'message' => 'Bids updated successfully'
            ]);
        }else{
            $jobBids = new JobBid();
            $jobBids->job_id = $request->job_id;
            $jobBids->vendor_id = $vendor_id;
            $jobBids->amount = $request->amount;
            $jobBids->save();
            return response([
                'status' => true,
                'message' => 'Bids added successfully'
            ]);
        }
    }

    public function jobBidList(Request $request){

        $bids = DB::table('job_bids')->where('job_id',$request->job_id)
        ->join('vendors','vendors.id','job_bids.vendor_id')
        ->join('users','users.id','=','vendors.user_id')
        ->select('vendors.*','job_bids.amount','users.name')->get();


        $skills = DB::table('skills')->whereIn('user_id',$bids->pluck('user_id'))
        ->select('skills.title','skills.type','skills.user_id')->get();

        $certificates = DB::table('certificates')->whereIn('user_id',$bids->pluck('user_id'))
        ->select('certificates.title','certificates.image','certificates.user_id')->get();

        foreach ($bids as $key => $bid) {
           $bid->skills = $skills->where('user_id',$bid->user_id);
           $bid->certificates = $certificates->where('user_id',$bid->user_id);
        }

        return response([
            'bids' => $bids,
            'status' => true
        ]);
    }

    // ,'vendors.*','job_bids.id','jobs.title','users.name','job_bids.amount'

    public function myBidsList(){
        $vendor_id = getVendor()->id;
        $bids = DB::table('job_bids')->where('job_bids.vendor_id',$vendor_id)
        ->join('jobs','jobs.id','=','job_bids.job_id')
        ->join('vendors','vendors.id','=','job_bids.vendor_id')
        ->select('vendors.*','job_bids.job_id','jobs.title','jobs.image','job_bids.amount')->where('jobs.status',0)->get();
        return response([
            'bids' => $bids,
            'status' => true
        ]);
    }

    // public function runningJob(Request $request){
    //     $jobs = Job::where('vendor_id',getVendor()->id)->where('status',1)->orWhere('status',2)->latest()->get();
    //     return response([
    //         'bids' => $bid,
    //         'status' => true
    //     ]);
    // }

    public function jobwiseBids(Request $request){
        $vendor_id = getVendor()->id;
        $bid = DB::table('job_bids')->where('job_bids.vendor_id',$vendor_id)->where('job_bids.job_id',$request->job_id)
        ->select('job_bids.id','job_bids.amount')->first();
        return response([
            'bids' => $bid,
            'status' => true
        ]);
    }


    public function acceptBid(Request $request){
        $vendor_id = getVendor()->id;
        $job = Job::where('id',$request->job_id)->where('vendor_id',$vendor_id)->first();
        // dd($job);
        $job->status=1;
        $job->save();
        $bid = JobBid::where('job_id',$request->job_id)->where('vendor_id',$request->bider_id)->first();
        $bid->status=1;
        $bid->save();
        return response([
            'message' => 'Job bid accepted',
            'status' => true
        ]);
    }

    public function jobBidRequestdList(){
        $vendor_id = getVendor()->id;
        // $req = Job::where('vendor_id',$vendor_id)->latest()->get();
        // $jobBid = JobBid::whereIn('job_id',$req->pluck('id'))->get();
        // $jobs = Job::whereIn('id',$jobBid->pluck('job_id'))->where('status',0)->get();
        $jobs = DB::table('job_bids')
        ->join('jobs','jobs.id','=','job_bids.job_id')->where('jobs.vendor_id',$vendor_id)->select('jobs.*')->get();
        return response([
            'jobs' => $jobs,
            'status' => true
        ]);

    }

    public function jobFinishedRequest(Request $req){
        $job = Job::where('id',$req->job_id)->first();
        $job->status = 2;
        $job->save();
        return response([
            'msg' => 'request sent successfully',
            'status' => true
        ]);
    }

    public function acceptJobFinishedRequest(Request $req){
        // $job = Job::where('id',$req->job_id)->first();
        // $job->status = 3;
        // $job->save();
        $user = Auth::user();
        $review = new Review();
        $review->vendor_id = $req->vendor_id;
        $review->user_id = $user->id;
        $review->rate = $req->rating;
        $review->desc = $req->desc;
        $review->save();

        $job = Job::where('id',$req->job_id)->first();
        $job->status = 3;
        $job->save();

        $pay = new Payment();
        $pay->vendor_id = $req->vendor_id;
        $pay->user_id = $user->id;
        $pay->type = $req->type;
        $pay->job_id = $req->job_id;
        $pay->amount = $req->amount;

        if($req->type == 0){
            $pay->status = 2;
        }else{
            $pay->status = 1;
            $pay->reference_id = '#'.$req->job_id;
        }
        $pay->save();
        return response([
            'msg' => 'request accept successfully',
            'data' => [$review,$pay],
            'status' => true
        ]);
    }

    public function JobBidRequestList(){
        $jobbids = JobBid::where('vendor_id',getVendor()->id)->get();
        $jobs = Job::whereIn('id',$jobbids->pluck('job_id'))->where('status',0)->get();
        return response([
            'jobs' => $jobs,
            'status' => true
        ]);
    }

    public function userFinishedJobs(){
        $vendor = getVendor();
        // $jobs = Job::where('vendor_id',$vendor->id)->where('status',3)->latest()->get();
        $jobs = DB::table('jobs')->where('jobs.vendor_id',$vendor->id)->where('jobs.status',3)
        ->join('payments','payments.job_id','=','jobs.id')->select('jobs.*','payments.received as pay_received','payments.status as pay_status','payments.amount')->get();
        // dd($jobs);
        return response([
            'jobs' => $jobs,
            'status' => true
        ]);

    }

    public function vendorFinishedJobs(){
        $vendor = getVendor()->id;
        $bids = DB::table('job_bids')->where('vendor_id',$vendor)->where('status',1)->get();
        // $jobs = Job::whereIn('id',$bids->pluck('job_id'))->where('status',3)->get();
        $jobs = DB::table('jobs')->whereIn('jobs.id',$bids->pluck('job_id'))->where('jobs.status',3)
        ->join('payments','payments.job_id','=','jobs.id')->select('jobs.*','payments.received as pay_received','payments.status as pay_status','payments.amount','payments.id as payment_id')->get();
        return response([
            'jobs' => $jobs,
            'status' => true
        ]);

    }

    public function acceptPayment(Request $req){
        $pay = Payment::where('id',$req->payment_id)->first();
        $pay->received = 1;
        $pay->save();
        return response([
            'msg' => 'payment accepted',
            'status' => true
        ]);
    }

}
