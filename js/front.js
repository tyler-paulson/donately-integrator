(function(document, $) {

	$(function() {

        $('.di-list:gt(0)').hide();
        $('.di-categories').show();
        $('.di-categories li').first().children('button').addClass('is-active');

        $('.di-cat_filter').on('click', function() {
            var btn = this;
            $('.di-list').hide();
            $('.di-categories li button').removeClass('is-active');
            $('.di-list').each(function() {
                if($(this).data('category') === $(btn).text()) {
                    $(this).show();
                    $(btn).addClass('is-active');
                }
            });
        });

        if(typeof(window.URL) != "undefined") {

            const url = new URL(window.location.href);
            const category = url.searchParams.get('category');

            if(category) {
                $('.di-cat_filter').each(function() {
                    if($(this).text().toLowerCase() === category.toLowerCase()) {
                        $(this).trigger('click');
                        return false;
                    }
                });
            }

        }

	});

})(document, jQuery);
