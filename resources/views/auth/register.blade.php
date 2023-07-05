@extends('layouts.main')
@section('title','Contact App | Register')
@section('content')
<div class="col-md-4 m-auto mt-5">
    <div class="shadow-sm">
        <h1 class="border-bottom p-4">Register</h1>
        <div class="px-4 pt-4">
            <form action="{{route('register')}}" method="POST">
                @csrf
                @include('auth._form_register')
            </form>
        </div>
    </div>
</div>
@endsection