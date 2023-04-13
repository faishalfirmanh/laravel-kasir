<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    //

    public function viewKasir(Request $request)
    {
        return view('admin.kasir.index');
    }
}
