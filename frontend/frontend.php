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
        $d = $params["data_recommendations"];
	if ($d == null || $d == "") {
		$d = "true";
	} // then
        $ds = $params["data_share"];
	if ($ds == null || $ds == "") {
		$ds = "false";
	} // then
        $dc = $params["data_comments"];
	if ($dc == null || $dc == "") {
		$dc = "false";
	} // then
         $di = $params["data_info"];
	if ($di == null || $di == "") {
		$di = "false";
	} // then
       
	return '<div class="riddle_target" data-game="'.$params["data_game"].'" data-width="'.$w.'" data-height="'.$h.'"  data_recommendations="'.$d.'" data_share="'.$ds.'" data_comments="'.$dc.'" data_info="'.$di.'"> </div>'.
	'<script type="text/javascript" src="//www.riddle.com/files/js/embed.js"></script>';
        
        
}

function build_iframe_widget($params) {
	
	if ($params["src"] == null || $params["src"] == "") {
		return "<div'>src attribute is missing</div>";
	} // then
	$w = $params["width"];
	if ($w == null || $w == "") {
		$w = "100%";
	} // then
	$h = $params["height"];
	if ($h == null || $h == "") {
		$h = "255px";
	} // then
        $o = $params["ohref"];
	if ($o == null || $o == "") {
		$o = "/Embed/List/preview";
	} // then
        $s = $params["style"];
	if ($s == null || $s == "") {
		$s = "border: medium none; width: 100%; height: 255px;";
	} // then
        
	return '<iframe class="preview" width="'.$w.'" height="'.$h.'" src="'.$params['src'].'" ohref="'.$o.'" style="'.$s.'"></iframe>';
        
      //  
}
add_shortcode('postriddle', 'build_postriddle');
add_shortcode('riddlelist', 'build_iframe_widget');


?>