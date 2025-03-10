@props(['comments'=>[], "users"=>[],"postId"=>0])
<div>
    <div class="max-w-2xl mx-auto p-4 bg-white shadow-lg rounded-lg">
        <h2 class="text-xl font-bold mb-4">Comments</h2>
        @foreach ($comments as $comment )

        <div class="space-y-4">
            <!-- Comment Item -->
            <div class="flex space-x-3  pb-4">
                <div class="flex-1">
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <h4 class="font-semibold text-sm">{{$comment->user->name}}</h4>
                        <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    </div>
    <div class="max-w-xl mx-auto p-4 bg-white shadow-lg rounded-lg mt-5 ">

        <form id="comment-form" class="space-y-3" method="POST" action="{{ route('comments.store') }}">
            @csrf
            <div class="mb-6">
                <label for="creator" class="block text-sm font-medium text-gray-700 mb-1">Commenter</label>
                <select name="comment_creator" id="creator"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border bg-white">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                    {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <input class="hide" name="post_id" type="hidden" value="{{ $postId }}"/>
            <!-- Comment Input -->
            <textarea id="comment" name="comment" class="w-full p-2 border rounded" rows="3" placeholder="Write your comment..." required></textarea>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Post Comment</button>
        </form>

        <!-- Success Message -->
        <p id="success-message" class="text-green-500 mt-2 hidden">Comment added!</p>
    </div>
</div>
