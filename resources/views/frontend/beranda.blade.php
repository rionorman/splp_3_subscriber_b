@extends('layouts.app')

@section('title')
Beranda
@endsection

@section('content')
<div class="container">
  <h1>Beranda</h1>
  <hr>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    @php ($no = 1)
    @foreach ($rows as $row)
    <div class="col">
      <div class="card h-100">
        <img src="{{ $row->image }}" height="240" class="card-img-top" alt="...">
        <div class="card-body">
          {{ formatTanggal($row->updated_at) }} - {{ $row->username->name }}
          <p>
            <b> {{$row->category->category}}</b> -
            <a class="link-success link-underline-opacity-25" href="{{asset('/detail').'/'.$row->id }}">
              <b class="card-title">{{ $row->title }}</b></a>
          </p>
        </div>
      </div>
    </div>
    @endforeach
  </div>

</div>
@endsection