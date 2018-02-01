

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading">Upload Excel File</div>

                <div class="panel-body">

                    <form action="/store" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <input type="file" name="file">
                        <br>
                        <input type="submit" value="Upload" name="submit">
                                                <br>
                        <br>
                        

                    </form>
                </div>


            </div><?php

use Maatwebsite\Excel\Facades\Excel;
use App\Order;
use App\Customer;


                //         $orders=DB::table('orders')
                // ->orderBy('checkout_id', 'asc')
                // ->get();
                        $orders=Order::orderBy('checkout_id','asc')->paginate(20);
                        $orders->setPath('/uploadfile');
                        
                        if(!is_null($orders) && file_exists('public/datafiles/order.xls')){

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
                            echo "<th>ทะเบียนรถ</th>";
                            echo "<th>เลขที่ชั่งออก</th>";
                            echo "<th>เล่มที่/เลขที่</th>";
                            echo "<th>วันที่</th>"; 
                            echo "<th>เวลา</th>"; 
                            echo "<th>ลูกค้า</th>"; 
                            echo "<th>สินค้า</th>"; 
                            echo "<th>ระยะทาง(กม)</th>";
                            echo "<th>นน.รถ</th>"; 
                            echo "<th>นน.รวม</th>";     
                            echo "<th>นน.สุทธิ</th>";   
                            echo "<th>หน่วย</th>";   
                            echo "<th>แบก/ไม่แบก</th>";  
                           
                            echo "</tr>";
                        

                            foreach ($orders as $order) {
                             echo "<tr>";
                             echo "<td>".$order->license_plate."</td>";
                             echo "<td>"."000".$order->checkout_id."</td>";
                             echo "<td>".$order->transaction_id."</td>"; 
                             echo "<td>".(string)date("d/m/Y", strtotime(str_replace('/', '-', explode(" ",$order->date)[0])))."</td>";
                             echo "<td>".$order->time."</td>";

                             $customer =DB::table('customers')->where('customer_id',$order->customer_id )->first();
                             $product =DB::table('products')->where('product_id',$order->product_id )->first();
                            if(is_null($customer)){
                                echo "<td>".$order->customer_id." (ไม่มีข้อมูลชื่อลูกค้า) </td>";
                            } else {
                                echo "<td>".$customer->customer_name."</td>";
                            }

                            if(is_null($product)){
                                echo "<td>".$order->product_id." (ไม่มีข้อมูลชื่อสินค้า) </td>";
                            } else {
                                echo "<td>".$product->product_name."</td>";
                            }


                             if(is_null($order->distance)){

                                echo "<td><li><a href=".url('/definedistance/'.$order->id).">กำหนด</a></li></td>";

                             }else{

                                echo "<td>".number_format($order->distance)."</td>";
                             }
                             
                             
                            
                             echo "<td>".number_format($order->car_weight)."</td>";
                             echo "<td>".number_format($order->all_weight)."</td>";
                             echo "<td>".number_format($order->total_weight)."</td>";
                             echo "<td>".$order->unit."</td>";

                             if($order->is_carry==0){
                                
                                echo "<td>ไม่แบก</td>";

                            

                            } else{
                                echo "<td>แบก</td>";
                            }
                             



                             echo "</tr>";
                            }



                        echo "</table>";
                        
                        echo $orders->links();
                        echo "</body>";
                    } else {
                        echo "No order data , please upload.";
                    }
                    
                        




?>
        </div>
    </div>
</div>

@endsection