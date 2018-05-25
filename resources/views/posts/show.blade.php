@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>{{$post->title}}</h2>
            <p>{{$post->description}}</p>
            <small>{{$post->created_at->diffForHumans()}}</small>
        </div>
    </div>
@endsection
