<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
class RoleController extends Controller
{
    //

    public function viewRole()
    {
        return view('admin.role.index_serverside');
    }

    public function getRole(Request $request)
    {
        
    }
}
