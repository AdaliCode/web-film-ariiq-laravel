@extends('layout.main')
@section('title', "AFLIX | Login")
@section('container')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-3">
            <div class="card-body">
                <h1 class="text-center">Halaman Login</h1>
                <form action="/login" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control border border-dark" name="username" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control border border-dark" name="password" id="password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <p class="mt-3">Belum Login? <a href="register">Registrasi</a> atuh!</p>
            </div>
        </div>
    </div>
</div>
@endsection