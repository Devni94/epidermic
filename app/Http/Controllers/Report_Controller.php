<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/18/2016
 * Time: 5:22 PM
 */

namespace app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class Report_Controller extends Controller{

    public static function get_disease_details(Request $request){

       $results = DB::select('select * from treatments where disease_name = ?', [$request->input("disease_name")]);
        return $results;
    }

    public static function get_location_diseases(Request $request){
        $results = DB::select('select disease_name from location_disease where location = ?', [$request->input("location")]);
        return $results;
    }

}