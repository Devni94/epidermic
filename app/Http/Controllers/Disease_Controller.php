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
    /*
    public function add_disease($disease_name){
        DB::insert('INSERT INTO details(disease_name, symptoms, causes, precautions, first_aid, email)VALUES (?,?,?,?,?,?)',[$disease_name,NULL, NULL,NULL, NULL, NULL]);
    }

    */
    public function view_disease($registerData){
        $disease_name = $registerData -> disease_name;
        $result = DB::select('Select * from disease_view where disease_name = ?', [$disease_name]);
        return $result;
    }

    public function view_unfilled_disease(){
        $result = DB::select('select disease_name from details where symptoms is null and causes is null and  precautions is null and  first_aid is null and  email is null');
        return $result;
    }

    public function  update_disease($registerData, $email){
        $disease_name = $registerData -> disease_name;
        $symptoms = $registerData->symptoms;
        $causes = $registerData->causes;
        $precautions= $registerData->precautions;
        $first_aid = $registerData ->first_aid;
        $affected = DB::update('Update details set symptoms = ?, causes = ?, precautions = ?, first_aid = ?, email=? where disease_name = ?',[$symptoms, $causes, $precautions, $first_aid, $email, $disease_name]);
        return true;
    }

};


