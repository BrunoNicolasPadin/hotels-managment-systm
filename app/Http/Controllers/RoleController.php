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
    public function index(Request $request) : View
    {
        $params = $request->except('_token');
        $roles = null;

        if (empty($params) || (! isset($params['searchData']) && isset($params['filter']))) {
            $roles = Role::paginate(1);
        } elseif (isset($params['filter'])) {
            if ($params['filter'] === 'name') {
                $roles = Role::where('name', 'LIKE', trim($params['searchData']).'%')->paginate(1);
            }
        } else {
            $roles = Role::paginate(1);
        }

        return view('roles.index', [
            'roles' => $roles,
            'params' => $params,
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
        Role::findOrFail($id)->delete($id);
        return redirect()->route('roles.index')->with(['successMessage' => 'Role deleted!']);
    }

    function massiveDestroy()
    {
        
    }
}
