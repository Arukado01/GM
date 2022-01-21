<?php

namespace App\Http\Controllers\Admin;

use App\Mail\ResetPassword;
use App\Mail\UserRegister;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index($role_id)
    {
        try {
            $role = Role::findOrFail($role_id);
            return view('admin.users.index', compact('role'));
        } catch (ModelNotFoundException $e) {
            return abort(404, 'El recurso solicitado no se encuentra.');
        }
    }

    public function getUserData(Request $request)
    {
        $users = User::with('role')
            ->where('role_id', $request->role_id)
            ->get();

        return DataTables::of($users)
            ->setRowId('hashid')
            ->addColumn('action', function ($user) {
                return '<a href="' . route('admin.users.edit', ['user_id' => $user->hashid]) . '">' .
                    '<i class="fa fa-edit"></i> Editar' .
                    '</a>';
            })
            ->make();
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit($user_id)
    {
        $user = User::with('role')->find($user_id);
        return view('admin.users.edit', compact('user'));
    }

    public function createOrUpdate(Request $request)
    {
        $role = Role::find($request->role_id);
        $message = '';
        $codeResp = 201;

        if ($request->isMethod('post')) {
            $user = new User([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
            ]);

            $role->users()->save($user);

            $message = 'Usuario registrado con éxito.';
            Mail::to($user)->send(new UserRegister($user, $request->password));

        } elseif ($request->isMethod('put')) {
            $user = User::find($request->user_id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;

            if ($request->has('password') && (!empty($request->password))) {
                $user->password = Hash::make($request->password);
                $user->first_session = true;
                Mail::to($user)->send(new ResetPassword($user, $request->password));
            }

            $user->role()->associate($role);
            $user->save();

            $message = 'Usuario actualizado con éxito.';
        }

        return response()->json([
            'message'    => $message,
            'redirectTo' => route('admin.users.index', ['role_id' => $role->hashid]),
            'request'    => $request->all(),
        ], 200);
    }

    public function getSupervisors()
    {
        $users = User::where('role_id', '!=', 3)->get();

        return response()->json(['users' => $users], 200);
    }

    public function getClients(Request $request)
    {
        $users = User::where('role_id', 3)
            ->where('first_name', 'like', "%$request->queryString%")
            ->get();

        return response()->json(['clients' => $users], 200);
    }
}
