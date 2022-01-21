<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function getRoles()
    {
        $role = Role::all();
        return response()->json($role, 200);
    }
}
