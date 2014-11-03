<?php
     global $ridSearchText;
wp_enqueue_script( 'preview-script', plugins_url('/js/prev.js', __FILE__ ), false, '1.0.0' );

function rid_createPost($ridpostcontent, $ridposttype, $postriddle, $rID){

    $my_post = array(
                   'post_content'  => $ridpostcontent,
                   'post_type' => $ridposttype
                    );
     wp_insert_post( $my_post ); 

        $args = array(
	'posts_per_page'   => 1,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => $ridposttype,
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'draft',
	'suppress_filters' => true );
        $latest_cpt = get_posts($args);
        $id =  $latest_cpt[0]->ID;
      
        if($ridposttype == 'wp_riddlepost'){
          // $postriddle = getPostriddleCode($id, '100%', 'auto');
         
           add_metadata('post', $id, 'data_game', $postriddle["data_game"]);
           add_metadata('post', $id, 'data_width', $postriddle["data-width"]);
           add_metadata('post', $id, 'data_height', $postriddle["data-height"]);  
           add_metadata('post', $id, 'data_id', $rID);
        }
        
         else if($ridposttype == 'wp_riddlepost_prev'){
           
           $ridFrameCode = rid_createFrameCode($_POST["hidFr"]);
        #   echo $ridFrameCode["src"];
           add_metadata('post', $id, 'ridFrameSrc', $ridFrameCode["src"]);
           add_metadata('post', $id, 'ridFrameCode', $ridFrameCode["recCodeFinal"]);  
        }
        
    echo '<script type="text/javascript"> window.location = "'.admin_url().'post.php?post='.+$id.'&action=edit"</script>';
}   




function rid_getPages(){
  wp_enqueue_script( 'preview-script', plugins_url('/js/prev.js', __FILE__ ), false, '1.0.0' );
  
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

    foreach ( $pages as $page ) {
          $option .= '<option value="' .$page->ID. '">'; ///*' . get_page_link( $page->ID ) . '
          $option .= $page->post_title;
          $option .= '</option>';
   } 
    $option .='</select>';
    return $option;

}

function rid_getPosts(){
  wp_enqueue_script( 'preview-script', plugins_url('/js/prev.js', __FILE__ ), false, '1.0.0' );
  
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
    $option = '<select name="page-dropdown1" id="pageSelection" onchange="rid_getValPage1()"><option value="">Select post</option>'; //

    foreach ( $pages as $page ) {
          $option .= '<option value="' .$page->ID. '">'; ///*' . get_page_link( $page->ID ) . '
          $option .= $page->post_title;
          $option .= '</option>';
   } 
    $option .='</select>';
    return $option;

}

function rid_addToPage($ridPid, $ridPcontent, $ridTitle, $ridPostType, $postriddle, $rID){
    
    $ridFrameCode;
    if($ridPostType == 'wp_riddlepost'){
   //      $postriddle = getPostriddleCode($ridPcontent, "100%", "auto");
            $page = array(
                'ID'           => $ridPid,
                'post_content' => get_post_field('post_content', $ridPid)."<br/>". $postriddle["code"],
                'post_type'     => 'page',
            );
            /*
             *   add_metadata('post', $id, 'data_game', $postriddle["data_game"]);
           add_metadata('post', $id, 'data_width', $postriddle["data-width"]);
           add_metadata('post', $id, 'data_height', $postriddle["data-height"]);
             */
              $arr= get_metadata('post', $ridPid, 'metaRid2', true );

         if($arr == NULL){     
             $arr = array();
             $arr[0] = array(
                        'data_game' => $postriddle["data_game"],
                        'data_width' =>$postriddle["data-width"],
                        'data_height' => $postriddle["data-height"],
                      'data_id' => $rID
                    );  
             update_metadata('post', $ridPid, 'metaRid2', $arr);
         } else{
           $c = count($arr);

          $arr[$c]['data_game'] = $postriddle["data_game"];
          $arr[$c]['data_height'] =  $postriddle["data-width"];
          $arr[$c]['data_width'] =  $$postriddle["data-height"];
              $arr[$c]['data_id'] = $rID;
          update_metadata('post', $ridPid, 'metaRid2', $arr);
         }
            
    }else if($ridPostType == 'wp_riddlepost_prev'){
        $ridFrameCode = rid_createFrameCode($ridPcontent);
          $page = array(
                'ID'           => $ridPid,
                'post_content' => get_post_field('post_content', $ridPid)."<br/>". $ridFrameCode["recCodeFinal"],
                'post_type'     => 'page',
          );
          
           $arr= get_metadata('post', $ridPid, 'metaRid', true );

         if($arr == NULL){     
             $arr = array();
             $arr[0] = array(
                        'title' => $ridTitle,
                        'src' =>$ridFrameCode["src"]
                    );  
             update_metadata('post', $ridPid, 'metaRid', $arr);
         } else{
           $c = count($arr);

          $arr[$c]['title'] = $ridTitle;
          $arr[$c]['src'] =  $ridFrameCode["src"];
          update_metadata('post', $ridPid, 'metaRid', $arr);
         }
    }
  

    wp_update_post($page);
    echo ' <script type="text/javascript"> window.location = "'.admin_url().'post.php?post='.$ridPid.'&action=edit"</script>';
}

function rid_addToPost($ridPid, $ridPcontent, $ridTitle, $posttype, $postriddle, $rid){
   
    if($posttype=='wp_riddlepost_prev'){
        
  $ridFrameCode  = rid_createFrameCode( $ridPcontent);
    $page = array(
        'ID'           => $ridPid,
        'post_content' => get_post_field('post_content', $ridPid)."<br/>".$ridFrameCode["recCodeFinal"] ,
        'post_type'     =>  'post',
      );
    
       $arr= get_metadata('post', $ridPid, 'metaRidP', true );

         if($arr == NULL){     
             $arr = array();
             $arr[0] = array(
                        'title' => $ridTitle,
                        'src' =>$ridFrameCode["src"]
                    );  
       
             update_metadata('post', $ridPid, 'metaRidP', $arr);
         } else{
             
           $c = count($arr);

          $arr[$c]['title'] = $ridTitle;
          $arr[$c]['src'] =  $ridFrameCode["src"];
          update_metadata('post', $ridPid, 'metaRidP', $arr);
         }
         
    } 
    else if($posttype == 'wp_riddlepost'){
      //   $postriddle = getPostriddleCode($ridTitle, "100%", "auto");
            $page = array(
                'ID'           => $ridPid,
                'post_content' => get_post_field('post_content', $ridPid)."<br/>". $postriddle["code"],
                'post_type'     => 'post',
            );
            /*
             *   add_metadata('post', $id, 'data_game', $postriddle["data_game"]);
           add_metadata('post', $id, 'data_width', $postriddle["data-width"]);
           add_metadata('post', $id, 'data_height', $postriddle["data-height"]);
             */
              $arr= get_metadata('post', $ridPid, 'metaRid1', true );

         if($arr == NULL){     
             $arr = array();
             $arr[0] = array(
                        'data_game' => $postriddle["data_game"],
                        'data_width' =>$postriddle["data-width"],
                        'data_height' => $postriddle["data-height"],
                        'data_id' => $rid
                    );  
             update_metadata('post', $ridPid, 'metaRid1', $arr);
         } else{
           $c = count($arr);

          $arr[$c]['data_game'] = $postriddle["data_game"];
          $arr[$c]['data_height'] =  $postriddle["data-width"];
          $arr[$c]['data_width'] =  $postriddle["data-height"];
          $arr[$c]['data_id'] =  $rid;
          update_metadata('post', $ridPid, 'metaRid1', $arr);
         }
            
    }

  wp_update_post($page);
 echo ' <script type="text/javascript"> window.location = "'.admin_url().'post.php?post='.$ridPid.'&action=edit"</script>';
}



function rid_updatePost($ridPid, $ridPcontent, $posttype, $postriddle){ 

  #  echo $ridPcontent;
    if($posttype == 'wp_riddlepost_prev'){
       
           $page = array(
        'ID'           => $ridPid,
        'post_content' => $ridPcontent,
        'post_type'    =>  $posttype,
      );
           $ridFrameCode = rid_createFrameCode($_POST["rid_hidFr"]);
         
          update_metadata('post', $ridPid, 'ridFrameSrc', $ridFrameCode["src"]);
          update_metadata('post', $ridPid, 'ridFrameCode', $ridFrameCode["code"]);  
       
        } else if ($posttype == 'page'){
                 $rid_postcontent ="";
                 $arr_new= get_metadata('post', $ridPid, 'metaRid', true );
                for($b=0;is_array($arr_new) && $b< count($arr_new);$b++){
                    $ridCode = rid_createFrameCode($arr_new[$b]['src']);
                    $rid_postcontent .= '<p>'.$ridCode['recCodeFinal'].'</p>';  
                }

                
                   $page = array(
                        'ID'           => $ridPid,
                        'post_content' => $rid_postcontent,
                        'post_type'    =>  $posttype,
                    );
                   
                if(isset($_POST["rid_hidIDMet"])){
                    $ridFrameCode = rid_createFrameCode($_POST["rid_hidFr"]);
         
                    $i = $_POST["rid_hidIDMet"];
                    $arr= get_metadata('post', $ridPid, 'metaRid', true );
                   
                    $arr[$i]['src'] =  $ridFrameCode["src"];
                    update_metadata('post', $ridPid, 'metaRid', $arr );
                  }
            } else if ($posttype == 'post'){
                 #echo $ridPcontent;
                 $rid_postcontent ="";
                 $arr_new= get_metadata('post', $ridPid, 'metaRidP', true );
                for($b=0;is_array($arr_new) && $b< count($arr_new);$b++){
                    $ridCode = rid_createFrameCode($arr_new[$b]['src']);
                    $rid_postcontent .= '<p>'.$ridCode['recCodeFinal'].'</p>';  
                }

                
                   $page = array(
                        'ID'           => $ridPid,
                        'post_content' => $rid_postcontent,
                        'post_type'    =>  $posttype,
                    );
                   
                if(isset($_POST["rid_hidIDMet"])){
                    $ridFrameCode = rid_createFrameCode($_POST["rid_hidFr"]);
         
                    $i = $_POST["rid_hidIDMet"];
                    $arr= get_metadata('post', $ridPid, 'metaRidP', true );
                   
                    $arr[$i]['src'] =  $ridFrameCode["src"];
                 
                    update_metadata('post', $ridPid, 'metaRidP', $arr );
                  }
            }else{
         /*   else if ($posttype == 'wp_riddlepost'){
         /*        $rid_postcontent ="";
                 $arr_new= get_metadata('post', $ridPid, 'metaRidP', true );
                for($b=0;is_array($arr_new) && $b< count($arr_new);$b++){
                    $ridCode = rid_createFrameCode($arr_new[$b]['src']);
                    $rid_postcontent .= '<p>'.$ridCode['recCodeFinal'].'</p>';  
                }*/
                
              #  echo $posttype;
                
                   $page = array(
                        'ID'           => $ridPid,
                        'post_content' => $ridPcontent,
                        'post_type'    =>  $posttype,
                    );
            }
           /*     if(isset($_POST["rid_hidIDMet"])){
                    $ridFrameCode = rid_createFrameCode($_POST["rid_hidFr"]);
         
                    $i = $_POST["rid_hidIDMet"];
                    $arr= get_metadata('post', $ridPid, 'metaRidP', true );
                   
                    $arr[$i]['src'] =  $ridFrameCode["src"];
                 
                    update_metadata('post', $ridPid, 'metaRidP', $arr );
                  }
            }*/

    wp_update_post($page);    
    echo '<script type="text/javascript">rid_refresh()</script>';  
     echo ' <script type="text/javascript"> window.location = "'.admin_url().'post.php?post='.$ridPid.'&action=edit"</script>';
}

function rid_delPost($ridPid,  $posttype){ 
   
        if($posttype == 'wp_riddlepost_prev'){
            wp_delete_post( $_POST["rid_hidID"], true );
            echo '<script type="text/javascript">rid_refresh()</script>';   
        } else if ($posttype == 'page'){
            if(isset($_POST["rid_hidIDMet"])){

                $i = $_POST["rid_hidIDMet"];
                $arr= get_metadata('post', $ridPid, 'metaRid', true );
                unset( $arr[$i]);
                $arr_new = array_merge($arr);
          
                update_metadata('post', $ridPid, 'metaRid', $arr_new );
                       
                //get new postcontent:
                $rid_postcontent ="";
                for($b=0;is_array($arr_new) && $b< count($arr_new);$b++){
                    $ridCode = rid_createFrameCode($arr_new[$b]['src']);
                    $rid_postcontent .= '<p>'.$ridCode['code'].'</p>';  
                }
                 $page = array(
                     'ID'           => $ridPid,
                     'post_content' =>  $rid_postcontent,
                     'post_type'     =>  'page',
                 );
                 wp_update_post($page);
                 echo '<script type="text/javascript">rid_refresh()</script>';  
               }
       }else if ($posttype == 'post'){
            if(isset($_POST["rid_hidIDMet"])){

                $i = $_POST["rid_hidIDMet"];
                $arr= get_metadata('post', $ridPid, 'metaRidP', true );
                unset( $arr[$i]);
                $arr_new = array_merge($arr);
          
                update_metadata('post', $ridPid, 'metaRidP', $arr_new );
                       
                //get new postcontent:
                $rid_postcontent ="";
                for($b=0;is_array($arr_new) && $b< count($arr_new);$b++){
                    $ridCode = rid_createFrameCode($arr_new[$b]['src']);
                    $rid_postcontent .= '<p>'.$ridCode['code'].'</p>';  
                }
                 $page = array(
                     'ID'           => $ridPid,
                     'post_content' =>  $rid_postcontent,
                     'post_type'     =>  'post',
                 );
                 wp_update_post($page);
                 echo '<script type="text/javascript">rid_refresh()</script>';  
               }
       }else if ($posttype == 'wp_riddlepost_page'){
            if(isset($_POST["rid_hidIDMet"])){

                $i = $_POST["rid_hidIDMet"];
                $arr1= get_metadata('post', $ridPid, 'metaRid2', true );
                unset( $arr1[$i]);
                $arr_new1 = array_merge($arr1);
          
                update_metadata('post', $ridPid, 'metaRid2', $arr_new1 );
                       
                //get new postcontent:
                $rid_postcontent ="";
             for($b=0;is_array($arr_new1) && $b< count($arr_new1);$b++){
                   
                    $rid_postcontent .= '<p>[postriddle data_game="'.$arr_new1[$b]["data_game"].'" data-width="'.$arr_new1[$b]["data_width"].'" data-height="'.$arr_new1[$b]["data_height"].'" data-recommendations="true" data-share="false" data-comments="false" data-info="false"]</p>';  
                }
                 $page = array(
                     'ID'           => $ridPid,
                     'post_content' =>  $rid_postcontent,
                     'post_type'     =>  'page',
                 );
                 wp_update_post($page);
                 echo '<script type="text/javascript">rid_refresh()</script>';  
               }
       }else if ($posttype == 'wp_riddlepost_post'){
            if(isset($_POST["rid_hidIDMet"])){

                $i = $_POST["rid_hidIDMet"];
                $arr1= get_metadata('post', $ridPid, 'metaRid1', true );
                unset( $arr1[$i]);
                $arr_new1 = array_merge($arr1);
          
                update_metadata('post', $ridPid, 'metaRid1', $arr_new1 );
                       
                //get new postcontent:
                $rid_postcontent ="";
                for($b=0;is_array($arr_new1) && $b< count($arr_new1);$b++){
                   
                    $rid_postcontent .= '<p>[postriddle data_game="'.$arr_new1[$b]["data_game"].'" data-width="'.$arr_new1[$b]["data_width"].'" data-height="'.$arr_new1[$b]["data_height"].'" data-recommendations="true" data-share="false" data-comments="false" data-info="false"]</p>';  
                }
                 $page = array(
                     'ID'           => $ridPid,
                     'post_content' =>  $rid_postcontent,
                     'post_type'     =>  'post',
                 );
                 wp_update_post($page);
                 echo '<script type="text/javascript">rid_refresh()</script>';  
               }
       }
}

function rid_insert_post(){

    if(isset($_POST["rid_insertPost"])){
       $ridFrameCode = rid_createFrameCode($_POST["hidFr"]);
      rid_createPost($ridFrameCode["recCodeFinal"], 'wp_riddlepost_prev', '', '');
    }
}

function rid_add_to_page(){
    if(isset($_POST["PageSend"])){
       rid_addToPage($_POST["hidPageID"], $_POST["hidPageFr"],  $_POST["ridImpSite_Title"],'wp_riddlepost_prev', "", '');
      
    }
    
       if(isset($_POST["PageSend1"])){
           #function rid_addToPage($ridPid, $ridPcontent, $ridTitle, $ridPostType, $postriddle, $rID){
      rid_addToPost($_POST["hidPageID"], $_POST["hidPageFr"], $_POST["ridImpSite_Title"],'wp_riddlepost_prev', "", '');
      
    }
}
function getPostriddleCode($ridid, $ridwidth, $ridheight){
       global $rid_url;
       global $riddleResult;
      // echo "http://www.riddle.com/Api/Trends?search=".$_COOKIE["ridSearchText"];
       
         $content = riddle_loadremote("http://www.riddle.com/Api/Trends?search=".$_POST["text_searchRiddle"]);
        $jsons = json_decode($content);
        
        foreach ($jsons->trends as $json) {
            if($json->uid == $ridid){
                $rid_url = $json->data_game;
            }
        }
        

       if($ridheight==""){
            $ridheight = 'auto';
        }  if($ridwidth ==""){ 
            $ridwidth = '100%';
        }  
            $postriddleCode = array(
                'data_game' => $rid_url,
                'data-width' => $ridwidth,
                'data-height' => $ridheight,
                'code' => '[postriddle data_game="'.$rid_url.'" data_width="'.$ridwidth.'" data_height="'.$ridheight.'" data_recommendations="true" data_share="false" data_comments="false" data_info="false"]',
                'js-code' => '<div    class="riddle_list"  data-game="'.$rid_url.'"  data-width="'.$ridwith.'"  data-height="'.$ridheight.'"> </div>  '
                );
       
        return $postriddleCode;
}

function rid_createFrameCode($rid_src){
    

     $temp = substr($rid_src, strpos($rid_src, 'preview?')+8);
  #   if($_POST["openLinks"]=='yes'){
  #       $temp.= '&open=1';
  #   }else{
  #       $temp.= '&open=0';
 #    }
     $temp .= '&wwidth=100%&wheight=auto';
     
        
        $content = riddle_loadremote("http://www.riddle.com/Api/GenerateCode?".$temp);
        $jsons = json_decode($content);

        $riddleFrameCode = array(
                'src' => $rid_src,
                'code' => '[riddlelist src="'.$rid_src.'"]', 
                'recCode' => $jsons->code,
                'recCodeFinal' => '[riddlelist src="//www.riddle.com/Embed/List/'.$jsons->code.'" data_width="100%" data_height="255px"]',
                'iFrameCode' => '<iframe  width="100%" height="255px" src="'.$rid_src.'" ohref="/Embed/List/preview" style="border: medium none; width: 100%; height: 255px;" border="0">'
        
                );
        return $riddleFrameCode;

}