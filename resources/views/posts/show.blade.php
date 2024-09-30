<x-app2>
    @section('title', $post->title)
    <x-slot name="header">

    </x-slot>
    @section('css')
    @endsection
    <div class='container mx-auto  flex flex-col items-center justify-center'>
        <h2 class="max-w-lg text-3xl font-semibold leading-normal text-gray-900 dark:text-white">{{ $post->title }}</h2>
        <div class="w-full flex justify-center">
            <img class="object-cover w-96 md:w-1/2 max-h-96" src="{{ asset('images/' . $post->image_path) }}" alt="{{ $post->title }}">
        </div>
        <span class="w-96 md:w-1/2 text-sm text-right">Por {{ $post->author->datos->getNombreCompleto() }}</span>
        <p style="white-space:pre-wrap" class="mt-3 w-96 md:w-1/2 text-justify">{{ $post->content }}</p>
    </div>
    
</x-app2>