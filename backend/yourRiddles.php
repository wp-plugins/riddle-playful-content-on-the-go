<?php

function your_riddles(){ 
   
    $except;

   $args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'wp_riddlepost',
	'post_status'      => 'publish',
	'suppress_filters' => true
       );
       $posts = get_posts( $args );
         
          $args5 = array(
            'posts_per_page'   => 5,
            'offset'           => 0,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
          );
         $posts_p = get_posts( $args5);
               $posts = get_posts( $args );
         
          $args6 = array(
            'posts_per_page'   => 5,
            'offset'           => 0,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'page',
            'post_status'      => 'publish',
            'suppress_filters' => true
          );
         $posts_pp = get_posts( $args6);
         
               $args1 = array(
            'posts_per_page'   => 5,
            'offset'           => 0,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'page',
            'post_status'      => 'publish',
            'suppress_filters' => true
          );
         $posts1 = get_posts( $args1);
         
                  $args2 = array(
            'posts_per_page'   => 5,
            'offset'           => 0,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
          );
         $posts2 = get_posts( $args2);
         
        echo '<div id="rid_Container">';
        echo '<h1 style="margin-top: 30px; margin-bottom: 0px; "> Your embedded Riddles</h2>';
      echo '<div id="rid_text_below"  style=" margin-top: 20px;  margin-bottom: 20px;">';
    echo 'Our dashboard shows all of the individual Riddles that you have embedded on your blog...';
    echo   '<a href="#" onclick="readmore()" id="show" style="text-decoration: none;"><span style=" color: #000; text-decoration: none;" >▼</span> </a>';
    echo   '<a href="#" onclick="readless()" id="hide" style="display:none; text-decoration: none;"><span style=" color: #000; text-decoration: none;" >▲</span> </a>';
    echo '<div id="more" style="display: none"><p>Need to change the size of any Riddle?</p><ol><li>Click on the arrow next to a particular Riddle</li><li>Adjust the height and width by:
<ul><li style="list-style-type: circle; margin-left: 20px;">entering a number in pixels (ex. 450) or percentage (75%)</li>
<li style="list-style-type: circle; margin-left: 20px;">typing “auto” to use Riddle’s standard dimensions.</li></ul></li>
<li>Click ‘Update’</li></ol>

<p>Selecting the “Details” button will take directly to your page or post with the embedded Riddle, while clicking “Remove” will delete it.

</p></div>';
    echo '</div>';
        echo '</div>';    
             
     foreach($posts as $post){
   
        $rid_datagame = get_metadata('post', $post->ID, 'data_game', true);
        $rid_datawidth = get_metadata('post', $post->ID, 'data_width', true);
        $rid_dataheight = get_metadata('post', $post->ID, 'data_height', true);
          $rid_id = get_metadata('post', $post->ID, 'data_id', true);
       
       
   $content = riddle_loadremote("http://www.riddle.com/Api/Trends?uid=".$rid_id);//.$arr1[$s]['data_id']
          #  var_dump($post->ID);
          #  echo "<br/>";
         #   if ($post->ID == 1148) {
         #       var_dump($rid_id);
         #   }
                 $json = json_decode($content);
            $json = ($json->trends[0]);
      
            if($json->data_game == $rid_datagame){
                echo '<div class="addedRiddlePost">';
                echo '<div  onclick="showRiddleOptions('.$post->ID.')" class="addedRiddle_" id="addedRiddle_'.$post->ID.'">';
                echo '<img width="200px" height="133px" src="'.$json->rimageurl.'">';   
                echo $json->rname;
                echo '<img width="25px" height="25px" src="'.plugins_url("/images/rid_arrow.png", __FILE__ ).'" id="ridArrowRight">';   
                echo '</div>';

                echo '<div id="addedRiddlePostForm_'.$post->ID.'" class="addedRiddlePostForm">';
                echo '<h3>'.$post->post_title.'</h3>';
                echo '<form method="POST">';
                echo '<input type="hidden" value="'.$post->ID.'" name="ridoldID">';
                echo 'Move to <select name="addedRiddlePostSelect" style="width: 225px;">';
                echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>';

             
                $except =  $post->post_title; 

                 foreach ($posts as $p){
                     if ($p->post_title != $except){
                        if($p->post_title ==""){
                            echo '<option value="'.$p->ID.'">(kein Titel)</option>';
                        } else{
                            echo '<option value="'.$p->ID.'">'.$p->post_title.'</option>';
                     }
                    }}

                   foreach ($posts_p as $po){

                        if ($po->post_title != $except){
                         if($po->post_title ==""){
                            echo '<option value="'.$po->ID.'">(kein Titel)</option>';
                         } else{
                            echo '<option value="'.$po->ID.'">'.$po->post_title.'</option>';
                     }
                   }}
                   
                      foreach ($posts_pp as $poo){

                        if ($poo->post_title != $except){
                         if($poo->post_title ==""){
                            echo '<option value="'.$poo->ID.'">(kein Titel)</option>';
                         } else{
                            echo '<option value="'.$poo->ID.'">'.$poo->post_title.'</option>';
                     }
                   }}


                echo '</select><br/>';
                echo '<p><label>Width <input type="text" style="width: 70px;position: relative;left: 14px;" name="addedRiddleWidth" value="'.$rid_datawidth.'"></label> ';
                echo '<label style="position: relative;left: 40px;">Height<input type="text" style="width: 70px; position: relative;left: 10px;" name="addedRiddleHeight" value="'.$rid_dataheight.'"></label></p>';
                echo '<input type="hidden" name="addedRiddleID" value="'.$json->uid.'">';
                   echo '<input type="hidden" name="addedRiddlePosttype" value="wp_riddlepost">';
                
                  echo '<a href ="'.admin_url().'post.php?post='.$post->ID.'&action=edit"><input type="button" style="position: relative;" class ="button" name="addedRiddleRemove" value="Details" name="addedRiddleRemove"></a>'; 
                echo '<input type="submit" class ="button" name="addedRiddleUpdate" value="Update" style="position: relative;left: 2px;">  <input type="submit" style="position: relative;left: 1px;" class ="button" name="addedRiddleRemove" value="Remove" name="addedRiddleRemove"> ';
              
                echo '</form>';

                echo '</div>';
                echo '</div>';
        }
      }
   
   
   //page
      foreach($posts1 as $post){
         
        $arr1= get_metadata('post', $post->ID, 'metaRid2' , true);
      
     
        $i = 0;
      
        for($s = 0; is_array($arr1)&& $s < count($arr1); $s++){
              $content = riddle_loadremote("http://www.riddle.com/Api/Trends?uid=".$arr1[$s]['data_id']);//.$arr1[$s]['data_id']
                 $json = json_decode($content);
            $json = ($json->trends[0]);
            if($json->data_game == $arr1[$s]["data_game"]){
                echo '<div class="addedRiddlePost">';
                echo '<div  onclick="showRiddleOptions(\''.$post->ID.'__'.$s.'\')" class="addedRiddle_" id="addedRiddle_'.$post->ID.'__'.$s.'">';
                echo '<img width="200px" height="133px" src="'.$json->rimageurl.'">';  
                
                echo $json->rname;
                echo '<img width="25px" height="25px" src="'.plugins_url("/images/rid_arrow.png", __FILE__ ).'" id="ridArrowRight">';   
                echo '</div>';

                echo '<div id="addedRiddlePostForm_'.$post->ID.'__'.$s.'" class="addedRiddlePostForm">';
                echo '<h3>'.$post->post_title.'</h3>';
                echo '<form method="POST">';
                echo '<input type="hidden" value="'.$post->ID.'" name="ridoldID">';
                echo 'Move to <select name="addedRiddlePostSelect" style="width: 225px;">';
                echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>';

             
                $except =  $post->post_title; 

                 foreach ($posts as $p){
                     if ($p->post_title != $except){
                        if($p->post_title ==""){
                            echo '<option value="'.$p->ID.'">(kein Titel)</option>';
                        } else{
                            echo '<option value="'.$p->ID.'">'.$p->post_title.'</option>';
                     }
                    }}

                   foreach ($posts_p as $po){

                        if ($po->post_title != $except){
                         if($po->post_title ==""){
                            echo '<option value="'.$po->ID.'">(kein Titel)</option>';
                         } else{
                            echo '<option value="'.$po->ID.'">'.$po->post_title.'</option>';
                     }
                   }}
                   
                    foreach ($posts_pp as $poo){

                        if ($poo->post_title != $except){
                         if($poo->post_title ==""){
                            echo '<option value="'.$poo->ID.'">(kein Titel)</option>';
                         } else{
                            echo '<option value="'.$poo->ID.'">'.$poo->post_title.'</option>';
                     }
                   }}
 
               echo '</select><br/>';
                echo '<p><label>Width <input type="text" style="width: 70px;position: relative;left: 14px;" name="addedRiddleWidth" value="'. $arr1[$s]["data_width"].'"></label> ';
                echo '<label style="position: relative;left: 40px;">Height<input type="text" style="width: 70px; position: relative;left: 10px;" name="addedRiddleHeight" value="'.$arr1[$s]["data_height"].'"></label></p>';
                echo '<input type="hidden" name="addedRiddleID" value="'.$json->uid.'">';
                   echo '<input type="hidden" name="addedRiddlePosttype" value="page">';
                      echo' <input type="hidden" name="rid_hidIDMet" id ="rid_hidType" value="'.$s.'">';
                
                  echo '<a href ="'.admin_url().'post.php?post='.$post->ID.'&action=edit"><input type="button" style="position: relative;" class ="button" name="addedRiddleRemove" value="Details" name="addedRiddleRemove"></a>'; 
                echo '<input type="submit" class ="button" name="addedRiddleUpdate" value="Update" style="position: relative;left: 2px;">  <input type="submit" style="position: relative;left: 1px;" class ="button" name="addedRiddleRemove" value="Remove" name="addedRiddleRemove"> ';
              
                echo '</form>';

                echo '</div>';
                echo '</div>';
        
       }
      }
   }
   
   
     foreach($posts2 as $post){
           
        $arr2= get_metadata('post', $post->ID, 'metaRid1' , true);
      
        $i = 0;
   
        
        for($s = 0; is_array($arr2)&&$s < count($arr2); $s++){
               $content = riddle_loadremote("http://www.riddle.com/Api/Trends?uid=".$arr2[$s]['data_id']);//.$arr1[$s]['data_id']
                 $json = json_decode($content);
            $json = ($json->trends[0]);
  
         
            if($json->data_game == $arr2[$s]["data_game"]){
                echo '<div class="addedRiddlePost">';
                echo '<div  onclick="showRiddleOptions(\''.$post->ID.'_'.$s.'\')" class="addedRiddle_" id="addedRiddle_'.$post->ID.'_'.$s.'">';
                echo '<img width="200px" height="133px" src="'.$json->rimageurl.'">';   
                echo $json->rname;
                echo '<img width="25px" height="25px" src="'.plugins_url("/images/rid_arrow.png", __FILE__ ).'" id="ridArrowRight">';   
                echo '</div>';

                echo '<div id="addedRiddlePostForm_'.$post->ID.'_'.$s.'" class="addedRiddlePostForm">';
                echo '<h3>'.$post->post_title.'</h3>';
                echo '<form method="POST">';
                echo '<input type="hidden" value="'.$post->ID.'" name="ridoldID">';
                echo 'Move to <select name="addedRiddlePostSelect" style="width: 225px;">';
                echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>';

             
                $except =  $post->post_title; 

                 foreach ($posts as $p){
                     if ($p->post_title != $except){
                        if($p->post_title ==""){
                            echo '<option value="'.$p->ID.'">(kein Titel)</option>';
                        } else{
                            echo '<option value="'.$p->ID.'">'.$p->post_title.'</option>';
                     }
                    }}

                   foreach ($posts_p as $po){

                        if ($po->post_title != $except){
                         if($po->post_title ==""){
                            echo '<option value="'.$po->ID.'">(kein Titel)</option>';
                         } else{
                            echo '<option value="'.$po->ID.'">'.$po->post_title.'</option>';
                     }
                   }}

                    foreach ($posts_pp as $poo){

                        if ($poo->post_title != $except){
                         if($poo->post_title ==""){
                            echo '<option value="'.$poo->ID.'">(kein Titel)</option>';
                         } else{
                            echo '<option value="'.$poo->ID.'">'.$poo->post_title.'</option>';
                     }
                   }}
                   
                echo '</select><br/>';
                echo '<p><label>Width <input type="text" style="width: 70px;position: relative;left: 14px;" name="addedRiddleWidth" value="'. $arr2[$s]["data_width"].'"></label> ';
                echo '<label style="position: relative;left: 40px;">Height<input type="text" style="width: 70px; position: relative;left: 10px;" name="addedRiddleHeight" value="'.$arr2[$s]["data_height"].'"></label></p>';
                echo '<input type="hidden" name="addedRiddleID" value="'.$json->uid.'">';
                 echo '<input type="hidden" name="addedRiddlePosttype" value="post">';
                echo' <input type="hidden" name="rid_hidIDMet" id ="rid_hidType" value="'.$s.'">';
                
                  echo '<a href ="'.admin_url().'post.php?post='.$post->ID.'&action=edit"><input type="button" style="position: relative;" class ="button" name="addedRiddleRemove" value="Details" name="addedRiddleRemove"></a>'; 
                echo '<input type="submit" class ="button" name="addedRiddleUpdate" value="Update" style="position: relative;left: 2px;">  <input type="submit" style="position: relative;left: 1px;" class ="button" name="addedRiddleRemove" value="Remove" name="addedRiddleRemove"> ';
              
                echo '</form>';

                echo '</div>';
                echo '</div>';
        }
       }
      }
   
   
    echo '</div>';
   
   if(isset($_POST["addedRiddleUpdate"])){
    
        $rid_oldPostID = $_POST["ridoldID"];
       $newpostriddle = getPostriddleCode($_POST["addedRiddleID"], $_POST["addedRiddleWidth"], $_POST["addedRiddleHeight"]);
       $rid_newPostID = $_POST["addedRiddlePostSelect"];
       $rid_newPostType = get_post_type( $rid_newPostID );
       $rid_oldPostType = get_post_type( $rid_oldPostID );
       
       
      //wenn riddle auf normalen post-> append (neue ID) und riddle bestehen lassen
        if(($rid_oldPostType == 'wp_riddlepost') && ($rid_newPostType == 'post') ){
                wp_delete_post( $rid_oldPostID, true );
            rid_addToPost($rid_newPostID, $newpostriddle["code"], '', 'wp_riddlepost', $newpostriddle, $_POST["addedRiddleID"]);
        }
        else  if(($rid_oldPostType == 'wp_riddlepost') && ($rid_newPostType == 'page') ){
                wp_delete_post( $rid_oldPostID, true );
            rid_addToPage($rid_newPostID, $newpostriddle["code"], '', 'wp_riddlepost', $newpostriddle, $_POST["addedRiddleID"]);
        }
       //wenn riddle auf riddle -> einfach einfügen (nur 1 riddle pro riddlepost) und alten riddle löschen
        else if(($rid_oldPostType == 'wp_riddlepost') && ($rid_newPostType == 'wp_riddlepost')){
                   //wenn der selbe post ausgewählt wurde -> nur postriddlecode updaten ->nix löschen
         //   wp_delete_post( $rid_oldPostID, true );
            if($rid_newPostID != $rid_oldPostID){
             wp_delete_post( $rid_oldPostID, true );

               $postriddle = getPostriddleCode($rid_newPostID, $_POST["addedRiddleWidth"], $_POST["addedRiddleHeight"]);

                update_metadata('post', $rid_newPostID, 'data_game', $newpostriddle["data_game"]);
                update_metadata('post', $rid_newPostID, 'data_width', $POST["addedRiddleWidth"]);
               update_metadata('post', $rid_newPostID, 'data_height', $POST["addedRiddleHeight"]);
               update_metadata('post', $rid_newPostID, 'data_id', $_POST["addedRiddleID"]);

             rid_updatePost($rid_newPostID, $postriddle["code"], 'wp_riddlepost', $newpostriddle);
            }else{
                 $newpostriddle = getPostriddleCode($rid_newPostID, $_POST["addedRiddleWidth"], $_POST["addedRiddleHeight"]);
                 update_metadata('post', $rid_newPostID, 'data_width', $_POST["addedRiddleWidth"]);
               update_metadata('post', $rid_newPostID, 'data_height', $_POST["addedRiddleHeight"]);
          
              rid_updatePost($rid_newPostID, $newpostriddle["code"], 'wp_riddlepost', $newpostriddle);
             //    echo '<script type="text/javascript">rid_refresh()</script>';  
            }

        
        }
        
        //wenn page auf andere page oder post auf anderen post: alten riddle löschen und neuen bei neuem hinzufügen
        if(($rid_oldPostID != $rid_newPostID) && ($rid_oldPostType=='page') &&  $rid_newPostType == 'page'){
          rid_delPost($rid_oldPostID, 'wp_riddlepost_page');
          rid_addToPage($rid_newPostID, '$ridPcontent', $_POST["rid_hidIDMet"], 'wp_riddlepost',  $newpostriddle, $_POST["addedRiddleID"]);
        }
           if(($rid_oldPostID != $rid_newPostID) && ($rid_oldPostType=='post') &&  $rid_newPostType == 'post'){
          rid_delPost($rid_oldPostID, 'wp_riddlepost_post');
          rid_addToPost($rid_newPostID, '$ridPcontent', $_POST["rid_hidIDMet"], 'wp_riddlepost',  $newpostriddle, $_POST["addedRiddleID"]);
        }
        //post auf page
         if(($rid_oldPostID != $rid_newPostID) && ($rid_oldPostType=='post') &&  $rid_newPostType == 'page'){
          rid_delPost($rid_oldPostID, 'wp_riddlepost_post');
          rid_addToPage($rid_newPostID, '$ridPcontent', $_POST["rid_hidIDMet"], 'wp_riddlepost',  $newpostriddle, $_POST["addedRiddleID"]);
        }
        //page auf post
          if(($rid_oldPostID != $rid_newPostID) && ($rid_oldPostType=='page') &&  $rid_newPostType == 'post'){
          rid_delPost($rid_oldPostID, 'wp_riddlepost_page');
          rid_addToPost($rid_newPostID, '$ridPcontent', $_POST["rid_hidIDMet"], 'wp_riddlepost',  $newpostriddle, $_POST["addedRiddleID"]);
        }
        //wenn page auf die gleiche page bzw post auf den gleichen post: nix, nur den jeweiligen riddle updaten
        
          if(($rid_oldPostID == $rid_newPostID) && ($rid_oldPostType=='page') ){
   
          rid_updatePost($rid_newPostID, $newpostriddle["code"], 'page', $newpostriddle);
        }
  }

    if(isset($_POST["addedRiddleRemove"])){
    
          $rid_PostID = $_POST["addedRiddlePostSelect"];
         if($_POST["addedRiddlePosttype"]== 'wp_riddlepost'){
         wp_delete_post( $rid_PostID, true ); } 
         else if($_POST["addedRiddlePosttype"]== 'post'){
           
                 rid_delPost($rid_PostID, 'wp_riddlepost_post');
             
         } else{
              rid_delPost($rid_PostID, 'wp_riddlepost_page');
         }
         echo '<script type="text/javascript">rid_refresh()</script>';  
      
    }
}

function opt(){
      
    $args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'wp_riddlepost',
	'post_status'      => 'publish',
	'suppress_filters' => true );
     $posts = get_posts( $args );

      $f ="";
      foreach ($posts as $post){
                 
          $f .= '<option value="'.$post->post_title.'>'.$post->post_title.'</option>';
      }
    return $f;
}