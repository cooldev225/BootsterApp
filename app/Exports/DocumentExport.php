<?php

namespace App\Exports;

use App\Models\Document;
use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Util\DocumentUtil;
class DocumentExport implements FromCollection
{
    public $request;
    public $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $columns=explode(',','title,due_date,group_name,subgroup_name,project_name,business_name,status,process,license,protocal,protocal_date,responsible_username,description,tasks');
        $headers=explode(',','Título,Data de Vencimento,Nome do grupo,Nome do subgrupo,Nome do Projeto,Nome da empresa,Estado,Processo,Licença,Protocolo,Data protocal,Nome de usuário responsável,Descrição,Tarefas');
        $status=explode(',','Opening,Em desenvolvimento,Esperando pelo cliente,Em arquivado,Órgão de espera');
        $res=DocumentUtil::getDocumentDataTable($this->request);
        for($i=0;$i<count($columns);$i++)$data[0][$columns[$i]]=$headers[$i];
        for($i=0;$i<count($res['data']);$i++){
            $tasks=Task::select('task_descs.description')->leftJoin('task_descs', 'task_descs.id', '=', 'tasks.desc_id')->where('tasks.document_id',$res['data'][$i]['id'])->get();
            $res['data'][$i]['business_name']="{$res['data'][$i]['business_first_name']} {$res['data'][$i]['business_last_name']}";
            $res['data'][$i]['status']=$status[$res['data'][$i]['status']];
            $res['data'][$i]['tasks']="";
            foreach($tasks as $task)$res['data'][$i]['tasks'].=($res['data'][$i]['tasks']==""?"":",").$task['description'];
            foreach($columns as $key)$data[$i+1][$key]=$res['data'][$i][$key];
        }
        $this->data=$data;
        return $this;
    }
    public function all(){
        return $this->data;
    }
}
