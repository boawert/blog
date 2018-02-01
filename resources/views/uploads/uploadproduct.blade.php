

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Upload Excel File</div>

                <div class="panel-body">

                    <form action="/product_store" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <input type="file" name="upload_product_file">
                        <br>
                        <input type="submit" value="Upload" name="submit">
                        <br>
                        <br>
                        <?php

use Maatwebsite\Excel\Facades\Excel;
use App\Product;

                        $products=Product::paginate(15);
                        $products->setPath("/uploadproduct");

                        if(!is_null($products)&& file_exists('public/datafiles/product.xls')){


                            $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/product.xls', function($reader) {
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
                            echo "<th>รหัส</th>";
                            echo "<th>รหัสสินค้า</th>";
                            echo "<th>ชื่อสินค้า</th>";    
                            
                            echo "</tr>";
                        

                            foreach ($products as $product) {
                             echo "<tr>";
                             echo "<td>".$product->product_type."</td>";
                             echo "<td>".$product->product_id."</td>";
                             echo "<td>".$product->product_name."</td>";

                             echo "</tr>";
                            }



                        echo "</table>";

                        echo $products->links();

                        echo "</body>";
                    } else {
                        echo "No product data , please upload.";
                    }
                    
                        




?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection