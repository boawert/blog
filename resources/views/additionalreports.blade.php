

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading">กรอกข้อมูลนอกตาชั่ง</div>

                <div class="panel-body">

                    <form action="/storeadditionalreports" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        ทะเบียนรถ: 
                        <input type="text" name="license_plate">
                        <br><br>
                        เลขที่ชั่งออก: 
                        <input type="number" name="checkout_id">
                        <br><br>
                        เล่มที่/เลขที่: 
                        <input type="text" name="transaction_id">
                        <br><br>
                        วันที่: 
                        <input type="date" name="date">
                         เวลา <input type="time" name="time">

                        <br><br>      
                        ชื่อลูกค้า: 
                        <input type="text" name="customer_name">
                        <br><br>
                        ชื่อสินค้า:
                        <input type="text" name="product_name">
                        <br><br>
                        น้ำหนักรถ:
                        <input type="number" name="car_weight">
                        <br><br>
                        น้ำหนักรวม:
                        <input type="number" name="all_weight">
                        <br><br>
                        น้ำหนักสุทธิ:
                        <input type="number" name="total_weight">
                        <br><br>
                        หน่วย:
                        <input type="number" name="unit">
                        <br><br>

                        ราคารวม:
                        <input type="number" name="price">
                        <br><br>
                        
                        <input type="submit" value="Submit" name="submit">
                                                <br>
                        <br>
                        

                    </form>
                </div>


            </div>
            <br>
            <div><?php

use App\AdditionalReport;


                
                        $additionalreports=AdditionalReport::orderBy('date_time','asc')->paginate(10);
                        $additionalreports->setPath('additionalreports');
                        
                        if(!is_null($additionalreports)){

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
                        
                            echo "<table class='table_style'>";
                            echo "<tr>";
                            echo "<th>ทะเบียนรถ</th>";
                            echo "<th>เลขที่ชั่งออก</th>";
                            echo "<th>เล่มที่/เลขที่</th>";
                            echo "<th>วันที่</th>"; 
                            echo "<th>ลูกค้า</th>"; 
                            echo "<th>สินค้า</th>"; 
                            echo "<th>นน.รถ</th>"; 
                            echo "<th>นน.รวม</th>";     
                            echo "<th>นน.สุทธิ</th>";   
                            echo "<th>หน่วย</th>";   
                            echo "<th>ราคา</th>";  
                           
                            echo "</tr>";
                        

                            foreach ($additionalreports as $additionalreport) {
                             echo "<tr>";
                             echo "<td>".$additionalreport->license_plate."</td>";
                             echo "<td>".$additionalreport->checkout_id."</td>";
                             echo "<td>".$additionalreport->transaction_id."</td>"; 
                             echo "<td>".$additionalreport->date_time."</td>";
                             echo "<td>".$additionalreport->customer_name."</td>"; 
                             echo "<td>".$additionalreport->product_name."</td>";
                        
                             
                             
                            
                             echo "<td>".$additionalreport->car_weight."</td>";
                             echo "<td>".$additionalreport->all_weight."</td>";
                             echo "<td>".$additionalreport->total_weight."</td>";
                             echo "<td>".$additionalreport->unit."</td>";
                             echo "<td>".$additionalreport->price."</td>";

      
                             echo "</tr>";
                            }



                        echo "</table>";
                        
                        echo $additionalreports->links();

                        echo "</body>";
                    } else {
                        echo "No additionalreports data , please key.";
                    }
                    
                        




?></div>
        </div>
    </div>
</div>

@endsection