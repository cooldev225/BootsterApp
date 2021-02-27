@extends('frontend.layouts.dashboard')
@inject('dateFormat', 'App\Services\DateService')
@section('content')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
            <h5 class="text-dark font-weight-bold mt-2 mb-2"><a href="home" class="btn btn-clean font-weight-bold" style="color:#000;font-size:15px;">{{trans('layout.taskmap')}}</a></h5>
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
            @endif
            @if(isset($business_id)&&$business_id>0&&isset($project_id)&&$project_id>0)
            <span class="text-muted font-weight-bold mr-4">{{trans('layout.document')}}s: {{count($documentList[$business_id][$project_id])}}</span>
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
        <div class="row" style="height:100%;">
            <!--begin:epg widget-->
            <div class="col-4 mb-7">
                <!--begin::Card-->
                <div class="card card-custom" style="background-color:transparent;">
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12 d-flex align-items-center">
                                <label class="mr-5 mb-0 d-none d-md-block" style="width: 75px;">{{trans('layout.business')}}:</label>
                                <select class="form-control" id="kt_datatable_search_business" style="width:100%;">
                                <option value="0">___{{trans('layout.all')}}___</option>
                                @foreach($businessList as $business)
                                    <option value="{{$business['id']}}">{{$business['first_name']}} {{$business['last_name']}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12 mt-2 d-flex align-items-center">
                                <label class="mr-5 mb-0 d-none d-md-block" style="width: 75px;">{{trans('layout.project')}}:</label>
                                <input type="hidden" id="project_object" value="{{json_encode($projectList)}}"/>
                                <select class="form-control" id="kt_datatable_search_project" style="width:100%;">
                                <option value="0">___{{trans('layout.all')}}___</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12 mt-2 d-flex align-items-center">
                                <label class="mr-5 mb-0 d-none d-md-block" style="width: 75px;">{{trans('layout.user')}}:</label>
                                <select class="form-control" id="kt_datatable_search_user" style="width:100%;">
                                <option value="0">___{{trans('layout.all')}}___</option>
                                @foreach($responsibleUsersList as $user)
                                    <option value="{{$user['id']}}">{{$user['username']}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2 mt-2">
                            <div class="col-lg-8 col-xl-8">
                                <div class="row align-items-center">
                                    <div class="col-md-12 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="{{trans('layout.search')}}..." name="kt_datatable_search_query" id="kt_datatable_search_query" />
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 mt-2 mt-lg-0 align-items-right" style="text-align: right;display:none;">
                                <a href="javascript:searchAction();" class="btn btn-light-primary px-6 font-weight-bold">
                                    {{trans('layout.search')}}
                                </a>
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
            <div class="col-8 mb-7">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact" style="height:100%;">
                    <div class="card-body">
                        <div id="map" style="width:100%;height:100%;"></div>
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
<style>
.datatable-table{
    background-color: transparent!important;
}
</style>
<script type="text/javascript" src="frontend/js/task.js"></script>
<script type="text/javascript" src="frontend/js/taskmap.js"></script><!--AIzaSyAF3u390rF-WMrHHOpjmGgS_TNLJOkDubo-->
<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbCHyYWM0eCnJhK08UJCq_wwGkGJhwvMU&libraries=places&callback=initAutocomplete"></script-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbCHyYWM0eCnJhK08UJCq_wwGkGJhwvMU&libraries=places&callback=initAutocomplete"></script>
@endsection
