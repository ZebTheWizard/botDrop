<?php

namespace App\Http\Controllers;

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
        return view('dashboard', compact('canvases'));
    }
}
