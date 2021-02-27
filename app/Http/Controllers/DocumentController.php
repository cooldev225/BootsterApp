<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Util\GroupUtil;
use App\Http\Controllers\Util\DbUtil;
use App\Http\Controllers\Util\DocumentUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
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
    public function index(Request $request)
    {
        $business_id = $request->input('a');
        $project_id = $request->input('b');
        return view('frontend.document',[
            'business_id' => $business_id,
            'project_id' => $project_id,
            'parentGroupList'=>GroupUtil::getParentGroupList(),
            'subGroupCount'=>GroupUtil::getSubGroupCount(),
            'adStatesList' => DbUtil::getAdStatesList(),
            'responsibleUsersList' => DbUtil::getResponsibleUsersList(),
        ]);
    }
    public function getFileBody(Request $request){
        header('Content-Type: html/text');
        $file=Storage::get($request->input('path'));
        exit($file);
    }
    public function getDocumentDataTable(Request $request)
    {
        header('Content-Type: application/json');
		exit(json_encode(DocumentUtil::getDocumentDataTable($request)));
    }
    public function exportDocumentDataTable(Request $request)
    {
        //header('Content-Type: application/json');
		return DocumentUtil::exportDocumentDataTable($request);
    }
    public function saveDocument(Request $request){
        $id=DocumentUtil::saveDocument($request);
        $res=array('msg'=>'ok','id'=>$id);
		exit(json_encode($res));
    }
    public function deleteDocument(Request $request){
        $id=DocumentUtil::deleteDocument($request->input('id'));
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
    public function getDocumentByGroup(Request $request){
        exit(json_encode(DocumentUtil::getDocumentByGroup($request->input('gid'))));
    }
    public function finishDocument(Request $request){
        DocumentUtil::finishDocument($request);
        $res=array('msg'=>'ok');
		exit(json_encode($res));
    }
    public function getDocumentById(Request $request){
        exit(json_encode(DocumentUtil::getDocumentById($request)));
    }
    public function saveTemplate(Request $request){
        $id=DocumentUtil::saveTemplate($request);
        $res=array('msg'=>'ok','id'=>$id);
		exit(json_encode($res));
    }
}
