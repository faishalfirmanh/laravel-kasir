<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    //

    public function viewKasir(Request $request)
    {
        $last_id = cek_last_id_struck();
        return view('admin.kasir.index',['last_id_struck'=>$last_id]);
    }
}
