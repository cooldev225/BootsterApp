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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $business_id = $request->input('a');
        $project_id = $request->input('b');
        return view('frontend.home',[
            'business_id' => $business_id,
            'project_id' => $project_id,
            'parentGroupList'=>GroupUtil::getParentGroupList(),
            'subGroupCount'=>GroupUtil::getSubGroupCount(),
            'adStatesList' => DbUtil::getAdStatesList(),
            'responsibleUsersList' => DbUtil::getResponsibleUsersList(),
        ]);
    }
    public function getDocumentChartData(){
        header('Content-Type: application/json');
        exit(json_encode(DocumentUtil::getDocumentChartData()));
    }
    public function attachRemoveFile(Request $request){
        DbUtil::attachRemoveFile($request->input('id'));
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
}
