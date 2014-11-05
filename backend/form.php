<?php

$form = '<form name="riddle_widg_wp" method ="POST">';


  

            //type
            $form  .= '<h3>Type of Riddles</h3>'; 
            $form  .= '<label><input type="checkbox" id="riddleTypTop10" class="typeClass" name="type" value="riddleTypTop10" checked onchange="rid_change(\'\')">Lists</label><br>';
            $form  .= '<label><input type="checkbox" id="riddleTypTests" class="typeClass" name="type" value="riddleTypTests" onchange="rid_change(\'\')">Tests</label><br>'; 
            $form  .= '<label><input type="checkbox" id="riddleTypQuiz" class="typeClass" name="type" value="riddleTypQuiz" onchange="rid_change(\'\')">Quizzes</label><br>';
            $form  .= '<label><input type="checkbox" id="riddleTypPoll" class="typeClass" name="type" value="riddleTypPoll" onchange="rid_change(\'\')">Polls </label><br>';
            $form  .= '<label><input type="checkbox" id="riddleTypRhn" class="typeClass" name="type" value="riddleTypRhn" onchange="rid_change(\'\')">Hot or Not</label><br>';
        


           
         
            $form .= '<h3>Categories</h3>';
            //get categories
          $form.= ' <div id="CategWidth">';

            $content = riddle_loadremote("http://www.riddle.com/Api/Categories");
            $jsons = json_decode($content);
            $arr = array();
            $i = 0;
            $a = 0;
            foreach ($jsons->categories as $json) {

            //    if($i ==0){
                    if($json->parentid == 0){
                        $arr[$a] = $json->uid;
                        $a ++;
                                  
                    }
            }
            
            $name ="";
        $z = 0;
  
            for($s = 0; $s < count($arr); $s++){
                  foreach ($jsons->categories as $json) {
                      if($arr[$s] == $json->uid)
                          $name = $json->rname;
                  }
                  
               
                 $form .= '<div id="'.$arr[$s].'"  onclick="rid_showSub1(\'_'.$arr[$s].'\')" class="typeCatCat"   <span style="font-weight: bold">'.$name.'<span style="font-size: 10px">▼</span> </span> </div>'; 
            
                  $form .= '<div id="_'.$arr[$s].'" class="rid_ContainerSubcategory_">';
               
                  $z = 0;
                  foreach ($jsons->categories as $json) {
               //    if($json->uid == $arr[$s] ){
            
                      $abid++;
                   
                
      
           
              if($json->parentid == $arr[$s]){
                    
                    if($arr[$s]== 1){
                         if($z <= 0){
                               $form .= '<label><input type="checkbox" id="'.$arr[$s].'" class="typeCat" checked onchange="rid_change(\'\')" name="category" value="'.$arr[$s].'" >All of '.$name.' </label>';
                               $z ++;
                               
                         } 
                              $form .= '<label><input type="checkbox" id="'.$json->uid.'"  class="typeCat"  onchange="rid_change(\'\')" name="category" value="'.$json->uid.'" >'.$json->rname.' </label>';
                         
                    }else{
                        if($z <= 0){
                               $form .= '<label><input type="checkbox" id="'.$arr[$s].'" class="typeCat"onchange="rid_change(\'\')" name="category" value="'.$arr[$s].'" >All of '.$name.' </label>';
                               $z ++;
                               
                         }
                        $form .= '<label><input type="checkbox" id="'.$json->uid.'" class="typeCat"  onchange="rid_change(\'\')" name="category" value="'.$json->uid.'" >'.$json->rname.' </label>';
                                 
                   }
                
               }
                      
               }
               $form .= '</div>';
   
           }
           $form .= '</div>';
        


  
        //widget
          $form .= '</br>';
            $form .= '</br>';
              $form .= '</br>';
        $form  .= '<h3>Widget</h3>';
        $form  .= '<p>';
        $form  .= '<label><input onchange="rid_change(\'\')" type="radio" id="thumbnails" class="typeWidget" name="widget" value="thumbnails" checked>Thumbnails</label><br>';
        $form  .= '<label><input onchange="rid_change(\'\')" type="radio" id="imagelist" class="typeWidget" name="widget" value="imagelist">Image List</label><br>';
        $form  .= '<label><input onchange="rid_change(\'\')" type="radio" id="list" class="typeWidget" name="widget" value="list">List</label><br>';
        $form  .= '</p>';
        

                
         // number of items

        $form  .= '<h3>Number of Items</h3>';
        $form  .= ' <select class="numitems" onchange="rid_change(\'\')">';
        $form  .= '<option>1</option>';  $form  .= '<option>2</option>';
        $form  .= '<option>3</option>';  $form  .= '<option selected>4</option>';
        $form  .= '<option>5</option>';  $form  .= '<option>6</option>';
        $form  .= '<option>7</option>';  $form  .= '<option>8</option>';
        $form  .= '<option>9</option>';  $form  .= '<option>10</option>';
        $form  .= '<option>11</option>'; $form  .= '<option>12</option>';
        $form  .= '<option>13</option>'; $form  .= '<option>14</option>';
        $form  .= '<option>15</option>'; $form  .= '<option>16</option>';
        $form  .= '</select>';
        
        $form .= '</br>';
        $form  .= '<h3>Open links on your website</h3>';
   
        $form  .= '<label><input type="radio" name="openLinks" id="openLinksYes" value="yes"  checked  onchange="rid_change(\'\')">Open on riddle.com</label><br>';
        $form  .= '<label><input type="radio" name="openLinks" id="openLinksYes" value="no" onchange="rid_change(\'\')">Open on your Website</label><br>'; 
        
        $form .= '</form>';       

        
      
        $form .= '<div id="ridPrevStyle">';
        $frame = '<iframe class="preview" width="100%" height="255px" src="http://www.riddle.com/Embed/List/preview?numitems=4&riddleLayout=0&riddleTypTop10=1&riddleTypTests=0&riddleTypQuiz=0&riddleTypPoll=0&riddleTypRhn=0&riddleCat1=1&riddleCat6=0&riddleCat7=0&riddleCat2=0&riddleCat8=0&riddleCat9=0&riddleCat10=0&riddleCat11=0&riddleCat3=0&riddleCat29=0&riddleCat28=0&riddleCat13=0&riddleCat14=0&riddleCat27=0&riddleCat16=0&riddleCat17=0&riddleCat18=0&riddleCat20=0&riddleCat21=0&riddleCat24=0&riddleCat25=0&riddleCat26=0&riddleCat42=0&riddleCat43=0&riddleCat4=0&riddleCat22=0&riddleCat23=0&riddleCat40=0&riddleCat5=0&riddleCat31=0&riddleCat30=0&riddleCat32=0&riddleCat33=0&riddleCat34=0&riddleCat35=0&riddleCat36=0&riddleCat15=0&riddleCat12=0&riddleCat37=0&riddleCat38=0&riddleCat39=0&riddleCat41=0&riddleCat19=0&riddleCat48=0&riddleCat44=0&riddleCat45=0&riddleCat46=0&riddleCat51=0&open=1" ohref="/Embed/List/preview" style="border: medium none; width: 100%; height: 255px;" border="0"></iframe>';
        $form .= $frame;
        $form .= '</div>';

        // Open links on your Website
        $form .= '<form name="riddle_widg_wp" method ="post">'; 
             
        echo $form;
        ?>  <input type="hidden" name="hidFr" id ="rid_hidFr" value='http://www.riddle.com/Embed/List/preview?numitems=4&riddleLayout=0&riddleTypTop10=1&riddleTypTests=0&riddleTypQuiz=0&riddleTypPoll=0&riddleTypRhn=0&riddleCat1=1&riddleCat6=0&riddleCat7=0&riddleCat2=0&riddleCat8=0&riddleCat9=0&riddleCat10=0&riddleCat11=0&riddleCat3=0&riddleCat29=0&riddleCat28=0&riddleCat13=0&riddleCat14=0&riddleCat27=0&riddleCat16=0&riddleCat17=0&riddleCat18=0&riddleCat20=0&riddleCat21=0&riddleCat24=0&riddleCat25=0&riddleCat26=0&riddleCat42=0&riddleCat43=0&riddleCat4=0&riddleCat22=0&riddleCat23=0&riddleCat40=0&riddleCat5=0&riddleCat31=0&riddleCat30=0&riddleCat32=0&riddleCat33=0&riddleCat34=0&riddleCat35=0&riddleCat36=0&riddleCat15=0&riddleCat12=0&riddleCat37=0&riddleCat38=0&riddleCat39=0&riddleCat41=0&riddleCat19=0&riddleCat48=0&riddleCat44=0&riddleCat45=0&riddleCat46=0&riddleCat51=0&open=1'>
        <?php
        $form ="";

         
        $form .= '<div id="ridCatFormBottom">';
        $form  .= ' <input type="button" class ="button" name="site" style="width: 150px; height: 35px; margin-top: 25px;" value="Add to Post" onclick="rid_implementPost()"><input type="button" class ="button" name="site" style="width: 150px; height: 35px; margin-top: 25px; margin-left: 3px;" value="Add to Page" onclick="rid_implementSite()">'; //<input class ="button" type="submit" name="rid_insertPost" value="Create Post" style="width: 150px; height: 35px; margin-top: 25px;" > 

        $form .= '<input type="submit" class ="button" name="rid_getShortcodeCat" value="Get Shortcode" style=" position: relative; left: 3px;width: 150px; height: 35px; margin-top: 25px;" >';
        
        $form .= '</div>';
        
        //hidden input
    
        $form  .= '</form>';   
        
        $form .= '<div id="postSite"><br/> </div>';
        
        $form .= "<form method='POST' id='riddle_widg_wp'></form>";
       $form.= '</div>';
       echo $form;

?>