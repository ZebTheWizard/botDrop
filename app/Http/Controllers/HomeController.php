<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Canvas;
use Auth;

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
        $canvases = Canvas::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        foreach ($canvases as $canvas) {
          $dataURI = Redis::hget('canvas:'.$canvas->url, 'data');
          if($dataURI != "/image/blank.png"){
            $exploded = explode(',', $dataURI);
            $decodedDataURI = base64_decode($exploded[1]);
            $img = Image::make($decodedDataURI);
            $img->save(public_path('image/canvases/'.$canvas->url.'.png'));
            $canvas->image = '/image/canvases/'.$canvas->url.'.png';
            $canvas->save();
          }
        }
        return view('dashboard', compact('canvases'));
    }
}
