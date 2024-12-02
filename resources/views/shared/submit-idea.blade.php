<h4> Share yours ideas </h4>
<div class="row">
    <form action="{{ route('idea.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <textarea class="form-control" id="content" name="content" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-dark"> Share </button>
    </form>
</div>
