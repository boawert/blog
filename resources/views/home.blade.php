@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <?php
                        if(file_exists('public/datafiles/order.xls')){
                            echo "<style>";
                            echo "table {
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
                                    </style> ";    


                            echo "<table>";
                            echo "<tr>";
                            echo "<th>ทะเบียน</th>";
                            echo "<th>เล่มที่/เลขที่</th>";    
                            echo "<th>วันที่</th>";
                            echo "<th>เวลา</th>";  
                            echo "<th>ลูกค้า</th>";
                            echo "<th>สินค้า</th>";  
                            echo "<th>น้ำหนักสุทธิ</th>";  
                            echo "<th>หน่วย</th>";
                            echo "<th>ราคา</th>";  
                            echo "</tr>";
                        

                        foreach ($save_excel as $key => $row) {
                        
                            $filter_data=array('81-3508','81-9589','81-5872','81-7385','81-6618',
                                                '81-7797','81-3269','81-7376','82-0139','81-5246',
                                                '82-0346','84-6792','81-7902','85-2444','81-7754',
                                                '81-7419','81-7308','81-5285','81-7319','81-4397',
                                                '81-9583','81-5098','81-4171','81-7143','81-9771',
                                                '81-9822','81-3982','81-7722','81-7381','81-6777',
                                                '82-0069','81-7150','81-7205','81-8615');

                            if (strposa($row[1],$filter_data)){

                                echo "<tr>";
                            echo "<td>".$row[1]."</td>";
                            echo "<td>".$row[2]."</td>";
                            echo "<td>".$row[3]."</td>";
                            echo "<td>".$row[4]."</td>";
                            echo "<td>".$row[5]."</td>";
                            echo "<td>".$row[6]."</td>";
                            echo "<td>".number_format($row[9])."</td>";
                            echo "<td>".$row[10]."</td>";
                            //  if($row[10]>=50.5){
                            //          $valuePerTon=roundDigits($row[10]*113,2);
                            //      } else { $valuePerTon=roundDigits($row[10]*140,2); }
                            // echo "<td>".number_format($valuePerTon).".-"."</td>";



                            echo "</tr>";


                            
                            }
                
                            
                        }
                        echo "</table>";

                        

                        } else {
                            echo "ไม่มีข้อมูลลูกค้า กรุณาอัพโหลด";
                        }

                        
                        function strposa($haystack, $needle) {

                            if(!is_array($needle)) $needle = array($needle);

                                foreach($needle as $Something_is_wrong) {
                                    if(strpos($haystack, $Something_is_wrong, 0) !== false) return true; // stop on first true result
                                }
                                return false;
                        }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
