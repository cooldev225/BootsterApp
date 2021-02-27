<?php

namespace App\Http\Controllers\Util;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FileUtil extends Controller{
    public function uploadFile(Request $request){
        $res="error";
        if($request->hasfile('file')){
            $path='upload/tinymce';
            //@mkdir($path, 0777, true);
            $path=$request->file('file')->store($path);
            $res="ok";
        }
        $res=array('msg'=>$res,'location'=>'/downloadFile?path='.$path);
		exit(json_encode($res));
    }
    public function downloadFile(Request $request){
        return response()->download(storage_path("app/".$request->input('path')));
    }
}
