

@extends('layouts.app')



@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">กำหนดราคา</div>

                <div class="panel-body">


                <?php 

            $order =DB::table('orders')->where('id',$id )->first();
            



?>
                    <form action="/definedistance/update/{{$id}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}

                        กำหนดระยะทาง (กม) : 
                            <input type="number" name="distance" value=0>

<br>
                               
                            <input type="submit" value="อัพเดต">



                
                </div>
            </div>
        </div>
    </div>
</div>


 @endsection