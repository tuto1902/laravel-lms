<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="relative pt-[56.25%]">
        <iframe src="https://player.vimeo.com/video/{{ $getState() }}"
            frameborder="0" 
            allow="autoplay; fullscreen; picture-in-picture"
            class="absolute top-0 left-0 w-full h-full"
        ></iframe>
    </div>
    <script src="https://player.vimeo.com/api/player.js"></script>
</x-dynamic-component>
@script
    <script>
        let iframe = document.querySelector('iframe');
        let player = new Vimeo.Player(iframe);

        player.on('ended', (data) => {
            $wire.dispatch('episode-ended', {
                episode: '{{ $getRecord()->id }}'
            });
        });
    </script>
@endscript
