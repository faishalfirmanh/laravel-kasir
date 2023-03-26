<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //

    public function home(Request $request)
    {

    }

    public function dashboardView(Request $request)
    { 
        return view('admin.dashboard.index');
    }

    public function kategoriView(Request $request)
    {
        return view('admin.kategori.index');
    }

    public function productView(Request $request)
    {
        return view('admin.product.index');
    }

    public function keuntunganView(Request $request)
    {

    }


}
