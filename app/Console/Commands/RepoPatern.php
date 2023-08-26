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

    public function textInFile($dir_name, $name_repo_patern){
        return  "<?php \n".
                    "namespace ".$dir_name.";"."\n".
                    "use App\Http\Controllers\Controller;"."\n".
                    "use Illuminate\Http\Request;"."\n".
                    "use App\Http\Traits\ResponseApi;"."\n".
                    "class ".$name_repo_patern."Controller"." extends Controller{ \n"."\n".
                        
                        "\tpublic function __construct()"."\n"
                        ."\t{"."\n"

                        ."\t}"
                        ."\n".
                    "}";
    }

    public function defaultFunctionRepoImpl($name_repo,$id)
    {
        return  "\tpublic function getAll".$name_repo."()"."\n"       ."\t{"."\n"."\t}"."\n" ."\n"
                ."\tpublic function getByID".$name_repo."($id)"."\n"  ."\t{"."\n"."\t}"."\n" ."\n"
                ."\tpublic function saved".$name_repo."($id)"."\n"    ."\t{"."\n"."\t}"."\n" ."\n"
                ."\tpublic function deleted".$name_repo."($id)"."\n"  ."\t{"."\n"."\t}"."\n" ."\n";
    }

    public function defaultFunctionRepo($name_repo,$id)
    {
        return  "\tpublic function getAll".$name_repo."();"."\n"     
                ."\tpublic function getByID".$name_repo."($id);"."\n"
                ."\tpublic function saved".$name_repo."($id);"."\n"  
                ."\tpublic function deleted".$name_repo."($id);"."\n";
    }

    public function textInFileRepo($isImplement,$dir_name, $name_repo_patern){
        $id = "$"."id";
        $model = "$"."model";
        $dir_base_repo = "App\Repository\BaseRepository.php";
        //cek base repository ada atau tidak jika tidak create default function
        $cek_create_def_function = !file_exists($dir_base_repo) ? $this->defaultFunctionRepoImpl($name_repo_patern,$id) : "";
        $cek_create_def = !file_exists($dir_base_repo) ? $this->defaultFunctionRepo($name_repo_patern,$id) : "";
        if ($isImplement == 1) {
            return  "<?php \n".
                        "namespace ".$dir_name.";"."\n".
                        "use App\Models\\".$name_repo_patern.";"."\n".
                        "class ".$name_repo_patern."Repository"." implements ".$name_repo_patern."Repository"."{ \n"."\n". 
                            "\tprotected ".$model.";\n\n".

                            "\tpublic function __construct()"."\n"
                            ."\t{"."\n"
    
                            ."\t}"
                            ."\n"."\n".
                            
                            $cek_create_def_function
                            
                            
                        ."}";
        }else{
            return  "<?php \n".
                        "namespace ".$dir_name.";"."\n".
                        "interface ".$name_repo_patern."Repository"."{ \n"."\n".
                            
                            $cek_create_def
                    
                            
                        ."}";
        }
    }

    public function createRepository($name_repo){
        $dir_repository = "App\Repository\\";
        $folderPathRepo = 'App/Repository/'.$name_repo;
        if (!file_exists($folderPathRepo)) {
            if ( mkdir($folderPathRepo, 0755, true)) { //0755, permision php
                /** sukses create folder */
                if (file_exists($dir_repository)) {
                    $cek_repo_exsis = "App\Repository\\".$name_repo."\\".$name_repo."Repository.php";
                    if (file_exists($cek_repo_exsis)) {
                        unlink($cek_repo_exsis);
                        $createRepo = fopen('./App/Repository/'.$name_repo.'/'.$name_repo.'Repository'.'.php', 'x');
                        $write_Repo = $this->textInFileRepo(0,$dir_repository.$name_repo,$name_repo);
                        fwrite($createRepo, $write_Repo);
                        $create_repoImplement =  $createRepo = fopen('./App/Repository/'.$name_repo.'/'.$name_repo.'RepositoryImplement'.'.php', 'x');
                        $write_Repo_implement = $this->textInFileRepo(1,$dir_repository.$name_repo,$name_repo);
                        fwrite($create_repoImplement, $write_Repo_implement);
                        $this->info("sukses create repo");
                    }else{
                        $createRepo = fopen('./App/Repository/'.$name_repo.'/'.$name_repo.'Repository'.'.php', 'x');
                        $write_Repo = $this->textInFileRepo(0,$dir_repository.$name_repo,$name_repo);
                        fwrite($createRepo, $write_Repo);
                        $create_repoImplement =  $createRepo = fopen('./App/Repository/'.$name_repo.'/'.$name_repo.'RepositoryImplement'.'.php', 'x');
                        $write_Repo_implement = $this->textInFileRepo(1,$dir_repository.$name_repo,$name_repo);
                        fwrite($create_repoImplement, $write_Repo_implement);
                        $this->info("sukses create repo");
                    }
                 /** sukses create folder */
                }else{
                    $this->error('folder repository tidak ada harap dibuat');
                }
            } else {
                $this->error('folder repository gagal dibuat');
            }
        }else{
            $this->error("Folder already exists at $folderPathRepo");
        }
      
    }

    public function defaultFunctionService($name_service,$id,$is_implement)
    {
        $request = "$"."request".",".$id;
        if ($is_implement == 1) {
            return  "\tpublic function getAll".$name_service."Service"."()"."\n"  ."\t{"."\n"."\t}"."\n" ."\n"        
            ."\tpublic function getByID".$name_service."Service"."($request)"."\n"     ."\t{"."\n"."\t}"."\n" ."\n"
            ."\tpublic function saved".$name_service."Service"."($request)"."\n"       ."\t{"."\n"."\t}"."\n" ."\n"
            ."\tpublic function deleted".$name_service."Service"."($request)"."\n"     ."\t{"."\n"."\t}"."\n" ."\n";
        }else{
            return  "\tpublic function getAll".$name_service."Service"."();"."\n"     
            ."\tpublic function getByID".$name_service."Service"."($request);"."\n"
            ."\tpublic function saved".$name_service."Service"."($request);"."\n"  
            ."\tpublic function deleted".$name_service."Service"."($request);"."\n";
        }
       
    }

    public function writeCodeInFileRepo($isImplement,$dir_name, $name_repo_patern){
        $id = "$"."id";
        $cek_default_fuction = 
                $isImplement == 1 ? 
                $this->defaultFunctionService($name_repo_patern,$id,1):
                $this->defaultFunctionService($name_repo_patern,$id,0);
        $validator = "Illuminate\Support\Facades\Validator";
        $repo = "App\Repository\\".$name_repo_patern."\\".$name_repo_patern."Repository;". "\n";
        if ($isImplement == 1) {
            $var_repo = "$".$name_repo_patern."RepoVariable";
            $var_construct = $name_repo_patern."Repository"." ".$var_repo;
            $param_this = "$"."this->".$var_repo ."  "."=". $var_repo;
            return  "<?php \n".
                        "namespace ".$dir_name.";"."\n".
                        "use ".$validator .";"."\n".
                        "use ".$repo.";"."\n".
                        "class ".$name_repo_patern."Service"." implements ".$name_repo_patern."Service"."{ \n"."\n". 
                            "\t protected ".$var_repo.";\n\n".

                            "\tpublic function __construct(".$var_construct.")"."\n"
                            ."\t{"."\n"."\n"

                                ."\t    ".$param_this .";" . "\n"

                            ."\t}"
                            ."\n"."\n"
                            
                            .$cek_default_fuction
                            
                            
                        ."}";
        }else{
            return  "<?php \n".
                        "namespace ".$dir_name.$name_repo_patern.";"."\n".
                        "interface ".$name_repo_patern."Service"."{ \n"."\n"
                            
                            .$cek_default_fuction
                    
                            
                        ."}";
        }
    }

    public function createServiceValidate($name_service){
        $dir_service = "App\Service\\";
        $name_space_folder = $dir_service.$name_service;
        $folderPathSerc = 'App/Service/'.$name_service;
        if (!file_exists($folderPathSerc)) {
            if ( mkdir($folderPathSerc, 0755, true)) { //0755, permision php
                /** sukses create folder */
                if (file_exists($dir_service)) {
                    $cek_repo_exsis = "App\Service\\".$name_service."\\".$name_service."Service.php";
                    if (file_exists($cek_repo_exsis)) {
                        unlink($cek_repo_exsis);
                        $createService = fopen('./App/Service/'.$name_service.'/'.$name_service.'Service'.'.php', 'x');
                        $write_Service = $this->writeCodeInFileRepo(0,$name_space_folder, $name_service);
                        fwrite($createService, $write_Service);

                        $create_ServiceImplement =  fopen('./App/Service/'.$name_service.'/'.$name_service.'ServiceImplement'.'.php', 'x');
                        $write_Service_implement = $this->writeCodeInFileRepo(1,$name_space_folder, $name_service);
                        fwrite($create_ServiceImplement, $write_Service_implement);
                        $this->info("sukses create service");
                    }else{
                        $createService = fopen('./App/Service/'.$name_service.'/'.$name_service.'Service'.'.php', 'x');
                        $write_Service = $this->writeCodeInFileRepo(0,$name_space_folder, $name_service);
                        fwrite($createService, $write_Service);
                        
                        $create_ServiceImplement =  fopen('./App/Service/'.$name_service.'/'.$name_service.'ServiceImplement'.'.php', 'x');
                        $write_Service_implement = $this->writeCodeInFileRepo(1,$name_space_folder, $name_service);
                        fwrite($create_ServiceImplement, $write_Service_implement);
                        $this->info("sukses create service");
                    }
                 /** sukses create folder */
                }else{
                    $this->error('folder service tidak ada harap dibuat');
                }
            } else {
                $this->error('folder service gagal dibuat');
            }
        }
        else{
            $this->error("Folder  already exists at $folderPathSerc");
        }


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
                $write_controller = $this->textInFile($dir_name,$name_repo_patern);
                fwrite($createController, $write_controller);
                $this->createRepository($name_repo_patern);
                $this->createServiceValidate($name_repo_patern);
                $this->info("sukses create controller");
            }else{
                $createController = fopen('./App/Http/Controllers/API/'.$name_repo_patern.'Controller'.'.php', 'x');
                $write_controller = $write_controller = $this->textInFile($dir_name,$name_repo_patern);
                fwrite($createController, $write_controller);
                $this->createRepository($name_repo_patern);
                $this->createServiceValidate($name_repo_patern);
                $this->info("sukses create controller");
            }
           
        }else{
            $this->error('folder api didalam controllers tidak ada');
        }
       
       
        
    }
}
