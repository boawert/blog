<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Maatwebsite\Excel\Facades\Excel;

use App\Product;
use DB;

class UploadProductController extends Controller
{
    //
    public function index()
    {
    	return view('uploads/uploadproduct');
    }

    public function store(request $request)
    {
    	$data = $request->file('upload_product_file');
    			$filename="product";
               $data->move(public_path("/datafiles"), $filename.".xls");

                $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/product.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();



                foreach ($save_excel as $key => $row) {
                    
                            if ($row[2]!=null && $row[2]!="รหัส" && $row[4]!=null && $this->isTargetProduct($row[2])){

                                $available_products=DB::table('products')
                                ->where('product_id',$row[2])
                                ->first();


                                if(is_null($available_products)){
                                    $product = new Product;
                                    $product->product_id = $row[2];
                                    $product->product_name = $row[4];
                                    $product->product_type = $this->getProductType($row[4]);

                                    $product->save();

                                } else {
                                    DB::table('products')
                                        ->where('product_id', $row[2])
                                        ->update(['product_name' => $row[4]]);

                                    DB::table('products')
                                        ->where('product_id', $row[2])
                                        ->update(['product_type' => $this->getProductType($row[4])]);
                                }
                                

                                
                            
                        }


                

    }
            return view('uploads/uploadproduct');
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


}