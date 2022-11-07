<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerResource;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservations = Reservation::with('property', 'buyer')
            ->has('buyer.profile')
            ->orderBy('transaction_at', 'desc')
            ->paginate(10);

        return ReservationResource::collection($reservations);
    }

    public function locations()
    {
        $locations = Location::with('properties')
            ->when(request()->location_id, function ($query) {
                $query->where('id', request()->location_id);
            })
            ->orderBy('location')
            ->get();
            
        return LocationResource::collection($locations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        try {
            DB::beginTransaction();

            $reservation = $request->save();

            DB::commit();

            return response()->json([
                'data'  => $reservation,
                'message' => 'Successfully reserved'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(User $buyer)
    {
        $buyer_details = User::where('id', $buyer->id)->with('profile', 'spouses', 'coBorrowers', 'reservations.attorney', 'reservations.property', 'reservations.payments', 'documents')
            ->with(['reservations.payments' => function($query) {
                $query->orderBy('paid_at', 'asc');
            }])
            ->first();
        
        return new BuyerResource($buyer_details);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
