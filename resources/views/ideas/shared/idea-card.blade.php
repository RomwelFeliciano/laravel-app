<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width:50px" class="me-2 avatar-sm rounded-circle" src="{{ $idea->user->getImageUrl() }}"
                    alt="{{ $idea->user->name }} Avatar">
                <div>
                    <h5 class="card-title mb-0"><a href="{{ route('users.show', $idea->user->id) }}">
                            {{ $idea->user->name }}
                        </a></h5>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('ideas.show', $idea->id) }}">View</a>
                @auth
                    @can('update', $idea)
                        <a href="{{ route('ideas.edit', $idea->id) }}" class="mx-2">Edit</a>
                        <form action="{{ route('ideas.destroy', $idea->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn ms-2 btn-danger btn-sm">&times;</button>
                        </form>
                    @endcan
                @endauth
            </div>
        </div>
    </div>
    <div class="card-body">
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
        @if ($idea->image)
            <div class="mb-4">
                <img src="{{ $idea->getImageUrl() }}" alt="" class="img-fluid">
            </div>
        @endif
        <hr>
        <div class="d-flex justify-content-between">
            @include('ideas.shared.like-button')
            <div>
                <span class="fs-6 fw-light text-muted"> <span class="fas fa-clock"> </span>
                    {{ $idea->created_at->diffForHumans() }} </span>
            </div>
        </div>
        @include('ideas.shared.comments-box')
    </div>
</div>
