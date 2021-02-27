@extends('frontend.layouts.dashboard')
@inject('dateFormat', 'App\Services\DateService')
@section('content')
<style>
.datatable .btn.btn-icon.btn-sm, .btn-group-sm > .btn.btn-icon {
    width: calc(1.35em + 0.4rem + 2px);
}
</style>
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2"><a href="home" class="btn btn-clean font-weight-bold" style="color:#000;font-size:15px;">{{trans('layout.document')}}</a></h5>
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


            <span class="text-muted font-weight-bold mr-4">{{trans('layout.business')}}s: {{count($businessList)}}</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            @if(isset($business_id)&&$business_id>0)
            <span class="text-muted font-weight-bold mr-4">{{trans('layout.project')}}s: {{count($projectList[$business_id])}}</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            @else
            <span class="text-muted font-weight-bold mr-4">{{trans('layout.project')}}s: {{$totalProjectCount}}</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            @endif
            @if(isset($business_id)&&$business_id>0&&isset($project_id)&&$project_id>0)
            <span class="text-muted font-weight-bold mr-4">{{trans('layout.document')}}s: {{count($documentList[$business_id][$project_id])}}</span>
            @else
            <span class="text-muted font-weight-bold mr-4">{{trans('layout.document')}}s: {{$totalDocumentCount}}</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            @endif
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
                                {{trans('layout.document')}}s
                                <span class="d-block text-muted pt-2 font-size-sm">

                                </span>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <div class="mr-5" style="float:right;">
                                <span class="switch switch-outline switch-icon switch-success">
                                <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.finished')}}</label>
                                <label>
                                    <input type="checkbox" name="select" id="kt_datatable_search_finished"/>
                                    <span></span>
                                </label>
                                </span>
                            </div>
                            <div class="mr-5">
                                <span class="switch switch-outline switch-icon switch-success">
                                <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.allexpanding')}}</label>
                                <label>
                                    <input type="checkbox" name="select" checked="checked" id="kt_datatable_search_expanding"/>
                                    <span></span>
                                </label>
                                </span>
                            </div>
                            <button type="button" class="btn btn-light-primary font-weight-bolder mr-2"  data-toggle="modal" data-target="#TaskDescModal" onclick="searchTaskDeschAction();">
                                <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Design\Select.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M18.5,8 C17.1192881,8 16,6.88071187 16,5.5 C16,4.11928813 17.1192881,3 18.5,3 C19.8807119,3 21,4.11928813 21,5.5 C21,6.88071187 19.8807119,8 18.5,8 Z M18.5,21 C17.1192881,21 16,19.8807119 16,18.5 C16,17.1192881 17.1192881,16 18.5,16 C19.8807119,16 21,17.1192881 21,18.5 C21,19.8807119 19.8807119,21 18.5,21 Z M5.5,21 C4.11928813,21 3,19.8807119 3,18.5 C3,17.1192881 4.11928813,16 5.5,16 C6.88071187,16 8,17.1192881 8,18.5 C8,19.8807119 6.88071187,21 5.5,21 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M5.5,8 C4.11928813,8 3,6.88071187 3,5.5 C3,4.11928813 4.11928813,3 5.5,3 C6.88071187,3 8,4.11928813 8,5.5 C8,6.88071187 6.88071187,8 5.5,8 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 C14,5.55228475 13.5522847,6 13,6 L11,6 C10.4477153,6 10,5.55228475 10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,18 L13,18 C13.5522847,18 14,18.4477153 14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 C10,18.4477153 10.4477153,18 11,18 Z M5,10 C5.55228475,10 6,10.4477153 6,11 L6,13 C6,13.5522847 5.55228475,14 5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 C18.4477153,14 18,13.5522847 18,13 L18,11 C18,10.4477153 18.4477153,10 19,10 Z" fill="#000000"/>
                                    </g>
                                </svg><!--end::Svg Icon--></span>
                                {{trans('layout.taskdescriptions')}}
                            </button>
                            <button id="add_new_document_btn" type="button" class="btn btn-light-primary font-weight-bolder mr-2"  data-toggle="modal" onclick="documentAddAction();" data-target="#editDocumentModal">
                                <span class="svg-icon svg-icon-md"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 7.000000) rotate(-180.000000) translate(-12.000000, -7.000000) " x="11" y="1" width="2" height="12" rx="1"/>
                                    <path d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M14.2928932,10.2928932 C14.6834175,9.90236893 15.3165825,9.90236893 15.7071068,10.2928932 C16.0976311,10.6834175 16.0976311,11.3165825 15.7071068,11.7071068 L12.7071068,14.7071068 C12.3165825,15.0976311 11.6834175,15.0976311 11.2928932,14.7071068 L8.29289322,11.7071068 C7.90236893,11.3165825 7.90236893,10.6834175 8.29289322,10.2928932 C8.68341751,9.90236893 9.31658249,9.90236893 9.70710678,10.2928932 L12,12.5857864 L14.2928932,10.2928932 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
                                </svg></span>
                                {{trans('layout.add_document')}}
                            </button>
                            <button type="button" class="btn btn-primary font-weight-bolder ml-2" onclick="exportExcel();">
                                <span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Design\Select.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M18.5,8 C17.1192881,8 16,6.88071187 16,5.5 C16,4.11928813 17.1192881,3 18.5,3 C19.8807119,3 21,4.11928813 21,5.5 C21,6.88071187 19.8807119,8 18.5,8 Z M18.5,21 C17.1192881,21 16,19.8807119 16,18.5 C16,17.1192881 17.1192881,16 18.5,16 C19.8807119,16 21,17.1192881 21,18.5 C21,19.8807119 19.8807119,21 18.5,21 Z M5.5,21 C4.11928813,21 3,19.8807119 3,18.5 C3,17.1192881 4.11928813,16 5.5,16 C6.88071187,16 8,17.1192881 8,18.5 C8,19.8807119 6.88071187,21 5.5,21 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M5.5,8 C4.11928813,8 3,6.88071187 3,5.5 C3,4.11928813 4.11928813,3 5.5,3 C6.88071187,3 8,4.11928813 8,5.5 C8,6.88071187 6.88071187,8 5.5,8 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 C14,5.55228475 13.5522847,6 13,6 L11,6 C10.4477153,6 10,5.55228475 10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,18 L13,18 C13.5522847,18 14,18.4477153 14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 C10,18.4477153 10.4477153,18 11,18 Z M5,10 C5.55228475,10 6,10.4477153 6,11 L6,13 C6,13.5522847 5.55228475,14 5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 C18.4477153,14 18,13.5522847 18,13 L18,11 C18,10.4477153 18.4477153,10 19,10 Z" fill="#000000"/>
                                    </g>
                                </svg><!--end::Svg Icon--></span>
                                {{trans('layout.export')}}
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <div class="mb-7">
                            <div class="row align-items-center">

                                <!--div class="col-lg-2 col-xl-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 my-2 my-md-0">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" placeholder="{{trans('layout.search')}}..." name="kt_datatable_search_query" id="kt_datatable_search_query" />
                                                <span><i class="flaticon2-search-1 text-muted"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div-->

                                <div class="col-lg-6 col-xl-6 d-flex align-items-center">
                                    <a href="javascript:searchAction();" class="btn btn-light-primary px-6 mr-2 font-weight-bold">
                                        {{trans('layout.search')}}
                                    </a>
                                    <!--{{date('d/m/Y',strtotime('last sunday'))}}-->
                                    <input class="form-control" type="text" data-date-format="dd/mm/yyyy" placeholder="{{trans('layout.startdate')}}" value="" id="kt_datatable_search_start" style="width: 164px;" autocomplete="off">
                                    <label class="ml-2 mr-2">~</label>
                                    <!--{{date('d/m/Y',strtotime('next saturday',strtotime('last sunday')))}}-->
                                    <input class="form-control" type="text" data-date-format="dd/mm/yyyy" placeholder="{{trans('layout.enddate')}}" value="" id="kt_datatable_search_end" style="width: 164px;" autocomplete="off">

                                </div>

                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.user')}}</label>
                                    <select class="form-control" style="width:100%;" id="kt_datatable_search_user" name="param">
                                        <option value="0">___{{trans('layout.all')}}___</option>
                                        @foreach($responsibleUsersList as $user)
                                            <option value="{{$user['id']}}">{{$user['username']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.status')}}</label>
                                    <select class="form-control" style="width:100%;" id="kt_datatable_search_status" name="param">
                                        <option value="-1">___{{trans('layout.all')}}___</option>
                                        <option value="0">{{trans('layout.opening')}}</option>
                                        <option value="1">{{trans('layout.deveoping')}}</option>
                                        <option value="2">{{trans('layout.waitingforclient')}}</option>
                                        <option value="3">{{trans('layout.onfiled')}}</option>
                                        <option value="4">{{trans('layout.waitingfororganreturn')}}</option>
                                    </select>
                                </div>


                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.business')}}</label>
                                    <select class="form-control" style="width:100%;" id="kt_datatable_search_business" name="param">
                                        <option value="0">___{{trans('layout.all')}}___</option>
                                        @foreach($businessList as $business)
                                            <option value="{{$business['id']}}">{{$dateFormat->friendlyTxt($business['first_name']." ".$business['last_name'],23)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.project')}}</label>
                                    <select class="form-control" style="width:100%;" id="kt_datatable_search_project" name="param">
                                        <option value="0">___{{trans('layout.all')}}___</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.group')}}</label>
                                    <select class="form-control" style="width:100%;" id="kt_datatable_search_group" name="param">
                                        <option value="0">___{{trans('layout.all')}}___</option>
                                        @foreach($parentGroupList as $group)
                                        <option value="{{$group['id']}}">{{$group['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-xl-3 d-flex align-items-center">
                                    <label class="mb-0 d-none d-md-block">{{trans('layout.subgroup')}}</label>
                                    <select class="form-control" style="width:100%;" id="kt_datatable_search_subgroup" name="param">
                                        <option value="0">___{{trans('layout.all')}}___</option>
                                    </select>
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
                <input class="form-control" type="hidden" placeholder="id" value="0" id="edit_document_dupid">
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">{{trans('layout.title')}}<span class="text-danger">*</span></label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="{{trans('layout.title')}}" value="" id="edit_document_title">
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
                    <label class="col-form-label col-2 text-right">
                        <span id="quick_project_edit_btn" onclick="newProjectAction();" data-toggle="modal" data-target="#editProjectModal" class="label label-light-primary font-weight-bolder label-inline ml-2" style="cursor: pointer;">{{trans('layout.new')}}</span>
                        {{trans('layout.project')}}<span class="text-danger">*</span>
                    </label>
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
                <div class="form-group">
                    <div id="drop_file" class="col-12">
                        <div id="dropzoneForm" class="dropzone"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="margin-top: -30px;">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="document_model_close_btn">{{trans('layout.close')}}</button>
                <button type="button" onclick="submitDocumentEditForm();" id="document_model_submit_btn" class="btn btn-primary font-weight-bold">{{trans('layout.savechanges')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fileViewModal" tabindex="-1" role="dialog" aria-labelledby="fileViewModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input class="form-control" type="hidden" value="0" id="edit_attach_file_id">
                <input class="form-control" type="hidden" value="0" id="edit_attach_document_id">
                <h5 class="modal-title" id="exampleModalLabel">
                    <input class="form-control" type="text" placeholder="{{trans('layout.filename')}}" value="" style="width:600px;" id="edit_attach_file_name">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-12">
                        <textarea id="edit_group_template" class="tox-target" style="height:100px;">

                        </textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="attach_file_model_close_btn">{{trans('layout.close')}}</button>
                <button type="button" onclick="submitAttachFileEditForm();" id="document_model_submit_btn" class="btn btn-primary font-weight-bold">{{trans('layout.savechanges')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewBusinessModal" tabindex="-1" role="dialog" aria-labelledby="viewBusinessModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('dlg_business')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            <form id="editBusinessForm" method="post" enctype="multipart/form-data">
            	<input type="hidden" placeholder="id" value="0" id="edit_business_id">
                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('login.firstname')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('login.firstname')}}" value="" id="edit_business_first_name">
					</div>
					<label for="example-search-input" class="col-2 col-form-label text-right">{{trans('login.lastname')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('login.lastname')}}" value="" id="edit_business_last_name">
					</div>
                </div>
                <div class="form-group row">
                <label for="example-search-input" class="col-2 col-form-label">CNPJ</label>
					<div class="col-2">
						<input class="form-control" type="text" placeholder="CNPJ" value="" id="edit_business_cnpj">
                    </div>
                    <label for="example-search-input" class="col-1 col-form-label text-right">IE</label>
					<div class="col-1">
						<input class="form-control" type="text" placeholder="IE" value="" id="edit_business_ie">
                    </div>
                    <label for="example-search-input" class="col-1 col-form-label text-right">IM</label>
					<div class="col-1">
						<input class="form-control" type="text" placeholder="IM" value="" id="edit_business_im">
					</div>
					<label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.opendate')}}</span></label>
					<div class="col-2">
						<input class="form-control" type="text" data-date-format="dd/mm/yyyy" value="{{date('d/m/Y')}}" id="edit_business_open_date" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.address')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.street')}}" value="" id="edit_business_ad_street">
                    </div>
                    <label for="example-search-input" class="col-2 col-form-label text-right">N<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.addressnumber')}}" value="" id="edit_business_ad_number">
					</div>
                </div>
                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.neighborhood')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.neighborhood')}}" value="" id="edit_business_ad_neighborhood">
					</div>
					<label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.complement')}}</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.complement')}}" value="" id="edit_business_ad_complement">
					</div>
                </div>
                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.zipcode')}}<span class="text-danger">*</span></label>
					<div class="col-2">
						<input class="form-control" type="text" placeholder="{{trans('layout.zipcode')}}" value="" id="edit_business_ad_zip_code">
                    </div>
                    <label for="example-search-input" class="col-1 col-form-label text-right">{{trans('layout.state')}}<span class="text-danger">*</span></label>
					<div class="col-2">
                        <select class="form-control" id="edit_business_ad_state">
                        @foreach($adStatesList as $state)
                        <option>{{$state['uf']}}</option>
                        @endforeach
                        </select>
                    </div>
                    <input type="hidden" value="" id="edit_business_municipio_cnum">
                    <label for="example-search-input" class="col-1 col-form-label text-right">{{trans('layout.city')}}<span class="text-danger">*</span></label>
					<div class="col-4">
                        <select class="form-control" id="edit_business_ad_city" style="width:100%;">
                        </select>
					</div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">{{trans('layout.mobileoffice')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.mobileoffice')}}" value="" id="edit_business_mobile_office">
                    </div>
                    <label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.mobilephone')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.mobilephone')}}" value="" id="edit_business_mobile_phone">
					</div>
                </div>
                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.1stcontactor')}}<span class="text-danger">*</span></label>
					<div class="col-2">
						<input class="form-control" type="text" placeholder="{{trans('layout.name')}}" value="" id="edit_business_contactor_name_01">
                    </div>
					<label for="example-search-input" class="col-1 col-form-label">{{trans('layout.phone')}}<span class="text-danger">*</span></label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="{{trans('layout.phone')}}" value="" id="edit_business_contactor_phone_01">
                    </div>
					<label for="example-search-input" class="col-1 col-form-label">{{trans('login.email')}}<span class="text-danger">*</span></label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="{{trans('login.email')}}" value="" id="edit_business_contactor_email_01">
                    </div>
                </div>
                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.2ndcontactor')}}</label>
					<div class="col-2">
						<input class="form-control" type="text" placeholder="{{trans('layout.name')}}" value="" id="edit_business_contactor_name_02">
                    </div>
					<label for="example-search-input" class="col-1 col-form-label">{{trans('layout.phone')}}</label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="{{trans('layout.phone')}}" value="" id="edit_business_contactor_phone_02">
                    </div>
					<label for="example-search-input" class="col-1 col-form-label">{{trans('login.email')}}</label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="{{trans('login.email')}}" value="" id="edit_business_contactor_email_02">
                    </div>
                </div>

                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.alert1stemail')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('login.email')}}" value="" id="edit_business_alert_email_01">
                    </div>
					<label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.alert2ndemail')}}</label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('login.email')}}" value="" id="edit_business_alert_email_02">
                    </div>
                </div>


				<div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.description')}}</label>
					<div class="col-10">
						<textarea placeholder="{{trans('layout.description')}}" class="form-control" id="edit_business_description"></textarea>
					</div>
                </div>
                <div class="form-group" style="display:none;">
                    <div id="drop_file" class="col-12">
                        <div id="dropzoneForm" class="dropzone"></div>
                    </div>
                </div>

            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="business_model_close_btn">{{trans('layout.close')}}</button>
                <button type="button" id="editBusinessModal_btn" class="btn btn-primary font-weight-bold">{{trans('layout.savechanges')}}</button>
            </div>
        </div>
    </div>
</div>

<div id="TaskDescModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="min-height: 590px;">
			<div class="modal-header py-5">
				<h5 class="modal-title">
					{{trans('layout.dlg_taskdescription')}}
					<span class="d-block text-muted font-size-sm">{{trans('layout.plsmanagetaskdesc')}}</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<div class="modal-body">
				<!--begin: Search Form-->
                <div class="mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-8 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="{{trans('layout.search')}}..." id="kt_datatable_task_desc_search_like">
                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">{{trans('layout.group')}}:</label>
                                    <select class="form-control" style="width:100%;" id="kt_datatable_task_desc_search_group" name="param">
                                        <option value="0">___{{trans('layout.all')}}___</option>
                                        @foreach($parentGroupList as $group)
                                        <option value="{{$group['id']}}">{{$group['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                        <a href="javascript:;" onclick="searchTaskDeschAction();" class="btn btn-light-primary px-6 font-weight-bold">
                            {{trans('layout.search')}}
                        </a>
                    </div>
                </div>
                <div class="row align-items-center mt-3">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-12 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="hidden" class="form-control" id="kt_datatable_task_desc_create_id" value="0">
                                    <input type="text" class="form-control" placeholder="{{trans('layout.description')}}" id="kt_datatable_task_desc_create_desc">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                        <a href="javascript:;" onclick="saveTaskDeschAction();" class="btn btn-light-primary px-6 font-weight-bold">
                            {{trans('layout.create')}}
                        </a>
                    </div>
                </div>
                </div>
                <!--end::Search Form-->

				<!--begin: Datatable-->
				<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_task_desc"></div>
				<!--end: Datatable-->
			</div>
		</div>
	</div>
</div>

<div id="TaskModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="min-height: 590px;">
			<div class="modal-header py-5">
				<h5 class="modal-title">
					{{trans('layout.dlg_task')}}
					<span class="d-block text-muted font-size-sm">{{trans('layout.plsmanagetask')}}</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<div class="modal-body">
            <form id="editTaskForm" method="post" enctype="multipart/form-data">
                <input type="hidden" value="0" id="edit_task_id">
                <input type="hidden" value="0" id="edit_task_document_id">
                <div class="form-group row" style="margin-bottom: -10px;">
					<label for="example-search-input" class="col-4 col-form-label">{{trans('layout.business')}}: </label>
					<label for="example-search-input" class="col-8 col-form-label" id="edit_task_business_name"></label>
                </div>
                <div class="form-group row" style="margin-bottom: -10px;">
					<label for="example-search-input" class="col-4 col-form-label">{{trans('layout.project')}}: </label>
					<label for="example-search-input" class="col-8 col-form-label" id="edit_task_project_name"></label>
                </div>
                <div class="form-group row" style="margin-bottom: 0px;">
					<label for="example-search-input" class="col-4 col-form-label">{{trans('layout.document')}}: </label>
					<label for="example-search-input" class="col-8 col-form-label" id="edit_task_document_name"></label>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-4 col-form-label">{{trans('layout.state')}}<span class="text-danger">*</span></label>
					<div class="col-8">
                        <select class="form-control" id="edit_task_state" style="width:100%;">
                        @foreach($adStatesList as $state)
                        <option>{{$state['uf']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" value="" id="edit_task_municipio_cnum">
                    <label for="example-search-input" class="col-4 col-form-label">{{trans('layout.city')}}<span class="text-danger">*</span></label>
					<div class="col-8">
                        <select class="form-control" id="edit_task_city" style="width:100%;">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
					<label class="col-4 col-form-label">{{trans('layout.description')}}</label>
                    <div class="col-8">
                    <select class="form-control" id="edit_task_desc_id" style="width:100%;">
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label">{{trans('layout.responsibleuser')}}</label>
                    <div class="col-8">
                        <select class="form-control" id="edit_task_user_id" style="width:100%;">
                        @foreach($responsibleUsersList as $user)
                            <option value="{{$user['id']}}">{{$user['username']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
					<label for="example-search-input" class="col-4 col-form-label">{{trans('layout.datetofinish')}}</label>
					<div class="col-4">
                        <input class="form-control" type="text" data-date-format="dd/mm/yyyy" value="{{date('d/m/Y')}}" id="edit_task_due_date" autocomplete="off">
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="task_model_close_btn">{{trans('layout.close')}}</button>
                    <button type="button" onclick="submitTaskEditForm();" id="task_model_submit_btn" class="btn btn-primary font-weight-bold">{{trans('layout.savechanges')}}</button>
                </div>
            </form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('layout.dlg_project')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            <form id="editProjectForm" method="post" enctype="multipart/form-data">
            	<input type="hidden" placeholder="id" value="0" id="edit_project_id">
                <div class="form-group row">
					<label for="example-search-input" class="col-3 col-form-label">{{trans('layout.name')}}<span class="text-danger">*</span></label>
					<div class="col-9">
						<input class="form-control" type="text" placeholder="{{trans('layout.name')}}" value="" id="edit_project_name">
					</div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-3">{{trans('layout.business')}}<span class="text-danger">*</span></label>
                    <div class="col-9">
                        <select class="form-control" style="width:100%;" id="edit_project_business" name="param">
                        @foreach($businessList as $business)
                            <option value="{{$business['id']}}">{{$business['first_name']}} {{$business['last_name']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-3 col-form-label">{{trans('layout.state')}}<span class="text-danger">*</span></label>
					<div class="col-9">
                        <select class="form-control" id="edit_project_state">
                        @foreach($adStatesList as $state)
                        <option>{{$state['uf']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" value="" id="edit_project_municipio_cnum">
                    <label for="example-search-input" class="col-3 col-form-label">{{trans('layout.city')}}<span class="text-danger">*</span></label>
					<div class="col-9">
                        <select class="form-control" id="edit_project_city" style="width:100%;">
                        </select>
                    </div>
                </div>
				<div class="form-group row">
					<label for="example-search-input" class="col-3 col-form-label">{{trans('layout.description')}}</label>
					<div class="col-9">
						<textarea placeholder="{{trans('layout.description')}}" class="form-control" id="edit_project_description"></textarea>
					</div>
                </div>
                <div class="form-group">
                    <div id="drop_file" class="col-12">
                        <div id="dropzoneProjectForm" class="dropzone"></div>
                    </div>
                </div>

            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="project_model_close_btn">{{trans('layout.close')}}</button>
                <button type="button" id="editProjectModal_btn" class="btn btn-primary font-weight-bold">{{trans('layout.savechanges')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="finishDocumentModal" tabindex="-1" role="dialog" aria-labelledby="finishDocumentModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('layout.dlg_finishdocument')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<input class="form-control" type="hidden" placeholder="id" value="0" id="finish_document_id">
                <div class="form-group row">
                    <label for="example-date-input" class="col-4 col-form-label text-right">{{trans('layout.finisheddate')}}<span class="text-danger">*</span></label>
                    <div class="col-8">
                        <input class="form-control" type="text" data-date-format="dd/mm/yyyy" value="{{date('d/m/Y')}}" id="finish_document_date" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-4 col-form-label text-right">{{trans('layout.finishedby')}}</label>
					<div class="col-8">
                        <select class="form-control" id="finish_document_user" style="width:100%;">
                        @foreach($responsibleUsersList as $user)
                            <option value="{{$user['id']}}">{{$user['username']}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="finish_document_model_close_btn">{{trans('layout.close')}}</button>
                <button type="button" onclick="finishDocumentEditForm();" id="document_model_submit_btn" class="btn btn-primary font-weight-bold">{{trans('layout.finish')}}</button>
            </div>
        </div>
    </div>
</div>

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
                <button type="button" onclick="finishTaskEditForm();" id="document_model_submit_btn" class="btn btn-primary font-weight-bold">{{trans('layout.finish')}}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="frontend/js/document.js"></script>
@endsection
