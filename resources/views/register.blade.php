@extends('layout.main')
@section('title', "AFLIX | Register")
@section('container')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-3">
            <div class="card-body">
                <h1 class="text-center">Halaman Registrasi</h1>
                <form action="/register" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control border border-dark" name="username" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control border border-dark" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Konfirmasi password</label>
                        <input type="password" class="form-control border border-dark" name="password2" id="password2">
                    </div>
                    <button type="submit" class="btn btn-primary">Registrasi</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <p class="mt-3">Sudah Login? Segeralah Lakukan <a href="/login">Login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection