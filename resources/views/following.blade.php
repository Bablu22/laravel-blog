<x-posts :sharedData="$sharedData" doctitle="Who {{$sharedData['username']}} Follows">
    <div class="list-group">
        @foreach($following as $follow)
            <a href="{{route('profile',$follow->userBeingFollowed->username)}}"
               class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{$follow->userBeingFollowed->avatar}}"
                     alt=""/>
                <strong>{{$follow->userBeingFollowed->username}}</strong>
            </a>
        @endforeach
    </div>
</x-posts>
