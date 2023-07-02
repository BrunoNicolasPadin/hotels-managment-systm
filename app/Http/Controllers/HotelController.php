<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\HotelUpdateRequest;
use App\Models\Hotel;
use App\Models\Lov;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HotelController extends Controller
{
    public function index(Request $request): View
    {
        $params = $request->except('_token');
        $hotels = null;
        $pages = 10;

        if (empty($params) || (! isset($params['searchData']) && isset($params['filter']))) {
            $hotels = Hotel::withTrashed()->with('type')->paginate($pages);
        } else {
            $hotels = Hotel::withTrashed()->with('type')->filter($params)->paginate($pages);
        }

        return view('hotels.index', [
            'hotels' => $hotels,
            'params' => $params,
        ]);
    }

    public function create(): View
    {
        return view('hotels.create', [
            'types' => Lov::where('type', 'hotelType')
                ->orderBy('label', 'ASC')
                ->get(),
        ]);
    }

    public function store(HotelStoreRequest $request): RedirectResponse
    {
        $hotel = Hotel::create($request->validated());
        $fileName = 'hotel-'.$hotel->id.'.jpg';
        Storage::putFileAs(
            'public/hotels', $request->file('photo'), $fileName
        );
        $hotel->photo = 'hotels/'.$fileName;
        $hotel->save();

        return redirect()->route('hotels.index')->with(['successMessage' => 'Hotel created!']);
    }

    public function show(Hotel $hotel): View
    {
        return view('hotels.show', [
            'hotel' => $hotel,
        ]);
    }

    public function edit(Hotel $hotel): View
    {
        return view('hotels.edit', [
            'hotel' => $hotel,
            'types' => Lov::where('type', 'hotelType')
                ->orderBy('label', 'ASC')
                ->get(),
        ]);
    }

    public function update(HotelUpdateRequest $request, Hotel $hotel): RedirectResponse
    {
        $hotel->update($request->validated());

        if ($request->hasFile('photo')) {
            $fileName = 'hotel-'.$hotel->id.'.jpg';
            Storage::putFileAs(
                'public/hotels', $request->file('photo'), $fileName
            );
            $hotel->photo = 'hotels/'.$fileName;
            $hotel->save();
        }

        return redirect()->route('hotels.index')->with(['successMessage' => 'Hotel updated!']);
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        $hotel->delete();

        return redirect()->route('hotels.index')->with(['successMessage' => 'Hotel removed!']);
    }

    public function restore($id): RedirectResponse
    {
        $hotel = Hotel::withTrashed()->findOrFail($id);
        $hotel->restore();

        return redirect()->route('hotels.index')->with(['successMessage' => 'Hotel restored!']);
    }
}
