<div id="search" class="search overlay">

    <div class="search__background"></div>

    <div class="l-padding">

        <div class="l-width">

            <div class="search__bar">
                <form action="/" method="get" autocomplete="off" class="search__form">
                    <input type="text" name="s"
                           placeholder="<?= __( 'What are you looking for?', 'stilpress' ) ?>"
                           id="keyword" class="input_search" onkeyup="stilpress__search()">
                    <button type="submit"><?= __( 'Search', 'stilpress' ); ?></button>
                </form>

                <div class="close-search">

                    <button class="toggle toggle--search is-active" aria-label="Close Search">

					<span class="toggle__indicator">
						<span></span>
                        <span></span>
						<span></span>
					</span>

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="search__results l-padding">
        <div class="l-width">
            <div class="results" id="search_result"></div>
        </div>
    </div>

</div>