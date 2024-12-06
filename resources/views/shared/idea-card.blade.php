<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                    src="https://api.dicebear.com/6.x/fun-emoji/svg?seed={{ $idea->user->name }}"
                    alt="{{ $idea->user->name }} Avatar">
                <div>
                    <h5 class="card-title mb-0"><a href="#"> {{ $idea->user->name }}
                        </a></h5>
                </div>
            </div>
            <div>
                <form action="{{ route('ideas.destroy', $idea->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <a href="{{ route('ideas.show', $idea->id) }}">View</a>
                    @auth
                        @if (auth()->id() === $idea->user_id)
                            <a href="{{ route('ideas.edit', $idea->id) }}" class="mx-2">Edit</a>
                            <button class="btn ms-2 btn-danger btn-sm">&times;</button>
                        @endif
                    @endauth
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($idea->image)
            <div class="mb-4">
                <img src="{{ URL::to('/images') }}/{{ $idea->image }}" alt="" class="img-fluid">
            </div>
        @endif
        {{-- Editing Mode --}}
        @if ($editing ?? false)
            <form action="{{ route('ideas.update', $idea->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="mb-3">
                    <textarea class="form-control" id="content" name="content" rows="3">{{ $idea->content }}</textarea>
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
                <button type="submit" class="btn btn-dark mb-2 btn-sm"> Update </button>
            </form>
        @else
            <p class="fs-6 fw-light text-muted">
                {{ $idea->content }}
            </p>
        @endif
        <hr>
        <div class="d-flex justify-content-between">
            <div>
                <a href="#" class="fw-light nav-link fs-6"> <span class="fas fa-heart me-1">
                    </span> {{ $idea->likes }} </a>
            </div>
            <div>
                <span class="fs-6 fw-light text-muted"> <span class="fas fa-clock"> </span>
                    {{ $idea->created_at }} </span>
            </div>
        </div>
        @include('shared.comments-box')
    </div>
</div>
