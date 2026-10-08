(function (blocks) {
    blocks.registerSplide('.b-image-slider', function () {
        return {
            perPage: 2,
            perMove: 1,
            focus: 0,
            arrows: true,
            pagination: true,
            type: 'loop',
            autoplay: true,
            pauseOnHover: true,
            interval: 5000,
            drag: true,
            mediaQuery: 'min',
            gap: blocks.getLayoutGutter(),
            breakpoints: {
                1280: {perPage: 3},
            },
        };
    });
}(window.stilpressBlocks));
