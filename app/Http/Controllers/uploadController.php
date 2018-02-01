<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Maatwebsite\Excel\Facades\Excel;

use DB;

use Auth;

use App\Order;

use App\Carry;

class uploadController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return view('auth/login');
        }else{
            return view('uploads/uploadfile');
        }
    	
    }
         public function define_distance($id){
   
            if(Auth::guest()){
            return view('auth/login');
        }else{
            return view('uploads/definedistance',compact('id'));
        }

        

     }

     public function isTargetProduct($data){
        $target=array('ก01','ด01','น01','น02','ป01','ป01-1','ป02','ผ04','ย08','ส01','ห01','ห01-1','ท02','ท02-1','ท02-3','ท02-4','ท02-5','ท02-6','อ01');
        if(in_array($data, $target)){
            return false;
        }
        else return true;
    }

    public function getProductType($name){

    if(strpos($name, "หิน")!==false){
        return "1";
    } else if(strpos($name, "ทราย")!==false){
        return "2";
    } else if(strpos($name, "ยาง")!==false){
        return "3";
    } else {
        return "0";
    }



}




    public function getCarryStatus($save_excel,$key,$row){
        if($row[7]<18000){
            if(strpos($row[0], "แม่")!==false){
                if(strpos($save_excel[$key+1][0],"ลูก")!==false){
                    if(($row[8]+$save_excel[$key+1][8])>50500){
                        return true;
                    }
                    else {
                        return false;
                    }
                } 
                else {
                    if($row[8]>27000){
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            else if(strpos($row[0], "ลูก")!==false){
                if(strpos($save_excel[$key-1][0],"แม่")!==false){
                    if(($row[8]+$save_excel[$key-1][8])>50500){
                        return true;
                    }
                    else {
                        return false;
                    }
                } 
                else {
                    if($row[8]>27000){
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            else {
                if($row[8]>27000){
                    return true;
                } else {
                    return false;
                }
            }
        }
        else {
            if($row[8]>50500){
                return true;
            } else {
                return false;
            }
        }
    }

     public function define_distance_update(Request $request,$id){
        if(Auth::guest()){
            echo '<script language="javascript">';
            echo 'alert("Access Denied , Please Login .")';
            echo '</script>';
            return view('auth/login');
        }else{

            $dis=$request->all();

            DB::table('orders')
            ->where('id', $id)
            ->update(['distance' => $dis['distance']]);

            
            echo '<script language="javascript">';
            echo 'alert("success !!")';
            echo '</script>';

            return view('uploads/uploadfile');

        }
     }

    public function store(request $request)
    {
    	$data = $request->file('file');
                //$filename  = time()."-".$image->getClientOriginalName();
    			$filename="order";
                $data->move(public_path("/datafiles"), $filename.".xls");
                //$file = Image::make(sprintf('uploads/%s', "ahoj"))->resize(600,400)->save();

    //             $edata=[];

    //     		Mail::send('emails.test', $edata, function ($message) 
    //     		{	
    // 				$message->from('boawert@gmail.com', 'SAHASILA.Admin');
    // 				$message->to('boawert@gmail.com', 'Client')->subject('Summary Report');
				// });

               $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/order.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();

                foreach ($save_excel as $key => $row) {
                    
                            if ($row[1]!=null 
                                &&$row[2]!=null 
                                && $row[1]!="เลขที่ชั่งออก")
                            {
                                if($this->isTargetProduct($row[6])){
                                    $available_orders=DB::table('orders')
                                ->where('checkout_id',$row[1])
                                ->first();

                                if(is_null($available_orders)){
                                    $order = new Order;
                                    $order->license_plate = $row[0];
                                    $order->checkout_id = $row[1];
                                    $order->transaction_id = $row[2];

                                    $datetime = str_replace('/', '-', $row[3]);
                                    $dt=date("Y/m/d", strtotime($datetime));

                                    $order->date = (string)$dt." ".$row[4].":00";
                                    $order->time = $row[4];
                                    $order->customer_id = $row[5];
                                    $order->product_id = $row[6];
                                    $order->car_weight= $row[7];
                                    $order->all_weight= $row[8];
                                    $order->total_weight= $row[9];
                                    $order->unit= $row[10];
                                    // $order->is_carry=iscarry($row[11]);
                                    $order->is_carry=$this->getCarryStatus($save_excel,$key,$row);

                                    $product_object=DB::table('products')->
                                    where('product_id',$row[6])->first();
        
                                    $available_carry=DB::table('carries')
                                ->where([['customer_id',$row[5]],['product_type',$this->getProductType($product_object->product_name)]])
                                ->first();

                                if(is_null($available_carry)){

                                    $carry=new Carry;
                                    $carry->customer_id=$row[5];
                                    $carry->product_type=$this->getProductType($product_object->product_name);

                                    $carry->save();

                                } else {
                                        
                                 }



                                    $order->save();

                                } else {

                                    $iscarry_val=$this->getCarryStatus($save_excel,$key,$row);

                                    $datetime = str_replace('/', '-', $row[3]);
                                    $dt=date("Y/m/d", strtotime($datetime));

                                    DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['license_plate' => $row[0]]);

                                    DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['transaction_id' => $row[2]]);

                                    DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['date' => (string)$dt." ".$row[4].":00"]);

                                    DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['time' => $row[4]]);

                                    DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['customer_id' => $row[5]]);

                                    DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['product_id' => $row[6]]);

                                        DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['car_weight' => $row[7]]);

                                        DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['all_weight' => $row[8]]);

                                        DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['total_weight' => $row[9]]);

                                        DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['unit' => $row[10]]);

                                        DB::table('orders')
                                        ->where('checkout_id', $row[1])
                                        ->update(['is_carry' => $iscarry_val]);
                                }
                                }
    
                        }

    }               
            return view('uploads/uploadfile');

    }

}
