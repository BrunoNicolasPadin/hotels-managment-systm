<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('roles.index', [
            'roles' => Role::paginate(10)
        ]);
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return back()->with(['message' => 'Role created!']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    function massiveDestroy()
    {
        
    }
}
