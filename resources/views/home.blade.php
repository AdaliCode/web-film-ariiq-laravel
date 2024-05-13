@extends('layout.main')
@section('title', "AFLIX")
@section('container')
@include('partials.coverHome', ["coverName" => "Film"])
<hr>
@include('partials.coverHome', ["coverName" => "Variety Show"])
{{-- <script src="<?= BASEURL; ?>/js/script.js"></script> --}}
@endsection