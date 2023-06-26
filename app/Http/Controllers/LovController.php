<?php

namespace App\Http\Controllers;

use App\Http\Requests\LovStoreRequest;
use App\Http\Requests\LovUpdateRequest;
use App\Models\Lov;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LovController extends Controller
{
    public function index(Request $request): View
    {
        $params = $request->except('_token');
        $lovs = null;
        $pages = 10;

        if (empty($params) || (! isset($params['searchData']) && isset($params['filter']))) {
            $lovs = Lov::paginate($pages);
        } else {
            $lovs = Lov::filter($params)->paginate($pages);
        }

        return view('lovs.index', [
            'lovs' => $lovs,
            'params' => $params,
        ]);
    }

    public function create(): View
    {
        return view('lovs.create');
    }

    public function store(LovStoreRequest $request): RedirectResponse
    {
        Lov::create($request->validated());

        return redirect()->route('lovs.index')->with(['successMessage' => 'Lov created!']);
    }

    public function edit(Lov $lov): View
    {
        return view('lovs.edit', [
            'lov' => $lov
        ]);
    }

    public function update(LovUpdateRequest $request, Lov $lov): RedirectResponse
    {
        $lov->update($request->validated());

        return redirect()->route('lovs.index')->with(['successMessage' => 'Lov updated!']);
    }

    public function destroy(Lov $lov): RedirectResponse
    {
        $lov->delete();

        return redirect()->route('lovs.index')->with(['successMessage' => 'Lov removed!']);
    }
}
