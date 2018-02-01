<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\Carry;
use App\Carry_value;
use DB;

class DefineCarryPriceController extends Controller
{
    //
       public function index()
    {

    	
    	 if(Auth::guest()){
    	 	echo '<script language="javascript">';
            echo 'alert("Access Denied , Please Login .")';
            echo '</script>';
            return view('auth/login');
        }else{

        	return view('defineprice/definecarryprice');

        }
    }
     public function edit($id,$monthyear,Request $request){
        $req=$request->all();
        if($monthyear==0){

        } else {
            $monthyear=$req['monthyear'];
        }
     	return view('defineprice/edit',compact('id','monthyear'));

     }

          public function edit_cotruck_price($id){
            $carry =DB::table('carries')->where('id',$id )->first();
            $carryprice=$carry->carry_price;
            $notcarryprice=$carry->notcarry_price;

        return view('defineprice/edit_redirect_to_cotruck',compact('id','carryprice','notcarryprice'));

     }

     public function update(Request $request,$id,$monthyear){
     	if(Auth::guest()){
            echo '<script language="javascript">';
			echo 'alert("Access Denied , Please Login .")';
			echo '</script>';
			return view('auth/login');
        }else{

        	$price=$request->all();

            $carry_val=DB::table('carry_values')
                        ->where('carry_id',$id)
                        ->where('year_month',$monthyear)
                        ->first();
            if(is_null($carry_val)){
                $carry_value=new Carry_value;
                $carry_value->carry_id=$id;
                $carry_value->year_month=$monthyear;
                $carry_value->carry_price=$price['carry'];
                $carry_value->notcarry_price=$price['notcarry'];
                $carry_value->save();
            }
            else {
                DB::table('carry_values')
            ->where('id', $carry_val->id)
            ->update(['carry_price' => $price['carry']]);

            DB::table('carry_values')
            ->where('id', $carry_val->id)
            ->update(['notcarry_price' => $price['notcarry']]);
            }

        	

        	echo '<script language="javascript">';
			echo 'alert("success !!")';
			echo '</script>';

        	return view('defineprice/definecarryprice');

        }
     }

          public function update_cotruck_price(Request $request,$id){
        if(Auth::guest()){
            echo '<script language="javascript">';
            echo 'alert("Access Denied , Please Login .")';
            echo '</script>';
            return view('auth/login');
        }else{

            $price=$request->all();

            DB::table('carries')
            ->where('id', $id)
            ->update(['carry_price' => $price['carry']]);

            DB::table('carries')
            ->where('id', $id)
            ->update(['notcarry_price' => $price['notcarry']]);

            echo '<script language="javascript">';
            echo 'alert("success !!")';
            echo '</script>';
            
            $from="";
            $to="";
            $is_view_result=0;
            return view('reports/view_cotrucks',compact('is_view_result','from','to'));

        }
     }

    
}
