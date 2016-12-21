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
            $obj->status = false;

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
            $obj = new \stdClass();
            $obj->status = false;
            $obj->message="User does not exist";
            $this->apiSendResponse($obj);

        }

        else{
            $query = DB::select("select * from user where email='".$email."' and password='".$password."'");
            if(sizeof($query)==1){
                $token_t = md5(rand(0,1000));
                $token = $email.$token_t;
                $affected = DB::update("update user set token = ? where email = ?",[$token,$email]);
                $query = DB::select("select first_name,last_name from user where email='".$email."'");

                $first_name= $query->first_name;
                $last_name=$query->last_name;

                $obj = new \stdClass();
                $obj->token = $token;
                $obj->status = true;
                $obj->email = $email;
                $obj->password = $password;
                $obj->first_name=$first_name;
                $obj->last_name=$last_name;

                $this->apiSendResponse($obj);
            }
            else{
                $obj = new \stdClass();
                $obj->status = false;
                $obj->message="Password Incorrect";
                $this->apiSendResponse($obj);
            }

        }
    }

    public function signOut(Request $request){
        $requestObject = $request->get('data');
        $register = $this->objectDeserialize($requestObject);
        $email = $register->email;
        $token = $register->token;
        $token = null;
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
    
    public function getRequest(Request $request){
        $requestObject = $request->get('data');
        $register = $this->objectDeserialize($requestObject);

        $requestData = $request->get('function_data');
        $registerData = $this->objectDeserialize($requestData);

        $email = $register->email;
        $token = $register->token;
        $function_name= $register->function_name;

        
        $query = DB::select("select * from user where email='".$email."' and token='".$token."'");

        if(sizeof($query)==1){
            $obj = new \stdClass();
            if($function_name == "add_Report_Disease"){
                $disease_report = new Report_Controller();
                $status = $disease_report->add_Report_Disease($registerData,$email);
                if($status){
                    $obj->status = true;
                    $obj->message="Successfully added";
                    $this->apiSendResponse($obj);
                }
                else{
                    $obj->status = false;
                    $obj->message="Adding disease failed";
                    $this->apiSendResponse($obj);
                }
            }
            elseif ($function_name == "update_disease"){
                $details = new Disease_Controller();
                $status = $details->update_disease($registerData,$email);
                if($status){
                    $obj->status = true;
                    $obj->message="Successfully added the details";
                    $this->apiSendResponse($obj);

                }
                else{
                    $obj->status = false;
                    $obj->message="Adding details failed";
                    $this->apiSendResponse($obj);
                }
            }
            elseif ($function_name == "location_disease"){
                $location = new Report_Controller();
                $disease = $location-> get_location_disease($registerData);
                $disease_array = [];
                foreach ($disease as $row){
                    $temp = new \stdClass();

                    $disease_name = $row->disease_name;

                    $temp->disease_name=$disease_name;

                    $disease_array[] = $temp;

                }
                $obj->data = $disease_array;
                $obj->status=true;
                return $this->apiSendResponse($obj);

            }
            elseif($function_name == "view_disease"){
                $v_disease = new Disease_Controller();
                $details = $v_disease->view_disease($registerData);
                $disease_details = [];
                foreach ($details as $row){
                    $temp = new \stdClass();

                    $symptoms = $row->symptoms;
                    $causes = $row->causes;
                    $precautions = $row->precautions;
                    $first_aid = $row->first_aid;

                    $temp->symptoms = $symptoms;
                    $temp->causes = $causes;
                    $temp->precautions = $precautions;
                    $temp->first_aid = $first_aid;

                    $disease_details[]=$temp;
                }
                $obj->data = $disease_details;
                $obj->status=true;
                return $this->apiSendResponse($obj);

            }
            elseif ($function_name == "view_unfilled_disease"){
                $disease_ct = new Disease_Controller();
                $unfilled = $disease_ct->view_unfilled_disease();
                $disease_unfilled = [];
                foreach ($unfilled as $row){
                    $temp = new \stdClass();
                    
                    $disease_name = $row->disease_name;

                    $temp->disease_name=$disease_name;

                    $disease_unfilled[]=$temp;
                }
                $obj->data = $disease_unfilled;
                $obj->status=true;
                return $this->apiSendResponse($obj);
            }
        }
    }
}