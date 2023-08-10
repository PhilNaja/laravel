@extends('layouts.app')
@section('content')
<div class="container-md h-100">
<div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
                        <form class="row g-3" action="{{url('filterhome')}}" method="GET" enctype="multipart/form-data">
                            <div class="col-auto">
                                <select class="form-select" aria-label="Default select example" name="mount">
                                    <option selected value={{Request::get("mount")?? date("m")}}>{{Request::get("mount")?? date("m")}}</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" aria-label="Default select example" name="year">
                                    <option selected value="{{Request::get("year")?? date("Y")}}">{{Request::get("year")?? date("Y")}}</option>
                                    @php
                                    $currentYear = now()->year; // ปีปัจจุบัน
                                    $endYear = $currentYear - 15; // ปีที่ลงมา 15 ปี
                                    @endphp
                                    @for ($year = $currentYear; $year >= $endYear; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3">Filter</button>
                            </div>
                        </form>
                    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- <h4>Dashboard</h4> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body py-5">
                        <h2 class="card-title">จำนวนบ้าน</h2>
                        <h4 class="card-text">{{$house}}</h4>

                    </div>
                    <div class="card-footer d-flex">
                    <a href="/houselist" class="text-decoration-none text-dark">View Details</a>
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-dark h-100">
                    <div class="card-body py-5">
                        <h2 class="card-title">จำนวนบิล</h2>
                        <h4 class="card-text">{{$allbill}}</h4>
                    </div>
                    <div class="card-footer d-flex">
                    <a href="/bill" class="text-decoration-none text-dark">View Details</a>
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body py-5">
                        <h2 class="card-title">บิลที่ชำระแล้ว</h2>
                        <h4 class="card-text">{{$ispaid}}</h4>
                    </div>
                    <div class="card-footer d-flex">
                    <a href="/bill" class="text-decoration-none text-dark">View Details</a>
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body py-5">
                        <h2 class="card-title">บิลที่ยังไม่ชำระ</h2>
                        <h4 class="card-text">{{$notpaid}}</h4>
                    </div>
                    <div class="card-footer d-flex">
                    <a href="/bill" class="text-decoration-none text-dark">View Details</a>
                        <span class="ms-auto">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
                        Area Chart Example
                    </div>
                    <div class="card-body">
                    <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 4.5rem;">{{$billispaid}} บาท</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 1rem;">ยังไม่จ่าย {{$billnotpaid}}</h1>
                        <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 1rem;">รวม {{$billamount}}</h1>
                        <!-- <canvas class="chart" width="400" height="200"></canvas> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
                        Area Chart Example
                    </div>
                    <div class="card-body">

                    
                    @if($feetotal !=null)
                    <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">ค่าส่วนกลาง {{$feetotal}}
                </h1>
                @endif
                @if($feetotal ==null)
                    <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">ค่าส่วนกลาง 0
                </h1>
                @endif
                <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">ค่าน้ำ ค่าไฟ {{$metre}}
                <h1 class='mt-5 mb-5 me-5 d-flex justify-content-end align-items-end'style="font-size: 3rem;">ค่าปรับ {{$fine}}
                </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @endsection
