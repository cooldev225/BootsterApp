@extends('frontend.layouts.home')
@inject('dateFormat', 'App\Services\DateService')
@section('content')
<section class="top-body-area">
    <h1>Expo 2021</h1>
    <div class="expo-inner">
        <p>Encuentra infomation de tu campus, facultad o carrera de interes, a traves de nuestro buscador o ingresa a la seccion directamente.</p>
        <div class="expo-search-div">
            <i class="lnr lnr-magnifier"></i>
            <input placeholder="Lorem ipsum dolor sit amet...">
        </div>
    </div>
</section>
<!-- our product area start -->
<section class="our-product section-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-product-title text-left">
                    <h2>Tus carreras de interes</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-title">Ingenieria industrial</p>
                    <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-title">Medicina</p>
                    <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-title">Administration</p>
                    <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- our product area end -->

<section class="our-product section-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-product-title text-left">
                    <h2>Facultades</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-caption">Ingenieria</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="query-body-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 text-left">
                <h1>?Quieres saber tus siguientes pasos?</h1>
                <p>Enterate aqui des todo lo que necesitas.</p>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 text-right">
                <button>Siguientes psos</button>
            </div>
        </div>
    </div>
</section>

<section class="our-product-table section-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div style="padding:0px 20px;">
                    <div class="section-product-title text-left" style="display:flex;">
                        <h2>Proximos eventos</h2>
                        <div class="right">Ver agenda</div>
                    </div>
                    <div class="product-card-table">
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star-o"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star-o"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star-o"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
            <div style="padding:0px 20px;">
                    <div class="section-product-title text-left" style="display:flex;">
                        <h2>Proximos eventos</h2>
                        <div class="right">Ver agenda</div>
                    </div>
                    <div class="product-card-table">
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star-o"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star-o"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                        <div class="product-card-table-item">
                            <div class="left">
                                <p class="month">18 Nov</p>
                                <p>10:00 AM</p>
                            </div>
                            <div class="right">
                                <div class="item-title text-left" style="display:flex;">
                                    <p>Lorem ipsum dolor sit amet...</p>
                                    <div class="right-star"><i class="fa fa-star-o"></i>Me interesa</div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="our-product section-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-product-title text-left">
                    <h2>Tambien te podria interesar</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-title">Ingenieria Mecanica</p>
                    <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-title">en alimentos</p>
                    <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-card-item mt-40">
                    <p class="product-title">Mercades</p>
                    <p>Lorem ipsum dolor sit amet, c set diam no-nummy nibh euismod tincidunt ut.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
