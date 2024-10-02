<x-app2>
    @section('title', $post->title)
    <x-slot name="header">

    </x-slot>
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @endsection
    <div class='container mx-auto w-full md:w-1/2 flex flex-col items-center justify-center'>
        <h2 class="text-3xl font-semibold leading-normal text-gray-900 dark:text-white">{{ $post->title }}</h2>
        @if ($post->image_path !== null)
        <div class="w-full flex justify-center">
            <img class="object-cover w-96 md:w-1/2 max-h-96" src="{{ asset('images/' . $post->image_path) }}" alt="{{ $post->title }}">
        </div>
        @endif
        <span class="w-full md:w-1/2 text-sm text-right">Por {{ $post->author->datos->getNombreCompleto() }}</span>
        <div class="flex justify-between w-full md:w-1/2">
            <i id="like-btn" class="fa fa-thumbs-up {{ $post->hasLikedBy(auth()->user()) ? 'text-red-600' : null }}" style="font-size: 30px" onclick="toggleLike()"></i>
            <span class="text-sm text-right">{{ explode(' ', $post->created_at)[0] }}</span>
        </div>
        <p style="white-space:pre-wrap" class="mt-3 w-96 md:w-1/2 text-justify">{{ $post->content }}</p>

        <h3>Comentarios</h3>
        <form class="w-full md:w-1/2 flex flex-col" action="{{ route('posts.comment', $post->id) }}" method="POST">
            @csrf
            <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                <label for="comment-field" class="sr-only">Your comment</label>
                <textarea name="comment" id="comment-field" rows="6" class="w-full resize-none text-sm text-gray-900 bg-gray-200 border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"></textarea>
                <div class="px-3 py-2 border-t rounded bg-gray-600">
                    <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">Publicar comentario</button>
                </div>
            </div>
        </form>
        @foreach ($post->comments as $comment)
            @include('posts.partials.comment')
            <br>
        @endforeach
        
    </div>
    @section('js')
        <script>
            function toggleLike() {
                fetch("{{ route('posts.like', $post->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const likeButton = document.getElementById(`like-btn`);
                    if (data.success)
                        likeButton.classList.toggle('text-red-600');
                    else
                        alert('Ha ocurrido un error');
                })
                .catch(error => console.error('Error:', error));
            }
        </script>
    @endsection
</x-app2>