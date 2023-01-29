<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Location;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\LocationResource;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\UpdateDocumentRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\BuyerUpdateOrPropertyRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservations = Reservation::with('property', 'buyer', 'payments')
            ->has('buyer.profile')
            ->when(request()->search, function ($query) {
                $query->search(request()->search);
            })
            ->orderBy('transaction_at', 'desc')
            ->paginate(10);

        return ReservationResource::collection($reservations);
    }

    public function locations()
    {
        $locations = Location::with('properties')
            ->with(['properties' => function($query) {
                $query->where('status', 'Available');
            }])
            ->when(request()->location_id, function ($query) {
                $query->where('id', request()->location_id);
            })
            ->whereHas('properties', function($q) {
                $q->where('status', 'Available');
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

    public function updateOrCreateProperty(User $buyer, BuyerUpdateOrPropertyRequest $request)
    {
        try {
            DB::beginTransaction();

            $reservation = $request->save($buyer);

            DB::commit();

            return response()->json([
                'data'  => $reservation,
                'message' => 'Successfully added'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function updateDocument(User $buyer, UpdateDocumentRequest $request)
    {
        // return $request->all();
        try {
            DB::beginTransaction();

            $document = $request->save($buyer);

            DB::commit();

            return response()->json([
                'data'  => $document,
                'message' => 'Successfully updated'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function updatePayment(User $buyer, UpdatePaymentRequest $request)
    {
        // return $request->all();
        try {
            DB::beginTransaction();

            $document = $request->save($buyer);

            DB::commit();

            return response()->json([
                'data'  => $document,
                'message' => 'Successfully updated'
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
            ->with(['reservations.payments' => function($query) {
                $query->orderBy('paid_at', 'asc');
            }])
            ->first();
        
        return new BuyerResource($buyer_details);
    }

    public function download(User $buyer)
    {
        $file_path = 'buyers/644/birth_or_marriage_certificate/property-img-default.gif';
        $file = Storage::disk('s3')->url($file_path);

        // $file= public_path(). "/download/info.pdf";

        $id = 1;
 
        $headers = [
 
            'Content-Type'        => 'application/jpeg',
 
            'Content-Disposition' => 'attachment; filename="'. 'property-img-default.gif' .'"',
 
        ];
 
        return \Response::make(Storage::disk('s3')->get($file_path), 200, $headers);
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
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $reservation = Reservation::findOrFail($request->id);

            $reservation->delete();
            
            DB::commit();

            return response()->json([
                'message' => 'Successfully deleted'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
}
