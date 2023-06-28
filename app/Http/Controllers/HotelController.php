<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\HotelUpdateRequest;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    public function index(Request $request): View
    {
        return view('hotels.index');
    }

    public function create(): View
    {
        return view('hotels.create');
    }

    public function store(HotelStoreRequest $request): RedirectResponse
    {
        $hotel = Hotel::create($request->validated());

        return redirect()->route('hotels.index');
    }

    public function show(Hotel $hotel): View
    {
        return view('hotels.show');
    }

    public function edit(Hotel $hotel): View
    {
        return view('hotels.edit');
    }

    public function update(HotelUpdateRequest $request, Hotel $hotel): RedirectResponse
    {
        $hotel->update($request->validated());

        return redirect()->route('hotels.index');
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        $hotel->delete();

        return redirect()->route('hotels.index');
    }
}
