<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        if (request()->routeIs('karyawan')) {
            $tokoId = Session::get('toko.id');

            $user = User::role(['operator', 'kasir']) // filter berdasarkan role
                ->whereHas('tokos', function ($query) use ($tokoId) {
                    $query->where('tokos.id', $tokoId); // hanya user yang punya toko ini
                })
                ->with([
                    'tokos' => function ($query) use ($tokoId) {
                        $query->where('tokos.id', $tokoId); // eager load relasi toko sesuai session
                    },
                ])
                ->get();
        } else {
            if (Auth::user()->hasRole('core')) {
                $role = ['admin', 'core'];
            } else {
                $role = ['admin'];
            }
            $user = User::role($role)->with('tokos')->get();
        }
        $data = [
            'role' => request()->routeIs('karyawan') ? Role::whereIn('name', ['operator', 'kasir'])->get() : (Auth::user()->hasRole('core') ? Role::whereIn('name', ['admin', 'core'])->get() : Role::where('name', 'admin')->get()),
            'users' => $user,
            'toko' => Toko::all(),
        ];

        // dd($data['role']);
        return view('user.user', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|array',
            'password' => 'required|string|min:8',
            'toko' => 'nullable|array', // validate toko[]
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        // Attach toko(s) to user
        $user->tokos()->sync($request->toko);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|array',
            'password' => 'nullable|string|min:8',
            'toko' => 'nullable|array', // validate toko[]
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->nama;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $user->syncRoles($request->role);

        // Sync toko(s) to user
        $user->tokos()->sync($request->toko);

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Detach all toko relationships
        $user->tokos()->detach();

        // Remove all roles
        $user->syncRoles([]);

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
