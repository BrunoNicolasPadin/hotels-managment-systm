<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('roles.index', [
            'roles' => Role::paginate(10)
        ]);
    }

    public function create() : View
    {
        return view('roles.create');
    }

    public function store(StoreRoleRequest $request) : RedirectResponse
    {
        Role::create($request->validated());

        return redirect()->route('roles.index')->with(['successMessage' => 'Role created!']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id) : View
    {
        return view('roles.edit', [
            'role' => Role::findOrFail($id),
        ]);
    }

    public function update(UpdateRoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->validated());

        return redirect()->route('roles.index')->with(['successMessage' => 'Role updated!']);
    }

    public function destroy(string $id)
    {
        //
    }

    function massiveDestroy()
    {
        
    }
}
