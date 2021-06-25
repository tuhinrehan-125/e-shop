<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permission = Permission::orderBy('id', 'DESC')->pluck('name');
        return response()->json(['success' => true, 'message' => $permission], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        Permission::create(['name' => $request->input('name')]);

        return response()->json(['success' => true, 'message' => 'Permission Created Successfully'], 200);
    }

    public function assignPermission(Request $request)
    {
        $role = Role::find($request->role_id);
        $permissions = $request->permissions;
        
        $role->syncPermissions($permissions);

        return response()->json(['success' => true, 'message' => 'Assign permission Successfully'], 200);
    }
}
