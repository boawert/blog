

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Upload Excel File</div>

                <div class="panel-body">

                    <form action="/bingo" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <input type="file" name="upload_bingo_file">
                        <br>
                        <input type="submit" value="Upload" name="submit">
                        <br>
                        <br>
                        <?php

use Maatwebsite\Excel\Facades\Excel;
                        if(file_exists('public/datafiles/bingo.xls')){


                            $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/bingo.xls', function($reader) {
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

                            for($k=1;$k<=150;$k++){

                                echo "<table class='table_style'>";
                            echo "<tr>";
                            echo "<th>".$k."</th>";
                            echo "</tr>";

                            $bingo_data=array();
                            $major_position=array(1,7,13,19,25);

                           // $random_data=rand(1, 60);

                        $i=1;

                         while ( $i <= 25) {
                                    $random_bingo_data=random_int(1, 60);

                             if(in_array($random_bingo_data,$bingo_data)){

                             } else {
                                if(in_array($i, $major_position)){
                                    if($random_bingo_data>28){

                                            $bingo_data[$i]=$random_bingo_data;
                                            $i=$i+1;
                                        

                                    }

                                    
                                } else {
                                    $bingo_data[$i]=$random_bingo_data;
                                    $i=$i+1;
                                }

                             }
                         }
                            $checkrow=1;
                            for ($j=1; $j <=25 ; $j++) { 
                                if($j==$checkrow){
                                    $checkrow=$j+5;
                                    echo "<tr>"; 
                                }

                                echo "<td>".$save_excel[$bingo_data[$j]][2]."</td>";    

                                 if($j==$checkrow-1){
                                     echo "</tr>"; 
                                 }

                            }


                         
                            
                        // }



                        echo "</table>";
                        echo "<br>";
                        

                            }

                            
                        echo "</body>";
                        
                        // foreach ($save_excel as $key => $row) {
                    
                        //     if ($row[1]!=null&&$row[2]!=null){

                        //         echo "<tr>";
                        //     echo "<td>".$row[1]."</td>";
                        //     echo "<td>".$row[2]."</td>";
                            



                        //     echo "</tr>";


                        
                        //     }
                            

                            
                    } else {
                        echo "No bingo data , please upload.";
                    }
                    
                        




?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection