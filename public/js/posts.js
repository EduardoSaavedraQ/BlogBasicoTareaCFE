/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/posts.js ***!
  \*******************************/
document.addEventListener('DOMContentLoaded', function () {
  var loadMoreBtn = document.getElementById('load-more-btn');
  var loadingIndicator = document.getElementById('loader');
  var postList = document.getElementById('post-list');
  loadMoreBtn.addEventListener('click', function () {
    var page = loadMoreBtn.getAttribute('data-page');
    var url = "{{ route('posts.index') }}?page=".concat(page);
    loadMoreBtn.style.display = 'none';
    loadingIndicator.style.display = 'block'; // Mostrar el indicador de carga

    fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (response) {
      return response.text();
    }).then(function (data) {
      setTimeout(function () {
        loadingIndicator.style.display = 'none'; // Ocultar el indicador de carga
        loadMoreBtn.style.display = 'block';
        if (data === 'no_more_posts') {
          loadMoreBtn.textContent = 'No hay más posts';
          loadMoreBtn.disabled = true;
        } else {
          postList.insertAdjacentHTML('beforeend', data); // Añadir los nuevos posts
          loadMoreBtn.setAttribute('data-page', parseInt(page) + 1); // Incrementar la página
        }
      }, 3000);
    })["catch"](function (error) {
      console.error('Error:', error);
      loadingIndicator.style.display = 'none';
    });
  });
});
/******/ })()
;