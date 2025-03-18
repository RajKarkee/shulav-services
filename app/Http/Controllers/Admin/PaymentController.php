<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(){
        $payments = DB::table('payments')
        ->join('jobs','jobs.id','=','payments.job_id')->select('payments.*','jobs.title')->where('payments.status',1)->get();
        return view('admin.payments.index',compact('payments'));
    }

    public function store($id){
        $payment =Payment::where('id',$id)->first();
        $payment->status = 2;
        $comm_amt = ($payment->amount * env('commission_percentage',10))/100;
        $payment->commission = $comm_amt;
        $payment->amount = $payment->amount -$comm_amt;
        $payment->save();
        return redirect()->back()->with('success','Saved successfully!');
    }
}
