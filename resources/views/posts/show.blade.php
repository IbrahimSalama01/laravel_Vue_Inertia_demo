<x-template :title="'Post ' . $post['id']">

    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto space-y-6">
            <!-- Post Info Card -->
            <div class="bg-white border border-gray-200 rounded">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-base font-medium text-gray-700">Post Info</h2>
                </div>
                <div class="px-4 py-4">
                    <div class="mb-2">
                        <h3 class="text-lg font-medium text-gray-800">Title :- <span
                                class="font-normal">{{$post->title}}</span></h3>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">Description :-</h3>
                        <p class="text-gray-600">{{$post->description}}</p>
                    </div>
                </div>
            </div>


            <!-- Post Creator Info Card -->
            <div class="bg-white border border-gray-200 rounded">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-base font-medium text-gray-700">Post Creator Info</h2>
                </div>
                <div class="px-4 py-4">
                    <div class="mb-2">
                        <h3 class="text-lg font-medium text-gray-800">Name :- <span
                                class="font-normal">{{$post->user->name}}</span></h3>
                    </div>
                    <div class="mb-2">
                        <h3 class="text-lg font-medium text-gray-800">Email :- <span
                                class="font-normal">{{$post->user->email}}</span></h3>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">Created At :- <span
                                class="font-normal">{{$post->created_at->toformattedDateString()}}  </span></h3>
                    </div>
                </div>
            </div>


            <!-- Back Button -->
            <div class="flex justify-end">
                <a href="{{ route('posts.index') }}"
                    class="px-4 py-2 font-medium text-white bg-gray-600 rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back to All Posts
                </a>
            </div>
        </div>
    </div>
    <x-comment-section :comments="$comments" :users="$users" :postId="$post->id" :slug="$post->slug" />
</x-template>
