<?php

namespace App\Console\Commands;

use App\Models\KeranjangKasir;
use App\Models\NewStruck;
use Illuminate\Console\Command;
use PhpParser\Node\Stmt\TryCatch;

class NormalisasiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixing-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'untuk menghapus data di tabel new_struck dan keranjang kasir yang statusnya tidak = 2';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function getDataKeranjangNotUsed()
    {
        try {
            $data = KeranjangKasir::query()->where('status','!=',2)->get();
            $totalKer = [];
            if (count($data) > 0) {
                array_push($totalKer,count($data));
                foreach ($data as $key => $value) {
                    if (NewStruck::find($value->struck_id)->status != 2) {
                        KeranjangKasir::find($value->id_keranjang_kasir)->delete();
                    }
                
                }
            }
            $dataStruck = NewStruck::query()->where('status','!=',2)->get();
            if (count($dataStruck) > 0) {
                $fileName = 'logDeleteStruck.txt';
                $totalKerAnjang = count($totalKer) > 0 ? $totalKer[0] : 0;
                date_default_timezone_set('Asia/Jakarta');
                $dateDeleted = date('Y-m-d H:i:s');
                $content = $dateDeleted.' Total Keranjang '.$totalKerAnjang . " | total struck tidak digunakan ".count($dataStruck);
                //file_put_contents($fileName, $content); //tidak bisa
                //yang bisa
                if (file_exists('./'.$fileName)) {
                    unlink('./'.$fileName);
                    $createFile = fopen('./'.$fileName, 'x');
                }else{
                    $createFile = fopen('./'.$fileName, 'x');
                }
               
                fwrite($createFile, $content);
                foreach ($dataStruck as $key => $value) {
                    NewStruck::find($value->id_struck)->delete();
                }
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
    } 

    public function handle()
    {
        $cek = $this->getDataKeranjangNotUsed();
        if ($cek) {
            $this->info("sukses clear struck");
        }else{
            $this->error('gagal hapus struck');
        }
    }
}
