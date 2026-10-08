(function (blocks) {
    blocks.registerSplide('.b-employees-slider', function () {
        return {
            perPage: 2,
            perMove: 1,
            focus: 0,
            arrows: true,
            pagination: true,
            type: 'loop',
            autoplay: false,
            interval: 5000,
            drag: true,
            mediaQuery: 'min',
            gap: blocks.getLayoutGutter(),
            breakpoints: {
                576: {perPage: 3},
                768: {perPage: 4},
                1024: {perPage: 5},
                1280: {perPage: 6},
            },
        };
    });
}(window.stilpressBlocks));
