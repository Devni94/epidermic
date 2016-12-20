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
        DB::insert("INSERT INTO user(first_name, last_name, email, password)VALUES ('".$first_name."','".$last_name."','".$email."','".$password."')");
        DB::insert("INSERT INTO doctor(email, registration_no)VALUES ('".$email."','".$password."')");
        
        $api = new API_controller();
        $api->responseObj("successfully signed up");
    }
}