@extends('layouts.app')

@section('content')
    <h2 class="py-4">New Post</h2>
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" value="{{ old('title') }}" name="title" id="title"
                placeholder="Enter post title">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" name="content" id="content" rows="3" placeholder="Enter content">{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="user" class="form-label">Author</label>
            <select class="form-select" id="user_id" name="user_id" aria-label="Default select example">
                <option selected>Select the author</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>    
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" aria-label="Default select example">
                <option selected>Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>    
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
