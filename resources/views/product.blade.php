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

        .p-img {
            width: 100%;
            max-height: 450px;
        }
    </style>

    <div class="container">
        <div id="hopia" class="{{ $id == 1 ? '' : 'd-none' }}">
            <div class="row justify-content-center">
                <h3 class="h2 title2">Hopia Box</h3>
                <div class="col-8">
                    <img src="{{ URL::asset('assets/images/hopia.png') }}" alt="" class="p-img">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-8">
                    <p class="paragraph1 text-white">Century Company is a trusted supplier of premium hopia boxes in a range
                        of sizes to perfectly accommodate your delectable treats. We offer three standard sizes: 6 1/4 x 6
                        1/4 x 2 1/2, 7 x 5 3/8 x 2, and 5 3/8 x 4 1/2 x 2 1/2. Our hopia boxes are crafted from sturdy
                        corrugated cardboard, ensuring your hopias remain fresh and protected. We also provide custom
                        printing options to elevate your brand and showcase your delicious creations.</p>
                </div>
            </div>
        </div>

        <div id="pizza" class="{{ $id == 2 ? '' : 'd-none' }}">
            <div class="row justify-content-center">
                <h3 class="h2 title2">Pizza Box</h3>
                <div class="col-8">
                    <img src="{{ URL::asset('assets/images/pizza.png') }}" alt="" class="p-img">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-8">
                    <p class="paragraph1 text-white">Century Company is a leading provider of high-quality pizza boxes in a
                        variety of sizes to meet the needs of our customers. We offer three standard sizes of pizza boxes:
                        10 x 10 x 1 1/2, 12 x 12 x 1 1/2, and 14 x 14 x 1 3/4. Our pizza boxes are made from durable
                        corrugated cardboard and are designed to keep your pizzas fresh and hot. We also offer custom
                        printing options to help you promote your brand.</p>
                </div>
            </div>
        </div>

        <div id="eggpie" class="{{ $id == 3 ? '' : 'd-none' }}">
            <div class="row justify-content-center">
                <h3 class="h2 title2">Egg Pie Box</h3>
                <div class="col-8">
                    <img src="{{ URL::asset('assets/images/eggpie.png') }}" alt="" class="p-img">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-8">
                    <p class="paragraph1 text-white">Century Company proudly presents our exceptional egg pie boxes,
                        available in a standard size of 9 x 9 x 1 3/4. These boxes are meticulously crafted from
                        high-quality corrugated cardboard, ensuring your delectable egg pies remain protected and retain
                        their freshness. Our egg pie boxes are designed to accommodate various pie sizes and depths, making
                        them versatile for your baking needs. We also offer custom printing options to personalize your
                        packaging and enhance your brand visibility.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
