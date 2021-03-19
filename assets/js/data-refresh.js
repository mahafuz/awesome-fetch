(function () {
	"use strict";

	var is_blocked = function ($node) {
		return $node.is(".processing") || $node.parents(".processing").length;
	};

	var block = function ($node) {
		if (!is_blocked($node)) {
			$node.addClass("processing");
		}
	};

	var unblock = function ($node) {
		$node.removeClass("processing");
	};

	jQuery(function ($) {
		$(document).ready(function () {
			$("#awf-refresh-button").on("click", function (ev) {
				ev.preventDefault();

				var $this = $(this),
					ajax_url = AwesomeFetch.ajax_url,
					nonce = AwesomeFetch.nonce,
					$form = $(".awf-data-form");

				block($form);

				$.ajax({
					type: "GET",
					url: ajax_url,
					data: {
						action: "awesome_fetch_get_data",
						nonce: nonce,
						context: "refresh_data",
					},
					dataType: "json",
					beforeSend: function () {
						$this.html(
							'<svg id="awf-spinner" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48"><circle cx="24" cy="4" r="4" fill="#fff"/><circle cx="12.19" cy="7.86" r="3.7" fill="#fffbf2"/><circle cx="5.02" cy="17.68" r="3.4" fill="#fef7e4"/><circle cx="5.02" cy="30.32" r="3.1" fill="#fef3d7"/><circle cx="12.19" cy="40.14" r="2.8" fill="#feefc9"/><circle cx="24" cy="44" r="2.5" fill="#feebbc"/><circle cx="35.81" cy="40.14" r="2.2" fill="#fde7af"/><circle cx="42.98" cy="30.32" r="1.9" fill="#fde3a1"/><circle cx="42.98" cy="17.68" r="1.6" fill="#fddf94"/><circle cx="35.81" cy="7.86" r="1.3" fill="#fcdb86"/></svg><span>Refresing...</span>'
						);
					},
					success: function (res) {
						setTimeout(function () {
							$this.html("Refresh");
							unblock($form);
							location.reload();
						}, 100);
					},
					error: function (res) {
						console.error(res);
					},
				});
			});
		});
	});
})();
