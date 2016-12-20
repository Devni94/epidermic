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

class Public_User_Controller extends Controller{
    public static function add_user(Request $request){
        DB::insert('INSERT INTO Public_User(email, Password, first_name, last_name)VALUES (?,?,?,?)',
            [$request->input("User_Name"),$request->input("Password"),$request->input("first_name"),$request->input("last_name")]);
    }
    public static function  update_password(Request $request){
        $affected = DB::update('update Public_User set Password = ? where User_Name = ?', [$request->input("Password"),$request->input("User_Name")]);
    }
    public static function  update_first_name(Request $request){
        $affected = DB::update('update Public_User set first_name = ? where User_name = ?', [$request->input("first_name"),$request->input("User_name")]);
    }
    public static function  update_last_name(Request $request){
        $affected = DB::update('update Public_User set last_name = ? where User_name = ?', [$request->input("last_name"),$request->input("User_name")]);
    }
};