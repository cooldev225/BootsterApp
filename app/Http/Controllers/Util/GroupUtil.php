<?php

namespace App\Http\Controllers\Util;

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

class GroupUtil extends Controller{
    public static function getGroupDataTable(Request $request){
        $query=Group::select('groups.*','users.username as created_name')
                        ->leftJoin('users', 'groups.created_by', '=', 'users.id');
        $query=$query->where('parent',$request->input('parent'));
        $rows=$query->get();
        $params['pagination']['total']=count($rows);
        $params['pagination']['page']=$request->input('pagination.page');
        $params['pagination']['perpage']=$request->input('pagination.perpage');
		$params['pagination']['pages']=round($params['pagination']['total']/$params['pagination']['perpage'])+($params['pagination']['total']%$params['pagination']['perpage']<5?1:0);
        $params['sort']['field']=$request->input('sort.field');
        $params['sort']['sort']=$request->input('sort.sort');
        if(count($rows)&&isset($params['sort']['field'])&&isset($params['sort']['sort'])&&$params['sort']['field']!=null&&$params['sort']['sort']!=null)
        {
            foreach($rows[0] as $key=>$val)
                if($key==$params['sort']['field'])
                {
                    $$query=$query->orderBy("{$params['sort']['field']}","{$params['sort']['sort']}");
                    break;
                }            
        }
        $res['data']=$query
                        ->skip(($params['pagination']['page']-1)*$params['pagination']['perpage'])
                        ->take($params['pagination']['perpage'])
                        ->get();
		for($i=0;$i<count($res['data']);$i++) {
            $res['data'][$i]['documents_count']=count(Document::select()->where('group_id',$res['data'][$i]['id'])->get());
            $res['data'][$i]['children_count']=count(Group::select()->where('parent',$res['data'][$i]['id'])->get());
		}
        $res['meta']=$params['pagination'];
        return $res;
    }
    public static function getParentGroupList(){
        return Group::select()->where('parent',0)->get();
    }
    public static function saveGroup(Request $request){
        $id=$request->input('id');
        if($id==0&&count(Group::select()->where('name',$request->input('name'))->get()))return -1;
        $row=$id>0?Group::find($id):new Group;
        $row->name=$request->input('name');
        $row->parent=$request->input('parent');
        $row->alert_01=$request->input('alert_01');
        $row->alert_02=$request->input('alert_02');
        $row->template=$request->input('template');
        if($id==0)$row->created_by=Auth::id();
        $row->updated_by=Auth::id();
        $row->updated_at=date('Y-m-d H:i:s');
        $row->save();
        return $row->id;
    }
    public static function deleteGroup($id){
        $row=Group::find($id);
        $row->delete();
    }
    public static function getSubGroupCount(){
        return count(Group::select()->where('parent','>',0)->get());
    }
    public static function getGroupList($id){
        return Group::select()->where('parent',$id)->get();
    }
}