@extends('layouts.app')
@section('content')

<div class="container-md h-100">
        <div class="row h-100">
            <div class="col-md-8 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                    <h1 class='mt-2 mb-5 ms-5'style="font-size: 2rem;">จำนวนเงินที่ต้องได้รับ</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 4.5rem;">{{$billamount}}</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 1rem;">จ่ายแล้ว {{$billispaid}} บาท</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 1rem;">ยังไม่จ่าย {{$billnotpaid}} บาท</h1>

                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h1 class='mt-2 mb-5 ms-3'style="font-size: 2rem;">จำนวนบิลทั้งหมด</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">{{$allbill}}</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 1rem;">จ่ายแล้ว {{$ispaid}} บิล</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 1rem;">ยังไม่จ่าย {{$notpaid}} บิล</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row h-100 mb-5">
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                    <h1 class='mt-2 mb-5 ms-3'style="font-size: 2rem;">ยอดหนี้คงค้าง</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">{{$debt}}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                    <h1 class='mt-2 mb-5 ms-3'style="font-size: 2rem;">ยอดหนี้ค่าส่วนกลาง</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">{{$feetotal}}</h1>

                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                    <h1 class='mt-2 mb-5 ms-3'style="font-size: 2rem;">ยอดหนี้จากมิเตอร์ต่างๆ</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">{{$metre}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


