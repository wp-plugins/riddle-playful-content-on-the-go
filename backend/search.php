<?php

    
wp_enqueue_script( 'preview-script', plugins_url('/js/prev.js', __FILE__ ), false, '1.0.0' );
   wp_enqueue_script( 'zClip-script', plugins_url('/js/zClip.js', __FILE__ ), false, '1.0.0' );

function riddle_search() {
    
    echo '<div id="rid_Container">';
    
 
    echo '<h1 style="margin-top: 30px; margin-bottom: 30px; ">Search Riddle</h1>';
      echo '<div id="rid_text_below"  style=" margin-top: 20px;  margin-bottom: 20px;">';
        echo 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  ';
        echo '</div>';  
    echo '<form method="POST">';
    echo '<input type="text" id="text_searchRiddle" name="text_searchRiddle">';
    echo ' <select name="lang" style="height: 50px; width: 10%; margin-bottom: 2px;"> <option value="en-US">English</option> <option value="de-DE">Deutsch</option> </select>';
    echo '<input type="submit" id="sub_searchRiddle" name="sub_searchRiddle" value="Search Riddle" class="button" >';
    
    echo '</form>';
   
    
      $option = rid_getPages();
      showSearchedRiddles(0); 
    
      if(isset($_POST["sub_searchRiddle"])){ 
          // $option = rid_getPages();

            showSearchedRiddles(0);   
                   
              
      }
      
     if(isset($_POST["rid_post"])){
      //create new Post
        $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");
         rid_createPost($postriddleCode["code"], 'wp_riddlepost', $postriddleCode, $_POST["ridSearch_id"]);
      
     }
     #  if(isset($_POST["rid_shortcode"])){
      //create new Post 
         
          #  $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");
        #  
       #    echo $rid_Popup;
      
  #   }
      if(isset($_POST["rid_page"])){
     
         $content = riddle_loadremote("http://www.riddle.com/Api/Trends?search=".$_POST["text_searchRiddle"]);
         $jsons = json_decode($content);
        
        foreach ($jsons->trends as $json) {
            if($json->uid == $_POST["ridSearch_id"]){
                $rid_url = $json->data_game;
        }
      }
       
 
         showSearchedRiddles($option, $_POST["ridSearch_id"]);  
        //  $ridSearchText = htmlentities($_POST["text_searchRiddle"]);
      echo '</div>';
}

if(isset($_POST["rid_postAdd"])){
        
          
         $content = riddle_loadremote("http://www.riddle.com/Api/Trends?search=".$_POST["text_searchRiddle"]);
         $jsons = json_decode($content);
        
        foreach ($jsons->trends as $json) {
            if($json->uid == $_POST["ridSearch_id"]){
                $rid_url = $json->data_game;
        }
      }
         $option = rid_getPosts();
         showSearchedRiddles($option, $_POST["ridSearch_id"]);  
      echo '</div>';
}


    if(isset($_POST["rid_page_implement"])){
        
        $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");
        rid_addToPage($_POST["page-dropdown"], $postriddleCode["code"],'', 'wp_riddlepost', $postriddleCode, $_POST["ridSearch_id"] );
    }
    
      if(isset($_POST["rid_post_implement"])){
      
        
      $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");
   
        rid_addToPost($_POST["page-dropdown1"], $postriddleCode["code"], $_POST["ridSearch_id"], 'wp_riddlepost', $postriddleCode, $_POST["ridSearch_id"]);
    }

}

function showSearchedRiddles($ridID){
    
   $f ="";
   
  echo '<script type="text/javascript"> rid_emptyRiddleSearch()</script>';

  $content = riddle_loadremote("http://www.riddle.com/Api/Trends?search=".$_POST["text_searchRiddle"]);
  $jsons = json_decode($content);
  $f .= '<div id="riddleSearch">';
  foreach ($jsons->trends as $json) {
                           
        $f .= '<div class="riddle_element">';
        if ($json->rimageurl != null && $json->rimageurl != "") {
           $f .=  '<img src="'.$json->rimageurl.'" width="180px" height="120px"><br/>';                      
        }else { 
            $f = '<img src="'.plugins_url("/images/riddle_600x400.jpg", __FILE__ ).' " width="180px" height="120px">'; 
        }
        $f .= '<div id="textRidSearch">'. htmlspecialchars($json->rname) .' </div>';
    //     $postriddleCode = getPostriddleCode($json->uid, "100%", "auto");
        $f .= '<form method="POST" name="form_'.$json->uid.'"><input type="button" class="button" style="width: 180px; position: relative; left: 2px; margin-bottom: 1px;" onclick="rid_getShortcode(\''.$json->uid.'\')"  value="Get Shortcode" name="rid_shortcode"><input type="hidden" name="ridSearch_id" value="'.$json->uid.'"><input type="button" class="button" style="width: 87px;  margin-top: 5px;" id="rid_post"  onclick="rid_ShowAddButton(\'addPost_'.$json->uid.'\')"  value="Add to Post" name="rid_postAdd"> <input type="button" class="button" style="width: 87px;    margin-top: 5px;" id="rid_post" value="Add to Page" name="rid_page" onclick="rid_ShowAddButton(\'addPage_'.$json->uid.'\')">'; //<input type="submit" style="width: 180px; margin-top: 5px; "class="button" value="Create Riddlepost" name="rid_post" id="rid_post">   
        //if(($optionPage != "" || $optionPage != NULL) && ($ridID == $json->uid)) {
            $f .= '<div id="addPage_'.$json->uid.'" class="ridAddButtonHidden">';
              $option = rid_getPages();
            $f.= $option;  
            $f.= '<input type="submit" class="button" style=" margin-top: 5px; width:42px" value="Add!" name="rid_page_implement"> ';
            $f .= '</div>';
            
             $f .= '<div id="addPost_'.$json->uid.'" class="ridAddButtonHidden">';
              $opt = rid_getPosts();
            $f.= $opt;
            $f.= '<input type="submit" class="button" style=" margin-top: 5px; width:42px" value="Add!" name="rid_post_implement"> ';
            $f .= '</div>';
      //  }
            $temp1 = getPostriddleCode($ridID, "100%", "auto");
            $f .= '<div style="display:none"><input  name =\'rid_HiddenShortcodePostriddle\'type=\'hidden\' id=\'rid_hiddenShortcodePostriddle'.$json->uid.'\' value=\''.$temp1["code"].'\'></div>';
                $f .= '<div style="display:none"><input  name =\'text_searchRiddle\'type=\'hidden\' id=\'rid_hiddenTextPostriddle'.$json->uid.'\' value=\''.$_POST["text_searchRiddle"].'\'></div>';
        $f .= '</form>';
        $f .= '</div>';                     
     }
    $f .= '</div>';    
    echo $f;      
    
   /* if(isset($_POST["rid_shortcode"])){
        wp_enqueue_script( 'zClip-script', plugins_url('/js/zClip.js', __FILE__ ), false, '1.0.0' );
       wp_enqueue_script( 'preview-script', plugins_url('/js/prev.js', __FILE__ ), false, '1.0.0' );
        $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");
   
               $rid_Popup = '<div id="ridPopUp"><h3>Your Shortcode</h3>';
        $rid_Popup .= '<div style="width: 450px">Copy the code below and paste it in a blog post or a blog page where you want your Riddle to appear.</div></br>';
            $rid_Popup .= '<textarea id="ridPopUpTextbox" style=" position: relative;width: 450px; height:150px; top: 5px;" rows ="6" readonly="readonly">   '.$postriddleCode["code"].'</textarea><input type="button" class="button" style="position: relative; top: 10px;left: 120px" id="rid_CopytoClipboardButton" value="Copy to Clipboard"> <input type="button" class="button" style="position: relative; top: 10px;left: 120px" onClick="ridClosePopup()" value="Close"> </div>'; //
              echo $rid_Popup;
    }*/
}




