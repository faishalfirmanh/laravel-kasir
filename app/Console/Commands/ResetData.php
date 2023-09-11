<?php

namespace App\Console\Commands;

use App\Models\KeranjangKasir;
use App\Models\NewStruck;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset-data-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'untuk reset data pada databse, keranjang';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function deleteDataKeranjang(){
        $model = KeranjangKasir::getQuery()->delete();
        return $model;
    }

    public function deleteDataStruck(){
        $model = NewStruck::getQuery()->delete();
        return $model;
    }

    public function deleteAllMerge(){
        DB::beginTransaction();
        try {
           $this->deleteDataKeranjang();
           $this->deleteDataStruck();
            DB::commit(); 
            $save_db = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $save_db = false;
        }
        return $save_db;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   $cek = $this->deleteAllMerge();
        if ($cek) {
            $this->info("sukses clear");
        }else{
            $this->error('gagal hapus');
        }
       
    }
}
