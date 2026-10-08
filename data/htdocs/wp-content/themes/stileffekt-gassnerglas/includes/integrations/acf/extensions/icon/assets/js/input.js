(function ($) {
    var active_item;

    jQuery(document).on('click', 'li[data-svg]', function () {
        var val = jQuery(this).attr('data-svg');
        active_item.find('input').val(val);
        active_item.find('.acf-icon-picker__svg').html(
            '<img src="' +
            jQuery(this)
                .find('img')
                .attr('src') +
            '" alt=""/>'
        );

        jQuery('.acf-icon-picker__popup-holder').trigger('close');
        jQuery('.acf-icon-picker__popup-holder').remove();
        jQuery('.acf-icon-picker__img input').trigger('change');

        active_item
            .parents('.acf-icon-picker')
            .find('.acf-icon-picker__remove')
            .addClass('acf-icon-picker__remove--active');
    });

    function initialize_field($el) {
        if ($el.data('acf-icon-picker-initialized')) {
            return;
        }

        $el.data('acf-icon-picker-initialized', true);

        $el.find('.acf-icon-picker__img').on('click', function (e) {
            e.preventDefault();
            active_item = $(this);

            if (iv.svgs.length == 0) {
                var list = '<p>' + iv.no_icons_msg + '</p>';
            } else {
                var list = `<ul class="acf-icon-picker__icon-list">`;
                list += `</ul>`;
            }

            jQuery('body').append(
                `<div class="acf-icon-picker__popup-holder">
        <div class="acf-icon-picker__popup">
        <a class="acf-icon-picker__popup__close" href="javascript:">Close</a>
        <h4 class="acf-icon-picker__popup__title">Icons</h4>
        <input class="acf-icon-picker__filter" type="text" id="filterIcons" placeholder="Search icons..." />
          ${list}
        </div>
      </div>`
            );

            var $list = jQuery('.acf-icon-picker__popup-holder').last().find('.acf-icon-picker__icon-list');
            var svgs = iv.svgs;

            function getIconLabel(svg) {
                return svg['name'].replace(
                    /[-_]/g,
                    ' '
                ).replace(
                    /Streamline Ultimate/g,
                    ''
                ).trim();
            }

            function renderIcons(icons) {
                $list.empty();

                icons.forEach(function (svg) {
                    var iconLabel = getIconLabel(svg);
                    var $el = $(`<li>
              <div class="acf-icon-picker__popup-svg">
                <img src="" alt=""/>
              </div>
              <span class="acf-icon-picker__icon-name"></span>
            </li>`);

                    $el.attr({
                        'data-svg': svg.name,
                        'title': iconLabel,
                        'aria-label': iconLabel
                    });
                    $el.find('.acf-icon-picker__icon-name').text(iconLabel);
                    $el.find('img').attr('src', `${svg['icon']}`);
                    $list.append($el);
                });
            }

            if (svgs.length) {
                renderIcons(svgs);
            }

            const iconsFilter = document.querySelector('#filterIcons');

            function filterIcons(wordToMatch) {
                return iv.svgs.filter(icon => {
                    let name = icon.name.replace(/[-_]/g, ' ');
                    const regex = new RegExp(wordToMatch, 'gi');
                    return name.match(regex);
                });
            }

            function displayResults() {
                renderIcons(filterIcons($(this).val()));
            }

            iconsFilter.focus();

            iconsFilter.addEventListener('keyup', displayResults);

            // Closing
            jQuery('.acf-icon-picker__popup__close').on('click', function (e) {
                e.stopPropagation();
                jQuery('.acf-icon-picker__popup-holder').remove();
            });
        });

        // show the remove button if there is an icon selected
        const $input = $el.find('input')
        if ($input.length && $input.val().length != 0) {
            $el
                .find('.acf-icon-picker__remove')
                .addClass('acf-icon-picker__remove--active');
        }

        $el.find('.acf-icon-picker__remove').on('click', function (e) {
            e.preventDefault();
            var parent = $(this).parents('.acf-icon-picker');
            parent.find('input').val('');
            parent
                .find('.acf-icon-picker__svg')
                .html('<span class="acf-icon-picker__svg--span">+</span>');

            jQuery('.acf-icon-picker__img input').trigger('change');

            parent
                .find('.acf-icon-picker__remove')
                .removeClass('acf-icon-picker__remove--active');
        });
    }

    if (typeof acf.add_action !== 'undefined') {
        acf.add_action('ready append remount', function ($el) {
            acf.get_fields({type: 'icon_picker'}, $el).each(function () {
                initialize_field($(this));
            });
        });
    }
})(jQuery);
