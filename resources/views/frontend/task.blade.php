@extends('frontend.layouts.dashboard')
@inject('dateFormat', 'App\Services\DateService')
@section('content')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2"><a href="home" class="btn btn-clean font-weight-bold" style="color:#000;font-size:15px;">{{trans('layout.task')}}</a></h5>
            <!--end::Page Title-->
            @if(isset($business_id)&&$business_id>0)
            @php
            foreach($businessList as $business)if($business['id']==$business_id){
            @endphp
            <div class="subheader-separator subheader-separator-ver" style="background-color:#655d5d;font-size:15px;"></div>
            <h5 class="text-dark font-weight-bold mt-2 mb-2"><a href="home?a={{$business_id}}" class="btn btn-clean font-weight-bold mr-1" style="color:#000;font-size:15px;">{{$business['first_name']}}</a></h5>
            @php
            break;
            }
            @endphp
            @endif
            <!--begin::Actions-->
            <span class="text-muted font-weight-bold mr-4">{{trans('layout.openedtask')}}: {{$openedTaskCount}}</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            <span class="text-muted font-weight-bold mr-4">{{trans('layout.finishedtask')}}: {{$finishedTaskCount}}</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            <!--end::Actions-->
        </div>
        <!--end::Info-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            @if(!isset($business_id)&&!isset($project_id))
            @for($i=0;$i<count($businessList);$i++)
            @if($i==2)
            <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="{{trans('layout.quickactions')}}">
                <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="svg-icon svg-icon-success svg-icon-lg"><!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                            <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"></path>
                        </g>
                    </svg><!--end::Svg Icon--></span>
                </a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right py-3">
                    <!--begin::Navigation-->
                    <ul class="navi navi-hover py-5">
            @endif
            @if($i<2)
            <a href="project?a={{$businessList[$i]['id']}}" class="btn btn-sm btn-light font-weight-bold mr-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Select {{$businessList[$i]['first_name']}} business">
            {{$businessList[$i]['first_name']}}
            </a>
            @else
                        <li class="navi-item">
                            <a href="project?a={{$businessList[$i]['id']}}" class="navi-link">
                                <span class="navi-text">{{$businessList[$i]['first_name']}}</span>
                            </a>
                        </li>
            @endif
            @if($i>1&&$i==count($businessList)-1)
                    </ul>
                    <!--end::Navigation-->
                </div>
            </div>
            @endif
            @endfor
            @endif
            @if(isset($business_id)&&!isset($project_id))
            @for($i=0;$i<count($projectList[$business_id]);$i++)
            @if($i==2)
            <div class="dropdown dropdown-inline" data-toggle="tooltip" title="" data-placement="left" data-original-title="{{trans('layout.quickactions')}}">
                <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="svg-icon svg-icon-success svg-icon-lg"><!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                            <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"></path>
                        </g>
                    </svg><!--end::Svg Icon--></span>
                </a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right py-3">
                    <!--begin::Navigation-->
                    <ul class="navi navi-hover py-5">
            @endif
            @if($i<2)
            <a href="project?a={{$business_id}}&b={{$projectList[$business_id][$i]['id']}}" class="btn btn-sm btn-light font-weight-bold mr-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Select {{$projectList[$business_id][$i]['name']}} project">
                {{$projectList[$business_id][$i]['name']}}
            </a>
            @else
                        <li class="navi-item">
                            <a href="project?a={{$business_id}}&b={{$projectList[$business_id][$i]['id']}}" class="navi-link">
                                <span class="navi-text">{{$projectList[$business_id][$i]['name']}}}</span>
                            </a>
                        </li>
            @endif
            @if($i>1&&$i==count($projectList[$business_id])-1)
                    </ul>
                    <!--end::Navigation-->
                </div>
            </div>
            @endif
            @endfor
            @endif
        </div>
        <!--end::Toolbar-->
    </div>
</div>
<!--end::Subheader-->

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class=" container ">
        <!--begin::Notice-->
        <?php if(isset($notification)){?>
        <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
            <div class="alert-icon">
                <span class="svg-icon svg-icon-primary svg-icon-xl"><!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
	            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
	                <rect x="0" y="0" width="24" height="24"/>
	                <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"/>
	                <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"/>
	            </g>
	        </svg><!--end::Svg Icon--></span>    </div>
            <div class="alert-text">
                <?php echo $notification;?>
            </div>
        </div>
    	<?php }?>
        <!--end::Notice-->
        <!--begin::Dashboard-->
        <!--begin::Row-->
        <div class="row">
            <!--begin:epg widget-->
            <div class="col-xxl-12 col-lg-12 mb-7">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{trans('layout.task')}}
                                <span class="d-block text-muted pt-2 font-size-sm">
                                </span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->

                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <div class="mb-7">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-xl-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 my-2 my-md-0">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" placeholder="{{trans('layout.search')}}..." name="kt_datatable_search_query" id="kt_datatable_search_query" />
                                                <span><i class="flaticon2-search-1 text-muted"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mr-5 mb-0 d-none d-md-block">{{trans('layout.user')}}:</label>
                                    <select class="form-control" id="kt_datatable_search_user" style="width:100%;">
                                    <option value="0">___{{trans('layout.all')}}___</option>
                                    @foreach($responsibleUsersList as $user)
                                        <option value="{{$user['id']}}">{{$user['username']}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mr-5 mb-0 d-none d-md-block">{{trans('layout.status')}}:</label>
                                    <select class="form-control" id="kt_datatable_search_status" style="width:100%;">
                                    <option value="-1">___{{trans('layout.all')}}___</option>
                                    <option value="0">{{trans('layout.opened')}}</option>
                                    <option value="1">{{trans('layout.finished')}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-xl-3 mt-2 mt-lg-0 align-items-right" style="text-align: right;display:none;">
                                    <a href="javascript:searchAction();" class="btn btn-light-primary px-6 font-weight-bold">
                                        {{trans('layout.search')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end: Search Form-->

                        <!--begin: Datatable-->
                        <div class="datatable datatable-bordered datatable-head-custom kt_datatable_class" name="kt_datatable" id="kt_datatable"></div>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end:epg widget-->
		</div>
        <!--end::Row-->
        <!--end::Dashboard-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<div class="modal fade" id="finishTaskModal" tabindex="-1" role="dialog" aria-labelledby="finishTaskModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('layout.dlg_taskfinish')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<input class="form-control" type="hidden" placeholder="id" value="0" id="finish_task_id">
                <div class="form-group row">
                    <label for="example-date-input" class="col-4 col-form-label text-right">{{trans('layout.finisheddate')}}<span class="text-danger">*</span></label>
                    <div class="col-8">
                        <input class="form-control" type="text" data-date-format="dd/mm/yyyy" value="{{date('d/m/Y')}}" id="finish_task_date" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-4 col-form-label text-right">{{trans('layout.finishedby')}}</label>
					<div class="col-8">
                        <select class="form-control" id="finish_task_user" style="width:100%;">
                        @foreach($responsibleUsersList as $user)
                            <option value="{{$user['id']}}">{{$user['username']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="finish_task_model_close_btn">{{trans('layout.close')}}</button>
                <button type="button" onclick="finishTaskEditForm();" id="document_model_submit_btn" class="btn btn-primary font-weight-bold">Finish</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editDocumentModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('layout.dlg_document')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<input class="form-control" type="hidden" placeholder="id" value="0" id="edit_document_id">
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">{{trans('layout.title')}}<span class="text-danger">*</span></label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="Title" value="" id="edit_document_title">
                    </div>
                    <label for="example-date-input" class="col-2 col-form-label text-right">{{trans('layout.duedate')}}<span class="text-danger">*</span></label>
                    <div class="col-2">
                        <input class="form-control" type="text" data-date-format="dd/mm/yyyy" value="{{date('d/m/Y')}}" id="edit_document_due_date" autocomplete="off">
                    </div>
                    <label class="col-form-label col-1 text-right">{{trans('layout.status')}}<span class="text-danger">*</span></label>
                    <div class="col-2">
                        <select class="form-control" style="width:100%;" id="edit_document_status" name="param">
                            <option value="0">{{trans('layout.opening')}}</option>
                            <option value="1">{{trans('layout.deveoping')}}</option>
                            <option value="2">{{trans('layout.waitingforclient')}}</option>
                            <option value="3">{{trans('layout.onfiled')}}</option>
                            <option value="4">{{trans('layout.waitingfororganreturn')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-2">{{trans('layout.business')}}<span class="text-danger">*</span></label>
                    <div class="col-4">
                        <select class="form-control" style="width:100%;" id="edit_document_business" name="param">
                        @foreach($businessList as $business)
                            <option value="{{$business['id']}}">{{$business['first_name']}} {{$business['last_name']}}</option>
                        @endforeach
                        </select>
                    </div>
                    <label class="col-form-label col-2 text-right">{{trans('layout.project')}}<span class="text-danger">*</span></label>
                    <input type="hidden" id="project_object" value="{{json_encode($projectList)}}"/>
                    <div class="col-4">
                        <select class="form-control" style="width:100%;" id="edit_document_project" name="param">

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-2">{{trans('layout.group')}}<span class="text-danger">*</span></label>
                    <div class="col-4">
                        <select class="form-control" style="width:100%;" id="edit_document_group" name="param">
                        @foreach($parentGroupList as $group)
                            <option value="{{$group['id']}}">{{$group['name']}}</option>
                        @endforeach
                        </select>
                    </div>
                    <label class="col-form-label col-2 text-right">{{trans('layout.subgroup')}}</label>
                    <div class="col-4">
                        <select class="form-control" style="width:100%;" id="edit_document_subgroup" name="param">
                            <option value=""> </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">{{trans('layout.process')}}</label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.process')}}" value="" id="edit_document_process">
                    </div>
                    <label for="example-search-input" class="col-1 col-form-label text-right">{{trans('layout.license')}}</label>
					<div class="col-5">
						<input class="form-control" type="text" placeholder="{{trans('layout.license')}}" value="" id="edit_document_license">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">{{trans('layout.protocal')}}</label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="{{trans('layout.protocal')}}" value="" id="edit_document_protocal">
                    </div>
                    <label for="example-search-input" class="col-1 col-form-label text-right">{{trans('layout.date')}}</label>
					<div class="col-2">
                        <input class="form-control" type="text" data-date-format="dd/mm/yyyy" value="" id="edit_document_protocal_date" autocomplete="off">
                    </div>
                    <label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.responsibleuser')}}</label>
					<div class="col-2">
                        <select class="form-control" id="edit_document_responsible_user" style="width:100%;">
                        @foreach($responsibleUsersList as $user)
                            <option value="{{$user['id']}}">{{$user['username']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
				<div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.description')}}</label>
					<div class="col-10">
						<textarea placeholder="{{trans('layout.description')}}" class="form-control" id="edit_document_description"></textarea>
					</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="document_model_close_btn">{{trans('layout.close')}}</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="frontend/js/task.js"></script>
@endsection
