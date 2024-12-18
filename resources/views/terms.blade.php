@extends('layout.app')

@section('title', 'Terms')

@section('content')
    <div class="row">
        <div class="col-3">
            @include('shared.left-sidebar')
        </div>
        <div class="col-6">
            <h1>Terms</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, consequuntur. Sit accusantium iste rem, non
                nesciunt nisi pariatur ducimus delectus placeat, autem, quam porro. Cupiditate molestias sequi incidunt
                minima numquam nobis, sed amet inventore architecto ad illo? Ipsum reprehenderit at optio placeat adipisci
                dignissimos mollitia obcaecati, blanditiis, ad numquam ducimus.</p>
        </div>
        <div class="col-3">
            @include('shared.search-bar')
            @include('shared.follow-box')
        </div>
    </div>
@endsection
