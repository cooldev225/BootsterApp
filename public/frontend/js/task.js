var task_table=null;
var taskColumns=[
    {
        field: 'description',
        title: lang.description,
        width:400,
    },
    {
        field: 'username',
        title: lang.user,
        width:120,
        sortable: 'asc',
    },
    {
        field: 'due_date',
        title: lang.datetofinish,
        width:120,
        template: function(row){
            return getJustDateWIthYear(row.due_date);
        }
    },
    {
        field: 'group_name',
        title: lang.group,
        template: function(row){
            return '<a data-toggle="modal" data-target="#editDocumentModal" href="javascript:;" onclick="viewDocumentModal(1,'+row.document_id+');">\
            '+row.group_name+'\
            </a>';
        }
    },
    {
        field: 'subgroup_name',
        title: lang.subgroup,
        template: function(row){
            return row.subgroup_name!=''&&row.subgroup_name!=null?'<a data-toggle="modal" data-target="#editDocumentModal" href="javascript:;" onclick="viewDocumentModal(0,'+row.document_id+');">\
            '+row.subgroup_name+'\
            </a>':'';
        }
    },
    {
        field: 'project_name',
        title: lang.project,
    },
    {
        field: 'business_name',
        title: lang.business,
        autoHide: false,
        template: function(row){
            return '<a data-toggle="modal" data-target="#viewBusinessModal" href="javascript:;" onclick="viewBusinessModal('+row.business_id+');">\
            '+row.business_first_name+' '+row.business_last_name+'\
            </a>';
        }
    },
    {
        field: 'city',
        title: lang.location,
        width:100
    },
    {
        field: 'finished_at',
        title: lang.finishedat,
        width: 100,
        template: function(row){
            return row.finished_status==1?getJustDateWIthYear(row.finished_at):'';
        }
    },
    {
        field: 'finished_username',
        title: lang.finishedby,
        width: 100,
        template: function(row){
            return row.finished_status==1?row.finished_username:'';
        }
    },
    {
        field: 'Actions',
        title: lang.actions,
        overflow: 'visible',
        width: 80,
        autoHide: false,
        template: function(row) {
            return '\
                <div class="dropdown dropdown-inline">'+
                (
                    row.finished_status==1?'':'\
                    <a data-toggle="modal" data-target="#finishTaskModal" href="javascript:;" onclick="$(\'#finish_task_id\').val('+row.id+');" class="btn btn-sm btn-clean btn-icon" title="finish document">\
                    <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Navigation\Double-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                            <polygon points="0 0 24 0 24 24 0 24"/>\
                            <path d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) "/>\
                            <path d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) "/>\
                        </g>\
                    </svg><!--end::Svg Icon--></span>\
                    </a>'
                )+
                '<a href="javascript:deleteTask('+row.id+');" class="btn btn-sm btn-clean btn-icon mr-2" title="Reset password">\
                <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span>\
                </a>\
                </div>\
            ';
        },
    }
];
function datatableInit(){
    task_table=$('#kt_datatable').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/task/getTaskDataTable',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    params:{
                        'user_id':$('#kt_datatable_search_user').val(),
                        'status':$('#kt_datatable_search_status').val(),
                    }
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: false,
            serverSorting: true
        },
        layout: {
            scroll: false,
            footer: false,
            header:true
        },
        sortable: true,
        pagination: true,
        search: {
            input: $('#kt_datatable_search_query'),
            key: 'generalSearch'
        },
        columns:taskColumns,
        translate: trans_pagination,
    });
}
jQuery(document).ready(function() {
    //search filters
    $('#kt_datatable_search_user').select2();
    $('#kt_datatable_search_user').on('change',function(){
        searchAction();
    });
    $('#kt_datatable_search_status').select2();
    $('#kt_datatable_search_status').on('change',function(){
        searchAction();
    });
    datatableInit();
    $('#kt_datatable_search_status').val(0).trigger('change');
    $('#finish_task_date').datepicker();
    $('#finish_task_user').select2();

    $('#edit_document_business').select2();
    $('#edit_document_project').select2();
    $('#edit_document_group').select2();
    $('#edit_document_subgroup').select2();
    //searchAction();
});
function searchAction(){
    task_table.setDataSourceParam('user_id',$('#kt_datatable_search_user').val());
    task_table.setDataSourceParam('status',$('#kt_datatable_search_status').val());
    task_table.reload();
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
            task_table.reload();
        },
        error: function (response) {

        }
    });
}

function viewDocumentModal(p,id){
    var form_data = new FormData();
    form_data.append('id',id);
    form_data.append('only_parent',p);
    $.ajax({
        url: '/document/getDocumentById',
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
            $('#edit_document_title').val(response.title);
            $('#edit_document_due_date').val(encodeIvanFormat(response.due_date));
            $('#edit_document_status').val(response.status);
            $('#edit_document_business').val(response.business_id).trigger('change');changeBusiness(response.project_id);
            $('#edit_document_group').val(response.group_id).trigger('change');changeGroup(response.sub_group_id);
            $('#edit_document_description').val(response.description);
            $('#edit_document_process').val(response.process);
            $('#edit_document_license').val(response.license);
            $('#edit_document_protocal').val(response.protocal);
            $('#edit_document_protocal_date').val(encodeIvanFormat(response.protocal_date));
            $('#edit_document_responsible_user').val(response.responsible_user_id);

            $('#edit_document_business').prop('disabled',true);
            $('#edit_document_project').prop('disabled',true);
            $('#edit_document_group').prop('disabled',true);
            $('#edit_document_subgroup').prop('disabled',true);
        },
        error: function (response) {

        }
    });
}
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
