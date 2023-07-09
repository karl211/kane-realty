<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PropertyResource;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('location_access');

        $locations = Location::with('properties')
            // ->when(request()->location_id, function ($query) {
            //     $query->where('id', request()->location_id);
            // })
            ->orderBy('location')
            ->paginate(20);
            
        return LocationResource::collection($locations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        try {
            DB::beginTransaction();

            $payment = $request->save();

            DB::commit();

            return response()->json([
                'data'  => $payment,
                'message' => 'Successfully reserved'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function getLocationProperties(Location $location, Request $request)
    {
        $blocks = $location->properties()->pluck('block')->unique()->values();

        if ($request->block != 'null' && $request->lot != 'null') {

            $properties = $location->properties()
                ->whereNotIn('status', ['Agents', 'Church'])
                ->where('block', $request->block)
                ->where('lot', $request->lot)
                ->get();
        } else {
            $properties = $location->properties()
                ->whereNotIn('status', ['Agents', 'Church'])
                ->where('status', $request->status)
                ->paginate(10);
        }


        return PropertyResource::customCollection($properties, $blocks);
    }

    public function getLocationLots(Location $location, Request $request)
    {
        return $location->properties()->where('block', $request->block)->pluck('lot')->unique()->values();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
