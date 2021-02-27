@extends('frontend.layouts.dashboard')
@inject('dateFormat', 'App\Services\DateService')
@section('content')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-2">

            <!--begin::Page Title-->
        <h5 class="text-dark font-weight-bold mt-2 mb-2"><a href="project" class="btn btn-clean font-weight-bold" style="color:#000;font-size:15px;">{{trans('layout.project')}}</a></h5>
            <!--end::Page Title-->
            @if(isset($business_id)&&$business_id>0)
            @php
            foreach($businessList as $business)if($business['id']==$business_id){
            @endphp
            <div class="subheader-separator subheader-separator-ver" style="background-color:#655d5d;font-size:15px;"></div>
            <h5 class="text-dark font-weight-bold mt-2 mb-2"><a href="project?a={{$business_id}}" class="btn btn-clean font-weight-bold mr-1" style="color:#000;font-size:15px;">{{$business['first_name']}}</a></h5>
            @php
            break;
            }
            @endphp
            @endif
            <!--begin::Actions-->


            <span class="text-muted font-weight-bold mr-4">{{trans('layout.business')}}s: {{count($businessList)}}</span>

            <span class="text-muted font-weight-bold mr-4"></span>

            <span class="text-muted font-weight-bold mr-4">{{trans('layout.project')}}s: {{$totalProjectCount}}</span>
            <span class="text-muted font-weight-bold mr-4"></span>

            <span class="text-muted font-weight-bold mr-4">{{trans('layout.document')}}s: {{$totalDocumentCount}}</span>

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
                <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">
                                {{trans('layout.business')}}:

                                <span class="d-block text-muted pt-2 font-size-sm">

                                </span>
                            </h3>
                            <div class="mr-5">
                                <div class="row align-items-center">
                                    <div class="col-md-12 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="{{trans('layout.search')}}..." value="{{isset($sch)?$sch:''}}" name="kt_datatable_search_query" id="kt_datatable_search_query" />
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="card-label ml-3">
                                {{trans('layout.project')}}:
                            </h3>
                            <div class="mr-5">
                                <div class="row align-items-center">
                                    <div class="col-md-12 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="{{trans('layout.search')}}..." value="{{isset($pch)?$pch:''}}" name="kt_datatable_pearch_query" id="kt_datatable_pearch_query" />
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <button type="button" data-toggle="modal" onclick="businessAddAction();" data-target="#editBusinessModal" class="btn btn-light-primary font-weight-bolder mr-2" data-toggle="dropdown" onclick="" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-plus"></i>
                                {{trans('layout.add_business')}}
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::business level-->
                        <div class="example example-basic">
                                <!--begin::Timeline-->
                                <div class="timeline timeline-3 business-timeline-3">
                                    <div class="timeline-items">
                                        @foreach($schBusinessList as $business)
                                        @if((isset($business_id)&&$business_id==$business['id'])||(!isset($business_id)||$business_id==0))
                                        <div class="timeline-item business-panel-{{$business['id']}}">
                                            <div class="timeline-media" onclick="$('#project-timeline-{{$business['id']}}').toggle();$('#business-toggle-icon-{{$business['id']}} i').toggle();" style="cursor: pointer;">
                                                @if(isset($business['company']['logo'])&&$business['company']['logo']!='')
                                                <img alt="Pic" src="{{$business['company']['logo']}}">
                                                @else
                                                <i class="flaticon2-layers text-warning"></i>
                                                @endif
                                                <div class="business-toggle-icon" id="business-toggle-icon-{{$business['id']}}">
                                                <i class="icon-md fas fa-arrow-circle-up" style="{{isset($pch)&&$pch!=''?'':'display:none;'}}"></i>
                                                <i class="icon-md fas fa-arrow-circle-down" style="{{isset($pch)&&$pch!=''?'display:none;':''}}"></i>
                                                </div>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="mr-2">
                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                            {{$business['first_name']}} {{$business['last_name']}}
                                                        </a>
                                                        @isset($business['created_name'])
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.createdby')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['created_name']}}
                                                        </span>
                                                        @endisset
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.createdat')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$dateFormat->frandlyDate($business['created_at'])}}
                                                        </span>

                                                    </div>
                                                    <div class="dropdown ml-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="{{trans('layout.quickactions')}}">
                                                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ki ki-more-hor font-size-lg text-primary"></i>
                                                        </a>
                                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                                                            <!--begin::Navigation-->
                                                            <ul class="navi navi-hover">
                                                                <li class="navi-header font-weight-bold py-4">
                                                                    <span class="font-size-lg">{{trans('layout.action')}}:</span>
                                                                    <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
                                                                </li>
                                                                <li class="navi-item">
                                                                    <a href="javascript:;" class="navi-link">
                                                                        <span class="navi-text" onclick="
                                                                        $('#edit_business_id').val({{$business['id']}});
                                                                        $('#edit_business_first_name').val('{{$business['first_name']}}');
                                                                        $('#edit_business_last_name').val('{{$business['last_name']}}');
                                                                        $('#edit_business_cnpj').val('{{$business['cnpj']}}');
                                                                        $('#edit_business_ie').val('{{$business['ie']}}');
                                                                        $('#edit_business_im').val('{{$business['im']}}');
                                                                        $('#edit_business_open_date').val(encodeIvanFormat('{{$business['open_date']}}'));
                                                                        $('#edit_business_ad_street').val('{{$business['ad_street']}}');
                                                                        $('#edit_business_ad_number').val('{{$business['ad_number']}}');
                                                                        $('#edit_business_ad_neighborhood').val('{{$business['ad_neighborhood']}}');
                                                                        $('#edit_business_ad_complement').val('{{$business['ad_complement']}}');
                                                                        $('#edit_business_ad_zip_code').val('{{$business['ad_zip_code']}}');
                                                                        $('#edit_business_ad_state').val('{{$business['ad_state']}}').trigger('change');
                                                                        $('#edit_business_municipio_cnum').val('{{$business['municipio_cnum']}}');
                                                                        $('#edit_business_mobile_phone').val('{{$business['mobile_phone']}}');
                                                                        $('#edit_business_mobile_office').val('{{$business['mobile_office']}}');
                                                                        $('#edit_business_contactor_name_01').val('{{$business['contactor_name_01']}}');
                                                                        $('#edit_business_contactor_phone_01').val('{{$business['contactor_phone_01']}}');
                                                                        $('#edit_business_contactor_email_01').val('{{$business['contactor_email_01']}}');
                                                                        $('#edit_business_contactor_name_02').val('{{$business['contactor_name_02']}}');
                                                                        $('#edit_business_contactor_phone_02').val('{{$business['contactor_phone_02']}}');
                                                                        $('#edit_business_contactor_email_02').val('{{$business['contactor_email_02']}}');
                                                                        $('#edit_business_alert_email_01').val('{{$business['alert_email_01']}}');
                                                                        $('#edit_business_alert_email_02').val('{{$business['alert_email_02']}}');
                                                                        $('#edit_business_description').val('{{$business['description']}}');
                                                                        " data-toggle="modal" data-target="#editBusinessModal">
                                                                            <span class="label label-xl label-inline label-light-success">{{trans('layout.edit_business')}}</span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="navi-separator mb-3 opacity-70"></li>
                                                                <li class="navi-item">
                                                                    <a href="javascript:;" class="navi-link">
                                                                        <span class="navi-text" data-toggle="modal" data-target="#editProjectModal" onclick="
                                                                             $('#edit_project_state').val('{{$business['ad_state']}}').trigger('change');
                                                                             $('#edit_project_municipio_cnum').val('{{$business['municipio_cnum']}}');
                                                                            projectAddAction({{$business['id']}});">
                                                                            <span class="label label-xl label-inline label-light-primary">{{trans('layout.add_project')}}</span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                @if(!count($schProjectList[$business['id']]))
                                                                <li class="navi-item">
                                                                    <a href="javascript:;" onclick="deleteBusinessAction({{$business['id']}});" class="navi-link">
                                                                        <span class="navi-text">
                                                                        <span class="label label-xl label-inline label-light-danger">{{trans('layout.del_business')}}</span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                @endif
                                                                <li class="navi-separator mt-3 opacity-70"></li>
                                                                <li class="navi-footer py-4">
                                                                    <a class="btn btn-clean font-weight-bold btn-sm" data-toggle="modal" onclick="businessAddAction();" data-target="#editBusinessModal">
                                                                        <i class="ki ki-plus icon-sm"></i>
                                                                        {{trans('layout.add_business')}}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <!--end::Navigation-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="p-0" style="line-height: 25px;">
                                                    @if($business['cnpj']!='')
                                                    <span class="label label-light-success font-weight-bolder label-inline ml-1">CNPJ</span>
                                                    <span class="text-muted ml-2">
                                                        {{$business['cnpj']}}
                                                    </span>
                                                    @endif
                                                    @if($business['ie']!='')
                                                    <span class="label label-light-success font-weight-bolder label-inline ml-1">IE</span>
                                                    <span class="text-muted ml-2">
                                                        {{$business['ie']}}
                                                    </span>
                                                    @endif
                                                    @if($business['im']!='')
                                                    <span class="label label-light-success font-weight-bolder label-inline ml-1">IM</span>
                                                    <span class="text-muted ml-2">
                                                        {{$business['im']}}
                                                    </span>
                                                    @endif
                                                    @if($business['open_date']!='')
                                                    <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.open')}}</span>
                                                    <span class="text-muted ml-2">
                                                        {{$dateFormat->frandlyDate($business['open_date'])}}
                                                    </span>
                                                    @endif
                                                </p>
                                                <a href="javascript:;" class="btn btn-hover-light-primary btn-sm btn-icon" onclick="$('.business-body-info-{{$business['id']}}').toggle();">
                                                    <i class="ki ki-more-hor font-size-lg text-primary"></i>
                                                </a>
                                                <div class="business-body-info-{{$business['id']}}" style="display:none;">
                                                    <p class="p-0" style="line-height: 25px;">
                                                        @if($business['ad_street']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.address')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['ad_street']}}
                                                        </span>
                                                        @endif
                                                        @if($business['ad_number']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.addressofnumber')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['ad_number']}}
                                                        </span>
                                                        @endif
                                                        @if($business['ad_neighborhood']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.neighborhood')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['ad_neighborhood']}}
                                                        </span>
                                                        @endif
                                                        @if($business['ad_zip_code']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.zipcode')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['ad_zip_code']}}
                                                        </span>
                                                        @endif
                                                        @if($business['ad_state']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.state')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['ad_state']}}
                                                        </span>
                                                        @endif
                                                        @if($business['ad_city']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.city')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['ad_city']}}
                                                        </span>
                                                        @endif
                                                        @if($business['mobile_office']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.mobileoffice')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['mobile_office']}}
                                                        </span>
                                                        @endif
                                                        @if($business['mobile_phone']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.mobilephone')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['mobile_phone']}}
                                                        </span>
                                                        @endif
                                                    </p>
                                                    <p class="p-0">
                                                        @if($business['contactor_name_01']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.contactor')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['contactor_name_01']}}
                                                        </span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['contactor_phone_01']}}
                                                        </span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['contactor_email_01']}}
                                                        </span>
                                                        @endif
                                                    </p>
                                                    <p class="p-0">
                                                        @if($business['contactor_name_02']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.contactorother')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['contactor_name_02']}}
                                                        </span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['contactor_phone_02']}}
                                                        </span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['contactor_email_02']}}
                                                        </span>
                                                        @endif
                                                    </p>
                                                    <p class="p-0">
                                                        @if($business['alert_email_01']!='')
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('login.email')}}</span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['alert_email_01']}}
                                                        </span>
                                                        <span class="text-muted ml-2">
                                                            {{$business['alert_email_02']}}
                                                        </span>
                                                        @endif
                                                    </p>
                                                    <p class="p-0">
                                                        <span class="label label-light-success font-weight-bolder label-inline ml-1">{{trans('layout.description')}}</span>
                                                        {{$business['description']}}
                                                    </p>
                                                    @foreach($business['attached_files'] as $attach_file)
                                                    <p class="p-0">
                                                        <a href="javascript:;" onclick="window.open('download/{{$attach_file['path']}}');">{{$attach_file['filename']}}</a>
                                                        <a href="javascript:;" onclick="window.open('downloadFile?path={{$attach_file['path']}}');">
                                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\Cloud-download.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                                    <path d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z" fill="#000000" opacity="0.3"/>
                                                                    <path d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 18.661508) rotate(-270.000000) translate(-11.959697, -18.661508) "/>
                                                                </g>
                                                            </svg><!--end::Svg Icon--></span>
                                                        </a>
                                                        <a style="cursor:pointer;" onclick="deleteAttachFileAction('{{$attach_file['id']}}');"><span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\Deleted-file.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                <path d="M10.5857864,13 L9.17157288,11.5857864 C8.78104858,11.1952621 8.78104858,10.5620972 9.17157288,10.1715729 C9.56209717,9.78104858 10.1952621,9.78104858 10.5857864,10.1715729 L12,11.5857864 L13.4142136,10.1715729 C13.8047379,9.78104858 14.4379028,9.78104858 14.8284271,10.1715729 C15.2189514,10.5620972 15.2189514,11.1952621 14.8284271,11.5857864 L13.4142136,13 L14.8284271,14.4142136 C15.2189514,14.8047379 15.2189514,15.4379028 14.8284271,15.8284271 C14.4379028,16.2189514 13.8047379,16.2189514 13.4142136,15.8284271 L12,14.4142136 L10.5857864,15.8284271 C10.1952621,16.2189514 9.56209717,16.2189514 9.17157288,15.8284271 C8.78104858,15.4379028 8.78104858,14.8047379 9.17157288,14.4142136 L10.5857864,13 Z" fill="#000000"/>
                                                            </g>
                                                        </svg><!--end::Svg Icon--></span></a>
                                                    </p>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <p>
                                            <div class="timeline timeline-5 project-timeline-5" id="project-timeline-{{$business['id']}}" style="{{isset($pch)&&$pch!=''?'':'display:none;'}}">
                                                <div class="timeline-items">
                                                @foreach($schProjectList[$business['id']] as $project)
                                                    <!--begin::Item-->
                                                    <div class="timeline-item project-panel-{{$project['id']}}">
                                                        <!--begin::Icon-->
                                                        <div class="timeline-media" onclick="$('#document-timeline-{{$project['id']}}').toggle();$('#project-toggle-icon-{{$project['id']}} i').toggle();" style="cursor: pointer;">
                                                            <img src="metronic/media/svg/icons/Layout/Layout-4-blocks.svg"/>
                                                            <div class="project-toggle-icon" id="project-toggle-icon-{{$project['id']}}">
                                                            <i class="icon-nm fas fa-arrow-circle-up"></i>
                                                            <i class="icon-nm fas fa-arrow-circle-down" style="display:none;"></i>
                                                            </div>
                                                        </div>
                                                        <!--end::Icon-->

                                                        <!--begin::Info-->
                                                        <div class="timeline-info">
                                                            <div class="mr-2">
                                                                <a href="javascript:;" class="text-dark-75 text-hover-primary font-weight-bold project_name_of_{{$project['id']}}">
                                                                    {{$project['name']}}
                                                                </a>
                                                                <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.createdat')}}</span>
                                                                <span class="text-muted ml-1">
                                                                    {{$dateFormat->frandlyDate($project['created_at'])}}
                                                                </span>
                                                                @if($project['state']!=''&&$project['state']!='null')
                                                                <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.state')}}</span>
                                                                <span class="text-muted ml-1">
                                                                    {{$project['state']}}
                                                                </span>
                                                                @endif
                                                                <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.city')}}</span>
                                                                <span class="text-muted ml-1">
                                                                    {{$project['city']}}
                                                                </span>
                                                                <p class="font-weight-normal text-dark-50 pt-1">
                                                                    <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.description')}}</span>
                                                                    {{$project['description']}}
                                                                </p>
                                                                @foreach($project['attached_files'] as $attach_file)
                                                                <p class="p-0">
                                                                    <a href="javascript:;" onclick="window.open('download/{{$attach_file['path']}}');">{{$attach_file['filename']}}</a>
                                                                </p>
                                                                @endforeach

                                                                <!--Document Area-->
                                                                @isset($documentList[$business['id']])
                                                                <p>
                                                                <div class="timeline timeline-5 document-timeline-5" id="document-timeline-{{$project['id']}}" style="display:block;">
                                                                    <div class="timeline-items">
                                                                    @foreach($documentList[$business['id']][$project['id']] as $document)
                                                                        @isset($document['id'])
                                                                            <!--begin::Item-->
                                                                            <div class="timeline-item">
                                                                                <!--begin::Icon-->
                                                                                <div class="timeline-media">
                                                                                    <img src="metronic/media/svg/icons/Files/Folder.svg"/>
                                                                                </div>
                                                                                <!--end::Icon-->

                                                                                <!--begin::Info-->
                                                                                <div class="timeline-info">
                                                                                    <div class="mr-2">
                                                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                            {{$document['title']}}
                                                                                        </a>
                                                                                        <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.createdat')}}</span>
                                                                                        <span class="text-muted ml-2">
                                                                                            {{$dateFormat->frandlyDate($document['created_at'])}}
                                                                                        </span>
                                                                                        <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.dueto')}}</span>
                                                                                        <span class="text-muted ml-2" style="color: #000000db !important;font-weight:bold;">
                                                                                            {{$dateFormat->frandlyDate($document['due_date'])}}
                                                                                        </span>
                                                                                        <span class="label label-light-warning font-weight-bolder label-inline ml-2">{{trans('layout.firstalertat')}}</span>
                                                                                        <span class="text-muted ml-2">
                                                                                            {{$dateFormat->frandlyDate(date('Y-m-d',strtotime('-'.($document['sub_group_id']>0?$document['subgroup_alert_01']:$document['group_alert_01']).' day',strtotime($document['due_date']))))}}
                                                                                        </span>
                                                                                        <span class="label label-light-warning font-weight-bolder label-inline ml-2">{{trans('layout.secondalertat')}}</span>
                                                                                        <span class="text-muted ml-2">
                                                                                        {{$dateFormat->frandlyDate(date('Y-m-d',strtotime('-'.($document['sub_group_id']>0?$document['subgroup_alert_02']:$document['group_alert_02']).' day',strtotime($document['due_date']))))}}
                                                                                        </span>
                                                                                        <p class="font-weight-normal text-dark-50 pt-1">
                                                                                            {{$document['description']}}
                                                                                        </p>

                                                                                        <!--
                                                                                        @isset($taskLogList[$document['id']])
                                                                                        <div class="timeline timeline-1 task-timeline-1">
                                                                                            <div class="timeline-sep bg-primary-opacity-20"></div>
                                                                                            @foreach($taskLogList[$document['id']] as $taskLog)
                                                                                            <div class="timeline-item">
                                                                                                <div class="timeline-label">{{$taskLog['username']}}</div>
                                                                                                @if($taskLog['action']==0)
                                                                                                    <div class="timeline-badge label-light-primary">
                                                                                                        <img src="metronic/media/svg/icons/Communication/Shield-user.svg"/>
                                                                                                    </div>
                                                                                                    <div class="timeline-content text-muted font-weight-normal">
                                                                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                                            {{$taskLog['task_name']}}
                                                                                                        </a>
                                                                                                        <span class="label label-light-success font-weight-bolder label-inline ml-2">assigned at</span>
                                                                                                        <span class="text-muted ml-2">
                                                                                                            {{$dateFormat->frandlyDate($taskLog['created_at'])}}
                                                                                                        </span>
                                                                                                        {{$taskLog['task_description']}}
                                                                                                    </div>
                                                                                                @elseif($taskLog['action']==1)
                                                                                                    <div class="timeline-badge">
                                                                                                        <img src="metronic/media/svg/icons/Files/File-plus.svg"/>
                                                                                                    </div>
                                                                                                    <div class="timeline-content text-muted font-weight-normal">
                                                                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                                            {{$taskLog['task_name']}}
                                                                                                        </a>
                                                                                                        <span class="label label-light-primary font-weight-bolder label-inline ml-2">updated at</span>
                                                                                                        <span class="text-muted ml-2">
                                                                                                            {{$dateFormat->frandlyDate($taskLog['created_at'])}}
                                                                                                        </span>
                                                                                                        <p>{{$taskLog['description']}}</p>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <div class="timeline-badge">
                                                                                                        <img src="metronic/media/svg/icons/Files/Deleted-file.svg"/>
                                                                                                    </div>
                                                                                                    <div class="timeline-content text-muted font-weight-normal">
                                                                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                                            {{$taskLog['task_name']}}
                                                                                                        </a>
                                                                                                        <span class="label label-light-danger font-weight-bolder label-inline ml-2">deleted at</span>
                                                                                                        <span class="text-muted ml-2">
                                                                                                            {{$dateFormat->frandlyDate($taskLog['created_at'])}}
                                                                                                        </span>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                        @endisset
                                                                                        -->
                                                                                    </div>

                                                                                    <!--
                                                                                    <div class="dropdown ml-2 document-tools-dropdown" data-toggle="tooltip" title="" data-placement="left" data-original-title="{{trans('layout.quickactions')}}">
                                                                                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <i class="ki ki-more-hor font-size-lg text-primary"></i>
                                                                                        </a>
                                                                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                                                                                            <ul class="navi navi-hover">
                                                                                                <li class="navi-header font-weight-bold py-4">
                                                                                                    <span class="font-size-lg">{{trans('layout.action')}}:</span>
                                                                                                    <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
                                                                                                </li>
                                                                                                <li class="navi-separator mb-3 opacity-70"></li>
                                                                                                <li class="navi-item">
                                                                                                    <a href="#" class="navi-link">
                                                                                                        <span class="navi-text">
                                                                                                            <span class="label label-xl label-inline label-light-primary">Create new document</span>
                                                                                                        </span>
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="navi-item">
                                                                                                    <a href="#" class="navi-link">
                                                                                                        <span class="navi-text">
                                                                                                            <span class="label label-xl label-inline label-light-success">Edit project</span>
                                                                                                        </span>
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="navi-separator mt-3 opacity-70"></li>
                                                                                                <li class="navi-footer py-4">
                                                                                                    <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                                                                                                        <i class="ki ki-plus icon-sm"></i>
                                                                                                        Add new project
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                    -->
                                                                                </div>
                                                                                <!--end::Info-->
                                                                            </div>
                                                                            <!--end::Item-->

                                                                            <!--Document children Area-->
                                                                            @isset($documentList[$business['id']][$project['id']]['children_'.$document['id']])
                                                                                @foreach($documentList[$business['id']][$project['id']]['children_'.$document['id']] as $children)
                                                                                    <!--begin::Item-->
                                                                                    <div class="timeline-item children-document-item">
                                                                                        <!--begin::Icon-->
                                                                                        <div class="timeline-media">
                                                                                            <img src="metronic/media/svg/icons/General/Clipboard.svg"/>
                                                                                        </div>
                                                                                        <!--end::Icon-->

                                                                                        <!--begin::Info-->
                                                                                        <div class="timeline-info">
                                                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                                {{$children['title']}}
                                                                                            </a>
                                                                                            <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.createdat')}}</span>
                                                                                            <span class="text-muted ml-2">
                                                                                                {{$dateFormat->frandlyDate($children['created_at'])}}
                                                                                            </span>
                                                                                            <span class="label label-light-success font-weight-bolder label-inline ml-2">{{trans('layout.dueto')}}</span>
                                                                                            <span class="text-muted ml-2">
                                                                                                {{$dateFormat->frandlyDate($children['due_date'])}}
                                                                                            </span>
                                                                                            <span class="label label-light-primary font-weight-bolder label-inline ml-2">{{trans('layout.firstalertat')}}</span>
                                                                                            <span class="text-muted ml-2">
                                                                                                {{$dateFormat->frandlyDate($children['alert_date_01'])}}
                                                                                            </span>
                                                                                            <span class="label label-light-primary font-weight-bolder label-inline ml-2">{{trans('layout.secondalertat')}}</span>
                                                                                            <span class="text-muted ml-2">
                                                                                                {{$dateFormat->frandlyDate($children['alert_date_02'])}}
                                                                                            </span>
                                                                                            <p class="font-weight-normal text-dark-50 pt-1">
                                                                                                {{$children['description']}}
                                                                                            </p>

                                                                                            <!--
                                                                                            @isset($taskLogList[$children['id']])
                                                                                            <div class="timeline timeline-1 task-timeline-1">
                                                                                                <div class="timeline-sep bg-primary-opacity-20"></div>
                                                                                                @foreach($taskLogList[$children['id']] as $taskLog)
                                                                                                <div class="timeline-item">
                                                                                                    <div class="timeline-label">{{$taskLog['username']}}</div>
                                                                                                    @if($taskLog['action']==0)
                                                                                                        <div class="timeline-badge label-light-primary">
                                                                                                            <img src="metronic/media/svg/icons/Communication/Shield-user.svg"/>
                                                                                                        </div>
                                                                                                        <div class="timeline-content text-muted font-weight-normal">
                                                                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                                                {{$taskLog['task_name']}}
                                                                                                            </a>
                                                                                                            <span class="label label-light-success font-weight-bolder label-inline ml-2">assigned at</span>
                                                                                                            <span class="text-muted ml-2">
                                                                                                                {{$dateFormat->frandlyDate($taskLog['created_at'])}}
                                                                                                            </span>
                                                                                                            {{$taskLog['task_description']}}
                                                                                                        </div>
                                                                                                    @elseif($taskLog['action']==1)
                                                                                                        <div class="timeline-badge">
                                                                                                            <img src="metronic/media/svg/icons/Files/File-plus.svg"/>
                                                                                                        </div>
                                                                                                        <div class="timeline-content text-muted font-weight-normal">
                                                                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                                                {{$taskLog['task_name']}}
                                                                                                            </a>
                                                                                                            <span class="label label-light-primary font-weight-bolder label-inline ml-2">updated at</span>
                                                                                                            <span class="text-muted ml-2">
                                                                                                                {{$dateFormat->frandlyDate($taskLog['created_at'])}}
                                                                                                            </span>
                                                                                                            <p>{{$taskLog['description']}}</p>
                                                                                                        </div>
                                                                                                    @else
                                                                                                        <div class="timeline-badge">
                                                                                                            <img src="metronic/media/svg/icons/Files/Deleted-file.svg"/>
                                                                                                        </div>
                                                                                                        <div class="timeline-content text-muted font-weight-normal">
                                                                                                            <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">
                                                                                                                {{$taskLog['task_name']}}
                                                                                                            </a>
                                                                                                            <span class="label label-light-danger font-weight-bolder label-inline ml-2">deleted at</span>
                                                                                                            <span class="text-muted ml-2">
                                                                                                                {{$dateFormat->frandlyDate($taskLog['created_at'])}}
                                                                                                            </span>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                            @endisset
                                                                                            -->
                                                                                        </div>
                                                                                        <!--end::Info-->
                                                                                    </div>
                                                                                    <!--end::Item-->
                                                                                @endforeach
                                                                            @endisset
                                                                        @endif
                                                                    @endforeach
                                                                    </div>
                                                                </div>
                                                                @endisset
                                                            </div>
                                                        <div class="dropdown ml-2 project-tools-dropdown" data-toggle="tooltip" title="" data-placement="left" data-original-title="{{trans('layout.quickactions')}}">
                                                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="ki ki-more-hor font-size-lg text-primary"></i>
                                                                </a>
                                                                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                                                                    <!--begin::Navigation-->
                                                                    <ul class="navi navi-hover">
                                                                        <li class="navi-header font-weight-bold py-4">
                                                                            <span class="font-size-lg">{{trans('layout.action')}}:</span>
                                                                            <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="" data-original-title="Click to learn more..."></i>
                                                                        </li>
                                                                        <li class="navi-separator mb-3 opacity-70"></li>
                                                                        <li class="navi-item">
                                                                            <a href="javascript:;" class="navi-link">
                                                                                <span class="navi-text">
                                                                                    <span class="label label-xl label-inline label-light-success" data-toggle="modal" data-target="#editProjectModal" onclick="
                                                                                        $('#edit_project_id').val({{$project['id']}});
                                                                                        $('#edit_project_name').val('{{$project['name']}}');
                                                                                        $('#edit_project_business').val('{{$business['id']}}').trigger('change');
                                                                                        $('#edit_project_state').val('{{$project['state']}}').trigger('change');
                                                                                        $('#edit_project_municipio_cnum').val('{{$project['municipio_cnum']}}');
                                                                                        $('#edit_project_description').val('{{$project['description']}}');
                                                                                    ">{{trans('layout.edit_project')}}</span>
                                                                                </span>
                                                                            </a>
                                                                        </li>
                                                                        <!--li class="navi-item">
                                                                            <a href="javascript:;" onclick="alert('sorry for developing...');" class="navi-link">
                                                                                <span class="navi-text">
                                                                                    <span class="label label-xl label-inline label-light-primary">Create new document</span>
                                                                                </span>
                                                                            </a>
                                                                        </li-->
                                                                        @if(!isset($documentList[$business['id']][$project['id']])||!count($documentList[$business['id']][$project['id']]))
                                                                        <li class="navi-item">
                                                                            <a href="javascript:;" onclick="deleteProjectAction({{$project['id']}});" class="navi-link">
                                                                                <span class="navi-text">
                                                                                    <span class="label label-xl label-inline label-light-danger">{{trans('layout.del_project')}}</span>
                                                                                </span>
                                                                            </a>
                                                                        </li>
                                                                        @endif
                                                                        <li class="navi-separator mt-3 opacity-70"></li>
                                                                        <li class="navi-footer py-4">
                                                                            <a class="btn btn-clean font-weight-bold btn-sm" href="javascript:;" data-toggle="modal" data-target="#editProjectModal" onclick="
                                                                                $('#edit_project_municipio_cnum').val('{{$business['municipio_cnum']}}');
                                                                                $('#edit_project_state').val('{{$business['ad_state']}}').trigger('change');
                                                                                projectAddAction({{$business['id']}});">
                                                                                <i class="ki ki-plus icon-sm"></i>
                                                                                {{trans('layout.add_project')}}
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <!--end::Navigation-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Info-->


                                                    </div>
                                                    <!--end::Item-->
                                                @endforeach
                                                </div>
                                            </div>


                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                        </div>
                        <!--end::business level-->
                    </div>
                </div>
            </div>
            <!--end:epg widget-->
		</div>
        <!--end::Row-->
        <!--end::Dashboard-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
<div class="modal fade" id="editBusinessModal" tabindex="-1" role="dialog" aria-labelledby="editBusinessModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('layout.dlg_business')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            <form id="editBusinessForm" method="post" enctype="multipart/form-data">
            	<input type="hidden" placeholder="id" value="0" id="edit_business_id">
                <div class="form-group row">
					<label for="example-search-input" class="col-2 col-form-label">{{trans('layout.firstname')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.firstname')}}" value="" id="edit_business_first_name">
					</div>
					<label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.lastname')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.lastname')}}" value="" id="edit_business_last_name">
					</div>
                </div>
                <div class="form-group row">
                <label for="example-search-input" class="col-2 col-form-label">CNPJ</label>
					<div class="col-2">
						<input class="form-control" type="text" placeholder="CNPJ" value="" id="edit_business_cnpj">
                    </div>
					<div class="col-2 input-group">
                        <div class="input-group-prepend"><span class="input-group-text">IE</span></div>
						<input class="form-control" type="text" placeholder="IE" value="" id="edit_business_ie">
                    </div>
					<div class="col-2 input-group">
                        <div class="input-group-prepend"><span class="input-group-text">IM</span></div>
						<input class="form-control" type="text" placeholder="IM" value="" id="edit_business_im">
					</div>
					<label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.open')}}</label>
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
						<input class="form-control" type="text" placeholder="Address number" value="" id="edit_business_ad_number">
					</div>
                </div>
                <div class="form-group row">
                <label for="example-search-input" class="col-2 col-form-label">{{trans('layout.neighborhood')}}<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control" type="text" placeholder="{{trans('layout.neighborhood')}}" value="" id="edit_business_ad_neighborhood">
					</div>
                <label for="example-search-input" class="col-2 col-form-label text-right">{{trans('layout.complement')}}</label>
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
                <div class="form-group">
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
<script type="text/javascript" src="frontend/js/jquery.cpfcnpj.min.js"></script>
<script type="text/javascript" src="frontend/js/project.js"></script>
@endsection
