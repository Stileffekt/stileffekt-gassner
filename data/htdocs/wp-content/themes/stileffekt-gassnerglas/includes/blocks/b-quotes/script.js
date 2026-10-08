(function (blocks) {
    blocks.registerSplide('.b-quotes', function () {
        return {
            perPage: 1,
            perMove: 1,
            arrows: true,
            pagination: false,
            type: 'loop',
            autoplay: true,
            pauseOnHover: true,
            interval: 5000,
            drag: true,
            mediaQuery: 'min',
            gap: blocks.getLayoutGutter(),
            breakpoints: {
                768: {perPage: 2},
                1280: {perPage: 3},
            },
        };
    });
}(window.stilpressBlocks));
