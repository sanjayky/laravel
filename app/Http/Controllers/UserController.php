<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    private $status     =   200;
    // --------------- [ Save Student function ] -------------
    public function createUser(Request $request) {

        // validate inputs
        $validator          =       Validator::make($request->all(),
            [
                "first_name"        =>      "required",
                "last_name"         =>      "required",
                "email"             =>      "required|email",
                "phone"             =>      "required|numeric"
            ]
        );

        // if validation fails
        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $userArray           =       array(
            "first_name"            =>      $request->first_name,
            "last_name"             =>      $request->last_name,
            "full_name"             =>      $request->first_name . " " . $request->last_name,
            "email"                 =>      $request->email,
            "phone"                 =>      $request->phone
        );

        $user        =       User::create($userArray);
        if(!is_null($user)) {
            return response()->json(["status" => $this->status, "success" => true, "message" => "user record created successfully", "data" => $user]);
        }

        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
        }
    }


    // --------------- [ User Listing ] -------------------
    public function usersListing() {
        $users       =       User::all();
        if(count($users) > 0) {
            return response()->json(["status" => $this->status, "success" => true, "count" => count($users), "data" => $users]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no record found"]);
        }
    }

    // --------------- [ User Detail ] ----------------
    public function userDetail($id) {
        $user        =       User::find($id);
        if(!is_null($user)) {
            return response()->json(["status" => $this->status, "success" => true, "data" => $user]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no user found"]);
        }
    }
}
