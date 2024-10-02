<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin-top: 4cm;
        }
        #header {
            position: fixed;
            width: 100%;    
            top: -3cm;
            left: 0cm;
        }

        #imgHeader {
            float: left;
            width: 170px;
        }
        
        #inforHeader {
            float: left;
            margin-left: 1cm;
            margin-top: -1cm;
        }

        #companyName {
            color: green;
            font-style: italic;
        }

        #greenBar {
            margin-top: 2cm;
            margin-left: 0;
            width: 100%;
            height: 1cm;
            background-color: green;
        }

        #mainContent {
            width: 100%;
            margin-bottom: 1cm; /* Aumentar el margen inferior para evitar que la firma esté muy cerca del borde */
        }

        #imgPost {
            height: 400px;
            width: 350px;
            float: left;
        }

        #postSummary {
            float: left;
            margin-left: 1.5cm;
        }

        #postContent {
            margin-top: 11cm;
        }

        #signatureSeccion {
            page-break-inside: avoid;
            margin-top: 4cm;
            clear: both; /* Asegurarse de que la firma no esté afectada por flotantes */
        }

        #signatureLine {
            width: 5cm;
            margin-left: 6.7cm;
            border-top: 1px solid black;
        }
    </style>
</head>
<body>
    <div id="header">
        <img id="imgHeader" src="{{ public_path('assets/cfe.png') }}" alt="CFE">
        <div id="inforHeader">
            <h1 id="companyName">Comisión Federal de Electricidad</h1>
            <p>Informe de post</p>
        </div>
        <div id="greenBar"></div>
    </div>
    <div id="mainContent">
        <div id="postHeader">
            <h2>{{ $post->title }}</h2>
        @if ($post->image_path && public_path('images/' . $post->image_path))
            <img id="imgPost" src="{{ public_path('images/' . $post->image_path) }}">
        @else
            <p><i>Sin imagen disponible</i></p>
        @endif
        </div>
        <div id="postSummary">
            <h3>Detalles del post</h3>
            <p><b>ID:</b> {{ $post->id }}</p>
            <p><b>Título:</b> {{ $post->title }}</p>
            <p><b>Autor:</b> {{ $post->author->datos->getNombreCompleto() }}</p>
            <p><b>RPE del autor:</b> {{ $post->author->rpe }}</p>
            <p><b>Fecha de publicación:</b> {{ explode(' ', $post->created_at)[0] }}</p>
            <p><b>Likes:</b> {{ $post->likes->count() }}</p>
        </div>
        <div id="postContent">
            <h3 style="text-align: center">Contenido</h3>
            <p>{!! nl2br(e($post->content)) !!}</p>
        </div>
        <div id="signatureSeccion">
            <div id="signatureLine"></div>
            <p style="text-align: center">Firma del autor</p>
        </div>
    </div>
</body>
</html>