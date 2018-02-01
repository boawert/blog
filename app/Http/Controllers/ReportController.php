<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use DB;
use App\Truck;

class ReportController extends Controller
{
    //

    public function index_license(){
    	if(Auth::guest()){
            return view('auth/login');
        }else{
        	$license="";
            $license2="";
        	$from="";
        	$to="";
        	$is_view_result=0;
            return view('reports/view',compact('license','license2','is_view_result','from','to'));
        }
    }

        public function result_license(Request $request){
    	if(Auth::guest()){
            return view('auth/login');
        }else{
        	$result=$request->all();
        	$license=$result['license'];
            $license2=$result['license2'];
        	$from=$result['from_date'];
        	$to=$result['to_date'];
        	$is_view_result=1;
            return view('reports/view',compact('license','license2','is_view_result','from','to'));
        }
    }




        public function index_cotrucks(){
        if(Auth::guest()){
            return view('auth/login');
        }else{
           
            $from="";
            $to="";
            $is_view_result=0;
            return view('reports/view_cotrucks',compact('is_view_result','from','to'));
        }
    }

        public function result_cotrucks(Request $request){
        if(Auth::guest()){
            return view('auth/login');
        }else{
            $result=$request->all();
            $from=$result['from_date'];
            $to=$result['to_date'];
            $is_view_result=1;
            return view('reports/view_cotrucks',compact('is_view_result','from','to'));
        }
    }
    
    public function ajaxCenter()
    {
        if(\Request::ajax()){
            $method =\Request::input('method');
            $person =\Request::input('person');


            // Save To DB.
            $is_available=DB::table('trucks')->where('license_plate',$person)->first();
            if(is_null($is_available)){
                    $truck=new Truck;
                    $truck->license_plate=$person;
                    $truck->save();

            return ['status' => 'success', 'msg' => 'Save Data Success!!'];
            
            } else {
               return ['status' => 'error', 'msg' => 'ข้อมูลนี้อยู่ในทะเบียนร่วมอยู่แล้ว'];
            }

            // return status.
            
        }
    }   
}
