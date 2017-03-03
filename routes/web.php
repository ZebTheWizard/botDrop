<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Canvas;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (Auth::check()) {
      return redirect()->route('dashboard');}
    return view('welcome');
});

Auth::routes();

Route::post('/userlogin','Auth\AuthController@checkLogin')->name('newlogin');
Route::post('/userregister','Auth\AuthController@checkRegister')->name('newregister');

Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('auth.basic');

Route::get('/c/{url}', function($url){
  $c = Canvas::where('url', $url)->first();
  // $dataURI = Redis::hget('canvas:'.$url, 'data');
  // if($dataURI != "/image/blank.png"){
  //   $exploded = explode(',', $dataURI);
  //   $decodedDataURI = base64_decode($exploded[1]);
  //   $img = Image::make($decodedDataURI);
  //   $img->save(public_path('image/canvases/'.$url.'.png'));
  //   $c->image = '/image/canvases/'.$url.'.png';
  //   $c->save();
  // }

  return view('canvas')->with('canvas', $c);
});

Route::post('/createCanvas', function(){
  Canvas::create([
    'user_id'=>Auth::id(),
  ]);
  $c = Canvas::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
  Redis::hmset('canvas:'.$c->url, [
    'data' => '/image/blank.png',
    'password' => 'letmein'
  ]);
  $canvases = Canvas::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
  return back();
});


Route::post('/nameCanvas', function(Request $request){
  $c = Canvas::where('url', $request->url)
      ->update([
        'name'=> $request->name,
        'isNew' => FALSE
      ]);
  // $c->name = $request->name;
  // $c->isNew = FALSE;
  // $c->save();

  return back();
});

Route::post('/deleteCanvas', function(Request $request){
  $c = Canvas::where('url', $request->url);
  $c->delete();
  Redis::del('canvas:'.$request->url);
  return back();
});



// Route::post('/autosave', function(Request $request){
//   $mysqlData = $request->data;
//   $redisData = Redis::hget('canvas:'.$request->url, 'data');
//   if ($mysqlData != $redisData){
//     $c = Canvas::where('url', $request->url)->first();
//     $c->data = $redisData;
//     $c->save();
//   }
//   return response()->json([
//     'imageData' => $redisData,
//   ]);
// });
