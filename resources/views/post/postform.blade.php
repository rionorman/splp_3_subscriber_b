@extends('layouts.app')

@section('title')
Data Post 
@endsection

@section('content')
<div class="container">
  <script>
    function button_cancel() {
      location.replace("{{ asset('/') }}post");
    }
  </script>
  <div class="card">
    <h5 class="card-header"> Data Post</h5>
    <div class="card-body">
      @if($action == 'insert')
      <form class="form-horizontal" action="{{ asset('/') }}post" method="post" enctype="multipart/form-data">
        <!-- <div class="mb-3 row">
          <label for="id" class="col-sm-2 col-form-label">Id</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="id" value="">
          </div>
        </div> -->
        <!-- <div class="mb-3 row">
          <label for="user_id" class="col-sm-2 col-form-label">User_id</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="user_id" value="">
          </div>
        </div> -->
        <div class="mb-3 row">
          <label for="cat_id" class="col-sm-2 col-form-label">Category</label>
          <div class="col-sm-10">
            <!-- <input class="form-control" type="text" name="cat_id" value=""> -->
            {!! selectForm($categories,'id','category','cat_id','') !!}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="title" class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="content" class="col-sm-2 col-form-label">Content</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="content" id="content" rows="7"></textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="image" class="col-sm-2 col-form-label">Image</label>
          <div class="col-sm-10">
            <input class="form-control" type="file" name="image" value="">
          </div>
        </div>
        <!-- <div class="mb-3 row">
          <label for="created_at" class="col-sm-2 col-form-label">Created_at</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="created_at" value="">
          </div>
        </div> -->
        <!-- <div class="mb-3 row">
          <label for="updated_at" class="col-sm-2 col-form-label">Updated_at</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="updated_at" value="">
          </div>
        </div> -->
        <div class="mb-3">
          <div class="offset-sm-2 col-sm-10">
            <input type="hidden" name="action" value="{{ $action }}">
            <button type="submit" class="btn btn-primary">Insert</button>
            <button type="button" class="btn btn-secondary" onclick="button_cancel()">Cancel</button>
          </div>
        </div>
        {{ csrf_field() }}
      </form>
      @elseif($action == 'update')
      <form class="form-horizontal" action="{{ asset('/') }}post/{{ $row->id }}" method="post" enctype="multipart/form-data">
        <!-- <div class="mb-3 row">
          <label for="id" class="col-sm-2 col-form-label">Id</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="id" value="{{ $row->id }}">
          </div>
        </div> -->
        <!-- <div class="mb-3 row">
          <label for="user_id" class="col-sm-2 col-form-label">User_id</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="user_id" value="{{ $row->user_id }}">
          </div>
        </div> -->
        <div class="mb-3 row">
          <label for="cat_id" class="col-sm-2 col-form-label">Category</label>
          <div class="col-sm-10">
            {!! selectForm($categories,'id','category','cat_id', $row->cat_id) !!}

          </div>
        </div>
        <div class="mb-3 row">
          <label for="title" class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="{{ $row->title }}">
          </div>
        </div>
        <div class="mb-3 row">
          <label for="content" class="col-sm-2 col-form-label">Content</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="content" id="content" rows="7">{{ $row->content }}</textarea>
          </div>
        </div>
        <div class="mb-3 row">
          <label for="image" class="col-sm-2 col-form-label">Image</label>
          <div class="col-sm-10">
            <input class="form-control" type="file" name="image" value="{{ $row->image }}">
          </div>
        </div>
        <!-- <div class="mb-3 row">
          <label for="created_at" class="col-sm-2 col-form-label">Created_at</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="created_at" value="{{ $row->created_at }}">
          </div>
        </div> -->
        <!-- <div class="mb-3 row">
          <label for="updated_at" class="col-sm-2 col-form-label">Updated_at</label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="updated_at" value="{{ $row->updated_at }}">
          </div>
        </div> -->
        <div class="mb-3 row">
          <div class="offset-sm-2 col-sm-10">
            @method("PATCH")
            <input type="hidden" name="action" value="{{ $action }}">
            <input type="hidden" name="id" value="{{ $row->id }}">
            <button type="submit" class="btn btn-warning">Update</button>
            <button type="button" class="btn btn-secondary" onclick="button_cancel()">Cancel</button>
          </div>
        </div>
        {{ csrf_field() }}
      </form>
      @elseif($action == 'delete')
      <form class="form-horizontal" action="{{ asset('/') }}post/{{ $row->id }}" method="post">
        <div class="mb-3 row">
          <label for="id" class="col-sm-2 control-label">Id</label>
          <div class="col-sm-10">
            {{ $row->id }}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="user_id" class="col-sm-2 control-label">User_id</label>
          <div class="col-sm-10">
            {{ $row->user_id }}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="cat_id" class="col-sm-2 control-label">Category</label>
          <div class="col-sm-10">
            {{ $row->cat_id }}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="title" class="col-sm-2 control-label">Title</label>
          <div class="col-sm-10">
            {{ $row->title }}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="content" class="col-sm-2 control-label">Content</label>
          <div class="col-sm-10">
            {{ $row->content }}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="image" class="col-sm-2 control-label">Image</label>
          <div class="col-sm-10">
            {{ $row->image }}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="created_at" class="col-sm-2 control-label">Created_at</label>
          <div class="col-sm-10">
            {{ $row->created_at }}
          </div>
        </div>
        <div class="mb-3 row">
          <label for="updated_at" class="col-sm-2 control-label">Updated_at</label>
          <div class="col-sm-10">
            {{ $row->updated_at }}
          </div>
        </div>
        <div class="mb-3 row">
          <div class="offset-sm-2 col-sm-10">
            @method("DELETE")
            <input type="hidden" name="action" value="{{ $action }}">
            <input type="hidden" name="id" value="{{ $row->id }}">
            <button type="submit" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-secondary" onclick="button_cancel()">Cancel</button>
          </div>
        </div>
        {{ csrf_field() }}
      </form>
      @elseif($action == 'detail')
      <div class="mb-3 row">
        <label for="id" class="col-sm-2 control-label">Id</label>
        <div class="col-sm-10">
          {{ $row->id }}
        </div>
      </div>
      <div class="mb-3 row">
        <label for="user_id" class="col-sm-2 control-label">User_id</label>
        <div class="col-sm-10">
          {{ $row->user_id }}
        </div>
      </div>
      <div class="mb-3 row">
        <label for="cat_id" class="col-sm-2 control-label">Category</label>
        <div class="col-sm-10">
          {{ $row->cat_id }}
        </div>
      </div>
      <div class="mb-3 row">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
          {{ $row->title }}
        </div>
      </div>
      <div class="mb-3 row">
        <label for="content" class="col-sm-2 control-label">Content</label>
        <div class="col-sm-10">
          {{ $row->content }}
        </div>
      </div>
      <div class="mb-3 row">
        <label for="image" class="col-sm-2 control-label">Image</label>
        <div class="col-sm-10">
          {{ $row->image }}
        </div>
      </div>
      <div class="mb-3 row">
        <label for="created_at" class="col-sm-2 control-label">Created_at</label>
        <div class="col-sm-10">
          {{ $row->created_at }}
        </div>
      </div>
      <div class="mb-3 row">
        <label for="updated_at" class="col-sm-2 control-label">Updated_at</label>
        <div class="col-sm-10">
          {{ $row->updated_at }}
        </div>
      </div>
      <div class="mb-3 row">
        <div class="offset-sm-2 col-sm-10">
          <button type="button" class="btn btn-secondary" onclick="button_cancel()">Back</button>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection