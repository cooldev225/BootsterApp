<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Util\GroupUtil;
use App\Http\Controllers\Util\DbUtil;
use App\Http\Controllers\Util\TaskUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
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
        return view('frontend.task',[
            'business_id' => $business_id,
            'project_id' => $project_id,
            'parentGroupList'=>GroupUtil::getParentGroupList(),
            'responsibleUsersList' => DbUtil::getResponsibleUsersList(),
            'openedTaskCount' => TaskUtil::getOpenedTaskCount(),
            'finishedTaskCount' => TaskUtil::getFinishedTaskCount(),
        ]);
    }
    public function taskmap(Request $request)
    {
        $business_id = $request->input('a');
        $project_id = $request->input('b');
        return view('frontend.taskmap',[
            'business_id' => $business_id,
            'project_id' => $project_id,
            'parentGroupList'=>GroupUtil::getParentGroupList(),
            'responsibleUsersList' => DbUtil::getResponsibleUsersList(),
        ]);
    }

    public function getTaskDescDataTable(Request $request)
    {
        header('Content-Type: application/json');
		exit(json_encode(TaskUtil::getTaskDescDataTable($request)));
    }
    public function saveTaskDesc(Request $request){
        $id=TaskUtil::saveTaskDesc($request);
        $res=array('msg'=>'ok','id'=>$id);
		exit(json_encode($res));
    }
    public function deleteTaskDesc(Request $request)
    {
        $id=TaskUtil::deleteTaskDesc($request->input('id'));
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }

    public function getTaskDataTable(Request $request)
    {
        header('Content-Type: application/json');
		exit(json_encode(TaskUtil::getTaskDataTable($request)));
    }
    public function saveTask(Request $request){
        $id=TaskUtil::saveTask($request);
        $res=array('msg'=>'ok','id'=>$id);
		exit(json_encode($res));
    }
    public function deleteTask(Request $request)
    {
        $id=TaskUtil::deleteTask($request->input('id'));
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
    public function getTaskDescsList(Request $request)
    {
        exit(json_encode(TaskUtil::getTaskDescsList($request->input('group_id'))));
    }
    public function finishTask(Request $request){
        TaskUtil::finishTask($request);
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
}
