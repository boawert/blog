<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Maatwebsite\Excel\Facades\Excel;

use DB;

use App\Customer;

class UploadCustomerController extends Controller
{
    //
    public function index()
    {
    	return view('uploads/uploadcustomer');
    }


        public function store(request $request)
    {
    	$data = $request->file('upload_customer_file');
                //$filename  = time()."-".$image->getClientOriginalName();
    			$filename="customer";

               $data->move(public_path("/datafiles"), $filename.".xls");

               $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/customer.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();



                foreach ($save_excel as $key => $row) {
                    
                            if ($row[0]!=null && $row[0]!="รหัส" && $row[1]!=null){

                                $available_products=DB::table('customers')
                                ->where('customer_id',$row[0])
                                ->first();


                                if(is_null($available_products)){
                                    $product = new Customer;
                                    $product->customer_id = $row[0];
                                    $product->customer_name = $row[1];
                                    $product->save();

                                } else {
                                    DB::table('customers')
                                        ->where('customer_id', $row[0])
                                        ->update(['customer_name' => $row[1]]);
                                }
                                

                                
                            
                        }


                

    }

                
            return view('uploads/uploadcustomer');
}



public function bingo_index()
    {
        return view('uploads/uploadBingo');
    }


            public function bingo_store(request $request)
    {
        $data = $request->file('upload_bingo_file');
                //$filename  = time()."-".$image->getClientOriginalName();
                $filename="bingo";

               $data->move(public_path("/datafiles"), $filename.".xls");

                //$file = Image::make(sprintf('uploads/%s', "ahoj"))->resize(600,400)->save();


    //             $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/customer.xls', function($reader) {
    //                         $reader->noHeading();
    //                         $datas = $reader->toArray();
    //                     })->toArray();


    //             foreach ($save_excel as $key => $row) {
                    
    //                         if ($row[2]!=null && $row[2]!="รหัส" && $row[4]!=null){

    //                             $product = new Product;
    //                             $product->product_id = $row[2];
    //                             $product->product_name = $row[4];
    //                             $product->save();
                                
                            
    //                     }


                

    // }
            return view('uploads/uploadBingo');
}

}


