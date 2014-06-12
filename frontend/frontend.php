<?php
// Build our form with a shortcode
function build_postriddle($params) {
	
	if ($params["data_game"] == null || $params["data_game"] == "") {
		return "<div class='riddle_target'>data_game attribute is missing</div>";
	} // then
	$w = $params["data_width"];
	if ($w == null || $w == "") {
		$w = "auto";
	} // then
	$h = $params["data_height"];
	if ($h == null || $h == "") {
		$h = "auto";
	} // then
	return '<div class="riddle_target" data-game="'.$params["data_game"].'" data-width="'.$w.'" data-height="'.$h.'"> </div>'.
	'<script type="text/javascript" src="//www.riddle.com/files/js/embed.js"></script>';
}
add_shortcode('postriddle', 'build_postriddle');

?>