@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    SAHA SILA LOEI.

                    <?php

                    //use Maatwebsite\Excel\Facades\Excel;

                    // $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/price.xls', function($reader) {
                    //         $reader->noHeading();
                    //         $datas = $reader->toArray();
                    //     })->toArray();



                    //     $carry_data_1=DB::table('carries')
                    //             ->where([['customer_id',$save_excel[15][0]],['product_type',1]])
                    //             ->first();

                    //    $available_carry_value_1=DB::table('carry_values')
                    //             ->where([['carry_id',$carry_data_1->id],['year_month', 'LIKE','%'.$save_excel[0][0].'%']])
                    //             ->first();

                    //             if(is_null($available_carry_value_1)){
                    //                 echo "null";
                    //             } else {
                    //                 echo "not null";

                    //                 DB::table('carry_values')
                    //                     ->where([['carry_id',$carry_data_1->id],['year_month', 'LIKE', '%'.$save_excel[0][0].'%']])
                    //                     ->update(['carry_price' => $save_excel[15][2]]);

                    //     DB::table('carry_values')
                    //                     ->where([['carry_id',$carry_data_1->id],['year_month', 'LIKE', '%'.$save_excel[0][0].'%']])
                    //                     ->update(['notcarry_price' => $save_excel[15][3]]);

                    //             }

                    // echo (string)date("Y-m", strtotime(str_replace('/', '-', explode(" ","2017/12/01 08:30:00")[0])))

                        

                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
