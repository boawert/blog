

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">กำหนดราคา</div>

                <div class="panel-body">


                <?php 
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

            $carry =DB::table('carries')->where('id',$id )->first();
            $customer =DB::table('customers')->where('customer_id',$carry->customer_id )->first();
            
            echo "ลูกค้า : ".$customer->customer_name;
            echo "<br>";
            echo "สินค้า : ".decryptProductType($carry->product_type);
            echo "<br>";

?>          
            @if($monthyear==0)
                <form action="/defineprice/edit/{{$id}}/1" method="get" enctype="multipart/form-data">
                            {{csrf_field()}}

                        เดือน/ปี:
                            <input type="month" name="monthyear" value="">
                            
                        
                            <input type="submit" value="ค้นหา">
                    </form>
            @else 

                <?php 
                        $carry_value=DB::table('carry_values')
                        ->where('carry_id',$id)
                        ->where('year_month',$monthyear)
                        ->first();

                        if(is_null($carry_value)){
                            $carry_price=0;
                            $notcarry_price=0;
                        } else {
                            $carry_price=$carry_value->carry_price;
                            $notcarry_price=$carry_value->notcarry_price;
                        }


                 ?>

            <form action="/defineprice/update/{{$id}}/{{$monthyear}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}

                        เดือน/ปี:
                            <input type="month" name="monthyear" value="{{$monthyear}}" disabled="true"><br>
                            ราคาแบก:<br>
                            <input type="number" name="carry" value="{{$carry_price}}">
                                <br>
                        ราคาไม่แบก:<br>
                            <input type="number" name="notcarry" value="{{$notcarry_price}}">
                                <br><br>
                            <input type="submit" value="อัพเดต">
                    </form>

            @endif        
                   <!--  <form action="/defineprice/update/{{$id}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}

                        ราคาแบก:<br>
                            <input type="number" name="carry" value="">
                                <br>
                        ราคาไม่แบก:<br>
                            <input type="number" name="notcarry" value="">
                                <br><br>
                            <input type="submit" value="อัพเดต">
                    </form> 
                    <br> -->
                        

                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection