<?php
// Build our form with a shortcode
function build_postriddle($params) {
	
	if ($params["id"] == null || $params["id"] == "") {
		return "<div class='riddle_target'>data_game attribute is missing</div>";
	} 
	return '<div class="riddle_target" data-url="http://staging.riddle.com/a/'.$params["id"].'"></div><script type="text/javascript" src="http://staging.riddle.com/files/js/embed.js"></script>';
}
add_shortcode('riddle', 'build_postriddle');

?>