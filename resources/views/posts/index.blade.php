@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
        <div class="row">
            <div class="col-md-12">
                <h2>
                    <a href="{{ route('post_path', ['post_id'=>$post->id]) }}">{{$post->title}}</a>
                    @if($post->wasCreatedBy(Auth::user()))
                        <small class="pull-right">
                            <a href="{{route('edit_post_path', ['post_id' => $post->id])}}" class="btn btn-info">Edit</a>

                            <form action="{{route('delete_post_path', ['post_id'=>$post->id])}}" method="POST">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}

                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </small>
                    @endif
                </h2>
                <small>Posted {{$post->created_at->diffForHumans()}} posted by {{$post->user->name}}</small>
            </div>
        </div>
        <hr>
    @endforeach

    {{$posts->render()}}
@endsection