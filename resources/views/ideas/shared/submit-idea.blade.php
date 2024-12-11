@auth
    <h4> Share yours ideas </h4>
    <div class="row">
        <form action="{{ route('ideas.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                @error('content')
                    <span class="fs-6 text-danger mt-2 d-block">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @error('image')
                    <span class="fs-6 text-danger mt-2 d-block">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-dark"> Share </button>
        </form>
    </div>
@endauth

@guest
    <h4> Login to share yours ideas </h4>
@endguest
