<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) {
        $author = $request->query('author', null); // Puede ser null si no se pasa
        $order = $request->query('order'); // Valor por defecto es 'desc'
        $perpage = 6;

        if($order !== 'asc' && $order !== 'desc')
            $order = 'desc';

        $query = Post::select('id', 'title', 'created_at', 'author_id')->orderBy('created_at', $order);
        if($author !== null)
            $query->authorFilter($author);

        $posts = $query->paginate($perpage);

        if ($request->ajax()) {
            if ($posts->currentPage() >= $posts->lastPage()) {
                //return response()->json(['no_more_posts' => true]);
                return 'no_more_posts';
            }
            return view('posts.partials.posts', compact('posts'))->render(); // Renderiza solo la lista de posts para el ajax
        }
    
        return view('posts.index', compact('posts', 'author', 'order'));

        return view('posts.index')->with([
            "posts" => $posts,
            "author" => $author,
            "order" => $order
        ]);
    }
}
