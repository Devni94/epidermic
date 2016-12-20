<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2016
 * Time: 9:57 PM
 */

namespace app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use app\Http\Controllers\user_Controller;

class phi_Controller extends Controller{
    public static function signUp($first_name,$last_name,$email,$password,$registration_no){
        DB::insert('INSERT INTO user(first_name, last_name, email, password)VALUES ($first_name,$last_name,$email,$password,$registration_no)');
        API_controller::responseObj("successfully signed up");
    }
}