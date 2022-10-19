<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $users = User::all();

        return view('welcome', compact('users'));
    }

    public function getSalesManagers()
    {
        $users = User::where('role_id', 3)->get();

        return response()->json(['data' => $users]);
    }

    public function getNetworks()
    {
        $networks = Network::with('salesManagers.salesManagerAgents')->get();

        return response()->json(['data' => $networks]);
    }

    public function searchBuyer()
    {
        $buyers = User::join('profiles', 'profiles.user_id', '=', 'users.id')
        ->has('reservations')
        ->where('first_name', request('search'))
        ->orWhere('last_name', request('search'))
        ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%".request('search')."%")
        ->orderBy('last_name', 'asc')
        ->paginate(10);
        
        return response()->json(['data' => $buyers]);
        // return ReservationResource::collection($reservations);
    }
}
