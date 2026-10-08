(function (blocks) {
    blocks.register('.b-downloads-accordion', function (block) {
        const accordions = block.querySelectorAll('.c-downloads-accordion__item');
        const controller = new AbortController();

        accordions.forEach(function (accordion, index) {
            const button = accordion.querySelector('.c-downloads-accordion__button');
            const content = accordion.querySelector('.c-downloads-accordion__content');

            if (!button || !content) return;

            // Initialize first accordion
            if (index === 0) {
                content.style.maxHeight = content.scrollHeight + 'px';
            }

            const toggleAccordion = function () {
                const isExpanded = button.getAttribute('aria-expanded') === 'true';

                if (isExpanded) {
                    accordion.classList.remove('active');
                    button.setAttribute('aria-expanded', 'false');
                    content.style.maxHeight = 0 + 'px';
                } else {
                    accordions.forEach(function (otherAccordion) {
                        const otherButton = otherAccordion.querySelector('.c-downloads-accordion__button');
                        const otherContent = otherAccordion.querySelector('.c-downloads-accordion__content');
                        if (otherButton && otherContent) {
                            otherAccordion.classList.remove('active');
                            otherButton.setAttribute('aria-expanded', 'false');
                            otherContent.style.maxHeight = 0 + 'px';
                        }
                    });

                    accordion.classList.add('active');
                    button.setAttribute('aria-expanded', 'true');
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            };

            button.addEventListener('click', toggleAccordion, {signal: controller.signal});
        });

        return function () {
            controller.abort();
        };
    });
}(window.stilpressBlocks));
