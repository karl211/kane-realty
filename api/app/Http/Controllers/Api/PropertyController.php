<?php

namespace App\Http\Controllers\Api;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('invoice_access');
        
        $payments = Payment::with('reservation.buyer', 'reservation.property')
                ->whereHas('reservation.buyer', function($q) use($request){
                    $q->where('branch_id', $request->branch_id);
                })
                ->search(request('search'))
                ->orderBy('paid_at', 'desc')
                ->paginate(10);

        return PaymentResource::collection($payments);
    }

    public function getStatuses()
    {
        $statuses = Property::select('status', 'location_id')->whereNotIn('status', ['Agents', 'Church'])->groupBy('status')->get();

        return $statuses->pluck('status');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        try {
            DB::beginTransaction();

            $property = $request->save();

            DB::commit();

            return response()->json([
                'data'  => $property,
                'message' => 'Successfully reserved'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProperty(Property $property, UpdatePropertyRequest $request)
    {
        $this->authorize('property_edit');

        try {
            DB::beginTransaction();

            $property = $request->save($property);

            DB::commit();

            return response()->json([
                'data'  => $property,
                'message' => 'Successfully updated'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
        
    }

    public function updateStatus(Property $property, Request $request)
    {
        $this->authorize('property_edit');

        try {
            DB::beginTransaction();

            $property = $property->update(['status' => $request->status]);

            DB::commit();

            return response()->json([
                'data'  => $property,
                'message' => 'Successfully updated'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $this->authorize('property_delete');
        
        try {
            DB::beginTransaction();

            $property->delete();
            
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
