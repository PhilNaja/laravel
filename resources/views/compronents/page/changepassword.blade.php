@extends('layouts.app')

@section('content')
@if ($errors->any())
<div id="success-alert" class="alert alert-danger alert-dismissible fade show fixed-top w-25 mx-auto mt-5 text-center">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show fixed-top w-25 mx-auto mt-5 text-center">
    {{ session('success') }}
</div>
@endif
<script>
    function closeAlert() {
        document.getElementById('success-alert').style.display = 'none';
    }
    setTimeout(closeAlert, 3000);

</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change Password</div>

                <div class="card-body">
                    <form action="{{ route('password.action') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Password <span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="old_password" />
                        </div>
                        <div class="mb-3">
                            <label>New Password <span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="new_password" />
                        </div>
                        <div class="mb-3">
                            <label>New Password Confirmation<span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="new_password_confirmation" />
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary center">Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
