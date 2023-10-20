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
                        <img src="{{ URL::asset('assets/images/image-removebg-preview (19).png') }}"  alt=""
                                class="pic">
                                <img src="{{ URL::asset('assets/images/image-removebg-preview (21).png') }}" 
                                alt="" class="pic">
                                <img src="{{ URL::asset('assets/images/image-removebg-preview (23).png') }}"  alt=""
                                class="pic">
                                <img src="{{ URL::asset('assets/images/image-removebg-preview (24).png') }}" 
                                alt="" class="pic">    
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
