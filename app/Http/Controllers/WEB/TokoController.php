<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Toko;
use DataTables;
class TokoController extends Controller
{
    //
    public function viewToko()
    {
        return view('admin.toko.index_serverside');
    }

    public function getToko(Request $request)
    {
        if ($request->ajax()) {
            $data = Toko::query()->orderBy('id_toko','ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('no', function ($data) {
                    $id = $data->id_toko;
                    return $id;
                })
                ->addColumn('nama_toko', function ($data) {
                    return $data->nama_toko;
                })
                ->addColumn('action', function($data){
                    $actionBtn = '<i onclick="editToko('.$data->id_toko.')" class="far fa-edit" style="margin-right:5px;"></i>';
                    $actionBtn .= '<i onclick="deleteToko('.$data->id_toko.')" class="far fa-trash-alt" style="margin-right:5px;"></i>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
