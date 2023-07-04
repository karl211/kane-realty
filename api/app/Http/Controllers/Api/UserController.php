<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Network;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
    }

    public function getEmployees()
    {
        $this->authorize('user_access');

        $users = User::with('profile')
            ->where('id', '!=' ,auth()->user()->id)
            ->whereHas('roles', function($q) {
                $q->whereIn('name', ['bookepper', 'business administrator']);
            })
            ->get();

        return UserResource::collection($users);
    }

    public function getSalesManagers()
    {
        $users = User::whereHas('roles', function($q) {
            $q->where('name', 'sales manager');
        })
        ->get();

        return response()->json(['data' => $users]);
    }

    public function getNetworks()
    {
        $networks = Network::with('salesManagers.salesManagerAgents')->get();

        return response()->json(['data' => $networks]);
    }

    public function getDocuments()
    {
        return Document::all();
    }
    

    public function searchBuyer()
    {
        $buyers = User::select(['users.*', 'first_name', 'last_name', 'middle_name', 'photo'])
        ->has('reservations')
        ->join('profiles', 'profiles.user_id', '=', 'users.id')
        ->where(function ($query) {
            return $query->where('email', 'LIKE', "%".request('search')."%")
            ->orWhere('first_name', 'LIKE', "%".request('search')."%")
            ->orWhere('middle_name', 'LIKE', "%".request('search')."%")
            ->orWhere('last_name', 'LIKE', "%".request('search')."%")
            ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%".request('search')."%");
        })
        ->orderBy('last_name', 'asc')
        ->paginate(10);
        
        return UserResource::collection($buyers);
    }

    public function savePermission(Request $request)
    {
        try {
            DB::beginTransaction();

            $all_access = [];

            $user =  User::findOrFail($request->user_id);

            $accesses = collect($request->access)->where('value', true);

            foreach ($accesses as $access) {
                if (isset($access['sub_accesses']) && count($access['sub_accesses'])) {
                    $all_access[] = $access['key'];
                    $sub_accesses = collect($access['sub_accesses'])->where('value', true)->pluck('key')->toArray();
                    $all_access = array_merge($all_access, $sub_accesses);
                } else {
                    $all_access[] = $access['key'];
                }
            }

            $user->syncPermissions($all_access);

            DB::commit();

            return response()->json([
                'data'  => $all_access,
                'message' => 'Successfully saved'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
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

            $reservation = User::findOrFail($request->id);

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
