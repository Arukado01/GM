<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function indexAdmin()
    {
        return view('admin.users.profile');
    }

    public function show($user_id)
    {
        $user = User::find($user_id);
        return response()->json($user, 200);
    }

    public function update(Request $request)
    {
        $user = User::find($request->user_id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);
            if ($user->isFirstSession())
                $user->first_session = false;
        }

        $user->save();

        $message = 'Usuario actualizado con éxito.';
        return response()->json(['message' => $message], 200);
    }

    public function updateAvatar(Request $request)
    {
        $data = $request->img_profile;
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);

        $data = base64_decode($data);

        $user = User::find($request->user_id);

        $fileName = time() . snake_case($user->full_name . '.png');
        $path = public_path('accounts/profile_images/');

        if (!file_exists($path))
            mkdir($path, 0755, true);

        $filePath = $path . $fileName;

        file_put_contents($filePath, $data);

        $fileUrl = url('accounts/profile_images/' . $fileName);

        $user->deleteCurrentAvatar();
        $user->avatar = $fileUrl;
        $user->save();

        return response()->json(['message' => 'Imagen actualizada con éxito', 'fileUrl' => $fileUrl]);
    }
}
