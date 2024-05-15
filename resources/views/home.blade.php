@extends('layout.main')
@section('title', "AFLIX")
@section('container')
@foreach ($movieCollection as $key => $item)
    @include('partials.coverHome', ["coverName" => $key])
    <hr>
@endforeach
{{-- <script src="<?= BASEURL; ?>/js/script.js"></script> --}}
@endsection