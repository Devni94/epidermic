<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/18/2016
 * Time: 5:22 PM
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class Report_Controller extends Controller{

    public function add_Report_Disease($registerData, $email){
        $disease_name = $registerData -> disease_name;
        $location = $registerData->location;
        DB::insert('INSERT INTO report_disease(email, disease_name, location)VALUES (?,?,?)',[$email,$disease_name, $location]);
        return true;
    }

    public function get_location_disease($registerData){
        $location= $registerData->location;
        $results = DB::select('select DISTINCT disease_name from report_disease where location = ?', [$location]);
        return $results;
    }

}