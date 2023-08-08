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
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{url('/meter')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <strong>House Number:</strong>

                                    <select class="form-select" aria-label="Default select example" name="house_id">
                                        @foreach($houses as $item)
                                        <option value={{$item->id}}>{{$item->housenumber}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <strong>Type:</strong>
                                    <select class="form-select" aria-label="Default select example" name="meter_id">
                                        @foreach($type as $item)
                                        <option value={{$item->id}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group my-2">
                                        <strong>Unit:</strong>
                                        <input type="number" name="unit" class="form-control" placeholder="Price/Unit">
                                    </div>
                                </div>
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
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead  class="table-primary">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">ประเภท</th>
                                <th scope="col">ยูนิดปัจจุบัน</th>
                                <th scope="col">Status</th>
                                <th scope="col">อัพเดทล่าสุด</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($metre as $metre)
                            <tr>
                                <td>{{$metre->house_id}}</td>
                                <td>{{$metre->name}}</td>
                                <td>{{$metre->unit}}</td>
                                @if($metre->status==1)
                                <td>On</td>
                                @else
                                <td>off</td>
                                @endif
                                <td>{{$metre->updated_at}}</td>
                                <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#Modaledit{{$metre->id}}">
                                        Update
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#Modaldeletemetre{{$metre->id}}">
                                        Delete
                                    </button>
                                    @if($metre->status == '0')
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#Modalmetreon{{$metre->id}}">
                                        On
                                    </button>
                                    @endif
                                    @if($metre->status == '1')
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#Modalmetreoff{{$metre->id}}">
                                        Off
                                    </button>
                                    @endif
    </div>
                                    <!-- Modaledit -->
                                    <div class="modal fade" id="Modaledit{{$metre->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('/updatemeter/'.$metre->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group my-1">
                                                                    <strong>Unit:</strong>
                                                                    <input type="text" value="{{$metre->unit}}"
                                                                        name="unit" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-success mt-1">Submit</button>
                                                    </div>



                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- ModalDelete -->
                                    <div class="modal fade" id="Modaldeletemetre{{$metre->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/destroymetre')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to delete
                                                    </div>
                                                    <input type="hidden" name="id" value={{$metre->id}}>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- ModalOn -->
                                    <div class="modal fade" id="Modalmetreon{{$metre->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/metreon')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to off metre
                                                    </div>
                                                    <input type="hidden" name="id" value={{$metre->id}}>
                                                    <input type="hidden" name="status" value='off'>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">On metre</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!-- ModalOff -->
                                    <div class="modal fade" id="Modalmetreoff{{$metre->id}}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{url('/metreoff')}}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to on metre{{$metre->id}}
                                                    </div>
                                                    <input type="hidden" name="id" value={{$metre->id}}>
                                                    <input type="hidden" name="status" value='off'>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">off metre</button>
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
