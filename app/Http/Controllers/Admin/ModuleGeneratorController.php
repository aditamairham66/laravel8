<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleGeneratorController extends Controller
{
    function getStep1(Request $request) 
    {
        return view('admin.module.step1');
    }

    function getStep2(Request $request) 
    {
        return view('admin.module.step1');
    }

    function getStep3(Request $request) 
    {
        return view('admin.module.step1');
    }

}
