<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2016
 * Time: 9:29 PM
 */

namespace app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;


class doctor_Controller extends Controller{
    public function doctor_signUp($first_name,$last_name,$email,$password,$registration_no){
        $token_t = md5(rand(0,1000));
        $token = $email.$token_t;
        DB::insert("INSERT INTO user(first_name, last_name, email, password, token)VALUES ('".$first_name."','".$last_name."','".$email."','".$password."','".$token."')");
        DB::insert("INSERT INTO doctor(email, registration_no)VALUES ('".$email."','".$registration_no."')");
        
        $api = new API_controller();
        $api->responseObj("successfully signed up");
    }
}