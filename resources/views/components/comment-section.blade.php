@props(['comments'=>[], "users"=>[],"postId"=>0,"slug"=>""])
<div>
    <div class="max-w-2xl p-4 mx-auto bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-xl font-bold">Comments</h2>
        @foreach ($comments as $comment )

        <div class="space-y-4">
            <!-- Comment Item -->
            <div class="flex pb-4 space-x-3">
                <div class="flex-1">
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <h4 class="text-sm font-semibold">{{$comment->user->name}}</h4>
                        <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </div>
    <div class="max-w-xl p-4 mx-auto mt-5 bg-white rounded-lg shadow-lg ">

        <form id="comment-form" class="space-y-3" method="POST" action="{{ route('comments.store') }}">
            @csrf
            <div class="mb-6">
                <label for="creator" class="block mb-1 text-sm font-medium text-gray-700">Commenter</label>
                <select name="comment_creator" id="creator"
                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                    {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <input class="hide" name="post_id" type="hidden" value="{{ $postId }}"/>
            <input class="hide" name="slug" type="hidden" value="{{ $slug }}"/>
            <!-- Comment Input -->
            <textarea id="comment" name="comment" class="w-full p-2 border rounded" rows="3" placeholder="Write your comment..." required></textarea>

            <!-- Submit Button -->
            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Post Comment</button>
        </form>

        <!-- Success Message -->
        <p id="success-message" class="hidden mt-2 text-green-500">Comment added!</p>
    </div>
</div>
