@extends('layouts.app')

@section('title')
Beranda
@endsection

@section('content')
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{asset('/beranda')}}">Beranda</a></li>
      <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
  </nav>
  <h1>{{ $row->title }}</h1>
  <b>{{ formatTanggal($row->updated_at) }} - {{ $row->username->name }}</b>
  <hr>
  <div class="row row-cols-1 row-cols-md-1 g-4">
    <div class="col">
      <div class="card h-100">
        <div class="card-body">

          <p>
            <img src="{{ $row->image }}" width="300" class="img-r10" alt="...">
            {!! nl2br($row->content) !!}
          </p>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection