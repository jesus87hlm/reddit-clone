@if($post->exists)
    <form action="{{route('update_post_path',['post'=>$post->id])}}" method="POST">
        {{method_field('PUT')}}
@else
    <form action="{{route('store_post_path')}}" method="POST">
@endif
    {{csrf_field()}}
    <div class="row">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title"
               value="{{$post->title or old('title')}}"/>
    </div>
    <div class="row">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description"
                  rows="3">{{$post->description or old('description')}}</textarea>
    </div>
    <div class="row">
        <label for="url">Url</label>
        <input type="text" class="form-control" id="url" value="{{$post->url or old('url')}}" name="url"/>
    </div>
    <hr class="mb-4">
    <button class="btn btn-primary btn-lg btn-block" type="submit">Save post</button>
</form>