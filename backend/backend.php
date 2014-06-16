<?php
$rservername = "www.riddle.com";
function riddle_list () {
	global $rservername;
	echo "<div class='wrap riddleplugin'>";
	echo "<div class='riddleheader'>";
	echo "<div class='riddlelogo'><img src='".plugins_url("/images/logo.png", __FILE__ )."'></div>";
	echo "<h2>Riddle - HOW TO</h2>";
	echo "</div>";
	echo "<pre>";
	echo file_get_contents('http://'.$rservername.'/WordpressHelp2');
	echo "</pre></div>";
}

function riddle_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'riddle_nonce' ] ) && wp_verify_nonce( $_POST[ 'riddle_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-text' ] ) ) {
        update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
    }
}

function riddle_metabox() {
	global $rservername;
	$riddle_meta = get_post_meta( $post->ID );
    ?>
 
    <div id="riddle_area">
		<div class="riddle_description">
			Click a trending topic to insert the game shortcode.
		</div>
		<div class="riddle_trendings">
		<?php 
			$content = file_get_contents("http://".$rservername."/Api/Trends");
			$jsons = json_decode($content);
			foreach ($jsons->trends as $json) {
				echo "<a href='javascript:void(0);' class='riddle_click' data_game='".$json->data_game."'>";
				echo " <div class='riddle_item'>";
				echo "  <h3>".$json->rname."</h3>";
				if ($json->rimageurl != null && $json->rimageurl != "") {
					echo "  <div class='thumbnail'><img src='".$json->rimageurl."'></div>";
				} // then
				else {
					echo "  <div class='thumbnail'><img src='".plugins_url('/images/riddle_600x400.jpg', __FILE__ )."'></div>";
				} // else
				echo " </div>";
				echo "</a>";
			} // foreach
			echo "<div style='clear:both;' />";
		?>
		</div>
    </div>
 
    <?php
}

add_action( 'add_meta_boxes', function() {
	add_meta_box( 'riddle_meta', __( 'Riddle', 'riddle' ), function() {
		riddle_metabox(); 
	}, "post" );
});
add_action( 'save_post', 'riddle_meta_save' );
add_action('admin_enqueue_scripts', function ($hook) {
    global $page_handle;
	wp_enqueue_style( 'portfolio-admin-style', plugins_url('/css/riddle.css', __FILE__ ), false, '1.0.0' );
    if ( ($hook == 'post.php') || ($hook == 'post-new.php') || ($hook == 'page.php') || ($hook == 'page-new.php') || ($_GET['page'] == $page_handle) ) {
        
		wp_enqueue_script( 'portfolio-admin-script', plugins_url('/js/riddle.js', __FILE__ ), false, '1.0.0' );
    }
});
add_action('admin_menu', function() {
	global $rservername;
	add_menu_page('Riddle', 'Riddle', 10, __FILE__, 'riddle_list', "//".$rservername."/files/images/riddle_16x16.png");
});
?>