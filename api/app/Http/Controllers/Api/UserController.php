<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Network;
use Illuminate\Http\Request;
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
}
