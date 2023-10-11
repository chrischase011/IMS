@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://wallpapercave.com/wp/wp3702587.jpg");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }

        .pic-ctn {
            /* width: 80vw;
            height: 80px; */

        }

        .pic-ctn {
            position: relative;
            width: 100%;
            height: 60px;
            /* margin-top: 1vh; */
        }

        .pic-ctn>img {
            position: absolute;
            top: -350%;
            left:-100px;
            opacity: 0;
            animation: dissolve 10s ease infinite;
            height: 450px;
            width: 450px;
            /* margin-top: -390px; */
            border-radius: 50% 50% 0 0;
            transform: rotate(90deg);
        }

        @keyframes dissolve {

            0%,
            100% {
                transform: translateX(200px);
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        img:nth-child(2) {
            animation-delay: 2s;
        }

        img:nth-child(3) {
            animation-delay: 4s;
        }

        img:nth-child(4) {
            animation-delay: 6s;
        }

        img:nth-child(5) {
            animation-delay: 8s;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex flex-row align-items-center">
                <div class="waviy">
                    <span style="--i:1">W</span>
                    <span style="--i:2">E</span>
                    <span style="--i:3">L</span>
                    <span style="--i:4">C</span>
                    <span style="--i:5">O</span>
                    <span style="--i:6">M</span>
                    <span style="--i:7">E</span>
                    <span style="--i:8"> </span>
                    <span style="--i:9">T</span>
                    <span style="--i:10">O</span>
                    <br />
                </div>

                <img src="{{ URL::asset('assets/images/image-removebg-preview (14).png') }}" alt=""
                    class="img-logo">
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-7">
                        <p class="h2 title1">Century Cardboard Box Factory & Printing Inc.</p>
                    </div>
                    <div class="col-5">
                        <div class="pic-ctn">
                            <img src="https://smmarkets.ph/media/catalog/product/2/0/20532583_decs_assorted_2pcs_pork_shrimp_siomai_2pcs_hakaw_2pcs_sharksfin_6pcs.jpg?optimize=low&bg-color=255,255,255&fit=bounds&height=&width="
                                alt="" class="pic">
                            <img src="https://fiverr-res.cloudinary.com/images/q_auto,f_auto/gigs/319489656/original/ef60a5e7b8b47a1a20e48cd6f082ab634d9a0cce/creative-unique-pizza-box-design-for-your-restaurant-with-high-product-packaging.png"
                                alt="" class="pic">
                            <img src="https://ilovetaguig.files.wordpress.com/2012/01/tipas-hopia_3.jpg" alt=""
                                class="pic">
                            <img src="https://img.ws.mms.shopee.ph/c817072747d990b0317060a43b4a5f8c" alt=""
                                class="pic">
                            <img src="https://megaqmart.com/cdn/shop/products/800000000002_d64197a5-3b1b-45f9-bb00-96f1508e126b_800x.png?v=1645603028"
                                alt="" class="pic">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
