<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
class FollowsController extends Controller
{
    // This we use as a store 

/*what we do here is we grab authenticated users and then attach or detach this relationship, toggle() will toggle between connected and not connected for us*/ 


    public function __construct(){
        //This needs a  middleware of auth
        $this->middleware('auth');
    }
    public function store(User $user)
    {
        /**user we are referegin is user that's passed into us, not authenticated user
         * we are using authenticated user to actuially do our connection, but then what we connect is profile
         */
        return auth()->user()->following()->toggle($user->profile);
    }
}
