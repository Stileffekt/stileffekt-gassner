(function (blocks) {
    blocks.registerSplide('.b-quotes-slider', function () {
        return {
            perPage: 1,
            perMove: 1,
            autoHeight: true,
            arrows: true,
            pagination: false,
            type: 'loop',
            autoplay: true,
            pauseOnHover: true,
            interval: 5000,
            drag: true,
            mediaQuery: 'min',
            gap: blocks.getLayoutGutter(),
        };
    });
}(window.stilpressBlocks));
