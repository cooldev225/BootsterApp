<?php

namespace App\Http\Controllers\Util;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Business;
use App\Models\Company;
use App\Models\Contract;
use App\Models\ContractAttach;
use App\Models\Document;
use App\Models\Project;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Task;
use App\Models\TaskLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Group;
use App\Models\AttachFile;
use App\Models\TaskDesc;

class TaskUtil extends Controller{
    public static function getTaskDescDataTable(Request $request){
        $query=TaskDesc::select();
        if($request->input('group_id'))$query=$query->where('group_id',$request->input('group_id'));
        $rows=$query->get();
        $params['pagination']['total']=count($rows);
        $params['pagination']['page']=$request->input('pagination.page');
        $params['pagination']['perpage']=$request->input('pagination.perpage');
		$params['pagination']['pages']=round($params['pagination']['total']/$params['pagination']['perpage'])+($params['pagination']['total']%$params['pagination']['perpage']<5?1:0);
        $params['sort']['field']=$request->input('sort.field');
        $params['sort']['sort']=$request->input('sort.sort');
        if(isset($params['sort']['field'])&&isset($params['sort']['sort'])&&$params['sort']['field']!=null&&$params['sort']['sort']!=null)
        $sql=$query->orderBy("{$params['sort']['field']}","{$params['sort']['sort']}");
        $res['data']=$query
                        ->skip(($params['pagination']['page']-1)*$params['pagination']['perpage'])
                        ->take($params['pagination']['perpage'])
                        ->get();
        for($i=0;$i<count($res['data']);$i++){
            $res['data'][$i]['tasks']=Task::select()->where('desc_id',$res['data'][$i]['id'])->count();
        }
        $res['meta']=$params['pagination'];
        return $res;
    }
    public static function saveTaskDesc(Request $request){
        $id=$request->input('id');
        $row=$id>0?TaskDesc::find($id):new TaskDesc;
        $row->description=$request->input('description');
        $row->group_id=$request->input('group_id');
        if($id==0)$row->created_by=Auth::id();
        $row->updated_by=Auth::id();
        $row->updated_at=date('Y-m-d H:i:s');
        $row->save();
        return $row->id;
    }
    public static function deleteTaskDesc($id){
        return TaskDesc::find($id)->delete();
    }

    public static function getTaskDataTable(Request $request){
        $query=Task::select(
            'tasks.*',
            'users.username','users.address as user_address',
            'task_descs.description',
            'groups.name as group_name','groups.id as group_id',
            'subgroups.name as subgroup_name','subgroups.id as subgroup_id',
            'projects.name as project_name','projects.city as project_city','projects.id as project_id','projects.description as project_description',
            'finished_user.username as finished_username',
            'business.first_name as business_first_name','business.last_name as business_last_name','business.ad_city as business_city','business.id as business_id')
                        ->leftJoin('task_descs', 'task_descs.id', '=', 'tasks.desc_id')
                        ->leftJoin('documents', 'documents.id', '=', 'tasks.document_id')
                        ->leftJoin('projects', 'documents.project_id', '=', 'projects.id')
                        ->leftJoin('business', 'projects.business_id', '=', 'business.id')
                        ->leftJoin('groups', 'groups.id', '=', 'documents.group_id')
                        ->leftJoin('groups as subgroups', 'subgroups.id', '=', 'documents.sub_group_id')
                        ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
                        ->leftJoin('users as finished_user', 'tasks.finished_by', '=', 'finished_user.id');
        if($request->input('q_business')>0)$query=$query->where('business.id',$request->input('q_business'));
        if($request->input('q_project')>0)$query=$query->where('projects.id',$request->input('q_project'));
        if($request->input('document_id')>0)$query=$query->where('tasks.document_id',$request->input('document_id'));
        if($request->input('user_id')>0)$query=$query->where('tasks.user_id',$request->input('user_id'));
        if($request->input('status')=='0')$query=$query->where('tasks.finished_status',0);
        else if($request->input('status')=='1')$query=$query->where('tasks.finished_status',1);
        $rows=$query->get();
        $params['pagination']['total']=count($rows);
        $params['pagination']['page']=$request->input('pagination.page');
        $params['pagination']['perpage']=$request->input('pagination.perpage');
		$params['pagination']['pages']=round($params['pagination']['total']/$params['pagination']['perpage'])+($params['pagination']['total']%$params['pagination']['perpage']<5?1:0);
        $params['sort']['field']=$request->input('sort.field');
        $params['sort']['sort']=$request->input('sort.sort');
        $query=$query->orderBy("tasks.due_date","asc");
        if(isset($params['sort']['field'])&&isset($params['sort']['sort'])&&$params['sort']['field']!=null&&$params['sort']['field']!='name'&&$params['sort']['sort']!=null)
        $sql=$query->orderBy("{$params['sort']['field']}","{$params['sort']['sort']}");
        $res['data']=$query
                        ->skip(($params['pagination']['page']-1)*$params['pagination']['perpage'])
                        ->take($params['pagination']['perpage'])
                        ->get();
        $res['meta']=$params['pagination'];
        return $res;
    }
    public static function saveTask(Request $request){
        $id=$request->input('id');
        $row=$id>0?Task::find($id):new Task;
        $row->desc_id=$request->input('desc_id');
        $row->document_id=$request->input('document_id');
        $row->user_id=$request->input('user_id');
        $row->due_date=$request->input('due_date');
        $row->city=$request->input('city');
        $row->state=$request->input('state');
        $row->municipio_cnum=$request->input('municipio_cnum');
        if($id==0)$row->created_by=Auth::id();
        $row->updated_by=Auth::id();
        $row->updated_at=date('Y-m-d H:i:s');
        $row->save();
        return $row->id;
    }
    public static function deleteTask($id){
        return Task::find($id)->delete();
    }
    public static function getTaskDescsList($group_id){
        return TaskDesc::select()->where('group_id','0')->orWhere('group_id',$group_id)->get();
    }
    public static function finishTask(Request $request){
        $row=Task::find($request->input('id'));
        $row->finished_status=1;
        $row->finished_by=$request->input('finished_by');
        $row->finished_at=$request->input('finished_at');
        $row->save();
    }
    public static function getOpenedTaskCount(){
        return Task::select()->where('finished_status',0)->count();
    }
    public static function getFinishedTaskCount(){
        return Task::select()->where('finished_status',1)->count();
    }
}
