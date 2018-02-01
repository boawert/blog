

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">กำหนดราคา</div>

                <div class="panel-body">


                <?php 

            $carry =DB::table('carries')->where('id',$id )->first();
            $customer =DB::table('customers')->where('customer_id',$carry->customer_id )->first();
            $product =DB::table('products')->where('product_id',$carry->product_id )->first();
            echo "ลูกค้า : ".$customer->customer_name;
            echo "<br>";
            echo "สินค้า : ".$product->product_name;
            echo "<br>";



?>
                    <form action="/report/cotrucks/defineprice/update/{{$id}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}

                        ราคาแบก:<br>
                            <input type="number" name="carry" value={{$carryprice}}>
                                <br>
                        ราคาไม่แบก:<br>
                            <input type="number" name="notcarry" value="{{$notcarryprice}}">
                                <br><br>
                            <input type="submit" value="อัพเดต">
                    </form> 
                    <br>
                        

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection