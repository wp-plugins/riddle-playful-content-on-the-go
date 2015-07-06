<?php

/*****************************/
/*** Get all regular pages ***/
/*****************************/
function rid_getPages() {
    wp_enqueue_script('preview-script', plugins_url('/js/prev.js', __FILE__), false, '1.0.0');

    $args = array(
        'sort_order' => 'ASC',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );

    $pages = get_pages($args);
    $option = '<select name="page-dropdown" id="pageSelection" onchange="rid_getValPage()"><option value="">Select page</option>'; //

    foreach ($pages as $page) {
        $option .= '<option value="' . $page->ID . '">'; ///*' . get_page_link( $page->ID ) . '
        $option .= $page->post_title;
        $option .= '</option>';
    }
    $option .='</select>';
    return $option;
}

/*****************************/
/*** Get all regular posts ***/
/*****************************/

function rid_getPosts() {
    wp_enqueue_script('preview-script', plugins_url('/js/prev.js', __FILE__), false, '1.0.0');

    $args = array(
        'sort_order' => 'ASC',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'post',
        'post_status' => 'publish'
    );

    $pages = get_posts($args);
    $option = '<select name="post-dropdown" id="pageSelection" onchange="rid_getValPage1()"><option value="">Select post</option>'; //

    foreach ($pages as $page) {
        $option .= '<option value="' . $page->ID . '">'; ///*' . get_page_link( $page->ID ) . '
        $option .= $page->post_title;
        $option .= '</option>';
    }
    $option .='</select>';
    return $option;
}

/******************************/
/*** ADD a Riddle to a Page ***/
/******************************/

function rid_addToPage($pid,  $postriddle, $rid) {

        $page = array(
            'ID' => $pid,
            'post_content' => get_post_field('post_content', $pid) . "<br/>" . $postriddle,
            'post_type' => 'page',
        );

        $arr = get_metadata('post', $pid, 'metaRidPage', true);

        if ($arr == NULL) {
            $arr = array();
            $arr[0] = array(
                'riddle' => $postriddle,
                'data_id' => $rid
            );
            update_metadata('post', $pid, 'metaRidPage', $arr);
        } else {
            $c = count($arr);

            $arr[$c]['riddle'] = $postriddle;
            $arr[$c]['data_id'] = $rid;
            update_metadata('post', $pid, 'metaRidPage', $arr);
        }
   


    wp_update_post($page);
   echo ' <script type="text/javascript"> window.location = "' . admin_url() . 'post.php?post=' . $pid . '&action=edit"</script>';
}
/******************************/
/*** ADD a Riddle to a Post ***/
/******************************/
function rid_addToPost($pid,  $postriddle, $rid) {

        $page = array(
            'ID' => $pid,
            'post_content' => get_post_field('post_content', $pid) . "<br/>" . $postriddle,
            'post_type' => 'post',
        );
    
        $arr = get_metadata('post', $pid, 'metaRidPost', true);

        if ($arr == NULL) {
            $arr = array();
            $arr[0] = array(
                'riddle' => $postriddle,
                'data_id' => $rid
            );
            update_metadata('post', $pid, 'metaRidPost', $arr);
        } else {
            $c = count($arr);

            $arr[$c]['riddle'] = $postriddle;
            $arr[$c]['data_id'] = $rid;
            update_metadata('post', $pid, 'metaRidPost', $arr);
        }
    

    wp_update_post($page);
    echo ' <script type="text/javascript"> window.location = "' . admin_url() . 'post.php?post=' . $pid . '&action=edit"</script>';
}


/******************************/
/*** Create Riddle Shortcode ***/
/******************************/
function getPostriddleCode($ridid) {
 return '[riddle id="'.$ridid.'"]';
}
?>