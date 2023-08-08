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
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    ค่าส่วนกลาง
                </div>
                <div class="card-body">
                    
                    <br>
                    @component('compronents.Modal.addfeetype')
                    @endcomponent
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">ราคา</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fee as $item)
                            <tr>
                                <th scope="row">{{$item->name}}</th>
                                <td>{{$item->price_unit}}</td>
                                <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#Modaleditf{{$item->id}}">
                                        Edit
                                    </button>
                                    <div class="modal fade" id="Modaleditf{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('/updatefeetype/'.$item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group my-2">
                                                                    <strong>Name:</strong>
                                                                    <input type="text" name="name" class="form-control" value={{$item->name}}
                                                                        placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-2">
                                                                    <strong>Price/Unit:</strong>
                                                                    <input type="number" name="price_unit" value={{$item->price_unit}}
                                                                        class="form-control" placeholder="Price/Unit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-outline-secondary">Submit</button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#Modaldeletef{{$item->id}}">
                                            Delete
                                        </button>
                                        <div class="modal fade" id="Modaldeletef{{$item->id}}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{url('/destroyfee/'.$item->id)}}" method="GET"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            Are you sure you want to delete
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    ประเภทมิเตอร์
                </div>
                <div class="card-body"> 
                    <br>
                    @component('compronents.Modal.modelcreatemttype')
                    @endcomponent
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">ราคา</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meter_type as $item)
                            <tr>
                                <th scope="row">{{$item->name}}</th>
                                <td>{{$item->price_unit}}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#Modaleditmt{{$item->id}}">
                                        Edit
                                    </button>
                                    <div class="modal fade" id="Modaleditmt{{$item->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('/updatemetertype/'.$item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group my-2">
                                                                    <strong>Name:</strong>
                                                                    <input type="text" name="name" class="form-control" value={{$item->name}}
                                                                        placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-2">
                                                                    <strong>Price/Unit:</strong>
                                                                    <input type="number" name="price_unit" value={{$item->price_unit}}
                                                                        class="form-control" placeholder="Price/Unit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-outline-secondary">Submit</button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#Modaldeletemt{{$item->id}}">
                                            Delete
                                        </button>
                                        <div class="modal fade" id="Modaldeletemt{{$item->id}}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{url('/destroymt/'.$item->id)}}" method="GET"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            Are you sure you want to delete
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
