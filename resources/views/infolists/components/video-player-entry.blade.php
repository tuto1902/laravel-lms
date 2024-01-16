<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <iframe src="https://player.vimeo.com/video/{{ $getState() }}" ></iframe>
    </div>
</x-dynamic-component>
