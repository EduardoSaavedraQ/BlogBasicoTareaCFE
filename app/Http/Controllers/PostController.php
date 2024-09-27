<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) {
        $author = $request->query('author', null); // Puede ser null si no se pasa
        $order = $request->query('order'); // Valor por defecto es 'desc'

        if($order !== 'asc' && $order !== 'desc')
            $order = 'desc';
        
        $posts = Post::select('id', 'title', 'created_at', 'author_id')->orderBy('created_at', $order)->get();

        return view('posts.index')->with([
        "posts" => $posts,
        "author" => $author,
        "order" => $order
        ]);
    }
}
