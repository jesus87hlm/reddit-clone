@extends('layouts.app')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-12 order-md-1">
        <h4 class="mb-3">Edit Post</h4>
        <form action="{{route('update_post_path',['post'=>$post->id])}}" method="POST">
            {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="row">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}"/>
            </div>
            <div class="row">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{$post->description}}</textarea>
            </div>
            <div class="row">
                <label for="url">Url</label>
                <input type="text" class="form-control" id="url" value="{{$post->url}}" name="url"/>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Edit post</button>
        </form>
    </div>
@endsection