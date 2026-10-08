(function (blocks, gsap, ScrollTrigger) {
    gsap.registerPlugin(ScrollTrigger);

    blocks.register('.b-counter', function (block) {
        const tweens = [];

        block.querySelectorAll('.c-counter__item').forEach(function (item) {
            const valueWrapper = item.querySelector('.c-counter__value');

            if (!valueWrapper) {
                return;
            }

            const counter = {value: 1};
            const value = Number(valueWrapper.dataset.value || 1);
            const duration = Number(valueWrapper.dataset.duration || 5);
            const prefix = valueWrapper.dataset.prefix || '';
            const suffix = valueWrapper.dataset.suffix || '';
            const tween = gsap.to(counter, {
                value: value,
                duration: duration,
                snap: {value: 1},
                scrollTrigger: {
                    trigger: item,
                    markers: false,
                    start: 'top 70%',
                    end: 'top 70%',
                },
                onUpdate: function () {
                    const formattedValue = Math.floor(counter.value).toLocaleString('de-DE');
                    valueWrapper.textContent = prefix + formattedValue + (suffix ? ' ' + suffix : '');
                },
            });

            tweens.push(tween);
        });

        return function () {
            tweens.forEach(function (tween) {
                if (tween.scrollTrigger) {
                    tween.scrollTrigger.kill();
                }
                tween.kill();
            });
        };
    });
}(window.stilpressBlocks, window.gsap, window.ScrollTrigger));
