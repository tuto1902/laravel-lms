<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="relative pt-[56.25%]">
        <iframe src="https://player.vimeo.com/video/{{ $getState() }}"
            frameborder="0" 
            allow="autoplay; fullscreen; picture-in-picture"
            class="absolute top-0 left-0 w-full h-full"
        ></iframe>
    </div>
    @script
        <script src="https://player.vimeo.com/api/player.js"></script>
    @endscript
</x-dynamic-component>
