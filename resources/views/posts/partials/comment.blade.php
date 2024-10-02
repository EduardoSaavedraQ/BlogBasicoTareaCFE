<article class="w-full md:w-1/2 p-6 text-base rounded-lg bg-gray-400">
    <footer class="flex justify-between items-center mb-2">
        <div class="flex items-center">
            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">{{ $comment->user->datos->getNombreCompleto() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="{{ explode(' ', $comment->created_at)[0] }}"
                    title="February 8th, 2022">{{ explode(' ', $comment->created_at)[0] }}</time></p>
        </div>              
    </footer>
    <p class="text-gray-500 dark:text-gray-400">{{ $comment->content }}</p>
</article>