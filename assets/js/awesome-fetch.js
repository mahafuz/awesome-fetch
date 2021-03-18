(function () {
	"use strict";

	jQuery(function ($) {
		$(document)
			.on("awesome_fetch_init", function () {
				var ajax_url = AwesomeFetch.ajax_url,
					nonce = AwesomeFetch.nonce,
					send_request = Boolean(AwesomeFetch.send_request);

				if (send_request) {
					$.ajax({
						type: "GET",
						url: ajax_url,
						data: {
							action: "awesome_fetch_get_data",
							nonce: nonce,
						},
						dataType: "json",
					});
				}
			})
			.trigger("awesome_fetch_init");
	});
})();
