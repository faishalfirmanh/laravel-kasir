<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //

    public function viewLaporan(Request $request)
    {
        return view('admin.transaction.index');
    }
}
