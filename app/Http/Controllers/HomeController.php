<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(file_exists('public/datafiles/30-7-60.xls.xls')){
            $save_excel =   Excel::selectSheetsByIndex(0)->load('public/datafiles/30-7-60.xls.xls', function($reader) {
                            $reader->noHeading();
                            $datas = $reader->toArray();
                        })->toArray();
        
        return view('home',compact('save_excel'));
    } else {
        
        return view('home');

    }
        
    }
    public function index_upload()
    {
        return view('uploads/uploadfile');
    }

    public function upload(Request $request)
    {
        /**
         * @var Symfony\Component\HttpFoundation\File\UploadedFile
         */
        $uploadedFile = $request->file('image'); 

        if ($uploadedFile->isValid()) {
            $uploadedFile->move('uploads', $fileName);
        }
    }

}
