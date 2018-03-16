@extends('layouts.app')



@section('content')
<style>
  .table_style {
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
                                    background-color:   #DCDCDC;
                                    }

</style>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">รายงานทะเบียนรถร่วม</div>

                <div class="panel-body">
                  @if (DB::table('trucks')->count()==0)
                      <p>คุณยังไม่ได้กำหนดทะเบียนรถร่วม . </p>
                      
                  @else<?php
                      echo "ทะเบียนร่วม<br>";
                      echo "<table class='table_style'>";
                      echo "<tr>";
                    $cotrucks=DB::table('trucks')->get();
                    foreach ($cotrucks as $cotruck) {
                      echo "<td>";
                      echo $cotruck->license_plate;
                      echo "</td>";
                    }
                      echo "</tr>";
                      echo "</table>";
                      echo "<br>";
                   ?>
                  @endif
              
                  <button onclick="myFunction()">เพิ่มทะเบียนรถร่วม</button>
                    
                          <script>
                          function myFunction() {
                              var person = prompt("กรอกทะเบียนรถร่วม", "xx-xxxx");
                              //var available_value=Truck
                              if (person != null) {
                                
                               var url  = $('#ajax-center-url').data('url')
                               console.log(url);
                               var method = 'saveData';
                                $.ajax({
                                      headers: { 'X-CSRF-Token' : $('input[name=_token]').val() },
                                      type: 'post',
                                      url: url,
                                      data: {
                                        'method' : method,
                                        'person' : person,
                                      },
                                      success: function(result) {
                                          console.log(result);
                                          alert(result.msg);
                                          setTimeout(function(){
                                            window.location.reload();
                                          },2000);
                                          
                                          // msg_stop();
                                      },
                                      error: function(result) {
                                          console.log(result);

                                      },
                                  })
                                  
                              }
                          }
                          </script>


                    <br>

                    <form action="/report/cotrucks/result" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <br><b>วันที่ :</b>   
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

                    $viewcotrucks=DB::table('trucks')->get();

                if($from===$to){
              
                
          echo '<div class="report_center" >
              <h2>บริษัท สหศิลาเลย จำกัด</h2><br>รายงานค่าขนส่งของรถทะเบียนร่วม วันที่ '.$from.'</div>';

                                          

      } else {

        echo '<div class="report_center" >
              <h2>บริษัท สหศิลาเลย จำกัด</h2><br>รายงานค่าขนส่งของรถทะเบียนร่วม วันที่ '.$from.' - '.$to.'</div>';
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

                    foreach ($viewcotrucks as $viewcotruck) {
                      
                        
                            $total_price=0;

                            if($from===$to){
                              $datetime=str_replace('/', '-', $from);
                                    $dt=date("Y/m/d", strtotime($datetime));

                                    $orders=DB::table('orders')
                                      ->where('license_plate', 'LIKE', '%'.$viewcotruck->license_plate.'%')
                                      ->where('date', 'LIKE', '%' .$dt. '%')
                                      ->orderBy('date', 'asc')
                                      ->get();
                            }else{
                                    $datetime=str_replace('/', '-', $from);
                                    $dt=date("Y/m/d", strtotime($datetime));
                                    $datetime2=str_replace('/', '-', $to);
                                    $dt2=date("Y/m/d", strtotime($datetime2));

                                    $orders=DB::table('orders')
                                            ->where('license_plate', 'LIKE', '%'.$viewcotruck->license_plate.'%')
                                            ->whereBetween('date',[$dt." 00:00:01",$dt2." 23:59:59"])
                                            ->orderBy('date', 'asc')
                                            ->get();
                            }

                            foreach ($orders as $order) {

                              $product =DB::table('products')->where('product_id',$order->product_id )->first();
                             if($order->customer_id==='9' || $product->product_type=='2'){

                              }

                              else {

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

                             
                             
                            
                             echo "<td>".number_format($order->car_weight)."</td>";
                             echo "<td>".number_format($order->all_weight)."</td>";
                             echo "<td>".number_format($order->total_weight)."</td>";
                             echo "<td>".$order->unit."</td>";

                             $carryprice=DB::table('carries')->where([['customer_id',$order->customer_id],['product_type',$product->product_type]])->first();


                             $yearmonthtoselect=(string)date("Y-m", strtotime(str_replace('/', '-', explode(" ",$order->date)[0])));

                             $carryValue=DB::table('carry_values')
                             ->where([['carry_id',$carryprice->id],['year_month', 'LIKE', '%' .$yearmonthtoselect. '%']])->first();

                             if($order->is_carry==0){
                                
                                if(is_null($carryValue)){
                                    echo "<td>ไม่ได้กำหนด</td>";
                                    echo "<td>-</td>";
                                } else{
                                    echo "<td>".$carryValue->notcarry_price."</td>";
                                    echo "<td>".$carryValue->notcarry_price*$order->unit."</td>";

                                    $total_price=$total_price+($carryValue->notcarry_price*$order->unit);
                                }

                            

                            } else{
                                if(is_null($carryValue)){
                                    echo "<td>ไม่ได้กำหนด</td>";
                                    echo "<td>-</td>";
                                } else{
                                    echo "<td>".$carryValue->carry_price."</td>";
                                    echo "<td>".$carryValue->carry_price*$order->unit."</td>";
                                    $total_price=$total_price+($carryValue->carry_price*$order->unit);
                                }
                            }
                             



                             echo "</tr>";

                              }  

                             
                             

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
                            echo "<td>".$total_price."</td>";
                            echo "</tr>";

                            // echo "<tr>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "<td></td>";
                            // echo "</tr>";

                            



                       
                    } 
                    echo "</table>";

                  } else echo "false";
      
            



?>

    </div>
</div>
<input type="hidden" name="_token" id="csrf-token" value="<?php echo csrf_token() ?>" />
<div id="ajax-center-url" data-url="<?php echo URL::route('report.ajax_center.post');?>"></div>
 @endsection