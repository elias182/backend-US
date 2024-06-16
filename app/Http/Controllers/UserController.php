<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
    public function changeUserType($id)
    {
        $user = User::findOrFail($id);

        if ($user->type === 'standard') {
            $user->type = 'artist';
            $user->save();
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function obtart($id) {
        $user = User::findOrFail($id);
        return response()->json($user->name);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|in:standard,admin,artist',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'foto' => $request->foto,
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048' // Validar la imagen
        ]);

        if ($request->hasFile('photo')) {
            // Subir la nueva foto a la carpeta public
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('profile_photos'), $photoName);

            // Borrar la foto anterior si existe
            

            $user->foto = 'profile_photos/' . $photoName;
        }

        $user->update($request->only('name', 'email'));

        return response()->json($user);
    }


    // public function update(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $request->validate([
    //         'name' => 'sometimes|required|string|max:255',
    //         'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
    //         'password' => 'sometimes|nullable|string|min:8',
    //         'type' => 'sometimes|required|in:standard,admin,artist',
    //     ]);

    //     $user->update($request->only('name', 'email', 'type', 'foto'));

    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //         $user->save();
    //     }

    //     return response()->json($user);
    // }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
