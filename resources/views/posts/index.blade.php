@extends('layouts.app')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <a href="{{ Route('posts.create') }}" class="btn btn-primary">New Post</a>
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
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-warning">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Delete Post ?')" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
