<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function help() { return view('admin.support.help'); }
    public function docs() { return view('admin.support.docs'); }
    public function contact() { return view('admin.support.contact'); }
    public function feedback() { return view('admin.support.feedback'); }
}
