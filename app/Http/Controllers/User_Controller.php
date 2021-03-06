<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/18/2016
 * Time: 10:25 AM
 */

namespace app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\API_Controller;

class user_Controller extends Controller{
    public function signUp($first_name,$last_name,$email,$password){
        $token_t = md5(rand(0,1000));
        $token = $email.$token_t;
        DB::insert("INSERT INTO user(first_name, last_name, email, password, token)VALUES ('".$first_name."','".$last_name."','".$email."','".$password."','".$token."')");
            //[$request->input("User_Name"),$request->input("Password"),$request->input("first_name"),$request->input("last_name")]);
        $obj = new \stdClass();
        $obj->token = $token;
        $obj->status=true;
        $obj->message = "Successfully Signed Up";
        $api = new API_Controller();
        return $api->apiSendResponse($obj);
        
    }
    
    public function update_password(Request $request){
        $affected = DB::update("update user set password = ? where email = ?", [$request->input("password"),$request->input("email")]);
        $api = new API_Controller();
        $obj = new \stdClass();
        $obj->message = "Successfully changed the password";
        $obj->status=true;
        $api = new API_Controller();
        return $api->apiSendResponse($obj);
    }
    
    public function update_first_name(Request $request){
        $affected = DB::update('update user set first_name = ? where email = ?', [$request->input("first_name"),$request->input("email")]);
        $obj = new \stdClass();
        $obj->message = "Successfully changed the password";
        $obj->status=true;
        $api = new API_Controller();
        return $api->apiSendResponse($obj);
    }
    
    public function update_last_name(Request $request){
        $affected = DB::update('update user set last_name = ? where email = ?', [$request->input("last_name"),$request->input("email")]);
        $obj = new \stdClass();
        $obj->message = "Successfully changed the last name";
        $obj->status=true;
        $api = new API_Controller();
        return $api->apiSendResponse($obj);
    }
};