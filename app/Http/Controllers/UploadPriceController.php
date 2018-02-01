<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Maatwebsite\Excel\Facades\Excel;

use DB;

use Auth;

use App\Order;

use App\Carry;

use App\Carry_value;



class UploadPriceController extends Controller
{
    
    public function index()
    {
        if(Auth::guest()){
            return view('auth/login');
        }else{
            return view('uploads/uploadprice');
        }
    }

    
    public function create()
    {
        //
    }

   
    public function store(request $request)
    {
        $data = $request->file('file');
                
                $filename="price";
                $data->move(public_path("/datafiles"), $filename.".xls");
   
               $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/price.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();

                foreach ($save_excel as $key => $row) {
                    
                            if ($row[0]!=null&&$row[1]!=null )
                            {
                                $available_carry_1=DB::table('carries')
                                ->where([['customer_id',$row[0]],['product_type',1]])
                                ->first();
                                if(is_null($available_carry_1)){
                                    $carry=new Carry;
                                    $carry->customer_id=$row[0];
                                    $carry->product_type=1;
                                    $carry->save();
                                } else { }


                                $carry_data_1=DB::table('carries')
                                ->where([['customer_id',$row[0]],['product_type',1]])
                                ->first();
                                    
                                $available_carry_value_1=DB::table('carry_values')
                                ->where([['carry_id',$carry_data_1->id],['year_month',$save_excel[0][0]]])->first();

                                if(is_null($available_carry_value_1)){

                                    $carry_values=new Carry_value;
                                    $carry_values->carry_id=$carry_data_1->id;
                                    $carry_values->year_month=$save_excel[0][0];
                                    $carry_values->carry_price=$row[2];
                                    $carry_values->notcarry_price=$row[3];
                                    $carry_values->save();


                                }else {
                                    DB::table('carry_values')
                                        ->where([['carry_id',$carry_data_1->id],['product_type',1],['year_month',$save_excel[0][0]]])
                                        ->update(['carry_price' => $row[2]]);

                                        DB::table('carry_values')
                                        ->where([['carry_id',$carry_data_1->id],['product_type',1],['year_month',$save_excel[0][0]]])
                                        ->update(['notcarry_price' => $row[3]]);
                                }


                                $available_carry_2=DB::table('carries')
                                ->where([['customer_id',$row[0]],['product_type',2]])
                                ->first();
                                if(is_null($available_carry_2)){
                                    $carry=new Carry;
                                    $carry->customer_id=$row[0];
                                    $carry->product_type=2;
                                    $carry->save();
                                } else { }


                                $carry_data_2=DB::table('carries')
                                ->where([['customer_id',$row[0]],['product_type',2]])
                                ->first();
                                    
                                $available_carry_value_2=DB::table('carry_values')
                                ->where([['carry_id',$carry_data_2->id],['year_month',$save_excel[0][0]]])->first();

                                if(is_null($available_carry_value_2)){

                                    $carry_values=new Carry_value;
                                    $carry_values->carry_id=$carry_data_2->id;
                                    $carry_values->year_month=$save_excel[0][0];
                                    $carry_values->carry_price=$row[4];
                                    $carry_values->notcarry_price=$row[5];
                                    $carry_values->save();


                                }else {
                                    DB::table('carry_values')
                                        ->where([['carry_id',$carry_data_1->id],['product_type',2],['year_month',$save_excel[0][0]]])
                                        ->update(['carry_price' => $row[4]]);

                                        DB::table('carry_values')
                                        ->where([['carry_id',$carry_data_1->id],['product_type',2],['year_month',$save_excel[0][0]]])
                                        ->update(['notcarry_price' => $row[5]]);
                                }

                                $available_carry_3=DB::table('carries')
                                ->where([['customer_id',$row[0]],['product_type',3]])
                                ->first();
                                if(is_null($available_carry_3)){
                                    $carry=new Carry;
                                    $carry->customer_id=$row[0];
                                    $carry->product_type=3;
                                    $carry->save();
                                } else { }


                                $carry_data_3=DB::table('carries')
                                ->where([['customer_id',$row[0]],['product_type',3]])
                                ->first();
                                    
                                $available_carry_value_3=DB::table('carry_values')
                                ->where([['carry_id',$carry_data_3->id],['year_month',$save_excel[0][0]]])->first();

                                if(is_null($available_carry_value_3)){

                                    $carry_values=new Carry_value;
                                    $carry_values->carry_id=$carry_data_3->id;
                                    $carry_values->year_month=$save_excel[0][0];
                                    $carry_values->carry_price=$row[6];
                                    $carry_values->notcarry_price=$row[7];
                                    $carry_values->save();


                                }else {
                                    DB::table('carry_values')
                                        ->where([['carry_id',$carry_data_3->id],['product_type',3],['year_month',$save_excel[0][0]]])
                                        ->update(['carry_price' => $row[6]]);

                                        DB::table('carry_values')
                                        ->where([['carry_id',$carry_data_3->id],['product_type',3],['year_month',$save_excel[0][0]]])
                                        ->update(['notcarry_price' => $row[7]]);
                                }



                                } 
                            }


        
    
    

                   
            return view('uploads/uploadprice');

    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
