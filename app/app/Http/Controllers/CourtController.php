<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Region;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $courts = Court::all();
        // $regions = Region::where('title', 'Нижегородская область')->get();
        $courts = Court::with('region')
            ->whereHas('region', function ($query) {
                $query->where('title', 'Нижегородская область');
            })
            ->get();

        // dump($courts);
        return view("court.index", compact("courts"));
    }

    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $regions = Region::all();
        return view("court.create", compact("regions"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'region_id' => 'string',
            'cass_region' => 'required|string',
            'general_type_id' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'site' => 'required|url',
        ]);

        Court::create($data);
        return redirect()->route('court.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Court $court)
    {
        return view("court.show", compact("court"));
    }

    /**
     * Edit the specified resource in storage.
     */
    public function edit(Court $court)
    {
        $regions = Region::all();
        return view("court.edit", compact(["court", "regions"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Court $court)
    {
        $data = request()->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'region_id' => 'required|string',
            'cass_region' => 'required|string',
            'general_type_id' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email',
            'site' => 'required|url',
        ]);

        $court->update($data);
        return redirect()->route('court.show', $court->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Court $court)
    {
        $court->delete();
        return redirect()->route('court.index');
    }
}
