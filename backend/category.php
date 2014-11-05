<?php


function rid_add_categories(){
         wp_enqueue_script( 'zClip-script', plugins_url('/js/zClip.js', __FILE__ ), false, '1.0.0' );
       wp_enqueue_script( 'preview-script', plugins_url('/js/prev.js', __FILE__ ), false, '1.0.0' );
  

      
        echo '<div id="rid_Container" style="width: 850px">';
echo'<h1 style="margin-top: 30px; margin-bottom: 30px; ">Add Category</h1>';
  echo '<div id="rid_text_below_" style="  margin-top: 20px; margin-bottom: 20px;">';
        echo 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  ';
        echo '</div>';   
      include('form.php');      
       $r = rid_getPages();
        $f = rid_getPosts();
       echo "<form name='hid' style='visibility : hidden;'> <input type='hidden' name='hidPa1' id='hidPaId1' value='".$f."'>";
       echo "<form name='hid' style='visibility : hidden;'> <input type='hidden' name='hidPa' id='hidPaId' value='".$r."'></form>";
       
       if(isset($_POST["rid_getShortcodeCat"])){
           
            $ridFrameCode = rid_createFrameCode($_POST["hidFr"]); //cols= "65" rows ="6"
               $rid_Popup = '<div id="ridPopUp"><h3>Your Shortcode</h3>';
        $rid_Popup .= '<div style="width: 450px">Copy the code below and paste it in a blog post or a blog page where you want your Riddle to appear.</div></br>';
            $rid_Popup .= '<textarea id="ridPopUpTextbox" style=" position: relative;width: 450px; height:150px; top: 5px;" rows ="6" readonly="readonly">   '.$ridFrameCode["recCodeFinal"].'</textarea><input type="button" class="button" style="position: relative; top: 10px;left: 120px" id="rid_CopytoClipboardButton" value="Copy to Clipboard"> <input type="button" class="button" style="position: relative; top: 10px;left: 120px" onClick="ridClosePopup()" value="Close"> </div>'; //
              echo $rid_Popup;
       }
 
}

function rid_yourAddedCategories(){

   $args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'wp_riddlepost_prev',
	'post_status'      => 'publish',
	'suppress_filters' => true );
         $posts = get_posts( $args );
         $args1 = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'page',
	'post_status'      => 'publish',
	'suppress_filters' => true );
         $posts1 = get_posts( $args1 );
                 $args2 = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'post',
	'post_status'      => 'publish',
	'suppress_filters' => true );
         $posts2 = get_posts( $args2 );
         
         
        $content = riddle_loadremote("http://www.riddle.com/Api/Categories");
        $jsons = json_decode($content);
        echo '<h1 style="margin-top: 30px; margin-bottom: 0px; margin-left: 20px; ">Your added Categories</h1>';
          echo '<div id="rid_text_below" style="  margin-top: 30px; margin-bottom: 0px; margin-left: 20px;">';
        echo 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  ';
        echo '</div>';

         
         foreach($posts as $post){
           
             
              echo '<div class="addedRiddlePost_">';
              $rid_frameSource = get_metadata('post', $post->ID, 'ridFrameSrc', true);
               $rid_metadata= get_metadata('post', $post->ID, 'metaRid' , true);
              echo "<div id='rid_yourCatPostNav_".$post->ID."' class='addedRiddle__' onclick='rid_ShowForm(".$post->ID.")'>"; //onclick='rid_ShowForm(\"".$rid_frameSource."\")'
              
              $rid_src = $rid_frameSource;
      
                                    
                foreach ($jsons->categories as $json) {
               
                    if($json ->uid >9){
                        $temp = substr($rid_src, strpos($rid_src, 'riddleCat'.$json->uid.'=')+12, 1);
                    } else{
                        $temp = substr($rid_src, strpos($rid_src, 'riddleCat'.$json->uid.'=')+11, 1);
                    }
                           
                    if( $temp == 1){
                                
                        if ($json->image != null && $json->image != "") {
                            echo  '<img src="'.$json->image.'" width="200px" height="133px">';                     
                        }else { 
                            echo  '<img src="'.plugins_url("/images/riddle_600x400.jpg", __FILE__ ).'" width="200px" height="133px">';   
                        }
                         break;
                    }
                }
                            
  
                echo '<div id="rid_addedCatStyle">'.$post->post_title.'</div>';
                echo '<img width="25px" height="25px" src="'.plugins_url("/images/rid_arrow.png", __FILE__ ).'" id="ridArrowRight">';  
                echo '</div>';
                 
                 echo '<div class="rid_yourCatPost_" id="rid_yourCatPost_'.$post->ID.'">'; 
                 #$rid_frameSource = get_metadata('post', $post->ID, 'ridFrameSrc', true);
                 $LinkId = "'rid_yourCatPost_".$post->ID."'";
                 $rid_ID = $post->ID;
          
                   $ridDivID =  '_'.$rid_ID;
                 include('formCat.php'); 
              
                 $form .= ' <input type="hidden" name="rid_hidType" id ="rid_hidType" value="wp_riddlepost_prev">';
                 $form .= '</form>';
                 echo $form; 
                 echo '</div>';
                 echo '</div>';
         }
         
      

         //pages
    
         foreach($posts1 as $post){  
                   
             $arr_= get_metadata('post', $post->ID, 'metaRid' , true);
                   $rid_metadata= $arr_;
     
             for($b=0;is_array($arr_) && $b< count($arr_);$b++){    
            
                echo '<div class="addedRiddlePost_">';
                echo "<div class='addedRiddle__' id='rid_yourCatPostNav__".$b."' onclick='rid_ShowFormPage(\"".$b."\")'>"; //onclick='rid_ShowForm(\"".$rid_frameSource."\")'
                    
                $rid_src = $arr_[$b]['src'];
                     
                     foreach ($jsons->categories as $json) {
    
                        if($json ->uid >9){
                                  $temp = substr($rid_src, strpos($rid_src, 'riddleCat'.$json->uid.'=')+12, 1);
                        } else{
                                    $temp = substr($rid_src, strpos($rid_src, 'riddleCat'.$json->uid.'=')+11, 1);
                        }
                            
                        if( $temp == 1){
                                
                            if ($json->image != null && $json->image != "") {
                                echo  '<img src="'.$json->image.'"  width="200px" height="133px" style="position; relative;left: 20px; top: -50px;">';                     
                            }else { 
                                echo  '<img src="'.plugins_url("/images/riddle_600x400.jpg", __FILE__ ).'" width="200px" height="133px">';   
                            }
                            break;
                        }
               
                }
                          
        
                echo '<div id="rid_addedCatStyle">'.$post->post_title.': '.$arr_[$b]['title'].'</div>';
          
                echo '<img width="25px" height="25px" src="'.plugins_url("/images/rid_arrow.png", __FILE__ ).'" id="ridArrowRight">';  
                echo '</div>';
                
                 
                $arr_= get_metadata('post', $post->ID, 'metaRid' , true);
        
                $t = $b;
                echo '<div class="rid_yourCatPost_" id="rid_yourCatPost__'.$b.'">';
                $rid_frameSource = $arr_[$b]['src'];
      
                $LinkId = "'rid_yourCatPost__".$b."'";
                $rid_ID = $b;
                
                  $ridDivID =  '_'.$rid_ID;
                include('formCat.php'); 
                    
                $form .= ' <input type="hidden" name="rid_hidPageID"  value="'.$post->ID.'">';
                $form .= ' <input type="hidden" name="rid_hidType" id ="rid_hidType" value="page">';
                $form .= ' <input type="hidden" name="rid_hidIDMet" id ="rid_hidType" value="'.$t.'">';
                $form .= '</form>';
                echo $form; 
                echo '</div>';
                echo '</div>';
 
               }       
         }
         
         foreach($posts2 as $post){  
             
           
                     
             $arr_= get_metadata('post', $post->ID, 'metaRidP' , true);
                 $rid_metadata= $arr_;
                
             
     
             for($b=0;is_array($arr_) && $b< count($arr_);$b++){    
            
                echo '<div class="addedRiddlePost1_">';
                echo "<div class='addedRiddle1__' id='rid_yourCatPostNav2__".$b.$post->ID."' onclick='rid_ShowFormPost(\"".$b.$post->ID."\")'>"; //onclick='rid_ShowForm(\"".$rid_frameSource."\")'
                    
                $rid_src = $arr_[$b]['src'];
     
                     
                     foreach ($jsons->categories as $json) {
    
                        if($json ->uid >9){
                                  $temp = substr($rid_src, strpos($rid_src, 'riddleCat'.$json->uid.'=')+12, 1);
                        } else{
                                    $temp = substr($rid_src, strpos($rid_src, 'riddleCat'.$json->uid.'=')+11, 1);
                        }
                            
                        if( $temp == 1){
                                
                            if ($json->image != null && $json->image != "") {
                                echo  '<img src="'.$json->image.'"  width="200px" height="133px" style="position; relative;left: 20px; top: -50px;">';                     
                            }else { 
                                echo  '<img src="'.plugins_url("/images/riddle_600x400.jpg", __FILE__ ).'" width="200px" height="133px">';   
                            }
                            break;
                        }
               
                }
                          
        
                echo '<div id="rid_addedCatStyle">'.$post->post_title.': '.$arr_[$b]['title'].'</div>';
          
                echo '<img width="25px" height="25px" src="'.plugins_url("/images/rid_arrow.png", __FILE__ ).'" id="ridArrowRight">';  
                echo '</div>';
                
                 
                $arr_= get_metadata('post', $post->ID, 'metaRidP' , true);
        
                $t = $b;
                echo '<div class="rid_yourCatPost1_" id="rid_yourCatPost2__'.$b.$post->ID.'">';
                $rid_frameSource = $arr_[$b]['src'];
      
                $LinkId = "'rid_yourCatPost2__".$b.$post->ID."'";
                $rid_ID = $b;
                  $ridDivID =  'post_'.$rid_ID;

                include('formCat.php'); 
                    
                $form .= ' <input type="hidden" name="rid_hidPageID"  value="'.$post->ID.'">';
                $form .= ' <input type="hidden" name="rid_hidType" id ="rid_hidType" value="post">';
                $form .= ' <input type="hidden" name="rid_hidIDMet" id ="rid_hidType" value="'.$t.'">';
                $form .= '</form>';
                echo $form; 
                echo '</div>';
                echo '</div>';
 
               }       
         }
         
         

       if(isset($_POST["rid_updateCat"])){
        
            $ridFrameCode = rid_createFrameCode($_POST["rid_hidFr"], $_POST["ridWidthCat"], $_POST["ridHeightCat"]);
        
           rid_updatePost($_POST["rid_hidID"], $ridFrameCode["recCodeFinal"], $_POST["rid_hidType"], $ridFrameCode["src"], $ridFrameCode);

        }
        
        if(isset($_POST["rid_removeCat"])){
          
            rid_delPost($_POST["rid_hidID"],  $_POST["rid_hidType"]);
        }
}
