(function ($) {
	"use strict";

	jQuery(function ($) {
		$(document)
			.on("awesome_fetch_init", function () {
				$.ajax({
					type: "GET",
					url: ajaxurl,
					data: {
						action: "awesome_fetch_get_data",
						context: "fetching_data",
					},
					dataType: "json",
				});
			})
			.trigger("awesome_fetch_init");
	});
})(jQuery);
