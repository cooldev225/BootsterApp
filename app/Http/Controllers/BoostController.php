<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class BoostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        return view('frontend.boost',[
            
        ]);
    }
}
