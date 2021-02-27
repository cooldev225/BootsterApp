<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Util\GroupUtil;
use Illuminate\Http\Request;

class GroupController extends Controller
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
        return view('frontend.group',[
            'business_id' => $business_id,
            'project_id' => $project_id,
            'parentGroupList'=>GroupUtil::getParentGroupList(),
            'subGroupCount'=>GroupUtil::getSubGroupCount()
        ]);
    }
    public function getGroupDataTable(Request $request)
    {
        header('Content-Type: application/json');	
		exit(json_encode(GroupUtil::getGroupDataTable($request)));
    }
    public function saveGroup(Request $request){
        $id=GroupUtil::saveGroup($request);
        $res=array('msg'=>'ok','id'=>$id);
		exit(json_encode($res));
    }    
    public function deleteGroup(Request $request){
        $id=GroupUtil::deleteGroup($request->input('id'));
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
    function getGroupList(Request $request){
        exit(json_encode(GroupUtil::getGroupList($request->input('id'))));
    }
}
