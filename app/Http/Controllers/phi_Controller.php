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
        echo ($first_name);
        DB::insert("INSERT INTO user(first_name, last_name, email, password)VALUES ('".$first_name."','".$last_name."','".$email."','".$password."')");
        DB::insert("INSERT INTO phi(email, registration_no)VALUES ('".$email."','".$registration_no."')");
        $api = new API_controller();
        $api->responseObj("successfully signed up");
    }
}