<x-layout>
    <div class="container py-md-5 ">
        <div class="">

            @unless($posts->isEmpty())
                <h2>All latest the latest post</h2>
                <div class="row pt-5">
                    @foreach($posts as $post)
                        <div class="col-md-6 col-lg-4 pb-3">
                            <div class="card card-custom bg-white border-white border-0">
                                <div class="card-custom-img"
                                     style="background-image: url('http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg');"></div>
                                <div class="card-custom-avatar">
                                    <img class="img-fluid"
                                         src="{{$post->user->avatar}}"
                                         alt="Avatar"/>
                                </div>
                                <div class="card-body" style="overflow-y: auto">
                                    <h4 class="card-title">{{$post->title}}</h4>
                                    <p class="card-text">{!! Str::limit($post->body, 100, ' ...') !!}
                                    </p>
                                   on {{$post->created_at->format('j/n/Y')}}
                                </div>
                                <div class="card-footer" style="background: inherit; border-color: inherit;">
                                    <a href="/post/{{$post->id}}" class="btn btn-primary rounded-0">Read More</a>
                                    <a href="{{route('profile',$post->user->username)}}" class="btn btn-outline-primary rounded-0">View Profile</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{$posts->links()}}
                </div>
            @else
                <h2>Hello <strong>{{auth()->user()->username}}</strong>, your feed is empty.</h2>
                <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don't
                    have
                    any friends to follow that's okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar
                    to
                    find content written by people with similar interests and then follow them.</p>
            @endunless


        </div>
    </div>
</x-layout>

