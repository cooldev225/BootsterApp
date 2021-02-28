var data_table=null;
function datatableInit(){
    data_table=$('#kt_datatable').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: '/users/getUsersDataTable',
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

        // columns definition
        columns:
        [
            {
                field: 'username',
                title: lang.users_tbl_username,
            },
            {
                field: 'followerno',
                title: lang.users_tbl_followerno,
                //sortable: 'asc'
            },
            {
                field: 'followingno',
                title: lang.users_tbl_followingno,
            },
            {
                field: 'wallet',
                title: lang.users_tbl_wallet,
            },
            {
                field: 'bought',
                title: lang.users_tbl_bought,
            },
            {
                field: 'boostdate',
                title: lang.users_tbl_boostdate,
            },
            {
                field: 'boughtdate',
                title: lang.users_tbl_boughtdate,
            },
            {
                field: 'boostcompletion',
                title: lang.users_tbl_boostcompletion,
            }, {
                field: 'Action',
                title: lang.actions,
                //sortable: false,
                //overflow: 'visible',
                //autoHide: false,
                
            }
        ],
        translate: trans_pagination,
    });
}
jQuery(document).ready(function() {
    datatableInit();
});
function groupAddAction(pid){
    $('#edit_group_id').val('0');
    $('#edit_group_parent').val(pid).trigger('change');
    $('#edit_group_name').val('');
    $('#edit_group_parent').val(pid);
    $('#edit_group_alert_01').val('');
    $('#edit_group_alert_02').val('');
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
                data_table.reload();
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
            data_table.reload();
        },
        error: function (response) {

        }
    });
}
