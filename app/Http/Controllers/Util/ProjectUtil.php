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
use App\Models\attachFile;

class ProjectUtil extends Controller{
    public static function saveBusiness(Request $request){
        $id=$request->input('id');
        $row=$id>0?Business::find($id):new Business;
        $row->first_name=$request->input('first_name');
        $row->last_name=$request->input('last_name');
        $row->cnpj=$request->input('cnpj');
        $row->ie=$request->input('ie');
        $row->im=$request->input('im');
        $row->open_date=$request->input('open_date');
        $row->ad_street=$request->input('ad_street');
        $row->ad_number=$request->input('ad_number');
        $row->ad_neighborhood=$request->input('ad_neighborhood');
        $row->ad_complement=$request->input('ad_complement');
        $row->ad_zip_code=$request->input('ad_zip_code');
        $row->ad_state=$request->input('ad_state');
        $row->ad_city=$request->input('ad_city');
        $row->municipio_cnum=$request->input('municipio_cnum');
        $row->mobile_office=$request->input('mobile_office');
        $row->mobile_phone=$request->input('mobile_phone');
        $row->contactor_name_01=$request->input('contactor_name_01');
        $row->contactor_phone_01=$request->input('contactor_phone_01');
        $row->contactor_email_01=$request->input('contactor_email_01');
        $row->contactor_name_02=$request->input('contactor_name_02');
        $row->contactor_phone_02=$request->input('contactor_phone_02');
        $row->contactor_email_02=$request->input('contactor_email_02');
        $row->alert_email_01=$request->input('alert_email_01');
        $row->alert_email_02=$request->input('alert_email_02');
        $row->description=$request->input('description');
        if($id==0)$row->created_by=Auth::id();
        $row->updated_by=Auth::id();
        $row->save();
        return $row->id;
    }
    public static function deleteBusiness($id){
        $row=Business::find($id);
        $row->delete();
        foreach(attachFile::select()->where('table_kind',0)->where('table_id',$id)->get() as $file)
            Storage::delete($file->path);
        attachFile::select()->where('table_kind',0)->where('table_id',$id)->delete();
        return $row->id;
    }
    public static function saveProject(Request $request){
        $id=$request->input('id');
        $row=$id>0?Project::find($id):new Project;
        $row->name=$request->input('name');
        $row->business_id=$request->input('business_id');
        $row->city=$request->input('city');
        $row->state=$request->input('state');
        $row->municipio_cnum=$request->input('municipio_cnum');
        $row->description=$request->input('description');
        if($id==0)$row->created_by=Auth::id();
        $row->updated_by=Auth::id();
        $row->updated_at=date('Y-m-d H:i:s');
        $row->save();
        return $row->id;
    }
    public static function deleteProject($id){
        $row=Project::find($id);
        $row->delete();
        foreach(attachFile::select()->where('table_kind',1)->where('table_id',$id)->get() as $file)
            Storage::delete($file->path);
        attachFile::select()->where('table_kind',1)->where('table_id',$id)->delete();
        return $row->id;
    }
    public static function getBusinessById($id){return Business::find($id);}
}