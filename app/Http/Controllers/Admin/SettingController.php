<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function general() { return view('admin.settings.general'); }
    public function payments() { return view('admin.settings.payments'); }
    public function email() { return view('admin.settings.email'); }
    public function sms() { return view('admin.settings.sms'); }
    public function language() { return view('admin.settings.language'); }
    public function backup() { return view('admin.settings.backup'); }
    public function logs() { return view('admin.settings.logs'); }
}
