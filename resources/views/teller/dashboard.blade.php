@extends('layouts.app')

@section('page-name', 'Dashboard Teller')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Selamat Datang, {{ Auth::user()->name }}</h4>
                <p>Anda login sebagai <strong>Teller</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection