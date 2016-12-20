<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2016
 * Time: 6:05 PM
 */

namespace app\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class API_controller extends Controller{
    protected function objectSerialize($object)
    {
        return json_encode($object);
    }
    protected function objectDeserialize($text)
    {
        return json_decode($text);
    }
    protected function apiSendResponse($object){
        $response = new Response($this->objectSerialize($object));
        return $response;
    }

    public function signUp(Request $request)
    {
        $requestObject = $request->get('data');
        $register = $this->objectDeserialize($requestObject);
        $first_name = $register->first_name;
        $last_name = $register->last_name;
        $email = $register->email;
        $password = $register->password;
        $role = $register->user_role;

        if($role == "doctor" or $role == "phi")
        {
            $registration_no = $register->registration_no;
        }

        if ($this->isUserExists($email)){
            $obj = new \stdClass();
            $obj->status = false;
            $obj->message = "Email address already exists";

            return $this->apiSendResponse($obj);
        }
        if($role == "doctor" or $role)
        Public_User_Controller::add_user($first_name,$last_name,$email,$password);

    }

    public function isUserExists($email){
        if (in_array($email,(DB::select('select email from user')))){
            return true;
        }
        else{
            return false;
        }
    }

}