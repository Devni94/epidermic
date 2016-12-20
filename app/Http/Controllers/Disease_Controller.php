<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/18/2016
 * Time: 11:23 AM
 */

namespace app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use app\Http\Controllers\Response;

class Disease_Controller extends Controller{
    public static function add_disease(Request $request){
        DB::insert('INSERT INTO disease (registration_no, title, location) VALUES 
        (?,?,?)',[$request->input("title"),$request->input("location")]);
        //$last_id = DB::getPdo()->lastInsertId();
        //return $last_id;
    }

    /*
    public static function  update_disease(Request $request){
        $affected = DB::update('Update  Disease set title = ?, symptoms = ?, postal_code = ?
        where disease_id = ?;', [$request->input("title"),$request->input("symptoms"),$request->input("postal_code"),$request->input("last_id")]);
    }
    */
};