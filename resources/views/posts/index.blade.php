<x-template :title="'posts'">
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->

    <div>
        <div class="text-center">
            <a href="{{ route('posts.create') }}"
                class="px-4 py-2 mt-4 font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Create Post
            </a>
        </div>

        <!-- Table Component -->
        <div class="mt-6 border border-gray-400 rounded-lg">
            <div class="overflow-x-auto rounded-t-lg">
                <div class="inline-block w-full" id="app">
                    <table class="min-w-full text-sm text-center bg-white divide-gray-800 divide-y-3">
                        <thead class="font-bold bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">#</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Title</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Posted By</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Created At</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Actions</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">

                            @foreach ($posts as $post)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">{{ $post->id }}</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{$post->title }}</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $post->user->name }}</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $post->created_at->toformattedDateString() }}</td>
                                    <td class="px-4 py-2 space-x-2 text-gray-700 whitespace-nowrap">
                                        <a href="{{ route('posts.show', $post->id) }}"
                                            class="inline-block px-4 py-1 text-xs font-medium text-white bg-blue-400 rounded hover:bg-blue-500">View</a>
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="inline-block px-4 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700">Edit</a>
                                        {{-- <button onclick="openModal({{ $post->id }})"
                                            class="inline-block px-4 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">Delete</button> --}}
                                        <form class="inline-block" action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                            class="inline-block px-4 py-1 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                            Delete</button>
                                        </form>

                                        <vue-component  postid="@php echo($post->id) @endphp" class="inline-block"/>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <modal-component ref="modal"></modal-component>
                </div>

            </div>

                <div class="px-10 py-1 mt-3 bg-gray-100 border-t-2 border-gray-600">
                    {{ $posts->onEachSide(0)->links() }}
                </div>
            </div>
        </div>



        <!-- Table of deleted -->
            <div class="mt-6 border border-gray-400 rounded-lg">
                <div class="overflow-x-auto rounded-t-lg">
                    <table class="min-w-full text-sm text-center bg-white divide-gray-800 divide-y-3">
                        <thead class="font-bold bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">#</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Title</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Posted By</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Created At</th>
                                <th class="px-4 py-2 text-gray-900 whitespace-nowrap">Actions</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($deletedPosts as $post)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">{{ $post['id'] }}</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{$post['title']}}</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $post['posted_By'] }}</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $post['created_at'] }}</td>
                                    <td class="px-4 py-2 space-x-2 text-gray-700 whitespace-nowrap">
                                    <a href="{{ route('posts.restore', $post->id) }}"
                                        class="inline-block px-4 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-700">Restore</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                    <div class="px-10 py-1 mt-3 bg-gray-100 border-t-2 border-gray-600">
                        {{ $deletedPosts->onEachSide(0)->links() }}
                    </div>
                </div>
            </div>
    </div>




    <script defer>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this post?");
        }
        function openModal(id) {
        document.querySelector('#app').__vue__.$refs.itemModal.openModal(id);
        }
        function asd(){
            console.log("ay habl")
        }
    </script>
</x-template>
