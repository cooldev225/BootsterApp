@extends('frontend.layouts.dashboard')
@inject('dateFormat', 'App\Services\DateService')
@section('content')
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-2">
            <h5 class="text-dark font-weight-bold mt-2 mb-2"><a href="home" class="btn btn-clean font-weight-bold" style="color:#000;font-size:15px;">{{trans('dashboard.dashboard')}}</a></h5>
            <div class="subheader-separator subheader-separator-ver mr-4" style="background-color:#655d5d;font-size:15px;"></div>
        
            <span class="text-muted font-weight-bold mr-4">TOTAL USERS: 0</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            <span class="text-muted font-weight-bold mr-4">USED BOOSTS: 0</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            <span class="text-muted font-weight-bold mr-4">PACKS BOUGHT OF TODAY/TOTAL: 0/0</span>
            <span class="text-muted font-weight-bold mr-4"></span>
            <span class="text-muted font-weight-bold mr-4">REVENUE OF TODAY/TOTAL: 0</span>
            <span class="text-muted font-weight-bold mr-4"></span>
        </div>
        <!--end::Info-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
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
                                {{trans('dashboard.users')}}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <div class="mb-7">
                            <div class="row align-items-center">
                                <div class="col-lg-8 col-xl-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 my-2 my-md-0">
                                            <div class="input-icon">
                                                <input type="text" class="form-control" placeholder="{{trans('layout.search')}}..." name="kt_datatable_search_query" id="kt_datatable_search_query" />
                                                <span><i class="flaticon2-search-1 text-muted"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-xl-2 mt-2 mt-lg-0">
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

<div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="editGroupModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('layout.dlguser')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <input class="form-control" type="hidden" placeholder="id" value="0" id="edit_group_id">
                <div class="form-group row">
                    <label for="example-search-input" class="col-1 col-form-label">{{trans('layout.description')}}<span class="text-danger">*</span></label>
					<div class="col-3">
						<input class="form-control" type="text" placeholder="{{trans('layout.description')}}" value="" id="edit_group_name">
					</div>
					<label for="example-search-input" class="col-3 col-form-label text-right">{{trans('layout.firstalert')}}<span class="text-danger">*</span></label>
					<div class="col-2">
						<input class="form-control" type="number" placeholder="{{trans('layout.firstalertdays')}}" value="" id="edit_group_alert_01">
					</div>
					<label for="example-search-input" class="col-1 col-form-label text-right">{{trans('layout.secondalert')}}<span class="text-danger">*</span></label>
					<div class="col-2">
						<input class="form-control" type="number" placeholder="{{trans('layout.againalertdays')}}" value="" id="edit_group_alert_02">
					</div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <textarea id="edit_group_template" class="tox-target" style="height:100px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="group_model_close_btn">{{trans('layout.close')}}</button>
                <button type="button" onclick="submitGroupEditForm();" class="btn btn-primary font-weight-bold">{{trans('layout.savechanges')}}</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="frontend/js/users.js"></script>
@endsection
