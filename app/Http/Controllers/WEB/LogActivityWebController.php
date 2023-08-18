<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogActivityWebController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('admin.logActivity.index');
    }
}
