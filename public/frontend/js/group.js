var country_table=null;
function datatableInit(){
    country_table=$('#kt_datatable').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/group/getGroupDataTable',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    params:{
                        parent:0,
                    }
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: false,
            serverSorting: true
        },
        layout: {
            scroll: true,
            footer: true,
        },
        sortable: true,
        pagination: true,

        search: {
            input: $('#kt_datatable_search_query'),
            key: 'generalSearch'
        },
        detail: {
            title: 'Load sub groups',
            content: function(e){
                $('<div/>').attr('id', 'child_data_ajax_' + e.data.id).appendTo(e.detailCell).KTDatatable({
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '/group/getGroupDataTable',
                                headers: {
                                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                },
                                params:{
                                    parent:e.data.id,
                                }
                            },
                        },
                        pageSize: 10,
                        serverPaging: true,
                        serverFiltering: false,
                        serverSorting: true
                    },
                    layout: {
                        scroll: true,
                        footer: false,
                        header:false
                    },
                    sortable: true,
                    pagination: true,
                    search: {
                        input: $('#kt_datatable_search_query'),
                        key: 'generalSearch'
                    },
                    columns:
                    [
                        {
                            field: 'id',
                            sortable: false,
                            title: '',
                            width:50,
                            template: function(row){
                                return '';
                            }
                        },
                        {
                            field: 'name',
                            title: lang.name,
                            sortable: 'asc'
                        },
                        {
                            field: 'alert_01',
                            title: lang.firstalert,
                        },
                        {
                            field: 'alert_02',
                            title: lang.secondalert,
                        },
                        {
                            field: 'documents_count',
                            title: lang.documents,
                        },
                        {
                            field: 'created_name',
                            title: lang.createdby,
                        },
                        {
                            field: 'created_at',
                            title: lang.createddate,
                            template: function(row){
                                return getJustDateWIthYear(row.created_at);
                            }
                        }, {
                            field: 'Actions',
                            title: lang.actions,
                            sortable: false,
                            overflow: 'visible',
                            autoHide: false,
                            template: function(row) {//.replace(/"/g,'\\"')
                                if($('body').find('#template_'+row.id).length==0){
                                    $('body').append('<input type="hidden" id="template_'+row.id+'" value="'+row.template+'"/>');
                                }
                                return '\
                                    <div class="dropdown dropdown-inline">\
                                    <a data-toggle="modal" data-target="#editGroupModal" href="javascript:;" onclick="groupAddAction('+row.parent+');" class="btn btn-sm btn-clean btn-icon" title="Reset password">\
                                    <i class="la la-plus"></i>\
                                    </a>\
                                    <a data-toggle="modal" data-target="#editGroupModal" href="javascript:;" onclick="\
                                    $(\'#edit_group_id\').val('+row.id+');\
                                    $(\'#edit_group_parent\').val('+row.parent+');\
                                    $(\'#edit_group_name\').val(\''+row.name+'\');\
                                    $(\'#edit_group_alert_01\').val('+row.alert_01+');\
                                    $(\'#edit_group_alert_02\').val('+row.alert_02+');\
                                    setContent(\''+row.id+'\');\
                                    " class="btn btn-sm btn-clean btn-icon" title="Reset password">\
                                        <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path><rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect></g></svg></span>\
                                    </a>'+
                                    (row.documents_count>0?'':'<a href="javascript:deleteGroup('+row.id+');" class="btn btn-sm btn-clean btn-icon mr-2" title="Reset password">\
                                        <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span>\
                                    </a>')+
                                    '</div>\
                                ';
                            },
                        }
                    ],
                    translate: trans_pagination,
                });
            },
        },

        // columns definition
        columns:
        [
            {
                field: 'id',
                title: '',
                width:50,
            },
            {
                field: 'name',
                title: lang.name,
                sortable: 'asc'
            },
            {
                field: 'alert_01',
                title: lang.firstalert,
            },
            {
                field: 'alert_02',
                title: lang.secondalert,
            },
            {
                field: 'documents_count',
                title: lang.documents,
            },
            {
                field: 'created_name',
                title: lang.createdby,
            },
            {
                field: 'created_at',
                title: lang.createddate,
                template: function(row){
                    return getJustDateWIthYear(row.created_at);
                }
            }, {
                field: 'Actions',
                title: lang.actions,
                sortable: false,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    str = row.template.replace(/[\n\r]/g, '');
                    str = str.replace(/(\r\n|\n|\r)/gm," ");
                    if($('body').find('#template_'+row.id).length==0){
                        //$('body').append('<input type="hidden" id="template_'+row.id+'" value="'+str.replace(/\"/g , "\\\"")+'"/>');
                    }
                    return '\
                    <div class="dropdown dropdown-inline">\
                    <a data-toggle="modal" data-target="#editGroupModal" href="javascript:;" onclick="groupAddAction('+row.id+');" class="btn btn-sm btn-clean btn-icon" title="Reset password">\
                    <i class="la la-plus"></i>\
                    </a>\
                    <a data-toggle="modal" data-target="#editGroupModal" href="javascript:;" onclick="\
                    $(\'#edit_group_id\').val('+row.id+');\
                    $(\'#edit_group_parent\').val('+row.parent+');\
                    $(\'#edit_group_name\').val(\''+row.name+'\');\
                    $(\'#edit_group_alert_01\').val('+row.alert_01+');\
                    $(\'#edit_group_alert_02\').val('+row.alert_02+');\
                    tinyMCE.activeEditor.setContent(unescape(\''+row.template+'\'));\
                    " class="btn btn-sm btn-clean btn-icon" title="Reset password">\
                        <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path><rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect></g></svg></span>\
                    </a>'+
                    (row.documents_count>0||row.children_count>0?'':'<a href="javascript:deleteGroup('+row.id+');" class="btn btn-sm btn-clean btn-icon mr-2" title="Reset password">\
                        <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span>\
                    </a>')+
                    '</div>\
                    ';
                },
            }
        ],
        translate: trans_pagination,
    });
}
function setContent(c){
    tinyMCE.activeEditor.setContent($('#template_'+c).val());
}
$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
});
$(document).on('keyup', 'input,select', function (e) {
    if(e.keyCode==13&&isValidateEditGroupModal()){
        e.preventDefault();
        var index = $('.form-control').index(this) + 1;
        $('.form-control').eq(index).focus();
    }
});
jQuery(document).ready(function() {
    $('#edit_group_parent').select2();
    datatableInit();
    tinymce.init(tinymceOption);
});
function groupAddAction(pid){
    if(pid=='0')$('#edit_group_parent').parent().parent().fadeOut();
    else {$('#edit_group_parent').parent().parent().fadeIn();}
    $('#edit_group_id').val('0');
    $('#edit_group_parent').val(pid).trigger('change');
    $('#edit_group_name').val('');
    $('#edit_group_parent').val(pid);
    $('#edit_group_alert_01').val('');
    $('#edit_group_alert_02').val('');
    tinyMCE.activeEditor.setContent('');
}
function isValidateEditGroupModal(){
    var reg = /^\d+$/;
    if($('#edit_group_name').val()==''){
        $('#edit_group_name').focus();
        return false;
    }
    if($('#edit_group_alert_01').val()==''||!reg.test($('#edit_group_alert_01').val())){
        $('#edit_group_alert_01').val('');
        $('#edit_group_alert_01').focus();
        return false;
    }
    if($('#edit_group_alert_02').val()==''||!reg.test($('#edit_group_alert_02').val())){
        $('#edit_group_alert_02').val('');
        $('#edit_group_alert_02').focus();
        return false;
    }
    if(eval($('#edit_group_alert_01').val())<=eval($('#edit_group_alert_02').val())){
        $('#edit_group_alert_02').val('');
        $('#edit_group_alert_02').focus();
        return false;
    }
    if(tinyMCE.activeEditor.getContent()==''){
        alert('Please, fill out template text.');
        return false;
    }
    return true;
}
function submitGroupEditForm(){
    if(!isValidateEditGroupModal())return;
    var form_data = new FormData();
    form_data.append('id',$('#edit_group_id').val());
    form_data.append('parent',$('#edit_group_parent').val());
    form_data.append('name',$('#edit_group_name').val());
    form_data.append('alert_01',$('#edit_group_alert_01').val());
    form_data.append('alert_02',$('#edit_group_alert_02').val());
    form_data.append('template',escape(tinyMCE.activeEditor.getContent()));
    $.ajax({
        url: '/group/saveGroup',
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
            if(response.id<0){
                alert('This name is existen already.');
                return;
            }
            if($('#edit_group_id').val()>0||$('#edit_group_parent').val()>0){
                $('#edit_group_id').val(response.id);
                country_table.reload();
            }else location.reload();
            $('#group_model_close_btn').trigger('click');
        },
        error: function (response) {

        }
    });
}
function deleteGroup(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/group/deleteGroup',
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
function searchAction(){

}
