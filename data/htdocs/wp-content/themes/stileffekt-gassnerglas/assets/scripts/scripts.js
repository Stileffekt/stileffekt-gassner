class HeaderManager {
    constructor(headerSelector) {
        this.header = document.querySelector(headerSelector);
        this.scrollPositionLast = 0;
    }

    updateClasses() {
        if (window.scrollY >= 1) {
            if (!this.header.classList.contains('header--scrolled')) {
                this.header.classList.add('header--scrolled');
            }
        }
        if (window.scrollY >= 1 && window.scrollY > this.scrollPositionLast) {
            this.header.classList.remove('header--visible');

            if (!this.header.classList.contains('header--hidden')) {
                this.header.classList.add('header--hidden');
            }
        }

        if (window.scrollY < this.scrollPositionLast && this.scrollPositionLast !== 0) {
            this.header.classList.remove('header--hidden');

            if (!this.header.classList.contains('header--visible')) {
                this.header.classList.add('header--visible');
            }
        }

        if (window.scrollY <= 0) {
            this.header.classList.remove('header--visible');
            this.header.classList.remove('header--hidden');
            this.header.classList.remove('header--scrolled');
        }

        this.scrollPositionLast = window.scrollY;
    }
}

const headerManager = new HeaderManager('#header');

window.addEventListener('scroll', () => {
    headerManager.updateClasses();
});

const header = document.querySelector('#header');
const menuToggle = header ? header.querySelector('.header__toggle') : null;
const body = document.querySelector('body');

// --- Hamburger toggle (mobile menu open/close) ---
const inertTargets = header
    ? [
        ...header.querySelectorAll('.header__logo, .header__languages, .header__search'),
        ...Array.from(header.parentElement.children).filter(el => el !== header),
    ]
    : [];

function setNavInert(active) {
    inertTargets.forEach(el => {
        if (active) {
            el.setAttribute('inert', '');
        } else {
            el.removeAttribute('inert');
        }
    });
}

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        const isOpen = menuToggle.classList.contains('is-active');

        if (isOpen) {
            menuToggle.classList.remove('is-active');
            header.classList.remove('nav-active');
            body.classList.remove('no-scroll');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', menuToggle.dataset.labelOpen);
            setNavInert(false);

            document.querySelectorAll('.c-navigation__toggle[aria-expanded="true"]').forEach(btn => {
                btn.setAttribute('aria-expanded', 'false');
            });
        } else {
            menuToggle.classList.add('is-active');
            header.classList.add('nav-active');
            body.classList.add('no-scroll');
            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', menuToggle.dataset.labelClose);
            setNavInert(true);
        }
    });
}

// --- Submenu disclosure toggles ---
document.querySelectorAll('.c-navigation__toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
    });

    toggle.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            if (toggle.getAttribute('aria-expanded') === 'true') {
                event.preventDefault();
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
            }
        }
    });
});

document.querySelectorAll('.c-navigation__submenu').forEach(submenu => {
    submenu.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            const toggle = document.querySelector(`[aria-controls="${submenu.id}"]`);

            if (toggle) {
                event.preventDefault();
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
            }
        }
    });
});

// --- Desktop: hover opens/closes submenus via aria-expanded ---
const desktopQuery = window.matchMedia('(min-width: 1024px)');

document.querySelectorAll('.c-navigation__item--has-children').forEach(item => {
    const toggle = item.querySelector(':scope > .c-navigation__toggle');
    if (!toggle) return;

    item.addEventListener('mouseenter', () => {
        if (desktopQuery.matches) {
            toggle.setAttribute('aria-expanded', 'true');
        }
    });

    item.addEventListener('mouseleave', () => {
        if (desktopQuery.matches) {
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
});

// --- Back button (mobile) ---
document.querySelectorAll('.c-navigation__back').forEach(backBtn => {
    backBtn.addEventListener('click', () => {
        const submenu = backBtn.closest('.c-navigation__submenu');
        if (!submenu) return;

        const toggle = document.querySelector(`[aria-controls="${submenu.id}"]`);
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
            toggle.focus();
        }
    });
});

// --- Search ---
const search_toggle = document.querySelector('.header__search');
const search_overlay = document.querySelector('#search');
const search_close = document.querySelector('.close-search');
const form = document.querySelector('.search__form');

if (search_close && search_overlay) {
    form.addEventListener('submit', event => {
        event.preventDefault();
    })
    search_close.addEventListener('click', () => {
        search_overlay.classList.remove('is-active');
        body.classList.remove('no-scroll');
    })
    search_overlay.addEventListener('click', function (event) {
        event.stopPropagation();
        search_overlay.classList.remove('is-active')
    })
    search_overlay.querySelector('.search__form').addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
    })
    search_overlay.querySelector('.search__results').addEventListener('click', function (event) {
        if (event.target === this) {
            event.stopPropagation();
        }
    })
}
if (search_toggle) {
    search_toggle.addEventListener('click', function () {
        body.classList.add('no-scroll');
        search_overlay.classList.add('is-active')
    })
}

// Language switcher - universal script
// Works with any variant (list, dropdown, mix) - CSS controls visibility
const langSwitcher = document.querySelector('.c-langs');

if (langSwitcher) {
    const langToggle = langSwitcher.querySelector('.c-langs__toggle');
    const langList = langSwitcher.querySelector('.c-langs__list');

    // Check if toggle button is visible (CSS controls this per variant)
    const isToggleVisible = () => {
        if (!langToggle) return false;
        const style = window.getComputedStyle(langToggle);
        return style.display !== 'none' && style.visibility !== 'hidden';
    };

    if (langToggle && langList) {
        // Get all visible focusable links
        const getAllLinks = () => Array.from(langList.querySelectorAll('a.c-langs__link, span.c-langs__link'))
            .filter(link => {
                const style = window.getComputedStyle(link.parentElement);
                return style.display !== 'none';
            });

        // Toggle dropdown on click (only if button is visible)
        langToggle.addEventListener('click', (event) => {
            if (!isToggleVisible()) return;

            event.stopPropagation();
            const isExpanded = langToggle.getAttribute('aria-expanded') === 'true';

            if (isExpanded) {
                closeLangDropdown();
            } else {
                openLangDropdown();
            }
        });

        // Handle keyboard on toggle button (only if button is visible)
        langToggle.addEventListener('keydown', (event) => {
            if (!isToggleVisible()) return;

            const isExpanded = langToggle.getAttribute('aria-expanded') === 'true';

            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                if (!isExpanded) {
                    openLangDropdown();
                } else {
                    // Focus first or last item
                    const links = getAllLinks();
                    const targetLink = event.key === 'ArrowDown' ? links[0] : links[links.length - 1];
                    if (targetLink) targetLink.focus();
                }
            }
        });

        // Close dropdown when clicking outside (only if button is visible)
        document.addEventListener('click', (event) => {
            if (!isToggleVisible()) return;
            if (!langSwitcher.contains(event.target)) {
                closeLangDropdown();
            }
        });

        // Close dropdown when focus leaves (only if button is visible)
        langSwitcher.addEventListener('focusout', (event) => {
            if (!isToggleVisible()) return;

            // Check if the new focused element is outside the language switcher
            // Use setTimeout to ensure relatedTarget is set
            setTimeout(() => {
                if (!langSwitcher.contains(document.activeElement)) {
                    closeLangDropdown();
                }
            }, 0);
        });

        // Keyboard navigation in list (only if button is visible = dropdown mode)
        langList.addEventListener('keydown', (event) => {
            if (!isToggleVisible()) return;

            const links = getAllLinks();
            const currentIndex = links.indexOf(document.activeElement);

            if (event.key === 'Escape') {
                event.preventDefault();
                closeLangDropdown();
                langToggle.focus();
            } else if (event.key === 'ArrowDown') {
                event.preventDefault();
                if (currentIndex === -1) {
                    // No focus yet, focus first item
                    links[0].focus();
                } else {
                    // Move to next item, wrap to first
                    const nextIndex = (currentIndex + 1) % links.length;
                    links[nextIndex].focus();
                }
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (currentIndex === -1) {
                    // No focus yet, focus last item
                    links[links.length - 1].focus();
                } else {
                    // Move to previous item, wrap to last
                    const prevIndex = currentIndex === 0 ? links.length - 1 : currentIndex - 1;
                    links[prevIndex].focus();
                }
            } else if (event.key === 'Home') {
                event.preventDefault();
                links[0].focus();
            } else if (event.key === 'End') {
                event.preventDefault();
                links[links.length - 1].focus();
            }
        });

        function openLangDropdown() {
            langToggle.setAttribute('aria-expanded', 'true');
            langList.removeAttribute('hidden');

            // Automatically focus the first item
            const links = getAllLinks();
            if (links.length > 0) {
                // Small delay to ensure dropdown is visible
                setTimeout(() => links[0].focus(), 10);
            }
        }

        function closeLangDropdown() {
            langToggle.setAttribute('aria-expanded', 'false');
            langList.setAttribute('hidden', '');
        }
    }

}

//tooltip code
{
    document.addEventListener('DOMContentLoaded', () => {
        const tooltipElements = document.querySelectorAll('.c-tooltip');

        tooltipElements.forEach(el => {
            const tooltipId = el.getAttribute('aria-describedby');
            const tooltip = document.getElementById(tooltipId);
            const maxWidth = el.getAttribute('data-width') || '360';

            // Styling für Tooltip
            tooltip.style.position = 'absolute';
            tooltip.style.background = '#dedede';
            tooltip.style.color = '#000';
            tooltip.style.padding = '6px 10px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.fontSize = '14px';
            tooltip.style.maxWidth = maxWidth + 'px';
            tooltip.style.whiteSpace = 'normal';
            tooltip.style.wordWrap = 'break-word';
            tooltip.style.zIndex = '9999';

            let popperInstance = null;

            function show() {
                tooltip.hidden = false; // Entfernt das hidden-Attribut
                tooltip.setAttribute('aria-hidden', 'false');
                popperInstance = Popper.createPopper(el, tooltip, {
                    placement: 'bottom',
                    modifiers: [
                        {name: 'offset', options: {offset: [0, 10]}},
                        {name: 'preventOverflow', options: {padding: 16}}
                    ]
                });
            }

            function hide() {
                tooltip.hidden = true;
                tooltip.setAttribute('aria-hidden', 'true');
                if (popperInstance) {
                    popperInstance.destroy();
                    popperInstance = null;
                }
            }

            // Desktop: Hover + Fokus
            el.addEventListener('mouseenter', show);
            el.addEventListener('mouseleave', hide);
            el.addEventListener('focus', show);
            el.addEventListener('blur', hide);

            // Mobile: Klick toggelt Tooltip
            el.addEventListener('click', (e) => {
                e.preventDefault();
                if (tooltip.hidden) {
                    show();
                } else {
                    hide();
                }
            });

            // Klick außerhalb schließt Tooltip
            document.addEventListener('click', (e) => {
                if (!el.contains(e.target) && !tooltip.contains(e.target)) {
                    hide();
                }
            });
        });
    });

}


{
    // contact form 7 prevent multiple form submission
    // document.addEventListener('wpcf7submit', (e) => {
    //     const form = e.target;
    //     form.querySelector('[type=submit]').removeAttribute('disabled');
    // });
    //
    // document.addEventListener('wpcf7submit', (e) => {
    //     const form = e.target;
    //     form.querySelector('[type=submit]').disabled = true;
    // });
}