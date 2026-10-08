(function (window, document) {
    'use strict';

    if (window.stilpressBlocks) {
        return;
    }

    const registrations = [];
    let observer;

    function forEachMatch(root, selector, callback) {
        if (root.nodeType !== Node.ELEMENT_NODE && root.nodeType !== Node.DOCUMENT_NODE) {
            return;
        }

        if (root.nodeType === Node.ELEMENT_NODE && root.matches(selector)) {
            callback(root);
        }

        root.querySelectorAll(selector).forEach(callback);
    }

    function mount(registration, element) {
        if (registration.instances.has(element)) {
            return;
        }

        try {
            const cleanup = registration.initialize(element);
            registration.instances.set(element, typeof cleanup === 'function' ? cleanup : null);
        } catch (error) {
            console.error('Could not initialize Stilpress block.', element, error);
        }
    }

    function unmount(registration, element) {
        if (!registration.instances.has(element)) {
            return;
        }

        const cleanup = registration.instances.get(element);
        registration.instances.delete(element);

        if (cleanup) {
            try {
                cleanup();
            } catch (error) {
                console.error('Could not clean up Stilpress block.', element, error);
            }
        }
    }

    function observe() {
        if (observer || !document.documentElement) {
            return;
        }

        observer = new MutationObserver(function (mutations) {
            registrations.forEach(function (registration) {
                mutations.forEach(function (mutation) {
                    mutation.removedNodes.forEach(function (node) {
                        forEachMatch(node, registration.selector, function (element) {
                            unmount(registration, element);
                        });
                    });
                });

                mutations.forEach(function (mutation) {
                    mutation.addedNodes.forEach(function (node) {
                        forEachMatch(node, registration.selector, function (element) {
                            mount(registration, element);
                        });
                    });
                });
            });
        });

        observer.observe(document.documentElement, {
            childList: true,
            subtree: true,
        });
    }

    function register(selector, initialize) {
        const registration = {
            selector: selector,
            initialize: initialize,
            instances: new Map(),
        };

        registrations.push(registration);
        forEachMatch(document, selector, function (element) {
            mount(registration, element);
        });
        observe();
    }

    function getLayoutGutter() {
        return window.getComputedStyle(document.documentElement)
            .getPropertyValue('--layout-gutter')
            .trim();
    }

    function registerSplide(selector, getOptions, getExtensions) {
        register(selector, function (block) {
            const slider = block.querySelector('.splide');

            if (!slider || typeof window.Splide === 'undefined') {
                return;
            }

            const options = typeof getOptions === 'function' ? getOptions(block) : getOptions;
            const extensions = typeof getExtensions === 'function' ? getExtensions(block) : getExtensions;
            const splide = new window.Splide(slider, options || {});

            splide.mount(extensions);

            return function () {
                splide.destroy(true);
            };
        });
    }

    function registerScrollArrow(selector) {
        register(selector, function (block) {
            const arrow = block.querySelector('.b__arrow');

            if (!arrow) {
                return;
            }

            function scrollDown() {
                const scrollTarget = window.scrollY + window.innerHeight * 0.5;
                window.scrollTo({top: scrollTarget, behavior: 'smooth'});
            }

            arrow.addEventListener('click', scrollDown);

            return function () {
                arrow.removeEventListener('click', scrollDown);
            };
        });
    }

    window.stilpressBlocks = {
        getLayoutGutter: getLayoutGutter,
        register: register,
        registerScrollArrow: registerScrollArrow,
        registerSplide: registerSplide,
    };
}(window, document));
