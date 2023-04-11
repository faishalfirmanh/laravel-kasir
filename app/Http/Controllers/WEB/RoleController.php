<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use DataTables;
class RoleController extends Controller
{
    //

    public function viewRole()
    {
        return view('admin.role.index_serverside');
    }

    public function getRole(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::query()->with('roleRelasiUser')->orderBy('id','ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('no', function ($data) {
                    $id = $data->id;
                    return $id;
                })
                ->addColumn('total_user', function ($data) {
                    $total = count($data->roleRelasiUser);
                    return $total;
                })
                ->addColumn('name_role', function ($data) {
                    return $data->name_role;
                })
                ->addColumn('action', function($data){
                    $actionBtn = '<i onclick="editRole('.$data->id.')" class="far fa-edit" style="margin-right:5px;"></i>';
                    if (count($data->roleRelasiUser) < 1) {
                        $actionBtn .= '<i onclick="deleteRole('.$data->id.')" class="far fa-trash-alt" style="margin-right:5px;"></i>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
