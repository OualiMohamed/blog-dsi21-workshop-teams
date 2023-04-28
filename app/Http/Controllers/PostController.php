<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupérer la liste des utilisateurs
        $authors = User::all();
        // Récupérer la liste des catégories
        $categories = Category::all();
        return view('posts.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        // using function validation
        $request->validate($this->validationRules());

        // Récupérer le nom de l'image uploadée
        // puis la transférer dans le dossier storage/app/posts        
        $image = Storage::disk('public')->put('posts', $request->file('image'));

        // Créer un Post vide
        $newPost = new Post();

        // Le remplir avec le contenu du formulaire
        $newPost->title = $request->title;
        $newPost->content = $request->content;
        $newPost->image = $image;
        $newPost->user_id = $request->user_id;
        $newPost->category_id = $request->category_id;

        // Sauvegarde dans la BD
        $newPost->save();

        return redirect()->route('posts.show', $newPost->id)->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('category', 'user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Récupérer le post à partir de son id
        $post = Post::findOrFail($id);
        // Récupérer la liste des utilisateurs
        $authors = User::all(); 
        // Récupérer la liste des catégories
        $categories = Category::all();

        return view('posts.edit', compact('post', 'authors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validationRules());

        $post = Post::findOrFail($id);

        if ($request->hasFile('image')) {
            // Delete old image
            $oldImage =  $post->image;
            if (Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            $image = Storage::disk('public')->put('posts', $request->file('image'));
            $post->image = $image;
        }
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $post->category_id = $request->category_id;

        $post->save() ;

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function validationRules() {
        return [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
