<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermission\PermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('RolePermission.permission', compact('permissions'));
    }

    public function store(PermissionRequest $request)
    {
        Permission::create(['name' => $request->name]);
        return redirect()->route('permission.index')->with('success', 'Permission berhasil ditambahkan.');
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update(['name' => $request->name]);
        return redirect()->route('permission.index')->with('success', 'Permission berhasil diubah.');
    }

    public function destroy(Permission $permission)
    {
        if ($permission->roles()->count() > 0 || $permission->users()->count() > 0) {
            return back()->with('error', 'Permission tidak dapat dihapus karena sedang digunakan.');
        }

        $permission->delete();
        return back()->with('success', 'Permission berhasil dihapus.');
    }
}
