var businessDropzone=null;
var projectDropzone=null;
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

$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
});
$(document).on('keyup', 'input,select', function (e) {
    if(e.keyCode==13){
        var id=$(this).prop('id');
        if(id.indexOf('edit_business')>-1){
            if(!isValidateEditBusinessModal())return;
        }else if(!isValidateEditProjectModal())return;
        e.preventDefault();
        var index = $('.form-control').index(this) + 1;
        $('.form-control').eq(index).focus();
    }
});
jQuery(document).ready(function() {
    $('#edit_business_open_date').datepicker({
        autoClose: true,
    }).on('changeDate', function(){
        $(this).blur();
    });
    $('#edit_business_ad_state').select2();
    //$('#edit_business_ad_state').val('RO').trigger('change');
    $('#edit_business_ad_city').select2();
    //$('#edit_business_ad_city').val(1).trigger('change');

    $('#edit_business_ad_state').on('change',function(){
        changeState($(this).val());
    });
    changeState($('#edit_business_ad_state').val());

    $('#edit_project_business').select2();
    $('#edit_project_state').select2();
    $('#edit_project_city').select2();
    $('#edit_project_state').on('change',function(){
        changeProjectState($(this).val());
    });
    changeProjectState($('#edit_project_state').val());
    $('#edit_business_cnpj').cpfcnpj({
        mask: true,
        validate: 'cpfcnpj',
        event: 'click',
        handler: '#editBusinessModal_btn',
        ifValid: function (input) { },
        ifInvalid: function (input) {
            if($('#edit_business_first_name').val()==''){
                $('#edit_business_first_name').focus();
                return false;
            }
            if($('#edit_business_last_name').val()==''){
                $('#edit_business_last_name').focus();
                return false;
            }
            $('#edit_business_cnpj').focus();
        }
    });

    $('#kt_datatable_search_query').on('keyup',function(e){
        if(e.keyCode==13){
            //if($(this).val()!='')
            location.href='project?sch='+$('#kt_datatable_search_query').val()+'&pch='+$('#kt_datatable_pearch_query').val();
        }
    });
    $('#kt_datatable_pearch_query').on('keyup',function(e){
        if(e.keyCode==13){
            location.href='project?sch='+$('#kt_datatable_search_query').val()+'&pch='+$('#kt_datatable_pearch_query').val();
        }
    });

    businessDropzone = new Dropzone("div#dropzoneForm", {
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
                formData.append('kind',0);
                formData.append('id',$('#edit_business_id').val());
            });
            this.on("complete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $('#business_model_close_btn').trigger('click');
                    location.reload();
                }
            });
            this.on('error', function(file, errorMessage) {

            });
            this.on('removedfile', function(file) {

            });
        }
    });
    $("#editBusinessModal_btn").click(function (e) {
        e.preventDefault();
        if(!isValidateEditBusinessModal())return;
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
              $('#edit_business_id').val(response.id);
              businessDropzone.processQueue();
              if(businessDropzone.getQueuedFiles().length==0){
                $('#business_model_close_btn').trigger('click');
                if($('#dropzoneForm .dz-preview').prop('class')==null)location.reload();
              }
            },
            error: function (response) {

            }
        });
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
                if($('#dropzoneProjectForm .dz-preview').prop('class')==null)location.reload();
              }
            },
            error: function (response) {

            }
        });
    });
});
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
            location.reload();
        },
        error: function (response) {

        }
    });
}
function isValidateEditBusinessModal(){
    if($('#edit_business_first_name').val()==''){
        $('#edit_business_first_name').focus();
        return false;
    }
    if($('#edit_business_last_name').val()==''){
        $('#edit_business_last_name').focus();
        return false;
    }
    if($('#edit_business_cnpj').val()==''){
        $('#edit_business_cnpj').focus();
        return false;
    }
    if($('#edit_business_ad_street').val()==''){
        $('#edit_business_ad_street').focus();
        return false;
    }
    if($('#edit_business_ad_number').val()==''){
        $('#edit_business_ad_number').focus();
        return false;
    }
    if($('#edit_business_ad_neighborhood').val()==''){
        $('#edit_business_ad_neighborhood').focus();
        return false;
    }
    if($('#edit_business_ad_zip_code').val()==''){
        $('#edit_business_ad_zip_code').focus();
        return false;
    }
    if($('#edit_business_mobile_office').val()==''){
        $('#edit_business_mobile_office').focus();
        return false;
    }
    if($('#edit_business_mobile_phone').val()==''){
        $('#edit_business_mobile_phone').focus();
        return false;
    }
    if($('#edit_business_contactor_name_01').val()==''){
        $('#edit_business_contactor_name_01').focus();
        return false;
    }
    if($('#edit_business_contactor_phone_01').val()==''){
        $('#edit_business_contactor_phone_01').focus();
        return false;
    }
    if($('#edit_business_contactor_email_01').val()==''){
        $('#edit_business_contactor_email_01').focus();
        return false;
    }
    if($('#edit_business_alert_email_01').val()==''){
        $('#edit_business_alert_email_01').focus();
        return false;
    }
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (!testEmail.test($('#edit_business_alert_email_01').val())){
        $('#edit_business_alert_email_01').focus();
        return false;
    }
    if($('#edit_business_alert_email_02').val()!=''){
        if (!testEmail.test($('#edit_business_alert_email_02').val())){
            $('#edit_business_alert_email_02').focus();
            return false;
        }
    }
    if (!testEmail.test($('#edit_business_contactor_email_01').val())){
        $('#edit_business_contactor_email_01').focus();
        return false;
    }
    if ($('#edit_business_contactor_email_02').val()!=''&&!testEmail.test($('#edit_business_contactor_email_02').val())){
        $('#edit_business_contactor_email_02').focus();
        return false;
    }

    return true;
}
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
function businessAddAction(){
    $('#edit_business_id').val('0');
    $('#edit_business_first_name').val('');
    $('#edit_business_last_name').val('');
    $('#edit_business_cnpj').val('');
    $('#edit_business_ie').val('');
    $('#edit_business_im').val('');
    $('#edit_business_open_date').val('');
    $('#edit_business_ad_street').val('');
    $('#edit_business_ad_number').val('');
    $('#edit_business_ad_neighborhood').val('');
    $('#edit_business_ad_complement').val('');
    $('#edit_business_ad_zip_code').val('');
    $('#edit_business_mobile_office').val('');
    $('#edit_business_mobile_phone').val('');
    $('#edit_business_contactor_name_01').val('');
    $('#edit_business_contactor_phone_01').val('');
    $('#edit_business_contactor_email_01').val('');
    $('#edit_business_contactor_name_02').val('');
    $('#edit_business_contactor_phone_02').val('');
    $('#edit_business_contactor_email_02').val('');
    $('#edit_business_alert_email_01').val('');
    $('#edit_business_alert_email_02').val('');
    $('#edit_business_description').val('');
}
function deleteBusinessAction(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/project/deleteBusiness',
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
            $('.business-panel-'+id).css('display','none');
        },
        error: function (response) {

        }
    });
}
function projectAddAction(business_id){
    $('#edit_project_id').val('0');
    $('#edit_project_business').val(business_id).trigger('change');
    $('#edit_project_name').val('');
    $('#edit_project_state').val('');
    $('#edit_project_description').val('');
}
function deleteProjectAction(id){
    var form_data = new FormData();
    form_data.append('id',id);
    $.ajax({
        url: '/project/deleteProject',
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
            $('.project-panel-'+id).css('display','none');
        },
        error: function (response) {

        }
    });
}
