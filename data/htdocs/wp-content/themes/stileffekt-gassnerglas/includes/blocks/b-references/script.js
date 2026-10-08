(function (blocks) {
    blocks.register('.b-references', function (block) {
        const industries = block.querySelector('[data-reference-filter="industries"]');
        const areas = block.querySelector('[data-reference-filter="areas"]');
        const interfaces = block.querySelector('[data-reference-filter="interfaces"]');
        const references = block.querySelectorAll('.c-reference');
        const referencesContainer = block.querySelector('.c-references');
        const controller = new AbortController();

        if (!industries || !areas || !interfaces || !referencesContainer) {
            return;
        }

        function getValues(select) {
            return Array.from(select.selectedOptions).map(function (option) {
                return option.value;
            });
        }

        function filterReferences() {
            const valsIndustries = getValues(industries);
            const valsAreas = getValues(areas);
            const valsInterfaces = getValues(interfaces);

            let itemsVisible = false;

            references.forEach(function (reference) {
                const termsIndustries = (reference.dataset.industries || '').split(',');
                const termsAreas = (reference.dataset.areas || '').split(',');
                const termsInterfaces = (reference.dataset.interfaces || '').split(',');

                const matchesIndustries = valsIndustries.length === 0 || valsIndustries.some(function (value) {
                    return termsIndustries.includes(value);
                });
                const matchesAreas = valsAreas.length === 0 || valsAreas.some(function (value) {
                    return termsAreas.includes(value);
                });
                const matchesInterfaces = valsInterfaces.length === 0 || valsInterfaces.some(function (value) {
                    return termsInterfaces.includes(value);
                });

                const visible = matchesIndustries && matchesAreas && matchesInterfaces;
                reference.style.display = visible ? '' : 'none';

                if (visible) {
                    itemsVisible = true;
                }
            });

            let noResults = referencesContainer.querySelector('[data-no-results-message]');
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.dataset.noResultsMessage = '';
                noResults.setAttribute('role', 'status');
                noResults.textContent = 'Keine Ergebnisse gefunden.';
                referencesContainer.appendChild(noResults);
            }
            noResults.hidden = itemsVisible;
        }

        [industries, areas, interfaces].forEach(function (select) {
            select.addEventListener('change', filterReferences, {signal: controller.signal});
        });

        filterReferences();

        return function () {
            controller.abort();
        };
    });
}(window.stilpressBlocks));
