@props(['type' => 'blue-200'])
<button
    class="inline-block px-4 py-1 text-xs font-medium text-white bg-{{$type}} rounded hover:bg-blue-700 ">{{ $slot }}</button>