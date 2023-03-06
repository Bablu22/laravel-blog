<x-layout doctitle="Manage avatar">
    <div class="container container--narrow py-md-5">
        <h2 class="text-center mb-3">Upload a new avatar</h2>

        <form action="{{route('avatar.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="avatar" class="text-muted mb-1"><small>Upload your avatar</small></label>
                <input value="{{old('avatar')}}" name="avatar"
                       id="avatar"
                       class="form-control"
                       type="file"
                       placeholder="Upload your avatar"/>
                @error('avatar')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
            <button type="submit" class="py-2 mt-4 btn btn-sm btn-success btn-block">Save</button>
        </form>
    </div>
</x-layout>


