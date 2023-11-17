@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("{{ URL::asset('assets/images/bg.jpg') }}");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
            overflow-y: auto;
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
            left: -100px;
            opacity: 0;
            animation: dissolve 2s ease-in-out;
            height: 450px;
            width: 450px;
            /* margin-top: -390px; */
            border-radius: 50% 50% 0 0;

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

            25% {
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
            animation-delay: 9s;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-7 order-2 order-md-1 d-flex flex-row align-items-center">
                <div class="waviy text-center order">
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
                    class="img-logo d-none d-md-flex">
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2 d-flex justify-content-center align-items-center">

                <img src="{{ URL::asset('assets/images/image-removebg-preview (14).png') }}" alt=""
                    class="img-logo d-block d-md-none">
            </div>

            <div class="col-12 order-3 order-md-3">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <p class="h2 title1">Century Cardboard Box Factory & Printing Inc.</p>
                    </div>
                    <div class="col-5 d-none d-md-block">
                        <div class="pic-ctn">
                            <img src="{{ URL::asset('assets/images/image-removebg-preview (19).png') }}" alt=""
                                class="pic">

                            <img src="{{ URL::asset('assets/images/image-removebg-preview (23).png') }}" alt=""
                                class="pic">
                            <img src="{{ URL::asset('assets/images/image-removebg-preview (24).png') }}" alt=""
                                class="pic">
                            <img src="{{ URL::asset('assets/images/image-removebg-preview (21).png') }}" alt=""
                                class="pic">

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <style>
            .card-img-top:hover {
                transition: .5s ease-in;
                transform: scale(1.05);
            }
        </style>
        <div class="row my-5 p-3">
            <h3 class="title2 fw-bold text-orange">Featured Products</h3>
            <div class="col-4">
                <div class="card bg-transparent">
                    <img src="{{ URL::asset('assets/images/hopia.png') }}" alt="" class="card-img-top">
                    <div class="card-body">
                        <h4 class="h4 card-title text-orange text-center">Hopia Box</h4>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-transparent">
                    <img src="{{ URL::asset('assets/images/pizza.png') }}" alt="" class="card-img-top">
                    <div class="card-body">
                        <h4 class="h4 card-title text-orange text-center">Pizza Box</h4>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-transparent">
                    <img src="{{ URL::asset('assets/images/eggpie.png') }}" alt="" class="card-img-top">
                    <div class="card-body">
                        <h4 class="h4 card-title text-orange text-center">Egg Pie Box</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3 p-3">
            <h3 class="title2 fw-bold text-orange">About Us</h3>
            <div class="col-12">
                <p class="paragraph1 text-white fst-italic">
                    Starting in 1981, Century Cardboard Box Factory & Printing Inc. is a
                    successful business that has been in operation for over four (4) decades and its founder is Hun-Yu
                    Tong.<br><br>

                    The company has been producing paperboard boxes for
                    the past four decades. The company's rapid growth and success are a result of its
                    ability to promptly meet the needs of its loyal customers, with over 10000
                    cardboard boxes (average sales) of different dimensions sold every day or roughly
                    60000 cardboard boxes in a week, this concludes that business is indeed garnering
                    enough sales.<br><br>

                    The company is investing in cutting-edge conversion equipment to
                    provide its customers with consistent and affordable packaging solutions, enabling
                    it to preserve its position as a preemptive provider in the markets it serves.<br><br>

                    There were existing Filipino-Chinese Company owners who were
                    receptive to Century Cardboard Box Factory, Inc. From that point on, the
                    organization is able to adapt to the local sector and eventually partner with
                    Filipino-owned businesses.<br><br>

                    Century Cardboard Box Factory & Printing Inc.
                    sources its raw materials from paper mills.<br><br>

                    Transforming the papers into
                    paperboard at the company's factory on Grace Park West, Caloocan, Metro Manila 6th Avenue. Once the
                    paperboard is done manufacturing, the cutting process
                    begins based on customer orders. When the required cardboard boxes are
                    completed, they are sent to the company's branch at 74 3rd St., 8th Ave. 109 Caloocan City Metro Manila
                    for additional polishing and application of the client's printing paper brand.<br><br>

                    The company has a loyal workforce that has been with the
                    company for over a decade. The average number of active employees in a day is
                    16, most of whom have been with the company for over 10 years.<br><br>

                    The company's production process is manual, which can be time-consuming and labor-intensive.
                    The dedication of the company’s loyal workforce is producing a high-quality cardboard boxes that meet
                    the needs of its customers<br><br>
                </p>
            </div>
        </div>

        <div class="row my-3 p-3">
            <h3 class="title2 text-orange">Our Location</h3>
            <div class="col-12">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3789.7489282382053!2d120.98903787917446!3d14.64937764933932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b67de5ac9b41%3A0x1635bebe14eb3d77!2sCentury%20Cardboard%20Box%20Factory%20%26%20Printing%20Inc.!5e1!3m2!1sen!2sph!4v1700015722711!5m2!1sen!2sph"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="row mt-3 mb-5 p-3">
            <h3 class="title2 text-orange">Contact Us</h3>
            <div class="col-12 text-white text-center">
                <p class="paragraph1">You may contact us through the following:</p>
                <label class=""><i class="fa fa-phone me-1"></i> +639 12345 6789</label><br>
                <label class=""><i class="fa fa-envelope me-1"></i> <a href="mailto:centurycardboard@gmail.com"
                        class="text-white text-decoration-none">centurycardboard@gmail.com</a></label><br>
                <label class=""><i class="fa-brands fa-facebook me-1"></i> <a
                        href="https://www.facebook.com/profile.php?id=61552260894658"
                        class="text-white text-decoration-none">Century Cardboard Box Factory & Printing Inc.</a>
            </div>
        </div>

    </div>
@endsection
