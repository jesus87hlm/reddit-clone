@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        <div class="row">
            <div class="col-md-12">
                <h2><a href="{{ route('post_path', ['post_id'=>$post->id]) }}">{{$post->title}}</a></h2>
                <small>Posted {{$post->created_at->diffForHumans()}}</small>
            </div>
        </div>
        <hr>
    @endforeach

    {{$posts->render()}}
@endsection