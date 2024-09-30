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