<div>
    <form action="{{ route('ideas.commentstore', $idea->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <textarea class="fs-6 form-control" name="content" rows="1"></textarea>
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-sm"> Post Comment </button>
        </div>
    </form>
    @foreach ($idea->comments as $comment)
        <hr>
        <div class="d-flex align-items-start">
            <img style="width:35px" class="me-2 avatar-sm rounded-circle"
                src="https://api.dicebear.com/6.x/fun-emoji/svg?seed={{ $comment->user->name }}"
                alt="{{ $comment->user->name }}">
            <div class="w-100">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">{{ $comment->user->name }}
                    </h6>
                    <small class="fs-6 fw-light text-muted"> {{ $comment->created_at }}</small>
                </div>
                <p class="fs-6 mt-3 fw-light">
                    {{ $comment->content }}
                </p>
            </div>
        </div>
    @endforeach
</div>
