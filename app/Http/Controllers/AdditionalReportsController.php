<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\AdditionalReport;

class AdditionalReportsController extends Controller
{
    //
    public function index()
    {
        if(Auth::guest()){
            return view('auth/login');
        }else{
            return view('additionalreports');
        }
    	
    }

    public function store(request $request)
    {
    	$additionalreport=new AdditionalReport();
    	$additionalreport->license_plate = $request->input('license_plate');
    	$additionalreport->checkout_id = $request->input('checkout_id');
    	$additionalreport->transaction_id = $request->input('transaction_id');
    	$additionalreport->product_name = $request->input('product_name');
    	$additionalreport->customer_name = $request->input('customer_name');
    	$additionalreport->date_time = $request->input('date').' '.$request->input('time');
    	$additionalreport->car_weight = $request->input('car_weight');
    	$additionalreport->all_weight = $request->input('all_weight');
    	$additionalreport->total_weight = $request->input('total_weight');
    	$additionalreport->unit = $request->input('unit');
    	$additionalreport->price = $request->input('price');
        $additionalreport->save();        

                 
           return redirect()->action('AdditionalReportsController@index');
    }

}
