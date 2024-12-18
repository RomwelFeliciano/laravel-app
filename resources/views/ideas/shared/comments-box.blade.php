<div class="mt-2">
    <form action="{{ route('ideas.commentstore', $idea->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <textarea class="fs-6 form-control" name="content" rows="1"></textarea>
            @error('content')
            <span class="fs-6 text-danger mt-2 d-block">{{ $message }}</span>
        @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-sm"> Post Comment </button>
        </div>
    </form>

    @forelse($idea->comments as $comment)
        <hr>
        <div class="d-flex align-items-start">
            <img style="width:35px" class="me-2 avatar-sm rounded-circle" src="{{ $comment->user->getImageUrl() }}"
                alt="{{ $comment->user->name }}">
            <div class="w-100">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">{{ $comment->user->name }}
                    </h6>
                    <small class="fs-6 fw-light text-muted"> {{ $comment->created_at->diffForHumans() }}</small>
                </div>
                <p class="fs-6 mt-3 fw-light">
                    {{ $comment->content }}
                </p>
            </div>
        </div>
    @empty
        <hr>
        <p class="text-center mt-4">No comments Found.</p>
    @endforelse
</div>
