<x-app2>
    @section('title', 'POSTS - ADMIN')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('POSTS - ADMIN') }}
        </h2>
    </x-slot>
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap4.css">
    @endsection
    <div class="card">
        <div class="card-body">
            <table id="posts" class="table table-striped table-bordered nowrap">
                <thead>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha de publicación</th>
                </thead>
            </table>
        </div>
    </div>
    @section('js')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap4.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap4.js"></script>
        <script>
            new DataTable('#posts', {
                responsive: true,
                autowidth: false,
                ajax: "{{ route('posts.dataTable') }}",
                columns: [
                    {data: "title"},
                    {data: "author"},
                    {data: "created_at", render: function (data, type, row) {
                        const date = new Date(data);
                        return date.toLocaleDateString('es-ES', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                        });
                    }},
                    {data: null, orderable: false, render: function (data, type, row) {
                        return `
                            <a href="{{ route('posts.show', ':id') }}" class="btn btn-info btn-sm">Ver</a>
                            <button class="btn btn-danger btn-sm" onclick="deletePost(${row.id})">Eliminar</button>
                            <a href="/posts/${row.id}/pdf" class="btn btn-warning btn-sm">PDF</a>
                        `.replace(/:id/g, row.id);
                    }},
                ],
                language: {
                    "decimal":        "",
                    "emptyTable":     "No hay datos disponibles en la tabla",
                    "info":           "Mostrando _START_ al _END_ de _TOTAL_ entradas",
                    "infoEmpty":      "Mostrando 0 al 0 de 0 entradas",
                    "infoFiltered":   "(filtrado de _MAX_ entradas totales)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing":     "",
                    "search":         "Buscar:",
                    "zeroRecords":    "Sin coincidencias encontradas",
                    "paginate": {
                        "first":      "Primera",
                        "last":       "Última",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "orderable":  "Ordenar por esta columna",
                        "orderableReverse": "Orden inverso de esta columna"
                    }
                }
            });
        </script>
    @endsection
</x-app2>