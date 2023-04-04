<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\User;

class RepoPatern extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo-patern  {name : The name of the repository patern }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk membuat repository partrn';

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
    public function handle()
    {
        $dir_name = 'App\Http\Controllers\API';
        $name_repo_patern = $this->argument("name");
        if (file_exists($dir_name)) {
            $cek_controller_exsis = "App\Http\Controllers\API\\".$name_repo_patern."Controller.php";
            if (file_exists($cek_controller_exsis)) {
                unlink($cek_controller_exsis);
                $createController = fopen('./App/Http/Controllers/API/'.$name_repo_patern.'Controller'.'.php', 'x');
                $write_controller = "<?php
                namespace ".$dir_name.";
                use App\Http\Controllers\Controller;
                use Illuminate\Http\Request;
                use App\Http\Traits\ResponseApi;
                class ".$name_repo_patern."Controller"." extends Controller{

                }";
                fwrite($createController, $write_controller);
                $this->info("sukses");
            }else{
               $createController = fopen('./App/Http/Controllers/API/'.$name_repo_patern.'Controller'.'.php', 'x');
                $write_controller = "<?php
                namespace ".$dir_name."; 
                use App\Http\Controllers\Controller;
                use Illuminate\Http\Request;
                use App\Http\Traits\ResponseApi;
                class ".$name_repo_patern."Controller"." extends Controller{
                    
                }";
                fwrite($createController, $write_controller);
                $this->info("sukses crate baru");
            }
           
        }else{
            $this->error('folder api didalam controllers tidak ada');
        }
       
       
        
    }
}
