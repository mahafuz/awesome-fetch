(function () {
	"use strict";

	jQuery(function ($) {
		$(document)
			.on("awesome_fetch_init", function () {
				var ajax_url = AwesomeFetch.ajax_url,
					nonce = AwesomeFetch.nonce;

				$.ajax({
					type: "GET",
					url: ajax_url,
					data: {
						action: "awesome_fetch_get_data",
						nonce: nonce,
						context: "get_data",
					},
					dataType: "json",
				});
			})
			.trigger("awesome_fetch_init");
	});
})();
