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
use App\Models\NotifyState;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentExport;
class DocumentUtil extends Controller{
    public static function getDocumentDataTable(Request $request){
        $query=Document::select(
                            'documents.*',
                            'groups.name as group_name','groups.alert_01 as group_alert_01','groups.alert_02 as group_alert_02','groups.template',
                            'sub_groups.name as subgroup_name','sub_groups.alert_01 as subgroup_alert_01','sub_groups.alert_02 as subgroup_alert_02','groups.template as subtemplate',
                            'projects.name as project_name','projects.state as project_state','projects.municipio_cnum as project_municipio_cnum',
                            'business.first_name as business_first_name',
                            'business.last_name as business_last_name',
                            'users.username as business_username',
                            'business.id as business_id',
                            'projects.id as project_id',
                            'responsible_user.username as responsible_username',
                            'finished_user.username as finished_username'
                        )
                        ->leftJoin('groups', 'documents.group_id', '=', 'groups.id')
                        ->leftJoin('groups as sub_groups', 'documents.sub_group_id', '=', 'sub_groups.id')
                        ->leftJoin('projects', 'documents.project_id', '=', 'projects.id')
                        ->leftJoin('business', 'projects.business_id', '=', 'business.id')
                        ->leftJoin('users', 'business.created_by', '=', 'users.id')
                        ->leftJoin('users as responsible_user', 'documents.responsible_user_id', '=', 'responsible_user.id')
                        ->leftJoin('users as finished_user', 'documents.finished_by', '=', 'finished_user.id');
                        //"STR_TO_DATE('{$request->input('q_start')}','%Y-%m-%d %H:%i:%s')");
        $query=$query->where('documents.finished_status',$request->input('finished_status')=='true'?1:0);
        if($request->input('expending')=='true'){

        }else{
            if($request->input('group_id')>0)$query=$query->where('documents.group_id','=',$request->input('group_id'))->where('documents.sub_group_id','>',0);
            else $query=$query->where(function ($q) {
                $q->where('documents.sub_group_id','=',0)
                ->orWhere('documents.sub_group_id','=',null)
                ->orWhere('documents.sub_group_id','=',"''");
            });
        }
        if($request->input('status')!=null&&$request->input('status')!=-1)$query=$query->where('documents.status',$request->input('status'));
        if($request->input('q_user')!=null&&$request->input('q_user'))$query=$query->where('responsible_user.id',$request->input('q_user'));
        if($request->input('is_noticed')>0){
            $query=$query->where(function ($q) {
                $q->where(function ($q) {
                    $q->where(function ($q) {
                        $q->where('documents.sub_group_id','=',0)
                         ->orWhere('documents.sub_group_id','=',null)
                         ->orWhere('documents.sub_group_id','=',"''");
                    })
                    ->whereRaw('DATEDIFF(DATE(documents.due_date),CURDATE())<=groups.alert_02');
                })
                ->orWhere(function ($q) {
                    $q->where('documents.sub_group_id','>',0)
                    ->whereRaw('DATEDIFF(DATE(documents.due_date),CURDATE())<=sub_groups.alert_02');
                });
            })
            ->where(function ($q) {
                $q->where('documents.sub_group_id','=',0)
                 ->orWhere('documents.sub_group_id','=',null)
                 ->orWhere('documents.sub_group_id','=',"''");
            });
        }
        if($request->input('q_business')>0)$query=$query->where('business.id','=',$request->input('q_business'));
        if($request->input('q_project')>0)$query=$query->where('projects.id','=',$request->input('q_project'));
        if($request->input('q_group')>0)$query=$query->where('documents.group_id','=',$request->input('q_group'));
        if($request->input('q_subgroup')>0)$query=$query->where('documents.sub_group_id','=',$request->input('q_subgroup'));
        if($request->input('q_start')!=''&&$request->input('q_end')!=''&&$request->input('q_start')!='00:00:00'&&$request->input('q_end')!='23:59:59')
            $query=$query->whereBetween('documents.due_date',[$request->input('q_start'),$request->input('q_end')]);
        $rows=$query->get();
        $params['pagination']['total']=count($rows);
        if($request->input('pagination.page')!=null&&$request->input('pagination.perpage')!=null&&$request->input('pagination.pages')!=null){
            $params['pagination']['page']=$request->input('pagination.page');
            $params['pagination']['perpage']=$request->input('pagination.perpage');
            $params['pagination']['pages']=round($params['pagination']['total']/$params['pagination']['perpage'])+($params['pagination']['total']%$params['pagination']['perpage']<5?1:0);
            $params['sort']['field']=$request->input('sort.field')=='name'?null:$request->input('sort.field');
            $params['sort']['sort']=$request->input('sort.sort');
            $query=$query->orderBy("documents.due_date","asc");
            if(isset($params['sort']['field'])&&isset($params['sort']['sort'])&&$params['sort']['field']!=null&&$params['sort']['sort']!=null&&$params['sort']['field']!='Actions'&&$params['sort']['field']!='username')
            $query=$query->orderBy("{$params['sort']['field']}","{$params['sort']['sort']}");
            $res['data']=$query
                            ->skip(($params['pagination']['page']-1)*$params['pagination']['perpage'])
                            ->take($params['pagination']['perpage'])
                            ->get();
        }else{
            $query=$query->orderBy("documents.due_date","asc");
            $res['data']=$query->get();
        }
		for($i=0;$i<count($res['data']);$i++) {
			$res['data'][$i]['id']=round($res['data'][$i]['id']);
            $res['data'][$i]['tasks_count']=count(Task::select()->where('document_id',$res['data'][$i]['id'])->get());
            if($res['data'][$i]['sub_group_id']==null||$res['data'][$i]['sub_group_id']==0||$res['data'][$i]['sub_group_id']==''){
                $res['data'][$i]['tasks_count']+=count(Task::select()->where('document_id',0)->get());
            }
            $res['data'][$i]['children_count']=0;
            if($res['data'][$i]['sub_group_id']==0)$res['data'][$i]['children_count']=
                Document::select()
                    ->where('documents.group_id',$res['data'][$i]['group_id'])
                    ->where('documents.sub_group_id','>',0)
                    ->get()
                    ->count();
            $res['data'][$i]['finishable']=1;
            if($res['data'][$i]['sub_group_id']==0){
                foreach(Document::select()
                ->where('documents.group_id',$res['data'][$i]['group_id'])
                ->where('documents.sub_group_id','>',0)
                ->get() as $row){
                    if($row['finished_status']==0){
                        $res['data'][$i]['finishable']=0;
                        break;
                    }
                }
            }
            $res['data'][$i]['attached_files']=AttachFile::select()->where('table_kind',2)->where('table_id',$res['data'][$i]['id'])->get();
            $res['data'][$i]['alert_01_read']=count(NotifyState::select()->where('document_id',$res['data'][$i]['id'])->where('alert_num',1)->get());
            $res['data'][$i]['alert_02_read']=count(NotifyState::select()->where('document_id',$res['data'][$i]['id'])->where('alert_num',2)->get());
		}
        $res['meta']=$params['pagination'];
        return $res;
    }
    public static function exportDocumentDataTable(Request $request){
        $docExport=new DocumentExport;
        $docExport->request=$request;
        return Excel::download($docExport, 'documents_'.date("d_m_Y").'.xlsx');
    }
    public static function saveDocument(Request $request){
        $id=$request->input('id');
        $row=$id>0?Document::find($id):new Document;
        $row->title=$request->input('title');
        $row->project_id=$request->input('project_id');
        $row->group_id=$request->input('group_id');
        $row->sub_group_id=$request->input('sub_group_id');
        if($request->input('sub_group_id')==0||$request->input('sub_group_id')==null||$request->input('sub_group_id')==''){
            foreach(Document::where('group_id',$request->input('group_id'))->where('sub_group_id','>',0)->get() as $child){
                $chd=Document::find($child['id']);
                $chd->process=$request->input('process')==null?'':$request->input('process');
                $chd->license=$request->input('license')==null?'':$request->input('license');
                $chd->save();
            }
        }
        $row->due_date=$request->input('due_date');
        $row->status=$request->input('status');
        $row->description=$request->input('description')==null?'':$request->input('description');
        $row->process=$request->input('process')==null?'':$request->input('process');
        $row->license=$request->input('license')==null?'':$request->input('license');
        $row->protocal=$request->input('protocal')==null?'':$request->input('protocal');
        if($request->input('protocal_date')!=null)$row->protocal_date=$request->input('protocal_date');
        $row->responsible_user_id=$request->input('responsible_user_id')==null?'':$request->input('responsible_user_id');
        if($id==0)$row->created_by=Auth::id();
        $row->updated_by=Auth::id();
        $row->updated_at=date('Y-m-d H:i:s');
        $row->save();
        if($row->sub_group_id==0||$row->sub_group_id==''||$row->sub_group_id==null){
            foreach(Document::select()->where('group_id','=',$row->group_id)->where('sub_group_id','>',0)->get() as $child){
                $sub_row=Document::find($child['id']);
                $sub_row->process=$row->process;
                $sub_row->license=$row->license;
                $sub_row->updated_by=Auth::id();
                $sub_row->updated_at=date('Y-m-d H:i:s');
                $sub_row->save();
            }
        }
        if(!$id>0)if($request->input('dupid')>0){
            $dupid=$request->input('dupid');
            foreach(AttachFile::select()->where('table_kind',2)->where('table_id',$dupid)->get() as $attach){
                $arow=new AttachFile;
                $arow->table_kind=2;
                $arow->table_id=$row->id;
                $arow->filename=$attach['filename'];
                $arow->path=$attach['path'];
                $arow->body=$attach['body'];
                $arow->flag=$attach['flag'];
                $arow->created_by=Auth::id();
                $arow->save();
            }
            foreach(Task::select()->where('document_id',$dupid)->get() as $task){
                $trow=new Task;
                $trow->desc_id=$task['desc_id'];
                $trow->document_id=$row->id;
                $trow->user_id=$task['user_id'];
                $trow->due_date=$request->input('due_date');//$task['due_date'];
                $trow->state=$task['state'];
                $trow->city=$task['city'];
                $trow->municipio_cnum=$task['municipio_cnum'];
                $trow->finished_status=0;
                $trow->finished_by=0;
                $trow->desc_id=$task['desc_id'];
                $trow->created_by=Auth::id();
                $trow->updated_by=Auth::id();
                $trow->save();
            }
            if($row->sub_group_id==0||$row->sub_group_id==''||$row->sub_group_id==null){
                foreach(Document::select()->where('group_id','=',$row->group_id)->where('sub_group_id','>',0)->get() as $child){
                    //
                }
            }
        }
        return $row->id;
    }
    public static function deleteDocument($id){
        $row=Document::find($id);
        $row->delete();
        foreach(attachFile::select()->where('table_kind',2)->where('table_id',$id)->get() as $file)
            Storage::delete($file->path);
        attachFile::select()->where('table_kind',2)->where('table_id',$id)->delete();
        return $row->id;
    }
    public static function getDocumentByGroup($gid){
        return Document::where('group_id','=',$gid)->where('sub_group_id','>',0)->get();
    }
    public static function getDocumentChartData(){
        $res=array();
        $today=date('Y-m-d');
        $res[0]=Document::select()->where('finished_status',0)->whereRaw('DATE(due_date)<CURDATE()')->get()->count();//whereDate('due_date','<',$today)
        $res[1]=Document::select()
                        ->leftJoin('groups', 'documents.group_id', '=', 'groups.id')
                        ->leftJoin('groups as sub_groups', 'documents.sub_group_id', '=', 'sub_groups.id')
                        ->where(function ($q){
                            $q->where(function ($q) {
                                $q->where(function ($q) {
                                    $q->where('documents.sub_group_id','=',0)
                                     ->orWhere('documents.sub_group_id','=',null)
                                     ->orWhere('documents.sub_group_id','=',"''");
                                })
                                ->whereRaw('DATEDIFF(DATE(documents.due_date),CURDATE())<=groups.alert_02');
                            })
                            ->orWhere(function ($q) {
                                $q->where('documents.sub_group_id','>',0)
                                ->whereRaw('DATEDIFF(DATE(documents.due_date),CURDATE())<=sub_groups.alert_02');
                            });
                        })
                        ->where('documents.finished_status',0)
                        ->get()->count();
        $res[2]=Document::select()->where('finished_status',0)->where('status',0)->get()->count();
        $res[3]=Document::select()->where('finished_status',0)->where('status',1)->get()->count();
        $res[4]=Document::select()->where('finished_status',0)->where('status',2)->get()->count();
        $res[5]=Document::select()->where('finished_status',0)->where('status',3)->get()->count();
        //$res[6]=Document::select()->where('status',4)->get()->count();
        $res[6]=Document::select()->where('finished_status',1)->get()->count();
        return $res;
    }
    public static function finishDocument(Request $request){
        $row=Document::find($request->input('id'));
        $row->finished_status=1;
        $row->finished_by=$request->input('finished_by');
        $row->finished_at=$request->input('finished_at');
        $row->save();

        foreach(Task::where('document_id',$request->input('id')) as $task)if($task['finish_status']==0){
            $row=Task::find($task['id']);
            $row->finished_status=1;
            $row->finished_by=$request->input('finished_by');
            $row->finished_at=$request->input('finished_at');
            $row->save();
        }
    }
    public static function getDocumentById(Request $request)
    {
        $id=$request->input('id');
        $row=Document::find($id);
        if($request->input('only_parent')==1){
            $row=Document::where(function ($q) {
                $q->where('sub_group_id','=',0)
                 ->orWhere('sub_group_id','=',null)
                 ->orWhere('sub_group_id','=',"''");
            })->where('group_id',$row->group_id)->get()[0];
        }
        $row->business_id=Project::find($row->project_id)->business_id;
        return $row;
    }
    public static function saveTemplate(Request $request){
        $row=$request->input('id')>0?AttachFile::find($request->input('id')):new AttachFile;
        $row->table_kind=2;
        $row->table_id=$request->input('document_id');
        $row->filename=$request->input('filename');
        $row->body=$request->input('body');
        $row->path='';
        $row->flag=1;
        $row->created_by=Auth::id();
        $row->save();
        return $row->id;
    }
}
