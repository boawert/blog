<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class UserController extends Controller
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
        return view('home');
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
            $uploadedFile->move(destinationPath, $fileName);
        }
    }

}
