<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostImagesController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request,[
            'file' => 'required|mimes:png,jpg,jpeg'
        ]);
        $picName = time(). "." . $request->file->extension();
        $request->file->move(public_path('uploads'),$picName);
        return $picName;
    }

    public function delete_image(Request $request)
    {
        $fileName = $request->imageName;
        $filePath = public_path().'/uploads/' . $fileName;
        if(file_exists($filePath))
        {
            unlink($filePath);
        }

        return "file Deleted";
    }
}
