<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request): View
    {
        $params = $request->except('_token');
        $permissions = null;
        $pages = 10;

        if (empty($params) || (! isset($params['searchData']) && isset($params['filter']))) {
            $permissions = Permission::paginate($pages);
        } elseif (isset($params['filter'])) {
            if ($params['filter'] === 'name') {
                $permissions = Permission::where('name', 'LIKE', trim($params['searchData']).'%')->paginate($pages);
            }
        } else {
            $permissions = Permission::paginate($pages);
        }

        return view('permissions.index', [
            'permissions' => $permissions,
            'params' => $params,
        ]);
    }

    public function create(): View
    {
        return view('permissions.create');
    }

    public function store(StorePermissionRequest $request): RedirectResponse
    {
        Permission::create($request->validated());

        return redirect()->route('permissions.index')->with(['successMessage' => 'Permission created!']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View
    {
        return view('permissions.edit', [
            'permission' => Permission::findOrFail($id),
        ]);
    }

    public function update(StorePermissionRequest $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->validated());

        return redirect()->route('permissions.index')->with(['successMessage' => 'Permission updated!']);
    }

    public function destroy(string $id)
    {
        Permission::findOrFail($id)->delete($id);

        return redirect()->route('permissions.index')->with(['successMessage' => 'Permission deleted!']);
    }
}
