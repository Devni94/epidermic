<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/20/2016
 * Time: 6:05 PM
 */

namespace App\Http\Controllers;

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
    public function apiSendResponse($object){
        $response = new Response($this->objectSerialize($object));
        return $response;
    }
    public function responseObj($message){
        $obj = new \stdClass();
        $obj->message = $message;
        return $this->apiSendResponse($obj);
    }
    

    public function signUp(Request $request)
    {
        $requestObject = $request->get('data');
        $register = $this->objectDeserialize($requestObject);

        //$register->first_name;
        //$register->first_name);

        $first_name = $register->first_name;
        $last_name = $register->last_name;
        $email = $register->email;
        $password = $register->password;
        $role = $register->role;
        $registration_no = null;

//        $first_name = $request->input("first_name");
//        $last_name = $request->input("last_name");
//        $email = $request->input("email");
//        $password = $request->input("password");
//        $role = $request->input("role");
//        $role = $request->input("role");
//        $email =

        if($role == "doctor" or $role == "phi")
        {
            $registration_no = $register->registration_no;
        }

        if ($this->isUserExists($email)){
            $obj = new \stdClass();
            $obj->message = "Email address already exists";

            return $this->apiSendResponse($obj);
        }
        else{
            if($role == "user"){
                $user = new user_Controller();
                $user->signUp($first_name,$last_name,$email,$password);
            }
            elseif($role == "doctor"){
                $user = new doctor_Controller();
                $user->doctor_signUp($first_name,$last_name,$email,$password,$registration_no);
            }

            else{
                $user = new phi_Controller();
                $user->phi_signUp($first_name,$last_name,$email,$password,$registration_no);
            }
        }


    }

    public function signIn(Request $request){

        $requestObject = $request->get('data');
        $register = $this->objectDeserialize($requestObject);
        $email = $register->email;
        $password = $register->password;

        if (!$this->isUserExists($email)){
            $this->responseObj("User does not exist");

        }

        else{
            $query = DB::select("select * from user where email='".$email."' and password='".$password."'");
            if(sizeof($query)==1){
                $token_t = md5(rand(0,1000));
                $token = $email.$token_t;
                $affected = DB::update("update user set token = ? where email = ?",[$token,$email]);

                $obj = new \stdClass();
                $obj->token = $token;
                $this->apiSendResponse($obj);
            }
            else{
                $this->responseObj("Password Incorrect");
            }

        }
        
    }

    public function isUserExists($email){
        $query = DB::select("select email from user where email='".$email."'");

        if (sizeof($query)==1){
            return true;
        }
        else{
            return false;
        }
    }


}