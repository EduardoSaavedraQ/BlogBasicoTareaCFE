<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
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

    public function show(Post $post) {
        $post->load('comments');
        return view('posts.show', compact('post'));
    }

    public function admin() {
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

    public function like(Post $post) {
        $user = auth()->user();
        
        if ($post->hasLikedBy($user))
            // Si ya ha dado el like, eliminar el like
            $post->likes()->where('user_rpe', $user->rpe)->delete();
        else
            //Si no ha dado like, agregarlo
            Like::create([
                'post_id' => $post->id,
                'user_rpe' => $user->rpe
            ]);
        
        return response()->json(['success' => true]);
    }

    public function comment(Request $request, Post $post) {
        $comment = $request->comment;
        $user = auth()->user();

        if ($comment !== null && $user)
            Comment::create([
                'post_id' => $post->id,
                'user_rpe' => $user->rpe,
                'content' => $comment
            ]);

        return redirect()->route('posts.show', $post->id);
    }

    public function destroy(Post $post) {
        // Verificar si el post existe
        if (!$post) {
            return response()->json(['message' => 'Post no encontrado.'], 404);
        }

        // Eliminar el post
        $post->delete();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Post eliminado exitosamente.'], 200);
    }

    public function pdfTest() {
        $pdf = PDF::loadView('posts.pdf-post');
        return $pdf->stream();
    }
}
