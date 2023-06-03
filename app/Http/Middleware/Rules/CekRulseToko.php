<?php

namespace App\Http\Middleware\Rules;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class CekRulseToko
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
                    "msg"=> "tidak dapat akses menu toko",
                ],403);
            }

            //default otomatis, tinggal dipanggil dicontroller / service
            $request->merge(["toko_id" => $id_toko]);
            $request->merge(["role_id" => $id_roles]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status"=>"exception error",
                "msg"=> "error toko",
            ],401);
        }
       
        return $next($request);
    }
}
