<?php


namespace App\Service\Product;

use App\Repository\Product;
use App\Repository\Product\ProductRepository;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Import\ProductImport;
use App\Service\Toko\TokoService;
use App\Service\Toko\TokoServiceImplement;
use App\Service\Kategori\KategoriServiceImplement;
use Database\Seeders\TokoSeeder;

class UploadProduct {

   

    public function validasiUploadExcel($request){
        
        $validator = Validator::make(
            [
                'file'      => $request->file('file_excel'),
                'extension' => strtolower($request->file('file_excel')->getClientOriginalExtension()),
            ],
            [
                'extension'      => 'required|in:xlsx,xls',
            ]
        );


        if ($validator->fails()) {
            return $validator->errors();
        }

        try {
            $import = new ProductImport();
            Excel::import($import, request()->file('file_excel'));
            $msg = 'OK';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            $msg = $failure;
        }
        return $msg;
        
       
    }

 

}