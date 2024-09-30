<x-app2>
    @section('title', 'Crea tu post')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CREA TU POST') }}
        </h2>
    </x-slot>
    @section('css')
        
    @endsection
    @if (session('success'))
    <div class="content w-full bg-green-400 text-xl text-green-900">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    <div class="container max-w-1/2 mx-auto mt-3 flex justify-center">
        <form class="w-full max-w-lg" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap -mx-3">
              <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                  Título de tu post
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="Mi increíble post" name="title" id="title_field" required>
                <p class="text-red-500 text-xs italic">Por favor llena este campo.</p>
                @error('title')
                <br>
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
              </div>
            </div>  
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="post_content_box">
                  Contenido
                </label>
                <textarea class="w-full h-72 block bg-gray-200 text-gray-700 border border-gray-200 rounded" name="content" id="post_content_box" cols="30" rows="10" placeholder="Agrega aquí el contenido de tu post" required></textarea>
                <p class="text-gray-600 text-xs italic">Dí todo lo que piensas, sin pena.</p>
              </div>
            </div>
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="file_upload">Sube una foto</label>
                <input type="file" name="image" id="file_field" accept="image/*">
                @error('file')
                <br>
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="block mx-auto mt-6 mb-6 items-center px-3 py-2 text-xl font-medium text-center border border-gray-200 rounded hover:bg-green-700 hover:text-white">Publicar</button>
        </form>
    </div>
</x-app2>