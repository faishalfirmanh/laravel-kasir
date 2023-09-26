<?php

namespace App\Http\Middleware\Rules;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class CekRules
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = Auth::user();

            if ($user == NULL) {
                return response()->json(['status' => 'Authorization Token not found', 
                'msg' => 'please login '],404);
            }

            $id_toko = $user->toko_id;
            $id_roles = $user->id_roles;
            $cek_roles = Role::find($id_roles);
            
            $host = request()->getHttpHost();
            $full_url = $request->url();
            $to_arr = explode("/",$full_url);
            $name_access = $to_arr[4];
           
           
            if ($cek_roles->$name_access == 0) {
                return response()->json([
                    "status"=>"not allowed",
                    "msg"=> "tidak dapat akses menu ".$name_access,
                ],403);
            }

            //default otomatis, tinggal dipanggil dicontroller / service
            $request->merge(["toko_id_from_middleware" => $id_toko]);
            $request->merge(["role_id_from_middleware" => $id_roles]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status"=>"exception error",
                "msg"=> "error toko",
            ],401);
        }

        //pengecekan disable script / xss
        foreach ($request->all() as $key => $value) {
            if ($key !== "toko_id_from_middleware" && $key !== "role_id_from_middleware"){
                $request->$key =  strip_tags($request->$key);
            }
            $request->$key = strtolower($request->$key);
        }
        //pengecekan disable script / xss

        return $next($request);
    }
}
