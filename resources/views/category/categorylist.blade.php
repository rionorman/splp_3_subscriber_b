@extends('layouts.app')

@section('title')
Data Category 
@endsection

@section('content')
<div class="container">
  <div class="card">
    <h5 class="card-header"> Data Category</h5>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover ">
          <thead class="thead-dark">
            <tr>
              <th width="40">No</th>
              <th>Category</th>
              <!-- <th>Created_at</th> -->
              <!-- <th>Updated_at</th> -->
              <th width="90" class="text-center"><a href="{{asset('/')}}category/create"> <i class="fas fa-plus"></i></a></th>
            </tr>
          </thead>
          <tbody>
            @php ($no = 1)
            @foreach ($rows as $row)
            <tr>
              <td>{{ $no++ }}.</td>
              <td>{{ $row['category'] }}</td>
              <!-- <td>{{ $row['created_at'] }}</td> -->
              <!-- <td>{{ $row['updated_at'] }}</td> -->
              <td class="text-center">
                <a href="{{asset('/')}}category/{{ $row->id }}"><i class="fas fa-info-circle"></i></a>
                <a href="{{asset('/')}}category/{{ $row->id }}/edit"><i class="far fa-edit"></i></a>
                <a href="{{asset('/')}}category/{{ $row->id }}/delete"><i class="far fa-trash-alt"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection