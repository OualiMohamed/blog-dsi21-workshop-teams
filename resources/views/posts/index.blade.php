@extends('layouts.app')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Category</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->title }}</td>
                    <td>{{ substr($post->content, 1, 80) . '...' }}</td>
                    <td>{{ $post->category->name }}</td>
                    <td>
                        <a href="{{ url('/posts/' . $post->id) }}" class="btn btn-outline-info">Show</a>
                        <a class="btn btn-outline-warning">Edit</a>
                        <a class="btn btn-outline-danger">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
