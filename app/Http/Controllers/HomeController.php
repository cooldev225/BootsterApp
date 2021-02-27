<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Util\GroupUtil;
use App\Http\Controllers\Util\DbUtil;
use App\Http\Controllers\Util\DocumentUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('frontend.home',[
            
        ]);
    }
}
