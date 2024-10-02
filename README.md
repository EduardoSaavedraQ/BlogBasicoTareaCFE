
## Descargar y configurar el proyecto base

1. Clona el repositorio de este proyecto base:
   **git clone {link del repo sin las llaves}**
2. Accede a la carpeta del proyecto clonado.
3. Conecta tu proyecto a tu propio repositorio en GitHub:
   **git remote add origin {URL de tu repositorio en GitHub sin las llaves}**
4. Verifica que el repositorio remoto esté correctamente configurado:
   **git remote -v**

Este proyecto es un punto de partida. Puedes usarlo para crear tus propios desarrollos, aplicando personalizaciones y subiendo tus cambios a tu repositorio.


## Ejecutar el proyecto de manera local

Para iniciar el proyecto, usa el comando:
**php artisan serve**

---

## Subir cambios al repositorio de GitHub

Para subir cambios, sigue estos pasos:

1. Crea un branch con tu nombre y trabaja siempre en él.
2. Asegúrate de que estás en tu branch verificándolo con: **git status**
3. Cambia de branch usando: **git checkout {Nombre de tu branch sin las llaves}**
4. Agrega los archivos cambiados con: **git add .** (o usa **git add {nombre de tu archivo sin las llaves}** para agregar archivos individualmente).
5. Realiza un commit con un mensaje descriptivo de los cambios: **git commit -m "aquí va tu comentario de lo que hiciste"**
6. Sube tus cambios a tu repositorio con: **git push origin {Nombre de tu branch sin las llaves}**

Si te sale el error de que no sabe quién eres o de que te tienes que identificar usa:
1. **git config user.name "Tu nombre de usuario"**
2. **git config user.email "Tu email"**

---

## Limpiar el cache del proyecto en caso de ser necesario

Ejecuta:
**php artisan cache:clear**

## Mantener tu branch al día con main

Desde tu branch, sincronízate con la rama principal usando:
**git merge main**
Luego, sube los cambios:
**git push**


# REPORTE DE ACTIVIDAD

A continuación, voy a describir cómo fue que llevé a cabo el desarrollo de este proyecto de capacitación, detallando con la mayor claridad posible los aspectos importantes.

### Paquetes adicionales para ejecutar el proyecto

Ejecute los siguientes comandos iniciales antes de ejecutar el proyecto.

`composer require yajra/laravel-datatables-oracle` para poder cargar de manera dinámica los registros en el datatable pasando mandando dichos registros a la vista en formato JSON.
`composer require barryvdh/laravel-dompdf` para la generación de pdfs.

### 1. Configuración inicial del proyecto

El proyecto ya venía con un conjunto de migraciones listas para ejecutarse con el comando `php artisan migrate`. Además, también añadí la bandera `--seed` para ejectuar los seeders incluidos y poblar la base de datos.

Luego de esta ejecución inicial de los seeders creé uno para la tabla "posts" con los campos solicitados: "title" (de tipo string), "content" (de tipo text), "author_id" (un entero sin signo que hace el papel de llave foránea), y "created_at" "updated?at" (estos dos mediante el método `timestamps()`). Además se incluye el campo id del propio post.

Para la generación de registros de prueba, creé tanto un seeder como un factory (aunque la creación del primero, según la implementación que llevé a cabo, estuvo un poco de más). La generación de datos de los registros se llevó a cabo de manera automática con la librería faker y la API Carbon para la generación de fechas.

### 2. Relación entre modelos

Llevé la creación del script Post.php con el comando `php artisan make:model Post` y definí las relaciones solicitadas. Tanto en el modelo User como en el modelo Post tuve que dejar esplícito que la columna 'author_id' era la llave foránea.

```php
//Post.php
public function author(): BelongsTo
{
   return $this->belongsTo(User::class, 'author_id');
}

//User.php
public function post(): HasMany
{
   return $this->hasMany(Post::class, 'author_id');
}
```

### 3. Interacción con Eloquent

Para esta parte creé la ruta 'posts.index' que llamaba al método index() del controlador PostController (el cual fue creado con el comando `php artisan make:controller PostController`). La vista de esta parte de la aplicación es posts.index.

El filtrado lo hice de tal forma que el servidor revisara si la cadena ingresada por el usuario era una subcadena del nombre completo de alguno o algunos de los autores. Para esto aproveché también las relaciones ya definidas de los modelos User y Datosuser.

```php
//Post.php
public function scopeAuthorFilter($query, $partialName) {
   $partialName = strtoupper($partialName);
   return $query->whereHas('author.datos', function($query) use ($partialName) {
      $query->whereRaw("UPPER(CONCAT(datosusers.nombre, ' ', datosusers.paterno, ' ', datosusers.materno) LIKE ?)", ["%{$partialName}%"]);
   });
}
```
En cuanto al ordenamiento por fechas, modifiqué el método index del controlador de los posts para que pudiera reciber parámetros mediante el método GET. De hecho, para aplicar tanto el filtro como el ordenamiento no hubo necesidad de definir ningún método aparte. De esta forma, en caso de que los parámetros estén definidos, el método index() sólo redirigé a la misma vista pero pasando los parámetros, los cuales se pueden visualizar en la URL en forma de query strings.

### 4.   Diseño modular con Javascript y CSS

En este caso, el loader del paso 5 fue lo único que pude dejar en un archivo separado llamado loader.css dentro de la ruta publi/css. El resto del código javascript definido por mí mismo no fui capaz de pasarlo a sus propios archivos debido a que dejaban de funcionar. Hasta el momento, aún no puedo resolver ese problema.

### 5. Integración de Ajax/fetch
Utilicé la API fetch en la vista posts.index para cargar más posts de forma dinámica. El botón 'Cargar más' se alterna con un loader animado en lo que se reciben los registros.

Cabe aclarar que para simular el retraso en un entorno local, he decidido utilizar la función setTimeOut() de JavaScript para, de esta manera, visualizar el loader.

### 6. Uso de datatables
Para implementar el datatable en la vista posts.admin, tomé como base los ejemplos disponibles en el sitio web Datatables.net, así como también seguí las indicaciones de una serie de video tutoriales del canal Coders Free. Los datatables ahí presentes ya integran muchas funcionalidades útiles.

### 7. Almacenamiento en Laravel
Para esto he creado una vista 'posts.crate' que despliega un formulario para asignar un título a un post, escribir el contenido de éste y subir una imagen que lo acompañe. Los resultados se pueden apreciar en la ruta 'posts.show'.

Para el almacenamiento de la imagen utilicé el helper move() y el helper public_path() para almacenar las imágenes en la ruta /public/images. Todo ello se puede observar en el método store() del controlador PostController.

```php
//PostController.php
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
```