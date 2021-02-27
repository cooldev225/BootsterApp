<?php

namespace App\Http\Controllers\Util;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\Document;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskLog;
use App\Models\User;
use App\Models\Group;
use App\Models\NotifyState;
use DB;
use App\Datas\MailData;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Helper\MailHelper;
class NotifyUtil extends Controller{
    function frandlyDate($d){
        $d=explode(' ',$d)[0];
        $dd=explode('-',$d);
        if(count($dd)==3)return $dd[2].'/'.$dd[1].'/'.$dd[0];
        return $d;
    }
    public function notify(Request $request){
        $timezones = array(
            'AC' => 'America/Rio_branco',   'AL' => 'America/Maceio',
            'AP' => 'America/Belem',        'AM' => 'America/Manaus',
            'BA' => 'America/Bahia',        'CE' => 'America/Fortaleza',
            'DF' => 'America/Sao_Paulo',    'ES' => 'America/Sao_Paulo',
            'GO' => 'America/Sao_Paulo',    'MA' => 'America/Fortaleza',
            'MT' => 'America/Cuiaba',       'MS' => 'America/Campo_Grande',
            'MG' => 'America/Sao_Paulo',    'PR' => 'America/Sao_Paulo',
            'PB' => 'America/Fortaleza',    'PA' => 'America/Belem',
            'PE' => 'America/Recife',       'PI' => 'America/Fortaleza',
            'RJ' => 'America/Sao_Paulo',    'RN' => 'America/Fortaleza',
            'RS' => 'America/Sao_Paulo',    'RO' => 'America/Porto_Velho',
            'RR' => 'America/Boa_Vista',    'SC' => 'America/Sao_Paulo',
            'SE' => 'America/Maceio',       'SP' => 'America/Sao_Paulo',
            'TO' => 'America/Araguaia',
            );
        date_default_timezone_set('America/Sao_Paulo');


        $res="";
        for($i=1;$i<=2;$i++){
            DB::raw("SET timezone = 'America/Sao_Paulo'");
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
                'responsible_user.username as responsible_username','responsible_user.email as responsible_email',
                'finished_user.username as finished_username'
            )
            ->leftJoin('groups', 'documents.group_id', '=', 'groups.id')
            ->leftJoin('groups as sub_groups', 'documents.sub_group_id', '=', 'sub_groups.id')
            ->leftJoin('projects', 'documents.project_id', '=', 'projects.id')
            ->leftJoin('business', 'projects.business_id', '=', 'business.id')
            ->leftJoin('users', 'business.created_by', '=', 'users.id')
            ->leftJoin('users as responsible_user', 'documents.responsible_user_id', '=', 'responsible_user.id')
            ->leftJoin('users as finished_user', 'documents.finished_by', '=', 'finished_user.id')
            ->where('documents.finished_status',0)
            ->where(function ($q) use ($i) {
                $q->where(function ($q) use ($i) {
                    $q->where(function ($q) {
                        $q->where('documents.sub_group_id','=',0)
                        ->orWhere('documents.sub_group_id','=',null)
                        ->orWhere('documents.sub_group_id','=',"''");
                    })
                    ->whereRaw('DATEDIFF(DATE(documents.due_date),CURDATE())<=groups.alert_0'.$i);
                })
                ->orWhere(function ($q) use ($i) {
                    $q->where('documents.sub_group_id','>',0)
                    ->whereRaw('DATEDIFF(DATE(documents.due_date),CURDATE())<=sub_groups.alert_0'.$i);
                });
            });
            foreach($query->get() as $document){
                $rows=NotifyState::select()->where('document_id',$document['id'])->where('alert_num',$i)->get();
                if(count($rows))continue;
                $row=new NotifyState;
                $row->business_id=$document['business_id'];
                $row->project_id=$document['project_id'];
                $row->document_id=$document['id'];
                $row->group_id=$document['group_id'];
                $row->sub_group_id=$document['sub_group_id']?$document['sub_group_id']:0;
                $row->alert_num=$i;
                $row->email=$document['responsible_email'];
                //$row->save();
                //sending message
                $mailData = new MailData();
                $mailData->template = 'temps.document_alert';
                $mailData->fromEmail = config('mail.from.address');
                $mailData->userName = $document['responsible_username'];
                $mailData->toEmail = $document['responsible_email'];
                $mailData->subject = $document['business_first_name'].'-'.$document['business_last_name'];
                $mailData->mailType = 'RESET_LINK_TYPE';
                $query=Task::select(
                    'tasks.*',
                    'users.username','users.address as user_address',
                    'task_descs.description',
                    'groups.name as group_name','groups.id as group_id',
                    'subgroups.name as subgroup_name','subgroups.id as subgroup_id',
                    'finished_user.username as finished_username')
                    ->leftJoin('task_descs', 'task_descs.id', '=', 'tasks.desc_id')
                    ->leftJoin('documents', 'documents.id', '=', 'tasks.document_id')
                    ->leftJoin('groups', 'groups.id', '=', 'documents.group_id')
                    ->leftJoin('groups as subgroups', 'subgroups.id', '=', 'documents.sub_group_id')
                    ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
                    ->leftJoin('users as finished_user', 'tasks.finished_by', '=', 'finished_user.id')
                    ->where('document_id',$document['id']);
                $tasks="";
                foreach($query->get() as $task)$tasks.=($tasks==""?"":"###").$task['description']."@@@".$task['username']."@@@".$task['due_date']."@@@".$task['finished_username'];
                $mailData->content = ($document['sub_group_id']?$document['subgroup_name']:$document['group_name']).",".$this->frandlyDate($document['due_date']).",{$document['title']},{$document['description']}";
                $mailData->content.=",".$tasks;
                $res.="sending email ...".$mailData->content."<br>";
                //try{
                    Mail::to($mailData->toEmail)->send(new MailHelper($mailData));
                    $row->save();
                //}catch(Exception $e){}
                $res.="sending email <{$mailData->subject}(document:{$document['id']})> to {$document['responsible_email']} by aert {$i}<br>";
            }
        }
        exit($res);
    }

    public static function getNotificationByDocument(){
        DB::raw("SET timezone = 'America/Sao_Paulo'");
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
            'responsible_user.username as responsible_username','responsible_user.email as responsible_email',
            'finished_user.username as finished_username',

            'notify_states.alert_num as notify_alert_num',
            'notify_states.reading as notify_reading',
            'notify_states.created_at as notify_created_at',
            'notify_states.updated_at as notify_updated_at',
            'notify_states.id as notify_id'
        )
        ->rightJoin('notify_states', 'documents.id', '=', 'notify_states.document_id')
        ->leftJoin('groups', 'documents.group_id', '=', 'groups.id')
        ->leftJoin('groups as sub_groups', 'documents.sub_group_id', '=', 'sub_groups.id')
        ->leftJoin('projects', 'documents.project_id', '=', 'projects.id')
        ->leftJoin('business', 'projects.business_id', '=', 'business.id')
        ->leftJoin('users', 'business.created_by', '=', 'users.id')
        ->leftJoin('users as responsible_user', 'documents.responsible_user_id', '=', 'responsible_user.id')
        ->leftJoin('users as finished_user', 'documents.finished_by', '=', 'finished_user.id')
        ->where('notify_states.email',Auth::user()->email)
        ->orderBy('notify_states.reading','asc')
        ->orderBy('notify_states.created_at','desc');
        $rows=$query->get();
        return $rows;
    }
    public static function read(Request $request){
        $row=NotifyState::find($request->input('id'));
        $row->reading=1;
        $row->save();
        exit("ok");
    }
}
