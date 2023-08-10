@extends('layouts.app')
@section('content')
<div class="container col-md-12 ">
    @if ($errors->any())
    <div id="success-alert"
        class="alert alert-danger alert-dismissible fade show fixed-top w-25 mx-auto mt-5 text-center">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div id="success-alert"
        class="alert alert-success alert-dismissible fade show fixed-top w-25 mx-auto mt-5 text-center">
        {{ session('success') }}
    </div>
    @endif
    <script>
        function closeAlert() {
            document.getElementById('success-alert').style.display = 'none';
        }
        setTimeout(closeAlert, 3000);

    </script>
    <div class="row">
        <div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Modalbill">
                Create Bills
            </button>
            <div class="modal fade" id="Modalbill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{url('/addbill')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                Are you sure you want Create Bills
                                <input type="hidden" class="form-control"  name="id" value={{$houses}}>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
                    <form class="row g-3" action="{{url('filterbill')}}" method="GET" enctype="multipart/form-data">
                        <div class="col-auto">
                            <select class="form-select" aria-label="Default select example" name="mount">
                                <option selected value={{Request::get("mount")?? date("m")}}>
                                    {{Request::get("mount")?? date("m")}}</option>
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
                                <option selected value="{{Request::get("year")?? date("Y")}}">
                                    {{Request::get("year")?? date("Y")}}</option>
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
                            <button type="submit" class="btn btn-outline-primary mb-3">Filter</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class='table-primary'>
                            <tr>
                                <th>เลขที่บิล</th>
                                <th>รอบบิล</th>
                                <th>ที่ต้องชำระ</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </thead>
                        @if(isset($data[0]))
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->billingcycle}}</td>
                                <td>{{$item->amount}}</td>
                                <td>
                                    @if($item->status==0)
                                    ยังไม่ได้เผยแพร่
                                    @endif
                                    @if($item->status==1)
                                    เผยแพร่แล้ว
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a class='btn btn-outline-primary'
                                            href="{{ url('detail/'.$item->id) }}">รายละเอียด</a>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#fine{{$item->id}}">
                                            ค่าปรับ
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#Modaldelete{{$item->id}}">
                                            Delete
                                        </button>
                                        @if($item->status==0)
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#ststus{{$item->id}}">
                                            Publish
                                        </button>
                                        @endif
                                    </div>
                                    <!-- ModalFine -->
                                    <div class="modal fade" id="fine{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มค่าปรับ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{url('/fine/'.$item->id)}}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group my-3">
                                                                    <strong>Amount:</strong>
                                                                    <input type="number" value=0 name="amount"
                                                                        class="form-control" placeholder="Amount">
                                                                </div>
                                                            </div>
                                                        </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Modaldelete -->
                                    <div class="modal fade" id="Modaldelete{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/destroybill')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to delete
                                                    </div>
                                                    <input type="hidden" name="id" value={{$item->id}}>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ststusModal -->
                                    <div class="modal fade" id="ststus{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Publish</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('billstatus')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        หากคุผยแพร่ไปแล้วจะไม่สาราถลบหรือแก้ไขได้
                                                    </div>
                                                    <input type="hidden" name="id" value={{$item->id}}>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Publish</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
