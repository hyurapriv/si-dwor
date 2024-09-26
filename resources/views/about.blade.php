
@extends('layouts.main')

@section('container')
    @foreach ($posts as $post)
    <article class="mb-5">
        <h2> {{ $post["judul"] }}</h2>
        <h5> {{ $post["author"] }}</h5>
        <p> {{ $post["body"] }}</p>
    </article>
    @endforeach
@endsection
                                       