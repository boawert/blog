

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">กำหนดราคา</div>

                <div class="panel-body">

                        <?php

use Maatwebsite\Excel\Facades\Excel;
use App\Carry;


                         function decryptProductType($data){
                            if($data==="1"){
                                return "หิน";
                            } else if($data==="2"){
                                return "ทราย";
                            }else if($data==="3"){
                                return "ยาง";
                            } else {
                                return "อื่นๆ";
                            }
                        }

                        $carries=Carry::all();
                        
                        if(!is_null($carries) && file_exists('public/datafiles/order.xls')){

                            $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/order.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();

                            

                            echo "<style>";
                        echo ".table_style {
                                        font-family: arial, sans-serif;
                                        border-collapse: collapse;
                                        width: 100%;
                                    }

                                td, th {
                                    border: 1px solid #dddddd;
                                    text-align: left;
                                    padding: 8px;
                                        }

                                tr:nth-child(even) {
                                    background-color: #dddddd;
                                    }
                                </style>
                                 ";    

                            echo "<body>";
                            echo "อัพเดตเมื่อวันที่ ".$save_excel[0][0]." เวลา ".$save_excel[1][0]."<br>";

                            echo "<table class='table_style'>";
                            echo "<tr>";
                            echo "<th>ลูกค้า</th>";
                            echo "<th>สินค้า</th>"; 
                            
                            echo "<th>Action</th>"; 
                            echo "</tr>";
                        

                            foreach ($carries as $carry) {
                             echo "<tr>";
                             $customer =DB::table('customers')->where('customer_id',$carry->customer_id )->first();
                             // $product =DB::table('products')->where('product_id',$carry->product_id )->first();
                        
                             
                             if(is_null($customer)){
                                echo "<td>".$carry->customer_id."</td>";
                             } else {
                                echo "<td>".$customer->customer_name."</td>";
                             }
                                echo "<td>".decryptProductType($carry->product_type)."</td>";
                             // if(is_null($product)){
                             //    echo "<td>".$carry->product_id."</td>";
                             // } else {
                             //    echo "<td>".$product->product_name."</td>";
                             // }
                             
                             

                            

                                echo "<td>
                                <li><a href=".url('/defineprice/edit/'.$carry->id)."/0>กำหนด/แก้ไขราคา</a></li>
                                </td>";


                             
                        
                             



                             echo "</tr>";
                            }



                        echo "</table>";
                        echo "</body>";
                    } else {
                        echo "No data , please upload order.";
                    }
                    
                        




?>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection