<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Embed\Embed;
use Validator;

class PreviewController extends Controller
{
    public function index() {
        return view('welcome');
    }
    public function getpreview(Request $request) {
        $validate  = Validator::make($request->all(),[
            'url' => ['required','regex:/^((ftp|http|https):\/\/)?(www.)?(?!.*(ftp|http|https|www.))[a-zA-Z0-9_-]+(\.[a-zA-Z]+)+((\/)[\w#]+)*(\/\w+\?[a-zA-Z0-9_]+=\w+(&[a-zA-Z0-9_]+=\w+)*)?$/'],
        ]);
        if($validate->passes()){
            $data = Embed::create($request->url);
            return response()->json(array(
                'success' => 'true',
                'image' => $data->image,
                'title' => $data->title,
                'description' => $data->description
            ));
        } else {
            // return redirect()->back()->withErrors($validate);
            // return response()->json($validate->getMessageBag());
            return response()->json(array(
                'success' => 'false',
                'error_mesg' => $validate->getMessageBag()
            ));
        }
    }
}
