

@extends('layouts.app')

@section('content')

<?php

use Maatwebsite\Excel\Facades\Excel;
                    
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
                            echo "<th>รหัสลูกค้า</th>";
                            echo "<th>ชื่อลูกค้า</th>";    
                            
                            echo "</tr>";
                        
                        $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/product.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();
                        foreach ($save_excel as $key => $row) {
                    
                            if ($row[2]!=null && $row[2]!="รหัส" && $row[4]!=null){

                                echo "<tr>";
                            echo "<td>".$row[2]."</td>";
                            echo "<td>".$row[4]."</td>";
                            



                            echo "</tr>";


                        
                            }
                                
                            
                
                            
                        }

                        echo "</table>";
                        echo "</body>";




?>

@endsection