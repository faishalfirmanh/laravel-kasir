<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coba;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Response;
use App\Http\Traits\ResponseApi;

class CobaController extends Controller
{
    //

    protected $coba_model;
    use ResponseApi;
    public function __construct(Coba $coba_model)
    {
        $this->coba_model = $coba_model;
    }

    

    public function CobaCreate(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'tanggal' => 'required|date_format:Y-m-d',
            'tempat' => 'required|string',
            'nama_peminjam' => 'required|string',
            'departement' => 'required|string',
            'jabatan' => 'required|string',
            'tujuan' => 'required|string',
            'keperluan' => 'required|string',
            'catatan_kusus' => 'required|string',
            'driver' => 'required|numeric|between:0,1',
            'tanggal_pinjam'=> 'required|date_format:Y-m-d',
            'tanggal_pengembalian'=> 'required|date_format:Y-m-d',
            'manager'=> 'required|string',
            'hrd'=> 'required|string',
        ]);
        if ($validated->fails()) {
            // return $validated->errors();
            return response([
                'status' => false,
                'message' => 'validation failed',
                'errors' =>$validated->errors()
              ], 400);
        }

        $data = $request->all();
        $saved = Coba::create($data);
        if ($saved) {
            return $this->generalResponseV2($saved,16);
        }
    }

    public function getAll(){
        $data = $this->coba_model->get();
        return $this->generalResponseV2($data,16);
    }

    public function getCobaById(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'no_form' => 'required|integer|exists:coba,no_form'
        ]);
        if ($validated->fails()) {
            return response([
                'status' => false,
                'message' => 'validation failed',
                'errors' =>$validated->errors()
              ], 400);
        }
        $get =$this->coba_model->where('no_form',$request->no_form)->first();
        return $this->generalResponseV2($get,16);
    }

    public function searchCoba(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_peminjam' => 'required|string'
        ]);
        if ($validated->fails()) {
            return response([
                'status' => false,
                'message' => 'validation failed',
                'errors' =>$validated->errors()
              ], 400);
        }

        $cari = $this->coba_model->where('nama_peminjam','like','%'.$request->nama_peminjam .'%')->get();
        return $this->generalResponseV2($cari,16);

    }
}
