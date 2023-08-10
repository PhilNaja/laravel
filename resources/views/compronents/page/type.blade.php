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
        <div class="card">
            <div class="card-body">
                <form action="{{url('/addtype')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Name</label>
                            <input type="text" class="form-control" id="inputCity" name="name">
                        </div>
                        <div class="col-md-4">
                            <label for="inputState" class="form-label">Type</label>
                            <select id="inputState" class="form-select" name="type">
                                <option selected>Choose</option>
                                <option value="1">ค่าส่วนกลาง</option>
                                <option value="2">ประเภทมิเตอร์</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="inputPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="inputPrice" name="price_unit">
                        </div>
                        <div class="container mt-3">
                            <div class="row text-center">
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-primary">
                                        {{ __('SUBMIT') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-sm">
            <div class="card mb-3">
                <div class="card-header">
                    ค่าส่วนกลาง
                </div>
                <div class="card-body">
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
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#Modaleditf{{$item->id}}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#Modaldeletef{{$item->id}}">
                                            Delete
                                        </button>
                                    </div>
                                    <!-- Modaleditf -->
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
                                                                    <input type="text" name="name" class="form-control"
                                                                        value={{$item->name}} placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-2">
                                                                    <strong>Price/Unit:</strong>
                                                                    <input type="number" name="price_unit"
                                                                        value={{$item->price_unit}} class="form-control"
                                                                        placeholder="Price/Unit">
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

                                    <!-- Modaldeletef -->
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
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#Modaleditmt{{$item->id}}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#Modaldeletemt{{$item->id}}">
                                            Delete
                                        </button>
                                    </div>
                                    <!-- #Modaleditmt -->
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
                                                                    <input type="text" name="name" class="form-control"
                                                                        value={{$item->name}} placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group my-2">
                                                                    <strong>Price/Unit:</strong>
                                                                    <input type="number" name="price_unit"
                                                                        value={{$item->price_unit}} class="form-control"
                                                                        placeholder="Price/Unit">
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
                                    <!-- Modaldeletemt -->
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
</div>

@endsection
