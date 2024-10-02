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