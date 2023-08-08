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
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header">
                    เพิ่มบิล
                </div>
                <div class="card-body">
                    <form action="{{url('addbill')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            Are you sure you want to Crete Bill
                            <div class="row">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-1">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    บิล
                    <form action="{{url('filterbill')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <label>Date</lable>
                            <select class="form-select" aria-label="Default select example" name="date">
                                <option selected>Open this select menu</option>
                                @foreach($billingcycle as $item)
                                        <option value={{$item->billingcycle}}>{{$item->billingcycle}}</option>
                                        @endforeach 
                            </select>
                            <button type="submit"  class="btn btn-success mt-1">Submit</button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class='table-success'>
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
                                    <a class='btn btn-success' href="{{ url('detail/'.$item->id) }}">รายละเอียด</a>
                                    <button type="button" class="btn btn-primary ms-1" data-bs-toggle="modal"
                                        data-bs-target="#fine{{$item->id}}">
                                        ค่าปรับ
                                    </button>
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
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#Modaldelete{{$item->id}}">
                                        Delete
                                    </button>
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
                                    @if($item->status==0)
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#ststus{{$item->id}}">
                                        Publish
                                    </button>
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
                                    @endif
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
