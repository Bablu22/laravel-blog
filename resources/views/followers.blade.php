<x-posts :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Followers">
    <div class="list-group">
        @foreach($followers as $follow)
            <a href="{{route('profile',$follow->userDoingFollowing->username)}}"
               class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{$follow->userDoingFollowing->avatar}}"
                     alt=""/>
                <strong>{{$follow->userDoingFollowing->username}}</strong>
            </a>
        @endforeach
    </div>
</x-posts>


