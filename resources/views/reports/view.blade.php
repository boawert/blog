@extends('layouts.app')



@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">รายงานตามทะเบียนรถ</div>

                <div class="panel-body">


                <?php 
            



?>
                    <form action="/report/license/result" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}

                        
                            
                            <b>ทะเบียนรถ : </b><input type="text" name="license" value={{$license}} >
                            - <input type="text" name="license2" value={{$license2}} >

                               <br> <br>
                            
                            <b>วันที่ :</b>   
                            <input type="text" name="from_date" class="from" value={{$from}} >
                            -  
                            <input type="text" name="to_date"  class="to" value={{$to}}>
                            <br><br>
                            <input type="submit" value="ค้นหา">


  
  <script>
  $( function() {
    var dateFormat = "dd/mm/yy",
      from = $( ".from" )
        .datepicker({
          dateFormat:  "dd/mm/yy",
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".to" ).datepicker({
        dateFormat:  "dd/mm/yy",
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>

                
                </div>
            </div>
        </div>
    </div>
    <div>
      <?php
      use Maatwebsite\Excel\Facades\Excel;
      use App\Order;
      use App\Customer;

       if($is_view_result){
        


                        


        echo "<style>";
                        echo ".table_style {
                                        font-family: arial, sans-serif;
                                        border-collapse: collapse;
                                        width: 100%;
                                    }

                                td, th {
                                    border: 1px solid #dddddd;
                                    text-align: left;
                                    padding: 3px;
                                        }

                                tr:nth-child(even) {
                                    background-color: #DCDCDC;
                                    }
                                </style>
                                 ";   

        if($from===$to){
                                    $datetime=str_replace('/', '-', $from);
                                    $dt=date("Y/m/d", strtotime($datetime));
          $orders=DB::table('orders')
                ->whereBetween('license_plate',[$license,$license2])
                ->where('date', 'LIKE', '%' .$dt. '%')
                ->orderBy('license_plate', 'asc')
                ->get();
                if($license===$license2){
                  $view_license_data=$license;
                } else {
                  $view_license_data=$license." - ".$license2;
                }
                
          echo '<div class="report_center" >
              <h2>บริษัท สหศิลาเลย จำกัด</h2><br>รายงานค่าขนส่งของรถทะเบียน '.$view_license_data.' วันที่ '.$from.'</div>';

                                          


      } else {

        $datetime=str_replace('/', '-', $from);
        $dt=date("Y/m/d", strtotime($datetime));
        $datetime2=str_replace('/', '-', $to);
        $dt2=date("Y/m/d", strtotime($datetime2));

        $orders=DB::table('orders')
                ->whereBetween('license_plate',[$license,$license2])
                ->whereBetween('date',[$dt." 00:00:01",$dt2." 23:59:59"])
                ->orderBy('license_plate', 'asc')
                ->get();

            if($license===$license2){
                  $view_license_data=$license;
                } else {
                  $view_license_data=$license." - ".$license2;
                }

        echo '<div class="report_center" >
              <h2>บริษัท สหศิลาเลย จำกัด</h2><br>รายงานค่าขนส่งของรถทะเบียน '.$view_license_data.' วันที่ '.$from.' - '.$to.'</div>';


      }


        echo "<br><table class='table_style'>";
                            echo "<tr>";
                            echo "<th>ทะเบียนรถ</th>";
                            echo "<th>เลขที่ชั่งออก</th>";
                            echo "<th>เล่มที่/เลขที่</th>";
                            echo "<th>วันที่</th>"; 
                            echo "<th>เวลา</th>"; 
                            echo "<th>ลูกค้า</th>"; 
                            echo "<th>สินค้า</th>"; 
                            // echo "<th>ระยะทาง(กม)</th>";
                            echo "<th>นน.รถ</th>"; 
                            echo "<th>นน.รวม</th>";     
                            echo "<th>นน.สุทธิ</th>";   
                            echo "<th>หน่วย</th>";   
                            echo "<th>ราคา/หน่วย</th>";  
                            echo "<th>ราคารวม</th>";  
                            echo "</tr>";
                        
                            $total_price=0;

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
                              echo "<td>".$order->customer_id." ไม่มีข้อมูล </td>";
                             } else {
                              echo "<td>".$customer->customer_name."</td>";
                             }



                             if(is_null($product)){
                              echo "<td>".$order->product_id." ไม่มีข้อมูล </td>";
                             } else {
                              echo "<td>".$product->product_name."</td>";
                             }
                             

                             // if(is_null($order->distance)){

                             //    echo "<td><li><a href=".url('/definedistance/'.$order->id).">กำหนด</a></li></td>";

                             // }else{

                             //    echo "<td>".number_format($order->distance)."</td>";
                             // }
                             
                             
                            
                             echo "<td>".number_format($order->car_weight)."</td>";
                             echo "<td>".number_format($order->all_weight)."</td>";
                             echo "<td>".number_format($order->total_weight)."</td>";
                             echo "<td>".$order->unit."</td>";

                             $carryprice=DB::table('carries')->where([['customer_id',$order->customer_id],['product_type',$product->product_type]])->first();

                             $carryValue=DB::table('carry_values')->where('carry_id',$carryprice->id)->first();

                             if($order->is_carry==0){
                                
                                if(is_null($carryValue)){
                                    echo "<td>ไม่ได้กำหนด</td>";
                                    echo "<td>-</td>";
                                } else{
                                    echo "<td>".$carryValue->notcarry_price."(ไม่แบก)</td>";
                                    echo "<td>".number_format($carryValue->notcarry_price*$order->unit)."</td>";

                                    $total_price=$total_price+($carryValue->notcarry_price*$order->unit);
                                }

                            

                            } else{
                                if(is_null($carryValue)){
                                    echo "<td>ไม่ได้กำหนด</td>";
                                    echo "<td>-</td>";
                                } else{
                                    echo "<td>".$carryValue->notcarry_price."(แบก)</td>";
                                    echo "<td>".number_format($carryValue->carry_price*$order->unit)."</td>";
                                    $total_price=$total_price+($carryValue->notcarry_price*$order->unit);
                                }
                            }
                             



                             echo "</tr>";
                            }

                            echo "<tr>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td><b>ราคารวม</b></td>";
                            echo "<td>".number_format($total_price)."</td>";
                            echo "</tr>";



                        echo "</table>";





      }else echo "false";
      
            



?>

    </div>
</div>

 @endsection