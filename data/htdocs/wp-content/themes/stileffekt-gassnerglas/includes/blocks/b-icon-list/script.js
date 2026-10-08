(function (blocks) {
    blocks.register('.b-icon-list', function (block) {
        const expandableItems = block.querySelectorAll('[data-expandable]');
        const controller = new AbortController();
        const transitionTimeouts = new Map();
        let resizeTimeout;

        function queueTransition(item, callback) {
            window.clearTimeout(transitionTimeouts.get(item));
            transitionTimeouts.set(item, window.setTimeout(function () {
                transitionTimeouts.delete(item);
                callback();
            }, 10));
        }

        function checkContentHeight(item) {
            const content = item.querySelector('[data-expandable-content]');
            const button = item.querySelector('[data-expand-toggle]');

            if (!content || !button) {
                return;
            }

            content.removeAttribute('data-collapsed');
            content.style.removeProperty('max-height');
            content.style.removeProperty('overflow');

            const actualHeight = content.scrollHeight;
            const isOverflowing = actualHeight > 260;

            if (isOverflowing) {
                button.hidden = false;
                content.setAttribute('data-collapsed', 'true');
            } else {
                button.hidden = true;
                content.removeAttribute('data-collapsed');
            }
        }

        function resetItem(item) {
            window.clearTimeout(transitionTimeouts.get(item));
            transitionTimeouts.delete(item);

            const content = item.querySelector('[data-expandable-content]');
            const button = item.querySelector('[data-expand-toggle]');

            if (!content || !button) {
                return;
            }

            const moreText = button.querySelector('[data-text="more"]');
            const lessText = button.querySelector('[data-text="less"]');

            content.setAttribute('data-collapsed', 'true');
            button.setAttribute('aria-expanded', 'false');
            button.classList.remove('active');
            if (moreText) moreText.hidden = false;
            if (lessText) lessText.hidden = true;
            checkContentHeight(item);
        }

        function toggleExpand(item) {
            const content = item.querySelector('[data-expandable-content]');
            const button = item.querySelector('[data-expand-toggle]');

            if (!content || !button) {
                return;
            }

            const isExpanded = button.getAttribute('aria-expanded') === 'true';
            const moreText = button.querySelector('[data-text="more"]');
            const lessText = button.querySelector('[data-text="less"]');

            if (isExpanded) {
                const currentHeight = content.scrollHeight;
                content.style.maxHeight = currentHeight + 'px';

                button.setAttribute('aria-expanded', 'false');
                button.classList.remove('active');
                if (moreText) moreText.hidden = false;
                if (lessText) lessText.hidden = true;

                queueTransition(item, function () {
                    content.style.maxHeight = '260px';
                    content.setAttribute('data-collapsed', 'true');
                });
            } else {
                if (!content.style.maxHeight || content.style.maxHeight === 'none') {
                    content.style.maxHeight = '260px';
                }

                content.setAttribute('data-collapsed', 'false');

                queueTransition(item, function () {
                    const targetHeight = content.scrollHeight;
                    content.style.maxHeight = targetHeight + 'px';
                });

                button.setAttribute('aria-expanded', 'true');
                button.classList.add('active');
                if (moreText) moreText.hidden = true;
                if (lessText) lessText.hidden = false;
            }
        }

        expandableItems.forEach(function (item) {
            const button = item.querySelector('[data-expand-toggle]');

            if (!button) {
                return;
            }

            button.addEventListener('click', function () {
                toggleExpand(item);
            }, {signal: controller.signal});
            checkContentHeight(item);
        });

        window.addEventListener('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = window.setTimeout(function () {
                expandableItems.forEach(resetItem);
            }, 250);
        }, {signal: controller.signal});

        return function () {
            controller.abort();
            window.clearTimeout(resizeTimeout);
            transitionTimeouts.forEach(function (timeout) {
                window.clearTimeout(timeout);
            });
            transitionTimeouts.clear();
        };
    });
}(window.stilpressBlocks));
