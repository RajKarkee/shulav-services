<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function step(Request $request)
    {
        if ($request->getMethod() == "GET") {
            $steps = getSetting('front.step') ?? (object)([
                'step1' => (object) [
                    'title' => '',
                    'text' => '',
                ],
                'step2' => (object)[
                    'title' => '',
                    'text' => '',
                ],
                'step3' => (object)[
                    'title' => '',
                    'text' => '',
                ],
                'step4' => (object) [
                    'title' => '',
                    'text' => '',
                ]
            ]
            );

            // dd($steps);
            return view('admin.setting.step', compact('steps'));
        } else {
            $steps = [
                'step1' => [
                    'title' => $request->step1_title,
                    'text' => $request->step1_text,
                ],
                'step2' => [
                    'title' => $request->step2_title,
                    'text' => $request->step2_text,
                ],
                'step3' => [
                    'title' => $request->step3_title,
                    'text' => $request->step3_text,
                ],
                'step4' => [
                    'title' => $request->step4_title,
                    'text' => $request->step4_text,
                ]
            ];
            setSetting('front.step', $steps);
            $this->renderHow();
            return redirect()->back()->with('message', 'Setting Saved Sucessfully');
        }
    }

    public function minor(Request $request)
    {
        if ($request->getMethod() == "GET") {
            $data = getSetting('minor') ?? (object)([
                'logo' => '',
                'footer_logo' => '',
                'play_store' => '',
                'social_links' => [
                    'Facebook' => '#',
                    'Twitter' => '#',
                    'Instagram' => '#',
                    'Youtube' => '#',
                    'LinkedIN' => '#',
                    'Telegram' => '#',
                ],
                'email' => [],
                'phone' => [],
                'address' => '',
                'company' => '',

            ]);

            // dd($data);
            return view('admin.setting.minor', compact('data'));
        } else {
            $olddata = getSetting('minor') ?? (object)([
                'logo' => '',
                'footer_logo' => '',
            ]);
            $logo = $olddata->logo;
            $phone = [];
            $email = [];
            $footer_logo = $olddata->footer_logo;
            $address = $request->address ?? '';
            $company = $request->company ?? '';
            $play_store = $request->play_store ?? '';
            if ($request->hasFile('logo')) {
                $logo = $request->logo->store('uploads/setting');
            }
            if ($request->hasFile('footer_logo')) {
                $footer_logo = $request->footer_logo->store('uploads/setting');
            }
            $social_links = [
                'Facebook' => $request->Facebook ?? '#',
                'Twitter' =>  $request->Twitter ?? '#',
                'Instagram' =>  $request->Instagram ?? '#',
                'Youtube' =>  $request->Youtube ?? '#',
                'LinkedIN' =>  $request->LinkedIN ?? '#',
                'Telegram' =>  $request->Telegram ?? '#',
            ];
            if ($request->has('phone')) {
                foreach ($request->phone as $key => $value) {
                    array_push($phone, $request->input('title_' . $value) ?? "");
                }
            }
            if ($request->has('email')) {
                foreach ($request->email as $key => $value) {
                    array_push($email, $request->input('title_' . $value) ?? "");
                }
            }

            $data = [
                'logo' => $logo,
                'footer_logo' => $footer_logo,
                'social_links' => $social_links,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'company' => $company,
                'play_store' => $play_store,

            ];
            setSetting("minor", $data);
            writeView('front.index.footer', 'admin.setting.template.footer');
            writeView('front.index.menu_logo', 'admin.setting.template.menu_logo', [
                'logo' => $logo,
                'footer_logo' => $footer_logo
            ]);
            return redirect()->back();
        }
    }

    public function website(Request $request)
    {
        if ($request->getMethod() == "GET") {
            $data = getSetting('website') ?? (object)([
                'type' => 0,
                'price' => 0,
                'meta_description' => "",
                'meta_banner' => "",
            ]);

            // dd($data);
            return view('admin.setting.website', compact('data'));
        } else {
            $olddata = getSetting('website') ?? (object)([
                'type' => 0,
                'price' => 0,
                'meta_description' => "",
                'meta_banner' => "",
            ]);

            $data = [
                'type' => $request->type,
                'price' => $request->price,
                'meta_description' => $request->meta_description,
                'meta_banner' => ($request->hasFile('meta_banner') ? $request->meta_banner->store('uploads/setting') : $olddata->meta_banner),
            ];

            setSetting('website', $data);
            writeView('front.index.meta', 'admin.setting.template.meta');

            return redirect()->back();
        }
    }

    public function payment(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $data = [];
            if ($request->has('payment')) {
                foreach ($request->payment as $key => $value) {
                    array_push($data, [
                        'title' => $request->input('title_' . $value),
                        'id' => $request->input('id_' . $value),
                    ]);
                }
            }
            setSetting('payment', $data);
            return redirect()->back();
        } else {
            $data = getSetting('payment') ?? (object)[];
            return view('admin.setting.payment', compact('data'));
        }
    }
    private function renderHow()
    {
        $steps = getSetting('front.step') ?? (object)([
            'step1' => (object) [
                'title' => '',
                'text' => '',
            ],
            'step2' => (object)[
                'title' => '',
                'text' => '',
            ],
            'step3' => (object)[
                'title' => '',
                'text' => '',
            ],
            'step4' => (object) [
                'title' => '',
                'text' => '',
            ]
        ]
        );
        writeView('front.index.how', 'admin.setting.template.how', ['steps' => $steps]);
    }

    public function footer(Request $request)
    {
        if ($request->getMethod() == "GET") {
            $steps = getSetting('front.step') ?? (object)([
                'step1' => (object) [
                    'title' => '',
                    'text' => '',
                ],
                'step2' => (object)[
                    'title' => '',
                    'text' => '',
                ],
                'step3' => (object)[
                    'title' => '',
                    'text' => '',
                ],
                'step4' => (object) [
                    'title' => '',
                    'text' => '',
                ]
            ]
            );

            // dd($steps);
            return view('admin.setting.step', compact('steps'));
        } else {
            $steps = [
                'step1' => [
                    'title' => $request->step1_title,
                    'text' => $request->step1_text,
                ],
                'step2' => [
                    'title' => $request->step2_title,
                    'text' => $request->step2_text,
                ],
                'step3' => [
                    'title' => $request->step3_title,
                    'text' => $request->step3_text,
                ],
                'step4' => [
                    'title' => $request->step4_title,
                    'text' => $request->step4_text,
                ]
            ];
            setSetting('front.step', $steps);
            $this->renderHow();
            return redirect()->back()->with('message', 'Setting Saved Sucessfully');
        }
    }

    public function contact(Request $request)
    {
        if ($request->getMethod() == "GET") {
            $data = getSetting('contact') ?? ((object)([
                'map' => '',
                'email' => '',
                'phone' => '',
                'addr' => '',
                'others' => [],

            ]));
            // dd($data);
            return view('admin.setting.contact', compact('data'));
        } else {
            $others = [];
            if ($request->filled('others')) {
                foreach ($request->others as $key => $other) {
                    array_push($others, [
                        'name' => $request->input('name_' . $other) ?? '',
                        'phone' => $request->input('phone_' . $other) ?? '',
                        'designation' => $request->input('designation_' . $other) ?? '',
                        'email' => $request->input('email_' . $other) ?? '',
                    ]);
                }
            }
            $data = [
                'map' => $request->map ?? '',
                'email' => $request->email ?? '',
                'phone' => $request->phone ?? '',
                'addr' => $request->addr ?? '',
                'others' => $others
            ];
            setSetting('contact', $data);
            Helper::putCache('logo', view('admin.setting.template.menu-logo')->render());
            return redirect()->back()->with('message', "Setting Saved Sucessfully");
        }
    }
}
