(function (blocks) {
    blocks.register('.b-products', function (block) {
        const controller = new AbortController();

        block.querySelectorAll('.c-tabs').forEach(function (tabs) {
            var buttons = Array.from(tabs.querySelectorAll('[role="tab"]'));
            var panels = Array.from(tabs.querySelectorAll('[role="tabpanel"]'));

            function activateTab(tab) {
                buttons.forEach(function (btn) {
                    btn.classList.remove('is-active');
                    btn.setAttribute('aria-selected', 'false');
                    btn.setAttribute('tabindex', '-1');
                });
                panels.forEach(function (panel) {
                    panel.classList.remove('is-active');
                    panel.setAttribute('hidden', '');
                });

                tab.classList.add('is-active');
                tab.setAttribute('aria-selected', 'true');
                tab.setAttribute('tabindex', '0');

                var panelId = tab.getAttribute('aria-controls');
                var panel = panels.find(function (candidate) {
                    return candidate.id === panelId;
                });

                if (!panel) {
                    return;
                }

                panel.classList.add('is-active');
                panel.removeAttribute('hidden');
            }

            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    activateTab(this);
                }, {signal: controller.signal});

                button.addEventListener('keydown', function (e) {
                    var index = buttons.indexOf(this);
                    var newIndex;

                    if (e.key === 'ArrowRight') {
                        newIndex = (index + 1) % buttons.length;
                    } else if (e.key === 'ArrowLeft') {
                        newIndex = (index - 1 + buttons.length) % buttons.length;
                    } else if (e.key === 'Home') {
                        newIndex = 0;
                    } else if (e.key === 'End') {
                        newIndex = buttons.length - 1;
                    } else {
                        return;
                    }

                    e.preventDefault();
                    activateTab(buttons[newIndex]);
                    buttons[newIndex].focus();
                }, {signal: controller.signal});
            });
        });

        return function () {
            controller.abort();
        };
    });
}(window.stilpressBlocks));
