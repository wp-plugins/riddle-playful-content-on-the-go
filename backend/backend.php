<?php
wp_enqueue_script( 'z-script', plugins_url('/js/zClip.js', __FILE__ ), false, '1.0.0' );
$rservername = "www.riddle.com";

add_action('admin_menu','riddleclosure3');
add_action('init', 'rid_insert_post');
add_action('init', 'rid_add_to_page');
add_action( 'init', 'rid_create_post_type' );
add_action( 'pre_get_posts', 'rid_add_customposts_to_query' );
add_action('admin_enqueue_scripts', 'riddleclosure2');
add_action( 'save_post', 'riddle_meta_save' );

add_filter('widget_text', 'do_shortcode');

$riddleResult = array();
function riddle_loadremote($url) {
    global $riddleResult;
        if($url != null) {
            if ($riddleResult[$url]!=null) {
                return $riddleResult[$url];
            }
        }
	$ch = curl_init();

	// Set the url, number of GET vars, GET data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, false);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// Execute request
	$result = curl_exec($ch);
        $riddleResult[$url] = $result;
	return $result;
}

function riddle_list () { 

       wp_enqueue_script( 'preview-script', plugins_url('/js/prev.js', __FILE__ ), false, '1.0.0' );
     
	global $rservername;  
     
	echo "<div class='wrap riddleplugin'>";
 	echo "<div class='riddleheader'>";
	echo "<div class='riddlelogo'><img src='".plugins_url("/images/logo.png", __FILE__ )."'></div>";
        echo "<h2>Riddle - HELP</h2>";
	echo "</div>";  
      /*  include('form.php');      
        $r = getPages();
        echo "<form name='hid' style='visibility : hidden;'> <input type='hidden' name='hidPa' id='hidPaId' value='".$r."'></form>";*/
        echo '<div id="ridVideoFrame"><iframe width="560" height="315" src="//www.youtube.com/embed/A5LVOp0YNbw" frameborder="0" allowfullscreen></iframe></div>';
        echo "<pre>";
	echo riddle_loadremote('http://'.$rservername.'/WordpressHelp2');// file_get_contents('http://'.$rservername.'/WordpressHelp2');
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
	$riddle_meta = get_post_meta( $post->ID , null);
    ?>
 
    <div id="riddle_area">
		<div class="riddle_description">
			Click a trending topic to insert the game shortcode.
		</div>
		<div class="riddle_trendings">
		<?php 
			//$content = file_get_contents("http://".$rservername."/Api/Trends");
			$content = riddle_loadremote("http://".$rservername."/Api/Trends");
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
function riddleclosure1() {
	add_meta_box( 'riddle_meta', __( 'Riddle', 'riddle' ), 'riddle_metabox', "build_postriddle" );
}
#add_action( 'add_meta_boxes', 'riddleclosure1');

function riddleclosure2($hook) {
    global $page_handle;
	wp_enqueue_style( 'portfolio-admin-style', plugins_url('/css/riddle.css', __FILE__ ), false, '1.0.0' );
    if ( ($hook == 'post.php') || ($hook == 'post-new.php') || ($hook == 'page.php') || ($hook == 'page-new.php') || ($_GET['page'] == $page_handle) ) {
        
	wp_enqueue_script( 'portfolio-admin-script', plugins_url('/js/riddle.js', __FILE__ ), false, '1.0.0' );
    }
}

 function riddleclosure3 () {
	global $rservername;
	add_menu_page('Riddle Help', 'Riddle',  'manage_options', 'riddlemain', '', "//".$rservername."/files/images/riddle_16x16.png");
            add_submenu_page("riddlemain", "Riddle Help", "Help", 'manage_options', 'riddlemain', 'riddle_list');
        add_submenu_page("riddlemain", "Add Riddle", "Add Riddle", 'manage_options', 'riddle_search', 'riddle_search');
        add_submenu_page("riddlemain", "Your added Riddles", "Your added Riddles", 'manage_options', 'your_riddles', 'your_riddles');
         add_submenu_page("riddlemain", "Add Category", "Add Category", 'manage_options', 'add_categories', 'rid_add_categories');
        add_submenu_page("riddlemain", "Your added Categories", "Your added Categories", 'manage_options', 'your_added_categories', 'rid_yourAddedCategories');

}

function showRiddlesPage(){
        echo '<script type="text/javascript"> window.location = "'.admin_url().'edit.php?post_type=wp_riddlepost"</script>';
} 
function rid_showCategorysPage(){
        echo '<script type="text/javascript"> window.location = "'.admin_url().'edit.php?post_type=wp_riddlepost_prev"</script>';
} 


//create custom post type wp_riddlepost
 function rid_create_post_type(){
    $args =  array(
      'labels' => array(
        'name' => __( 'Riddles' ),
        'singular_name' => __( 'Riddle' ),
        'edit_item' => __( 'Give your post a cool title' ),
        'add_new_item' => __( 'Add New Riddle' ),
        'new_item' => __( 'New Riddle' ),
        'view_item' => __( 'View Riddle' ),
        'search_items' => __( 'Search Riddle' )
        
      ),
      'public' => true,
      'has_archive' => true,
        'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => false,
	'query_var'          => true,
	'rewrite'            => array( 'slug' => 'riddles' ),
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => false,
	'menu_position'      => 100,
        'menu-icon'          => "//".$rservername."/files/images/riddle_16x16.png",
	'supports'           => array( 'title', 'author',  'comments' )
      
    );
    register_post_type('wp_riddlepost', $args);
    
    
    //////////
      $args1 =  array(
      'labels' => array(
        'name' => __( 'Riddles' ),
        'singular_name' => __( 'Riddle' ),
        'edit_item' => __( 'Give your post a cool title' ),
        'add_new_item' => __( 'Add New Riddle' ),
        'new_item' => __( 'New Riddle' ),
        'view_item' => __( 'View Riddle' ),
        'search_items' => __( 'Search Riddle' )
     
      ),
      'public' => true,
      'has_archive' => true,
        'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => false,
	'query_var'          => true,
	'rewrite'            => array( 'slug' => 'riddles_prev' ),
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => false,
	'menu_position'      => 100,
        'menu-icon'          => "//".$rservername."/files/images/riddle_16x16.png",
	'supports'           => array( 'title', 'author',  'comments' )
      
    );
    register_post_type('wp_riddlepost_prev', $args1);
 }
 
//add custom posts to home page
function rid_add_customposts_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'wp_riddlepost', 'wp_riddlepost_prev' ) );
  return $query;
}
       
function prfx_custom_meta_prev($id) {
    add_meta_box( 'prfx_meta', __( 'Preview', 'prfx-textdomain' ), 'prfx_meta_callback_prev', 'wp_riddlepost_prev' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta_prev' );

function prfx_custom_meta($id) {
    add_meta_box( 'prfx_meta', __( 'Preview', 'prfx-textdomain' ), 'prfx_meta_callback', 'wp_riddlepost' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

function prfx_custom_metapost($id) {
    add_meta_box( 'prfx_meta', __( 'Preview', 'prfx-textdomain' ), 'prfx_meta_callbackpost', 'post' );
}
add_action( 'add_meta_boxes', 'prfx_custom_metapost' );

function prfx_custom_metapage($id) {
    add_meta_box( 'prfx_meta', __( 'Preview', 'prfx-textdomain' ), 'prfx_meta_callbackpage', 'page' );
}
add_action( 'add_meta_boxes', 'prfx_custom_metapage' );

function prfx_meta_callback_prev(){
    $post_id = $_GET['post'];
  $content_post = get_post($post_id);
    $content = $content_post->post_content;
    $cont = substr($content, strpos($content, 'src=')+5);
    $arr = explode('"', $cont);
    $PostRiddle = rid_createFrameCode($arr[0]);

    echo '<p style="width: 101.8%; margin-left: -12px;padding-right: 100px;">'.$PostRiddle['iFrameCode'].'</p>'; 
       # echo '<div style="height: 100px"></div>';
}
function prfx_meta_callback(){
    $post_id = $_GET['post'];
     $content_post = get_post($post_id);
       $content = $content_post->post_content;
          $cont = substr($content, strpos($content, 'data_game=')+11);
    $arr = explode('"', $cont);
    echo '<div class="riddle_list" data-game="'.$arr[0].'"  data-width="" data-height=""></div>  <script type="text/javascript" src="//www.riddle.com/files/js/embed.js?qvs=2.1"></script>';
}

function prfx_meta_callbackpost(){
    
//metaRidP & MetaRid2
        $post_id = $_GET['post'];
        $arr1 = array();
       $arr1= get_metadata('post', $post_id, 'metaRid1' , true);
   
        for($s=0;is_array($arr1) && $s< count($arr1);$s++){    
           echo ' <div    class="riddle_list"  data-game="'.  $arr1[$s]['data_game'] .'"  data-width=""  data-height=""> </div><script type="text/javascript" src="//www.riddle.com/files/js/embed.js?qvs=2.1"></script> ';
        }
        
        $arr2 = array();
        $arr2= get_metadata('post', $post_id, 'metaRidP' , true);
   
        for($s=0;is_array($arr2) && $s< count($arr2);$s++){    
        
         $ridFramecode = rid_createFrameCode( $arr2[$s]['src']);
         echo  '<p>'. $ridFramecode["iFrameCode"].'</p>';
          }
}

function prfx_meta_callbackpage(){

//metaRid & MetaRid1
        $post_id = $_GET['post'];
        $arr1 = array();
       $arr1= get_metadata('post', $post_id, 'metaRid2' , true);


        for($s=0;is_array($arr1) && $s< count($arr1);$s++){    
           echo ' <div    class="riddle_list"  data-game="'.  $arr1[$s]['data_game'] .'"  data-width=""  data-height=""> </div> <script type="text/javascript" src="//www.riddle.com/files/js/embed.js?qvs=2.1"></script>';
        }
        
        $arr2 = array();
        $arr2= get_metadata('post', $post_id, 'metaRid' , true);
   
        for($s=0;is_array($arr2) && $s< count($arr2);$s++){    
        
         $ridFramecode = rid_createFrameCode( $arr2[$s]['src']);
         echo  '<p >'. $ridFramecode["iFrameCode"].'</p>'; 
          }
}


?>
 