<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * view dashboard
     */
    public function getIndex()
    {
        return view('admin.page.home.home');
    }
}
