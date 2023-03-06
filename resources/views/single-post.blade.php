<x-layout :doctitle="$post->title">
    <div class="container py-md-5 container--narrow">
        <div class="d-flex justify-content-between">
            <h2>{{$post->title}}</h2>
            @can('update',$post)
                <span class="pt-2">
          <a href="{{route('post.edit',$post->id)}}" class="text-primary mr-2" data-toggle="tooltip"
             data-placement="top" title="Edit">
              <i class="fas fa-edit"></i>
          </a>
          <form class="delete-post-form d-inline" action="{{route('post.delete',$post->id)}}" method="POST">
              @csrf
              @method('DELETE')
            <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
          </form>
        </span>
            @endcan
        </div>
        <p class="text-muted small mb-4">
            <a href="#">
                <img class="avatar-tiny" src="{{$post->user->avatar}}"
                     alt=""/></a>
            Posted by <a href="{{route('profile',$post->user->username)}}">{{$post->user->username}}</a>
            on {{$post->created_at->format('j/n/Y')}}
        </p>
        <div class="body-content">
            <p>{!! $post->body!!}</p>
        </div>
    </div>
</x-layout>

