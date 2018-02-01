

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading">Upload Excel File</div>

                <div class="panel-body">

                    <form action="/price_store" method="post" enctype="multipart/form-data">
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
use App\Carry_Value;
use App\Carry;

                        function getProductTypeTrans($id){

                            if($id==="1"){return "หิน";} 
                            else if($id==="2"){return "ทราย";} 
                            else if($id==="3"){return "ยาง";} 
                            else {return "0";}
                        }


                //         $orders=DB::table('orders')
                // ->orderBy('checkout_id', 'asc')
                // ->get();
                        $prices=Carry_Value::orderBy('carry_id','asc')->paginate(20);
                        $prices->setPath('/uploadprice');
                        
                        if(!is_null($prices) && file_exists('public/datafiles/price.xls')){

                            $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/price.xls', function($reader) {
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
                            echo "เดือนล่าสุด ".$save_excel[0][0]."<br>";

                            echo "<table class='table_style'>";
                            echo "<tr>";
                            echo "<th>ชื่อลูกค้า</th>";
                            echo "<th>ประเภทสินค้า</th>";
                            echo "<th>ราคาแบก</th>";
                            echo "<th>ราคาไม่แบก</th>"; 
                            
                           
                            echo "</tr>";
                        

                            foreach ($prices as $price) {
                             echo "<tr>";

                             $carry =DB::table('carries')->where('id',$price->carry_id )->first();
                            if(is_null($carry)){

                                echo "<td> (ไม่มีข้อมูล) </td>";
                                echo "<td> (ไม่มีข้อมูล) </td>";

                            } else {
                                $customer =DB::table('customers')->where('customer_id',$carry->customer_id )->first();
                                echo "<td>".$customer->customer_name."</td>";
                                echo "<td>".getProductTypeTrans($carry->product_type)."</td>";

                            }

                            if(is_null($price->carry_price)){
                                echo "<td> (ไม่มีข้อมูล) </td>";
                                
                            }else {
                                echo "<td>".$price->carry_price."</td>";
                            }

                            if(is_null($price->notcarry_price)){
                                echo "<td> (ไม่มีข้อมูล) </td>";
                                
                            }else {
                                echo "<td>".$price->notcarry_price."</td>";
                            }

                             echo "</tr>";

                            }



                        echo "</table>";
                        
                        echo $prices->links();
                        echo "</body>";
                    } else {
                        echo "No price data , please upload.";
                    }
                    
                        




?>
        </div>
    </div>
</div>

@endsection