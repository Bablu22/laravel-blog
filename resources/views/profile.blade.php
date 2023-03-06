<x-posts :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Profile">
    <div class="list-group">
        @foreach($posts as $post)
            <a href="/post/{{$post->id}}" class="list-group-item list-group-item-action mb-2">
                <img class="avatar-tiny" src="{{$post->user->avatar}}"
                     alt=""/>
                <strong>{{$post->title}}</strong> on {{$post->created_at->format('j/n/Y')}}
            </a>
        @endforeach
    </div>
</x-posts>
