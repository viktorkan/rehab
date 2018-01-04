if (jQuery().owlCarousel) {
    jQuery('.portfolio-container').each(function () {

        var portfolio = jQuery(this);
        var unique_id = portfolio.data('unique_id') ? portfolio.data('unique_id') : '';
        var portfolio_class = '.portfolio-container-',
            unique_portfolio_class = portfolio_class + unique_id;

        jQuery(unique_portfolio_class).mixItUp({
            selectors: {
                target: '.mix_' + unique_id,
                filter: '.filter_' + unique_id,
                sort: '.sort_' + unique_id
            }
        });
        jQuery(unique_portfolio_class + ' .wrapp-categories-portfolio .categories-item a').click(function (e) {
            e.preventDefault();
        });

    });
}
