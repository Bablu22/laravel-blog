<x-layout doctitle="Editing {{$post->title}}">
    <div class="container py-md-5 container--narrow">
        <a href="{{route('post.show',$post->id)}}">Back to the post </a>
        <form action="{{route('post.update',$post->id)}}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
                <input required
                       name="title"
                       id="post-title"
                       class="form-control form-control-lg form-control-title"
                       type="text"
                       placeholder=""
                       autocomplete="off"
                       value="{{old('title',$post->title)}}"
                />
            </div>

            <div class="form-group">
                <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
                <textarea required
                          name="body"
                          id="post-body"

                          class="body-content tall-textarea form-control">
                    {{old('body',$post->body)}}
                </textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</x-layout>

