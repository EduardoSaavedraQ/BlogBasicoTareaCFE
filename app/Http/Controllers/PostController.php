<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;
use Yajra\DataTables\Facades\DataTables;

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
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required',
            'content' => 'required'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        // Crea el post con el ID del usuario autenticado
        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image_path' => $imageName,
            'author_id' => Auth::id(), // Obtiene el ID del usuario autenticado
        ]);

        return redirect()->back()->with('success', 'Post creado con éxito.');
    }

    public function show($id) {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    public function admin() {
        //$posts = Post::all();
        return view('posts.admin');
    }

    public function dataTable() {
        $posts = Post::with(['author.datos'])->select('id', 'title', 'created_at', 'author_id');
        
        return DataTables::eloquent($posts)
        ->addColumn('author', function ($post) {
            // Accedemos al nombre completo usando el método que ya tienes en el modelo Datosuser
            return $post->author->datos->getNombreCompleto();
        })
        ->toJson();
    }
}
