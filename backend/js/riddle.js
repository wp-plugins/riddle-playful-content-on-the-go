jQuery(document).ready(function () {
	jQuery("body").delegate("a.riddle_click", "click", function () {
		var a = jQuery(this);
		send_to_editor("<p>[postriddle data_game='"+a.attr("data_game")+"']</p>");
	});
});