<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use DataTables;

class KategoriServerSideController extends Controller
{
    //

    public function viewKategori()
    {
        return view('admin.kategori.index_serverside');
    }

    public function getKategori(Request $request)
    {
        if ($request->ajax()) {
            $data = Kategori::query()->with('productRelasiKategori')->orderBy('id_kategori','ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('no', function ($data) {
                    $id = $data->id_kategori;
                    return $id;
                })
                ->addColumn('totalProduct', function ($data) {
                    $total = count($data->productRelasiKategori);
                    return $total;
                })
                ->addColumn('action', function($data){
                    $actionBtn = '<i onclick="editKategori('.$data->id_kategori.')" class="far fa-edit" style="margin-right:5px;"></i>';
                    if (count($data->productRelasiKategori) < 1) {
                        $actionBtn .= '<i onclick="deleteKategori('.$data->id_kategori.')" class="far fa-trash-alt"></i>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
