<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolePermissionRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(int $role_id): View
    {
        return view('rolePermissions.index', [
            'role' => Role::findById($role_id),
            'permissions' => Role::findById($role_id)->permissions,
        ]);
    }

    public function create(int $role_id): View
    {
        $permissionsALreadyTaken = Role::findById($role_id)->permissions->pluck('id');

        return view('rolePermissions.create', [
            'role' => Role::findById($role_id),
            'permissions' => Permission::orderBy('name', 'ASC')->whereNotIn('id', $permissionsALreadyTaken)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRolePermissionRequest $request, int $role_id): RedirectResponse
    {
        $role = Role::findById($role_id);
        $role->givePermissionTo($request->permission_id);

        return redirect()->route('assigned-permissions.index', $role_id)->with(['successMessage' => 'Permission assigned!']);
    }

    public function destroy(int $role_id, string $id): RedirectResponse
    {
        $role = Role::findById($role_id);
        $role->revokePermissionTo($id);

        return redirect()->route('assigned-permissions.index', $role_id)->with(['successMessage' => 'Permission revoked!']);
    }
}
