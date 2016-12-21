<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2016
 * Time: 9:57 PM
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class phi_Controller extends Controller{
    public function phi_signUp($first_name,$last_name,$email,$password,$registration_no){
        $token_t = md5(rand(0,1000));
        $token = $email.$token_t;
        DB::insert("INSERT INTO user(first_name, last_name, email, password, token)VALUES ('".$first_name."','".$last_name."','".$email."','".$password."','".$token."')");
        DB::insert("INSERT INTO phi(email, registration_no)VALUES ('".$email."','".$registration_no."')");
        
        $obj = new \stdClass();
        $obj->token = $token;
        $obj->status=true;
        $obj->message = "Successfully Signed Up";
        $api = new API_Controller();
        return $api->apiSendResponse($obj);
    }
}