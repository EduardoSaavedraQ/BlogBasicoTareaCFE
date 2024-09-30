<x-app2>
    @section('title', 'Posts')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('POSTS') }}
        </h2>
    </x-slot>
    @section('css')
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dataTables/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customDataTables.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('css/loader.css') }}">

    @endsection
    <form class="max-w-md mx-auto mt-2" method="GET" action="{{route('posts.index')}}">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input name="author" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{$author ?? 'Busque un autor'}}"/>
            <button type="submit" class="text-white absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
        </div>
        <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2">Ordenar por:</label>
        <select name="order" id="">
            <option value="asc"
            @if ($order == "asc")
                selected
            @endif
            >Menos recientes</option>
            <option value="desc"
            @if ($order == "desc")
                selected
            @endif
            >Mas recientes</option>
        </select>
    </form>

    @if (count($posts) === 0)
        <div class="conteiner mx-auto w-5/6 mt-3 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p class="font-bold">Sin resultados</p>
            <p>No se han encontrado coincidencias con la búsqueda</p>
        </div>
    @else
        <div class="container mx-auto mt-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="post-list">
                @include('posts.partials.posts')
            </div>
        </div>
        
        <div class="container mt-3 text-center">
            <button id="load-more-btn" data-page="2" class="btn btn-primary mx-auto block">Cargar más</button>
            <span id="loader" style="display:none"></span>    
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            let loadMoreBtn = document.getElementById('load-more-btn');
            let loadingIndicator = document.getElementById('loader');
            let postList = document.getElementById('post-list');
    
            loadMoreBtn.addEventListener('click', function() {
                let page = loadMoreBtn.getAttribute('data-page');
                let url = `{{ route('posts.index') }}?page=${page}`;
    
                loadMoreBtn.style.display = 'none';
                loadingIndicator.style.display = 'block'; // Mostrar el indicador de carga
    
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    setTimeout(() => {
                        loadingIndicator.style.display = 'none'; // Ocultar el indicador de carga
                        loadMoreBtn.style.display = 'block';
                        if(data === 'no_more_posts') {
                            loadMoreBtn.textContent = 'No hay más posts';
                            loadMoreBtn.disabled = true;
                        }
                        else {
                            postList.insertAdjacentHTML('beforeend', data); // Añadir los nuevos posts
                            loadMoreBtn.setAttribute('data-page', parseInt(page) + 1); // Incrementar la página
                        }
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingIndicator.style.display = 'none';
                });
            });
        });
        </script>
    @endif
</x-app2>