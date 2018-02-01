<?php

use Maatwebsite\Excel\Facades\Excel;
						echo "<html>";
						echo "<head>";
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
								</head> ";    

							echo "<body>";
                            echo "<table class='table_style'>";
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
                        
                        $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/30-7-60.xls.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();
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
                             if($row[10]>=50.5){
                                     $valuePerTon=number_format($row[10]*113);
                                 } else { $valuePerTon=number_format($row[10]*113);}
                            echo "<td>".$valuePerTon.".-"."</td>";



                            echo "</tr>";


                                // echo "ทะเบียน : ".$row[1];
                                // echo "<br>";
                                // echo "เล่มที่/เลขที่ : ".$row[2];
                                // echo "<br>";
                                // echo "วันที่ : ".$row[3];
                                // echo "<br>";
                                // echo "เวลา : ".$row[4];
                                // echo "<br>";
                                // echo "ลูกค้า : ".$row[5];
                                // echo "<br>";
                                // echo "สินค้า : ".$row[6];
                                // echo "<br>";
                                // echo "น้ำหนักรถ : ".$row[7];
                                // echo "<br>";
                                // echo "น้ำหนักรวม : ".$row[8];
                                // echo "<br>";
                                // echo "น้ำหนักสุทธิ : ".$row[9];
                                // echo "<br>";
                                // echo "หน่วย : ".$row[10];
                                // echo "<br>";

                                // if($row[10]>=50.5){
                                //     $valuePerTon=roundDigits($row[10]*113,2);
                                // } else { $valuePerTon=roundDigits($row[10]*140,2); }

                                // echo "ราคา : ".$valuePerTon.".- บาท";
                                // echo "<br>";

                                // echo "-----------";
                                // echo "<br>";
                            }
                                
                            
                
                            
                        }

                        echo "</table>";
                        echo "</body>";
                        echo "</html>";


                        function strposa($haystack, $needle) {
                            if(!is_array($needle)) $needle = array($needle);

                                foreach($needle as $Something_is_wrong) {
                                    if(strpos($haystack, $Something_is_wrong, 0) !== false) return true; // stop on first true result
                                }
                                return false;
                        }

                        function roundDigits( $value, $precision )
                            {
                                $precisionFactor = ($precision == 0) ? 1 : pow( 10, $precision );
                                return round( $value * $precisionFactor ) / $precisionFactor;
                            } 



?>