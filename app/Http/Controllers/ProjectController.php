<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Util\DbUtil;
use App\Http\Controllers\Util\ProjectUtil;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $sch = $request->input('sch');
        $pch = $request->input('pch');
        return view('frontend.project',[
            'business_id' => $business_id,
            'project_id' => $project_id,
            'sch' => $sch,'pch' => $pch,
            'schBusinessList'=>DbUtil::getBusinessList($sch,$pch),
            'schProjectList'=>DbUtil::getProjectListByBusiness($pch),
            'adStatesList' => DbUtil::getAdStatesList(),
        ]);
    }
    public function getAdCitiesList(Request $request){
        exit(json_encode(DbUtil::getAdCitiesList($request->input('uf'))));
    }
    public function saveBusiness(Request $request){
        $id=ProjectUtil::saveBusiness($request);
        $res=array('msg'=>'ok','id'=>$id);
		exit(json_encode($res));
    }
    public function deleteBusiness(Request $request){
        $id=ProjectUtil::deleteBusiness($request->input('id'));
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
    public function attachFile(Request $request){
        $res="error";
        if($request->hasfile('file') && $request->input('id')){
            DbUtil::attachFile($request->file('file'),$request->input('kind'),$request->input('id'));
            $res="ok";
        }
        $res=array('msg'=>$res);
		exit(json_encode($res));
    }
    public function saveProject(Request $request){
        $id=ProjectUtil::saveProject($request);
        $res=array('msg'=>'ok','id'=>$id);
		exit(json_encode($res));
    }
    public function deleteProject(Request $request){
        $id=ProjectUtil::deleteProject($request->input('id'));
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
    public function getBusinessById(Request $request){
        exit(json_encode(ProjectUtil::getBusinessById($request->input('id'))));
    }
    public function getProjectsByBusiness($sch){
        return DbUtil::getProjectListByBusiness($sch);
    }
}
