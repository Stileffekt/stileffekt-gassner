(function (blocks) {
    blocks.registerSplide('.b-logo-slider', function () {
        return {
            perPage: 5,
            type: 'loop',
            drag: true,
            arrows: false,
            pagination: false,
            gap: blocks.getLayoutGutter(),
            autoScroll: {
                speed: 1,
                pauseOnHover: true,
                pauseOnFocus: false,
            },
        };
    }, function () {
        return window.splide.Extensions;
    });
}(window.stilpressBlocks));
