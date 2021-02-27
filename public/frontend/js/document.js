var country_table=null;
var taskdesc_table=null;
var documentDropzone=null;
var documentData=null;
var usersList=null;
var task_table=null;
var projectDropzone=null;
var documentColumns=[
    {
        field: 'id',
        title: '',
        width:20,
        sortable:false,
    },
    {
        field: 'title',
        title: lang.description,
        sortable:true,
    },
    {
        field: 'due_date',
        title: lang.duedate,
        sortable:true,
        template: function(row){
            if((new Date(row.due_date))<(new Date()))
                return '<font style="color:red;">'+getJustDateWIthYear(row.due_date)+'</font>';
            else if(row.alert_01_read+row.alert_02_read)
                return '<font style="color:blue;">'+getJustDateWIthYear(row.due_date)+'</font>';
            else
                return getJustDateWIthYear(row.due_date);
        }
    },
    {
        field: 'group_name',
        title: lang.group,
        sortable:false,
    },
    {
        field: 'subgroup_name',
        title: lang.subgroup,
        sortable:false,
    },
    {
        field: 'project_name',
        title: lang.project,
        sortable:false,
    },
    {
        field: 'business_name',
        title: lang.business,
        autoHide: false,
        sortable:false,
        template: function(row){
            return '<a data-toggle="modal" data-target="#viewBusinessModal" href="javascript:;" onclick="viewBusinessModal('+row.business_id+');">\
            '+row.business_first_name+' '+row.business_last_name+'\
            </a>';
        }
    },
    {
        field: 'state',
        title: lang.status,
        autoHide: false,
        sortable:false,
        width:115,
        template: function(row){
            var status = {
                0: {'title': limitText(lang.opening,15), 'class': 'label-light-primary'},
                1: {'title': limitText(lang.developing,15), 'class': ' label-light-info'},
                2: {'title': limitText(lang.waitingforclient,15), 'class': ' label-light-success'},
                3: {'title': limitText(lang.onfiled,15), 'class': ' label-light-danger'},
                4: {'title': limitText(lang.waitingorgan,15), 'class': ' label-warning'},
            };
            return '<span class="label ' + status[row.status].class + ' label-inline font-weight-bold label-lg">' + status[row.status].title + '</span>';
        }
    },
    /*{
        field: 'business_username',
        title: 'Client',
    },*/
     {
        field: 'Actions',
        title: lang.actions,
        sortable:false,
        overflow: 'visible',
        width: 125,
        autoHide: false,
        template: function(row) {
            //$(\'#edit_document_due_date\').val(encodeIvanFormat(\''+row.due_date+'\'));\
            return '\
                <div class="dropdown dropdown-inline">'+
                (row.sub_group_id>0&&false?'':'\
                <a data-toggle="modal" data-target="#editDocumentModal" href="javascript:;" onclick="\
                $(\'#quick_project_edit_btn\').css(\'display\',\'none\');\
                $(\'#edit_document_id\').val(0);\
                $(\'#edit_document_dupid\').val('+row.id+');\
                $(\'#edit_document_title\').val(\'\');\
                $(\'#edit_document_title\').prop(\'placeholder\',\''+row.title+'\');\
                $(\'#edit_document_due_date\').val(\'\');\
                $(\'#edit_document_status\').val('+row.status+');\
                $(\'#edit_document_business\').val('+row.business_id+').trigger(\'change\');changeBusiness('+row.project_id+');\
                $(\'#edit_document_group\').val('+row.group_id+').trigger(\'change\');changeGroup('+row.sub_group_id+');\
                $(\'#edit_document_description\').val(\''+row.description+'\');\
                $(\'#edit_document_process\').val(\''+row.process+'\');\
                $(\'#edit_document_license\').val(\''+row.license+'\');\
                $(\'#edit_document_protocal\').val(\''+row.protocal+'\');\
                $(\'#edit_document_protocal_date\').val(encodeIvanFormat(\''+row.protocal_date+'\'));\
                $(\'#edit_document_responsible_user\').val(\''+row.responsible_user_id+'\');\
                $(\'#edit_document_business\').prop(\'disabled\',true);\
                $(\'#edit_document_project\').prop(\'disabled\',true);\
                $(\'#edit_document_group\').prop(\'disabled\',true);\
                $(\'#edit_document_subgroup\').prop(\'disabled\',false);\
                changeSubGroup();\
                " class="btn btn-sm btn-clean btn-icon" title="Duplicate a document">\
                <i class="la la-plus"></i>\
                </a>')+
                '<a data-toggle="modal" data-target="#editDocumentModal" href="javascript:;" onclick="\
                $(\'#quick_project_edit_btn\').css(\'display\',\'none\');\
                $(\'#edit_document_id\').val('+row.id+');\
                $(\'#edit_document_title\').val(\''+row.title+'\');\
                $(\'#edit_document_due_date\').val(encodeIvanFormat(\''+row.due_date+'\'));\
                $(\'#edit_document_status\').val('+row.status+');\
                $(\'#edit_document_business\').val('+row.business_id+').trigger(\'change\');changeBusiness('+row.project_id+');\
                $(\'#edit_document_group\').val('+row.group_id+').trigger(\'change\');changeGroup('+row.sub_group_id+');\
                $(\'#edit_document_description\').val(\''+row.description+'\');\
                $(\'#edit_document_process\').val(\''+row.process+'\');\
                $(\'#edit_document_license\').val(\''+row.license+'\');\
                $(\'#edit_document_protocal\').val(\''+row.protocal+'\');\
                $(\'#edit_document_protocal_date\').val(encodeIvanFormat(\''+row.protocal_date+'\'));\
                $(\'#edit_document_responsible_user\').val(\''+row.responsible_user_id+'\');\
                $(\'#edit_document_business\').prop(\'disabled\',true);\
                $(\'#edit_document_project\').prop(\'disabled\',true);\
                $(\'#edit_document_group\').prop(\'disabled\',true);\
                $(\'#edit_document_subgroup\').prop(\'disabled\',true);\
                changeSubGroup();\
                " class="btn btn-sm btn-clean btn-icon" title="edit document">\
                    <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path><rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect></g></svg></span>\
                </a>'+
                (
                    row.finishable==0||row.finished_status==1?'':'\
                    <a data-toggle="modal" data-target="#finishDocumentModal" href="javascript:;" onclick="$(\'#finish_document_id\').val('+row.id+');" class="btn btn-sm btn-clean btn-icon" title="finish document">\
                    <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Navigation\Double-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                            <polygon points="0 0 24 0 24 24 0 24"/>\
                            <path d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) "/>\
                            <path d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) "/>\
                        </g>\
                    </svg><!--end::Svg Icon--></span>\
                    </a>'
                )+
                (row.tasks_count>0||row.children_count>0?'':'<a href="javascript:deleteDocument('+row.id+');" class="btn btn-sm btn-clean btn-icon mr-2" title="delete document">\
                    <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span>\
                </a>')+
                '</div>\
            ';
        },
    }
];
function finishDocumentEditForm(){
    var form_data = new FormData();
    form_data.append('id',$('#finish_document_id').val());
    form_data.append('finished_by',$('#finish_document_user').val());
    form_data.append('finished_at',encodeIvanFormat($('#finish_document_date').val()));
    $.ajax({
        url: '/document/finishDocument',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $('#finish_document_model_close_btn').trigger('click');
            country_table.reload();
        },
        error: function (response) {

        }
    });
}
function finishTaskEditForm(){
    var form_data = new FormData();
    form_data.append('id',$('#finish_task_id').val());
    form_data.append('finished_by',$('#finish_task_user').val());
    form_data.append('finished_at',encodeIvanFormat($('#finish_task_date').val()));
    $.ajax({
        url: '/task/finishTask',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $('#finish_task_model_close_btn').trigger('click');
            country_table.reload();
        },
        error: function (response) {

        }
    });
}
function datatableInitOfTaskDesc(){
    taskdesc_table=$('#kt_datatable_task_desc').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/task/getTaskDescDataTable',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    params:{
                        'group_id':$('#kt_datatable_task_desc_search_group').val(),
                    }
                },
            },
            pageSize: 10, // display 20 records per page
            serverPaging: true,
            serverFiltering: false,
            serverSorting: true
        },
        // layout definition
        layout: {
            scroll: false,
            footer: false,
            header:true
        },
        sortable: true,
        pagination: true,
        search: {
            input: $('#kt_datatable_task_desc_search_like'),
            key: 'generalSearch'
        },
        // columns definition
        columns:
        [
            {
                field: 'description',
                title: lang.description,
                //width:600,
                flex:true,
            },
            {
                field: 'Actions',
                title: lang.actions,

                sortable: false,
                //overflow: 'visible',
                width: 100,
                //autoHide: false,
                template: function(row) {
                    if(row.tasks)return row.tasks+' '+lang.task+(row.task>1?'s':'');
                    return '\
                        <div class="dropdown dropdown-inline">\
                        <a href="javascript:deleteTaskDescAction('+row.id+');" class="btn btn-sm btn-clean btn-icon mr-2" title="Reset password">\
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span>\
                        </a>\
                        </div>\
                    ';
                },
            }
        ],
        translate: trans_pagination,
    });
}
function deleteTaskDescAction(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/task/deleteTaskDesc',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            searchTaskDeschAction();
        },
        error: function (response) {

        }
    });
}
function searchTaskDeschAction(){
    taskdesc_table.setDataSourceParam('group_id',$('#kt_datatable_task_desc_search_group').val());
    taskdesc_table.reload();
}
function saveTaskDeschAction(){
    if($('#kt_datatable_task_desc_create_desc').val()==''){
        $('#kt_datatable_task_desc_create_desc').focus();
        return;
    }
    var form_data = new FormData();
    form_data.append('id',$('#kt_datatable_task_desc_create_id').val());
    form_data.append('group_id',$('#kt_datatable_task_desc_search_group').val());
    form_data.append('description',$('#kt_datatable_task_desc_create_desc').val());
    $.ajax({
        url: '/task/saveTaskDesc',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            searchTaskDeschAction();
            $('#kt_datatable_task_desc_create_desc').val('');
            $('#kt_datatable_task_desc_create_desc').focus();
        },
        error: function (response) {

        }
    });
}
function submitAttachFileEditForm(){
    var form_data = new FormData();
    form_data.append('id',$('#edit_attach_file_id').val());
    form_data.append('filename',$('#edit_attach_file_name').val());
    form_data.append('document_id',$('#edit_attach_document_id').val());
    form_data.append('body',escape(tinyMCE.activeEditor.getContent()));
    $.ajax({
        url: '/document/saveTemplate',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            country_table.reload();
            $('#attach_file_model_close_btn').trigger('click');
        },
        error: function (response) {

        }
    });
}
function deleteAttachFileAction(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/home/attachRemoveFile',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            country_table.reload();
        },
        error: function (response) {

        }
    });
}
function exportExcel(){
    window.open('/document/exportDocumentDataTable'+
                '?status='+$('#kt_datatable_search_status').val()+
                '&q_start='+encodeIvanFormat($('#kt_datatable_search_start').val())+' 00:00:00'+
                '&q_end='+encodeIvanFormat($('#kt_datatable_search_end').val())+' 23:59:59'+
                '&q_user='+$('#kt_datatable_search_user').val()+
                '&finished_status='+$('#kt_datatable_search_finished').val()+
                '&q_business='+$('#kt_datatable_search_business').val()+
                '&q_project='+$('#kt_datatable_search_project').val()+
                '&q_group='+$('#kt_datatable_search_group').val()+
                '&q_subgroup='+$('#kt_datatable_search_subgroup').val());
}
function expendDetailBody(e){
    var detail=$('<div/>').attr('id', 'child_data_ajax_' + e.data.id);
    var html='\
        <div style="padding-top:10px;padding-bottom:10px;">\
        <p><p>\
        <span class="label label-light-primary font-weight-bolder label-inline ml-2">'+lang.description+'</span>\
        <span class="text-muted ml-2">'+e.data.description+'</span>\
        <span class="label label-light-primary font-weight-bolder label-inline ml-2">'+lang.project+'</span>\
        <span class="text-muted ml-2">'+e.data.process+'</span>\
        <span class="label label-light-primary font-weight-bolder label-inline ml-2">'+lang.license+'</span>\
        <span class="text-muted ml-2">'+e.data.license+'</span>\
        <span class="label label-light-primary font-weight-bolder label-inline ml-2">'+lang.user+'</span>\
        <span class="text-muted ml-2">'+e.data.responsible_username+'</span>\
        <span class="label label-light-'+(e.data.alert_01_read?'primary':'warning')+' font-weight-bolder label-inline ml-2">'+lang.firstalert+'</span>\
        <span class="text-muted ml-2" style="color: '+(e.data.alert_01_read?'#1bc5bd':'#000000db')+' !important;font-weight:bold;">'+getAlertDate(e.data.due_date,-(e.data.sub_group_id>0?e.data.subgroup_alert_01:e.data.group_alert_01),e.data.created_at)+'</span>\
        <span class="label label-light-'+(e.data.alert_01_read?'primary':'danger')+' font-weight-bolder label-inline ml-2">'+lang.secondalert+'</span>\
        <span class="text-muted ml-2" style="color: '+(e.data.alert_02_read?'#1bc5bd':'#000000db')+' !important;font-weight:bold;">'+getAlertDate(e.data.due_date,-(e.data.sub_group_id>0?e.data.subgroup_alert_02:e.data.group_alert_02),e.data.created_at)+'</span>\
        '+(e.data.finished_status==1?'<span class="label label-light-success font-weight-bolder label-inline ml-2">Finished by</span>\
        <span class="text-muted ml-2">'+e.data.finished_username+'</span>\
        <span class="label label-light-success font-weight-bolder label-inline ml-2">Finished at</span>\
        <span class="text-muted ml-2" style="color: #000000db !important;font-weight:bold;">'+getJustDate(e.data.finished_at)+'</span>\
        ':'');
        //
    html+='<p class="p-0 ml-2">\
    <div class="twice_area" style="display:flex;padding-left:10px;">\
        <div class="file_area" style="width:250px;">\
            <a href="javascript:;" '+(e.data.finished_status?' disabled ':' ')+'\
            onclick="\
            $(\'#edit_attach_file_id\').val(0);\
            $(\'#edit_attach_document_id\').val('+e.data.id+');\
            $(\'#edit_attach_file_name\').val(\''+(e.data.sub_group_id>0?e.data.subgroup_name:e.data.group_name)+'-template.txt\');\
            tinyMCE.activeEditor.setContent(unescape(\''+(e.data.sub_group_id>0?e.data.subtemplate:e.data.template)+'\'));\
            " class="btn btn-outline-primary btn-sm mr-2 mt-2 mb-2" data-toggle="modal" data-target="#fileViewModal">\
            '+lang.createfile+'\
            </a>\
            <br><table>';
            for(var i=0;i<e.data.attached_files.length;i++){
                if(e.data.attached_files[i].flag==0)
                    html+=  '<tr><td width="*" alt="'+e.data.attached_files[i].filename+'">\
                                <a href="download/'+e.data.attached_files[i].path+'" target="_blank" alt="'+e.data.attached_files[i].filename+'">'+limitText(e.data.attached_files[i].filename,22)+'</a>\
                                </td><td width="22px;"><a style="cursor:pointer;" onclick="deleteAttachFileAction('+e.data.attached_files[i].id+');"><span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\Deleted-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <polygon points="0 0 24 0 24 24 0 24"/>\
                                        <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                        <path d="M10.5857864,13 L9.17157288,11.5857864 C8.78104858,11.1952621 8.78104858,10.5620972 9.17157288,10.1715729 C9.56209717,9.78104858 10.1952621,9.78104858 10.5857864,10.1715729 L12,11.5857864 L13.4142136,10.1715729 C13.8047379,9.78104858 14.4379028,9.78104858 14.8284271,10.1715729 C15.2189514,10.5620972 15.2189514,11.1952621 14.8284271,11.5857864 L13.4142136,13 L14.8284271,14.4142136 C15.2189514,14.8047379 15.2189514,15.4379028 14.8284271,15.8284271 C14.4379028,16.2189514 13.8047379,16.2189514 13.4142136,15.8284271 L12,14.4142136 L10.5857864,15.8284271 C10.1952621,16.2189514 9.56209717,16.2189514 9.17157288,15.8284271 C8.78104858,15.4379028 8.78104858,14.8047379 9.17157288,14.4142136 L10.5857864,13 Z" fill="#000000"/>\
                                    </g>\
                                </svg><!--end::Svg Icon--></span></a></td>';
                else
                    html+=  '<tr><td alt="'+e.data.attached_files[i].filename+'">\
                        <a href="javascript:;" class="mr-5" data-toggle="modal" data-target="#fileViewModal" onclick="\
                        $(\'#edit_attach_file_id\').val(\''+e.data.attached_files[i].id+'\');\
                        $(\'#edit_attach_file_name\').val(\''+e.data.attached_files[i].filename+'\');\
                        $(\'#edit_attach_document_id\').val('+e.data.id+');\
                        tinyMCE.activeEditor.setContent(unescape(\''+e.data.attached_files[i].body+'\'));" alt="'+e.data.attached_files[i].filename+'">'+limitText(e.data.attached_files[i].filename,22)+'</a>\
                        </td><td><a style="cursor:pointer;" onclick="deleteAttachFileAction('+e.data.attached_files[i].id+');"><span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\Deleted-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                <polygon points="0 0 24 0 24 24 0 24"/>\
                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
                                <path d="M10.5857864,13 L9.17157288,11.5857864 C8.78104858,11.1952621 8.78104858,10.5620972 9.17157288,10.1715729 C9.56209717,9.78104858 10.1952621,9.78104858 10.5857864,10.1715729 L12,11.5857864 L13.4142136,10.1715729 C13.8047379,9.78104858 14.4379028,9.78104858 14.8284271,10.1715729 C15.2189514,10.5620972 15.2189514,11.1952621 14.8284271,11.5857864 L13.4142136,13 L14.8284271,14.4142136 C15.2189514,14.8047379 15.2189514,15.4379028 14.8284271,15.8284271 C14.4379028,16.2189514 13.8047379,16.2189514 13.4142136,15.8284271 L12,14.4142136 L10.5857864,15.8284271 C10.1952621,16.2189514 9.56209717,16.2189514 9.17157288,15.8284271 C8.78104858,15.4379028 8.78104858,14.8047379 9.17157288,14.4142136 L10.5857864,13 Z" fill="#000000"/>\
                            </g>\
                        </svg><!--end::Svg Icon--></span></a></td>';
            }
            html+='</table>\
        </div>\
        <div class="task_area" style="float:right; width:100%;padding-left:10px;padding-right:10px;">\
            <a href="javascript:;" '+(e.data.finished_status?' disabled ':' ')+'\
            onclick="\
            $(\'#edit_task_business_name\').html(\''+e.data.business_first_name+' '+e.data.business_last_name+'\');\
            $(\'#edit_task_project_name\').html(\''+e.data.project_name+'\');\
            $(\'#edit_task_document_name\').html(\''+e.data.title+'\');\
            $(\'#edit_task_municipio_cnum\').val('+e.data.project_municipio_cnum+');\
            $(\'#edit_task_state\').val(\''+e.data.project_state+'\').trigger(\'change\');\
            taskEditModalAction('+e.data.id+','+e.data.group_id+',\''+e.data.due_date+'\');" class="btn btn-outline-primary btn-sm mr-2 mt-2" data-toggle="modal" data-target="#TaskModal">\
            '+lang.createtask+'\
            </a>\
            <div id="parent_kt_datatable_tasks_' + e.data.id+'"></div>\
        </div>\
    </div></p></div>';
    detail.append(html);
    detail.appendTo(e.detailCell);
    //if(e.data.tasks_count>0){
    task_table=$('<div/>').attr('id', 'kt_datatable_tasks_' + e.data.id).appendTo($('#parent_kt_datatable_tasks_' + e.data.id)).KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/task/getTaskDataTable',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    params:{
                        'document_id':e.data.id,
                        'group_id':e.data.group_id,
                        'q_start':encodeIvanFormat($('#kt_datatable_search_start').val())+' 00:00:00',
                        'q_end':encodeIvanFormat($('#kt_datatable_search_end').val())+' 23:59:59',
                        'q_business':$('#kt_datatable_search_business').val(),
                        'q_project':$('#kt_datatable_search_project').val(),
                        'q_group':$('#kt_datatable_search_group').val(),
                        'q_subgroup':$('#kt_datatable_search_subgroup').val()
                    }
                },
            },
            pageSize: 10, // display 20 records per page
            serverPaging: true,
            serverFiltering: false,
            serverSorting: true
        },
        layout: {
            scroll: false,
            footer: false,
            header:false
        },
        sortable: true,
        pagination: true,
        columns:
        [
            {
                field: 'description',
                title: lang.description,
                width:330
            },
            {
                field: 'due_date',
                title: lang.datetofinish,
                template: function(row){
                    return getJustDate(row.due_date);
                },
                width:40
            },
            {
                field: 'username',
                title: lang.user,
                width:85
            },
            {
                field: 'city',
                title: lang.location,
                width:90
            },
            {
                field: 'finished_at',
                title: lang.finishedat,
                width: 40,
                template: function(row){
                    return row.finished_status==1?getJustDate(row.finished_at):'';
                }
            },
            {
                field: 'finished_username',
                title: lang.finishedby,
                width: 85,
                template: function(row){
                    return row.finished_status==1?row.finished_username:'';
                }
            },
            {
                field: 'Actions',
                title: lang.actions,
                //overflow: 'visible',
                width: 80,
                autoHide: false,
                template: function(row) {
                    return '\
                        <div class="dropdown dropdown-inline">'+
                        (
                            row.finished_status==1?'':'\
                            <a data-toggle="modal" data-target="#finishTaskModal" href="javascript:;" onclick="$(\'#finish_task_id\').val('+row.id+');" class="btn btn-sm btn-clean btn-icon" title="Finish task">\
                            <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Navigation\Double-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                    <polygon points="0 0 24 0 24 24 0 24"/>\
                                    <path d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) "/>\
                                    <path d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) "/>\
                                </g>\
                            </svg><!--end::Svg Icon--></span>\
                            </a>'
                        )+
                        '<a href="javascript:deleteTask('+row.id+');" class="btn btn-sm btn-clean btn-icon mr-2" title="Delete task">\
                            <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span>\
                        </a>\
                        </div>\
                    ';
                },
            }
        ],
        translate: trans_pagination,
    });
    if(e.data.tasks_count==0)$('#kt_datatable_tasks_'+e.data.id).fadeOut();
    if(e.data.children_count>0&&!$('#kt_datatable_search_expanding').prop('checked')){
        $('<div/>').attr('id', 'kt_datatable_children_' + e.data.id).appendTo(e.detailCell).KTDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/document/getDocumentDataTable',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        params:{
                            'group_id':e.data.group_id,
                            'status':$('#kt_datatable_search_status').val(),
                            'q_user':$('#kt_datatable_search_user').val(),
                            'finished_status': $('#kt_datatable_search_finished').prop('checked'),
                            'q_start':encodeIvanFormat($('#kt_datatable_search_start').val())+' 00:00:00',
                            'q_end':encodeIvanFormat($('#kt_datatable_search_end').val())+' 23:59:59',
                            'q_business':$('#kt_datatable_search_business').val(),
                            'q_project':$('#kt_datatable_search_project').val(),
                            'q_group':$('#kt_datatable_search_group').val(),
                            'q_subgroup':$('#kt_datatable_search_subgroup').val()
                        }
                    },
                },
                pageSize: 10, // display 20 records per page
                serverPaging: true,
                serverFiltering: false,
                serverSorting: true
            },
            // layout definition
            layout: {
                scroll: false,
                footer: false,
                header:false
            },
            sortable: true,
            pagination: true,
            // columns definition
            columns: documentColumns,
            translate: trans_pagination,
            detail:{
                title: 'Load children documents',
                content: expendDetailBody,
            }
        });
    }
}
function datatableInit(){
    country_table=$('#kt_datatable').KTDatatable({
        data: documentData,
        layout: {
            scroll: false,
            footer: true,
        },
        sortable: true,
        pagination: true,
        detail: {
            title: 'Load documents',
            content: expendDetailBody,
        },

        search: {
            input: $('#kt_datatable_search_query'),
            key: 'generalSearch'
        },

        // columns definition
        columns: documentColumns,
        translate: trans_pagination
    });
}
function newProjectAction(){
    $('#document_model_close_btn').trigger('click');
    $('#edit_project_business').val($('#edit_document_business').val()).trigger('change');
    $('#edit_project_business').prop('disabled',true);
    var form_data = new FormData();
    form_data.append('id',$('#edit_project_business').val());
    $.ajax({
        url: '/project/getBusinessById',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $('#edit_project_municipio_cnum').val(response.municipio_cnum);
            $('#edit_project_state').val(response.ad_state).trigger('change');
        },
        error: function (response) {

        }
    });
}
function taskEditModalAction(document_id,group_id,due_date){
    $('#edit_task_document_id').val(document_id);
    $('#edit_task_due_date').val(encodeIvanFormat(due_date));
    var form_data = new FormData();
    form_data.append('group_id',group_id);
    $.ajax({
        url: '/task/getTaskDescsList',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $("#edit_task_desc_id").empty();
            for(var i=0;i<response.length;i++){
                $("#edit_task_desc_id").append($("<option></option>").attr("value", response[i].id).text(response[i].description));
            }
        },
        error: function (response) {

        }
    });
}
function submitTaskEditForm(){
    var form_data = new FormData();
    form_data.append('id',$('#edit_task_id').val());
    form_data.append('desc_id',$('#edit_task_desc_id').val());
    form_data.append('document_id',$('#edit_task_document_id').val());
    form_data.append('user_id',$('#edit_task_user_id').val());
    form_data.append('due_date',encodeIvanFormat($('#edit_task_due_date').val()));
    form_data.append('state',$('#edit_task_state').val());
    form_data.append('city',$('#edit_task_city option:selected').text());
    form_data.append('municipio_cnum',$('#edit_task_city').val());
    $.ajax({
        url: '/task/saveTask',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            //$('#kt_datatable_tasks_'+$('#edit_task_desc_id').val()).fadeIn();
            //task_table.reload();
            //$('#task_model_close_btn').trigger('click');
            location.reload();
        },
        error: function (response) {

        }
    });
}
function deleteTask(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/task/deleteTask',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $('#kt_datatable_tasks_'+$('#edit_task_desc_id').val()).fadeIn();
            task_table.reload();
        },
        error: function (response) {

        }
    });
}
function viewBusinessModal(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/project/getBusinessById',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $('#edit_business_id').val(response.id);
            $('#edit_business_first_name').val(response.first_name);
            $('#edit_business_last_name').val(response.last_name);
            $('#edit_business_cnpj').val(response.cnpj);
            $('#edit_business_im').val(response.im);
            $('#edit_business_ie').val(response.ie);
            $('#edit_business_open_date').val(encodeIvanFormat(response.open_date));
            $('#edit_business_ad_street').val(response.ad_street);
            $('#edit_business_ad_number').val(response.ad_number);
            $('#edit_business_ad_neighborhood').val(response.ad_neighborhood);
            $('#edit_business_ad_complement').val(response.ad_complement);
            $('#edit_business_ad_zip_code').val(response.ad_zip_code);
            $('#edit_business_ad_state').val(response.ad_state).trigger('change');
            $('#edit_business_municipio_cnum').val(response.municipio_cnum);
            $('#edit_business_mobile_office').val(response.mobile_office);
            $('#edit_business_mobile_phone').val(response.mobile_phone);
            $('#edit_business_contactor_name_01').val(response.contactor_name_01);
            $('#edit_business_contactor_phone_01').val(response.contactor_phone_01);
            $('#edit_business_contactor_email_01').val(response.contactor_email_01);
            $('#edit_business_contactor_name_02').val(response.contactor_name_02);
            $('#edit_business_contactor_phone_02').val(response.contactor_phone_02);
            $('#edit_business_contactor_email_02').val(response.contactor_email_02);
            $('#edit_business_alert_email_01').val(response.alert_email_01);
            $('#edit_business_alert_email_02').val(response.alert_email_02);
            $('#edit_business_description').val(response.description);
        },
        error: function (response) {

        }
    });
}
$("#editBusinessModal_btn").click(function (e) {
    e.preventDefault();
    if($('#edit_business_first_name').val()==''){
        $('#edit_business_first_name').focus();
        return;
    }
    if($('#edit_business_last_name').val()==''){
        $('#edit_business_last_name').focus();
        return;
    }
    if($('#edit_business_cnpj').val()==''){
        $('#edit_business_cnpj').focus();
        return;
    }
    if($('#edit_business_ad_street').val()==''){
        $('#edit_business_ad_street').focus();
        return;
    }
    if($('#edit_business_ad_number').val()==''){
        $('#edit_business_ad_number').focus();
        return;
    }
    if($('#edit_business_ad_neighborhood').val()==''){
        $('#edit_business_ad_neighborhood').focus();
        return;
    }
    if($('#edit_business_ad_zip_code').val()==''){
        $('#edit_business_ad_zip_code').focus();
        return;
    }
    if($('#edit_business_mobile_office').val()==''){
        $('#edit_business_mobile_office').focus();
        return;
    }
    if($('#edit_business_mobile_phone').val()==''){
        $('#edit_business_mobile_phone').focus();
        return;
    }
    if($('#edit_business_contactor_name_01').val()==''){
        $('#edit_business_contactor_name_01').focus();
        return;
    }
    if($('#edit_business_contactor_phone_01').val()==''){
        $('#edit_business_contactor_phone_01').focus();
        return;
    }
    if($('#edit_business_contactor_email_01').val()==''){
        $('#edit_business_contactor_email_01').focus();
        return;
    }
    if($('#edit_business_alert_email_01').val()==''){
        $('#edit_business_alert_email_01').focus();
        return;
    }
    var form_data = new FormData();
    form_data.append('id',$('#edit_business_id').val());
    form_data.append('first_name',$('#edit_business_first_name').val());
    form_data.append('last_name',$('#edit_business_last_name').val());
    form_data.append('cnpj',$('#edit_business_cnpj').val());
    form_data.append('ie',$('#edit_business_ie').val());
    form_data.append('im',$('#edit_business_im').val());
    form_data.append('open_date',encodeIvanFormat($('#edit_business_open_date').val()));
    form_data.append('ad_street',$('#edit_business_ad_street').val());
    form_data.append('ad_number',$('#edit_business_ad_number').val());
    form_data.append('ad_neighborhood',$('#edit_business_ad_neighborhood').val());
    form_data.append('ad_complement',$('#edit_business_ad_complement').val());
    form_data.append('ad_zip_code',$('#edit_business_ad_zip_code').val());
    form_data.append('ad_state',$('#edit_business_ad_state').val());
    form_data.append('ad_city',$('#edit_business_ad_city option:selected').text());
    form_data.append('municipio_cnum',$('#edit_business_ad_city').val());
    form_data.append('mobile_office',$('#edit_business_mobile_office').val());
    form_data.append('mobile_phone',$('#edit_business_mobile_phone').val());
    form_data.append('contactor_name_01',$('#edit_business_contactor_name_01').val());
    form_data.append('contactor_phone_01',$('#edit_business_contactor_phone_01').val());
    form_data.append('contactor_email_01',$('#edit_business_contactor_email_01').val());
    form_data.append('contactor_name_02',$('#edit_business_contactor_name_02').val());
    form_data.append('contactor_phone_02',$('#edit_business_contactor_phone_02').val());
    form_data.append('contactor_email_02',$('#edit_business_contactor_email_02').val());
    form_data.append('alert_email_01',$('#edit_business_alert_email_01').val());
    form_data.append('alert_email_02',$('#edit_business_alert_email_02').val());
    form_data.append('description',$('#edit_business_description').val());
    $.ajax({
        url: '/project/saveBusiness',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            country_table.reload();
            $('#business_model_close_btn').trigger('click');
        },
        error: function (response) {

        }
    });
});


function changeBusiness(pid){
    var id=$('#edit_document_business').val();
    var projects=$. parseJSON($('#project_object').val());
    $("#edit_document_project").empty();
    if(projects.length==0)return;
    for(var i=0;i<projects[id].length;i++){
        $("#edit_document_project").append($("<option></option>").attr("value", projects[id][i].id).text(projects[id][i].name));
    }
    if(pid>0)$("#edit_document_project").val(pid);
}
function changeQeryBusiness(id){
    var projects=$. parseJSON($('#project_object').val());
    $("#kt_datatable_search_project").empty();
    $("#kt_datatable_search_project").append($("<option></option>").attr("value", 0).text('___'+lang.all+'___'));
    if(projects.length==0)return;
    for(var i=0;i<projects[id].length;i++){
        $("#kt_datatable_search_project").append($("<option></option>").attr("value", projects[id][i].id).text(projects[id][i].name));
    }
}
function changeGroup(sid){
    id=$("#edit_document_group").val();
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/group/getGroupList',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $("#edit_document_subgroup").empty();
            $("#edit_document_subgroup").append($("<option></option>").attr("value", '').text('___NULL___'));
            for(var i=0;i<response.length;i++){
                $("#edit_document_subgroup").append($("<option></option>").attr("value", response[i].id).text(response[i].name));
            }
            if(sid>0)$("#edit_document_subgroup").val(sid);
        },
        error: function (response) {

        }
    });
}
function changeQueryGroup(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/group/getGroupList',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $("#kt_datatable_search_subgroup").empty();
            $("#kt_datatable_search_subgroup").append($("<option></option>").attr("value", '').text('___'+lang.all+'___'));
            for(var i=0;i<response.length;i++){
                $("#kt_datatable_search_subgroup").append($("<option></option>").attr("value", response[i].id).text(response[i].name));
            }
        },
        error: function (response) {

        }
    });
}
function changeSubGroup(){
    var form_data = new FormData();
    form_data.append('gid',$('#edit_document_group').val());
    $.ajax({
        url: '/document/getDocumentByGroup',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            if(response.length==0){
                //$('#edit_document_process').val('');
                //$('#edit_document_license').val('');
            }else{
                //$('#edit_document_process').val(response[0].process);
                //$('#edit_document_license').val(response[0].license);
            }
            var sgid=$('#edit_document_subgroup').val();
            if(sgid==0||sgid==''||sgid===null){
                //$('#edit_document_process').prop('disabled',false);
                //$('#edit_document_license').prop('disabled',false);
            }else{
                //$('#edit_document_process').prop('disabled',true);
                //$('#edit_document_license').prop('disabled',true);
            }
        },
        error: function (response) {

        }
    });
}
function getFileBody(path){
    //window.open(\'download/'+e.data.attached_files[i].path+'\');
    var form_data = new FormData();
    form_data.append('path',path);
    $.ajax({
        url: '/home/getFileBody',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "html",
        success: function (response) {
            tinyMCE.activeEditor.setContent(response);
        },
        error: function (response) {
            tinyMCE.activeEditor.setContent(response);
        }
    });
}
$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
});
$(document).on('keyup', 'input,select', function (e) {
    if(e.keyCode==13&&$(this).val()!=''){
        e.preventDefault();
        var index = $('.form-control').index(this) + 1;
        $('.form-control').eq(index).focus();
    }
});
function changeState(uf){
    var form_data = new FormData();
    form_data.append('uf',uf);
    $.ajax({
        url: '/project/getAdCitiesList',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $("#edit_business_ad_city").empty();
            var newOption;
            for(var i=0;i<response.length;i++){
                //$("#edit_business_ad_city").append($("<option></option>").attr("value", response[i].cnum).text(response[i].xnum));
                newOption = new Option(response[i].xnum, response[i].cnum, false, false);
                $('#edit_business_ad_city').append(newOption).trigger('change');
            }
            if($('#edit_business_municipio_cnum').val()!=''){
                $("#edit_business_ad_city").val($('#edit_business_municipio_cnum').val()).trigger('change');
                $('#edit_business_municipio_cnum').val('');
            }
        },
        error: function (response) {

        }
    });
}
jQuery(document).ready(function() {
    $('#edit_document_protocal_date').datepicker({
        autoClose: true,
    });
    $('#edit_document_responsible_user').select2();
    $('#edit_document_business').select2();
    $('#edit_document_project').select2();
    $('#edit_document_group').select2();
    $('#edit_document_subgroup').select2();
    tinymce.init(tinymceOption);
    $('#edit_document_due_date').datepicker();
    $('#kt_datatable_search_start').datepicker();
    $('#kt_datatable_search_end').datepicker();
    $('#kt_datatable_search_finished').on('change',function(){searchAction();});
    $('#kt_datatable_search_expanding').on('change',function(){searchAction();});
    $('#edit_document_business').on('change',function(){
        changeBusiness(0);
    });
    $('#edit_document_group').on('change',function(){
        changeGroup(0);
    });
    changeBusiness(0);
    changeGroup(0);
    $('#edit_document_subgroup').on('change',function(){
        changeSubGroup();
    });

    //search filters
    $('#kt_datatable_search_status').select2();
    $('#kt_datatable_search_status').on('change',function(){
        searchAction();
    });
    $('#kt_datatable_search_user').select2();
    $('#kt_datatable_search_user').on('change',function(){
        searchAction();
    });
    $('#kt_datatable_search_group').select2();
    $('#kt_datatable_search_group').on('change',function(){
        changeQueryGroup($(this).val());
        searchAction();
    });
    $('#kt_datatable_search_subgroup').select2();
    $('#kt_datatable_search_subgroup').on('change',function(){
        searchAction();
    });
    $('#kt_datatable_search_business').select2();
    $('#kt_datatable_search_business').on('change',function(){
        changeQeryBusiness($(this).val());
        searchAction();
    });
    $('#kt_datatable_search_project').select2();
    $('#kt_datatable_search_project').on('change',function(){
        searchAction();
    });
    //
    $('#edit_business_ad_state').select2();
    $('#edit_business_ad_city').select2();
    $('#edit_business_open_date').datepicker({
        autoClose: true,
    }).on('changeDate', function(){
        $(this).blur();
    });
    $('#edit_business_ad_state').on('change',function(){
        changeState($(this).val());
    });
    //changeState($('#edit_business_ad_state').val());

    $('#finish_document_date').datepicker();
    $('#finish_document_user').select2();
    $('#finish_task_date').datepicker();
    $('#finish_task_user').select2();
    //
    $('#edit_task_desc_id').select2();
    $('#edit_task_due_date').datepicker();
    $('#edit_task_user_id').select2();
    documentData={
        type: 'remote',
        source: {
            read: {
                url: '/document/getDocumentDataTable',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                params:{
                    'group_id':0,
                    'status':$('#kt_datatable_search_status').val(),
                    'q_user':$('#kt_datatable_search_user').val(),
                    'finished_status': $('#kt_datatable_search_finished').prop('checked'),
                    'q_start':encodeIvanFormat($('#kt_datatable_search_start').val())+' 00:00:00',
                    'q_end':encodeIvanFormat($('#kt_datatable_search_end').val())+' 23:59:59',
                    'q_business':$('#kt_datatable_search_business').val(),
                    'q_project':$('#kt_datatable_search_project').val(),
                    'q_group':$('#kt_datatable_search_group').val(),
                    'q_subgroup':$('#kt_datatable_search_subgroup').val()
                }
            },
        },
        pageSize: 10,
        serverPaging: true,
        serverFiltering: false,
        serverSorting: true
    };
    datatableInit();
    searchAction();
    $('.datatable .datatable-table .datatable-body .datatable-row').on('click',function(){
        $(this).find('.datatable-toggle-subtable').trigger('click');
    });

    $('#kt_datatable_task_desc_search_group').select2();
    datatableInitOfTaskDesc();

    searchTaskDeschAction();
    $('#kt_datatable_task_desc_search_group').on('change',function(){
        searchTaskDeschAction();
    });

    $('#edit_task_state').select2();
    $('#edit_task_city').select2();
    $('#edit_task_state').on('change',function(){
        changeTaskState($(this).val());
    });
    changeTaskState($('#edit_task_state').val());

    $('#edit_project_business').select2();
    $('#edit_project_state').select2();
    $('#edit_project_city').select2();
    $('#edit_project_state').on('change',function(){
        changeProjectState($(this).val());
    });
    changeProjectState($('#edit_project_state').val());

    $('#project_model_close_btn').on('click',function(){
        $('#add_new_document_btn').trigger('click');
    });
    projectDropzone = new Dropzone("div#dropzoneProjectForm", {
        url: "/project/attachFile",
        paramName: "file",
        maxFilesize: 200, // MB
        addRemoveLinks: true,
        thumbnailWidth: 294,
        thumbnailHeight: 294,
        autoProcessQueue: false,
        dictDefaultMessage: lang.dropattach,
        init: function () {
            this.on("processing", function(file) {

            });
            this.on("uploadprogress", function(file, progress, bytesSent) {

            });
            this.on("thumbnail", function(file, dataUrl) {

            });
            this.on("success", function(file) {

            });
            this.on("sending", function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append('kind',1);
                formData.append('id',$('#edit_project_id').val());
            });
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $('#project_model_close_btn').trigger('click');
                    location.reload();
                }
            });
            this.on('error', function(file, errorMessage) {

            });
            this.on('removedfile', function(file) {

            });
        }
    });
    $("#editProjectModal_btn").click(function (e) {
        e.preventDefault();
        if(!isValidateEditProjectModal())return;
        var form_data = new FormData();
        form_data.append('id',$('#edit_project_id').val());
        form_data.append('name',$('#edit_project_name').val());
        form_data.append('business_id',$('#edit_project_business').val());
        form_data.append('state',$('#edit_project_state').val());
        form_data.append('city',$('#edit_project_city option:selected').text());
        form_data.append('municipio_cnum',$('#edit_project_city').val());
        form_data.append('description',$('#edit_project_description').val());
        $.ajax({
            url: '/project/saveProject',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            dataType: "json",
            success: function (response) {
                $('#edit_project_id').val(response.id);
                projectDropzone.processQueue();
                if(projectDropzone.getQueuedFiles().length==0){
                    $('#project_model_close_btn').trigger('click');
                    $('#add_new_document_btn').trigger('click');

                    var form_data = new FormData();
                    $.ajax({
                        url: '/project/getProjectsByBusiness',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        dataType: "json",
                        success: function (response) {
                            $('#project_object').val(JSON.stringify(response));
                            changeBusiness(0);
                        },
                        error: function (response) {

                        }
                    });
                    //location.reload();
              }
            },
            error: function (response) {

            }
        });
    });

    documentDropzone = new Dropzone("div#dropzoneForm", {
        url: "/project/attachFile",
        paramName: "file",
        maxFilesize: 200, // MB
        addRemoveLinks: true,
        thumbnailWidth: 294,
        thumbnailHeight: 294,
        autoProcessQueue: false,
        dictDefaultMessage: lang.dropattach,
        init: function () {
            this.on("processing", function(file) {

            });
            this.on("uploadprogress", function(file, progress, bytesSent) {

            });
            this.on("thumbnail", function(file, dataUrl) {

            });
            this.on("success", function(file) {

            });
            this.on("sending", function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append('kind',2);
                formData.append('id',$('#edit_document_id').val());
            });
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $('#document_model_close_btn').trigger('click');
                    country_table.reload();
                }
            });
            this.on('error', function(file, errorMessage) {

            });
            this.on('removedfile', function(file) {

            });
        }
    });

});
function isValidateEditProjectModal(){
    if($('#edit_project_name').val()==''){
        $('#edit_project_name').focus();
        return false;
    }
    if($('#edit_project_city').val()==''){
        $('#edit_project_city').focus();
        return false;
    }
    if($('#edit_project_state').val()==''){
        $('#edit_project_state').focus();
        return false;
    }
    return true;
}
function changeTaskState(uf){
    var form_data = new FormData();
    form_data.append('uf',uf);
    $.ajax({
        url: '/project/getAdCitiesList',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $("#edit_task_city").empty();
            var newOption;
            for(var i=0;i<response.length;i++){
                newOption = new Option(response[i].xnum, response[i].cnum, false, false);
                $('#edit_task_city').append(newOption).trigger('change');
            }
            if($('#edit_task_municipio_cnum').val()!=''){
                $("#edit_task_city").val($('#edit_task_municipio_cnum').val()).trigger('change');
                $('#edit_task_municipio_cnum').val('');
            }
        },
        error: function (response) {

        }
    });
}
function changeProjectState(uf){
    var form_data = new FormData();
    form_data.append('uf',uf);
    $.ajax({
        url: '/project/getAdCitiesList',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $("#edit_project_city").empty();
            var newOption;
            for(var i=0;i<response.length;i++){
                newOption = new Option(response[i].xnum, response[i].cnum, false, false);
                $('#edit_project_city').append(newOption).trigger('change');
            }
            if($('#edit_project_municipio_cnum').val()!=''){
                $("#edit_project_city").val($('#edit_project_municipio_cnum').val()).trigger('change');
                $('#edit_project_municipio_cnum').val('');
            }
        },
        error: function (response) {

        }
    });
}
function searchAction(){
    country_table.setDataSourceParam('group',0);
    country_table.setDataSourceParam('status',$('#kt_datatable_search_status').val());
    country_table.setDataSourceParam('q_user',$('#kt_datatable_search_user').val());
    country_table.setDataSourceParam('expending',$('#kt_datatable_search_expanding').prop('checked'));
    country_table.setDataSourceParam('finished_status',$('#kt_datatable_search_finished').prop('checked'));
    country_table.setDataSourceParam('q_start',encodeIvanFormat($('#kt_datatable_search_start').val())+' 00:00:00');
    country_table.setDataSourceParam('q_end',encodeIvanFormat($('#kt_datatable_search_end').val())+' 23:59:59');
    country_table.setDataSourceParam('q_business',$('#kt_datatable_search_business').val());
    country_table.setDataSourceParam('q_project',$('#kt_datatable_search_project').val());
    country_table.setDataSourceParam('q_group',$('#kt_datatable_search_group').val());
    country_table.setDataSourceParam('q_subgroup',$('#kt_datatable_search_subgroup').val());
    country_table.reload();
}
function documentAddAction(){
    $('#quick_project_edit_btn').css('display','initial');
    $('#edit_document_id').val('');
    $('#edit_document_dupid').val(0);
    $('#edit_document_title').prop('placeholder',lang.title);
    $('#edit_document_title').val('');
    $('#edit_document_status').val(0);
    $('#edit_document_protocal').val('');
    $('#edit_document_process').val('');
    $('#edit_document_license').val('');
    $('#edit_document_protocal_date').val('');
    $('#edit_document_description').val('');
    $('#edit_document_business').prop('disabled',false);
    $('#edit_document_project').prop('disabled',false);
    $('#edit_document_group').prop('disabled',false);
    $('#edit_document_subgroup').prop('disabled',false);
    changeSubGroup();
}
function submitDocumentEditForm(){
    if($('#edit_document_title').val()==''){
        $('#edit_document_title').focus();
        return;
    }
    if($('#edit_document_due_date').val()==''){
        $('#edit_document_due_date').focus();
        return;
    }
    var form_data = new FormData();
    form_data.append('id',$('#edit_document_id').val());
    form_data.append('dupid',$('#edit_document_dupid').val());
    form_data.append('title',$('#edit_document_title').val());
    form_data.append('due_date',encodeIvanFormat($('#edit_document_due_date').val()));
    form_data.append('status',$('#edit_document_status').val());
    form_data.append('project_id',$('#edit_document_project').val());
    form_data.append('group_id',$('#edit_document_group').val());
    form_data.append('sub_group_id',$('#edit_document_subgroup').val());
    form_data.append('description',$('#edit_document_description').val());
    form_data.append('process',$('#edit_document_process').val());
    form_data.append('license',$('#edit_document_license').val());
    form_data.append('protocal',$('#edit_document_protocal').val());
    form_data.append('protocal_date',encodeIvanFormat($('#edit_document_protocal_date').val()));
    form_data.append('responsible_user_id',$('#edit_document_responsible_user').val());
    $.ajax({
        url: '/document/saveDocument',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            $('#edit_document_id').val(response.id);
            documentDropzone.processQueue();
            if(documentDropzone.getQueuedFiles().length==0){
                $('#document_model_close_btn').trigger('click');
                country_table.reload();
            }
        },
        error: function (response) {

        }
    });
}
function deleteDocument(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/document/deleteDocument',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            country_table.reload();
        },
        error: function (response) {

        }
    });
}
