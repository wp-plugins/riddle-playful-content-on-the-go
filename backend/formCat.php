<?php

$rid_numitems = substr($rid_frameSource, strpos($rid_frameSource, 'numitems=') + 9, 1);
$rid_Layout = substr($rid_frameSource, strpos($rid_frameSource, 'riddleLayout=') + 13, 1);
$openLinks = substr($rid_frameSource, strpos($rid_frameSource, 'open=') +5, 1);
$rid_arrTyp[0] = substr($rid_frameSource, strpos($rid_frameSource, 'riddleTypTop10=') + 15, 1);
$rid_arrTyp[1] = substr($rid_frameSource, strpos($rid_frameSource, 'riddleTypTests=') + 15, 1);
$rid_arrTyp[2] = substr($rid_frameSource, strpos($rid_frameSource, 'riddleTypQuiz=') + 14, 1);
$rid_arrTyp[3] = substr($rid_frameSource, strpos($rid_frameSource, 'riddleTypPoll=') + 14, 1);
$rid_arrTyp[4] = substr($rid_frameSource, strpos($rid_frameSource, 'riddleTypRhn=') + 13, 1);

for ($i = 0; $i < 5; $i++) {
    if ($rid_arrTyp[$i] == 1) {
        $rid_arrTyp[$i] = "checked";
    } else {
        $rid_arrTyp[$i] = "";
    }
}


$form = '<form name="riddleCatChange" method ="post" id="ridCatForm">';
$form .= '<table>';
//type
$form .= '<tr>';
$form .= '<td>';
$form .= '<span id="ridSpan">Type of Riddles</span>';
$form .= '</td>';
$form .= '<td>';
$form .= '<label><input type="checkbox" id="riddleTypTop10" class="typeClass" name="type" onchange="rid_change(' . $LinkId . ')" value="riddleTypTop10" ' . $rid_arrTyp[0] . ' >Lists </label> ';
$form .= '<label><input type="checkbox" id="riddleTypTests" class="typeClass" name="type" onchange="rid_change(' . $LinkId . ')" value="riddleTypTests" ' . $rid_arrTyp[1] . ' >Tests </label> ';
$form .= '<label><input type="checkbox" id="riddleTypQuiz" class="typeClass" name="type" onchange="rid_change(' . $LinkId . ')" value="riddleTypQuiz" ' . $rid_arrTyp[2] . ' >Quizzes </label> ';
$form .= '<label><input type="checkbox" id="riddleTypPoll" class="typeClass" name="type" onchange="rid_change(' . $LinkId . ')" value="riddleTypPoll" ' . $rid_arrTyp[3] . ' >Polls </label> ';
$form .= '<label><input type="checkbox" id="riddleTypRhn" class="typeClass" name="type" onchange="rid_change(' . $LinkId . ')" value="riddleTypRhn" ' . $rid_arrTyp[4] . ' >Hot or Not </label> ';
$form .= '</td>';
$form .= '</tr>';

$form.= '</br>';
$form .= '<tr>';
$form .= '<td>';
$form .= '<span id="ridSpan">Categories</span>';
$form .= '</td>';

//get categories
$form .= '<td style="height: 55px;" valign ="top">';
$content = riddle_loadremote("http://www.riddle.com/Api/Categories");
$jsons = json_decode($content);
$i = 0;
global $rid_CatNr;

$arr = array();
$a = 0;

foreach ($jsons->categories as $json) {

    //    if($i ==0){
    if ($json->parentid == 0) {
        $arr[$a] = $json->uid;
        $a ++;
    }
}

$name = "";
$i = 0;
for ($s = 0; $s < count($arr); $s++) {
    foreach ($jsons->categories as $json) {
        if ($arr[$s] == $json->uid) {
            $name = $json->rname;
            if ($json->uid <= 9) {
                $rid_CatNr = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->uid . '=') + 11, 1);
            } else {
                $rid_CatNr = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->uid . '=') + 12, 1);
            }
        }
    }

    $form .= '<div id="' . $arr[$s] . '"  onclick="rid_showSub(\'' . $ridDivID . '_' . $arr[$s] . '\')" class="typeCatCat"   <span style="font-weight: bold">' . $name . '<span style="font-size: 10px">▼</span> </span> </div>';


    $form .= '<div id="' . $ridDivID . '_' . $arr[$s] . '" class="rid_ContainerSubcategory">';
    $z = 0;
    foreach ($jsons->categories as $json) {
        //    if($json->uid == $arr[$s] ){

        if ($json->uid <= 9) {
            $rid_CatNr = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->uid . '=') + 11, 1);
        } else {
            $rid_CatNr = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->uid . '=') + 12, 1);
        }


        if ($json->parentid == $arr[$s]) {
            $form .= "<div style='display:none;'>".$json->uid." ".$json->rname." ".$rid_frameSource." ".$rid_CatNr."</div>"; 
            if ($rid_CatNr == 1) {
                
                if ($z <= 0) {
              
                             if ($json->parentid <= 9) {
                                $rid_CatNr1 = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->parentid . '=') + 11, 1);
                            } else {
                                $rid_CatNr1 = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->parentid . '=') + 12, 1);
                            }
                        
                            if($rid_CatNr1 == 1){
                                 $form .= '<label><input type="checkbox" id="' . $arr[$s] . '" class="typeCat" checked onchange="rid_change(' . $LinkId . ')" name="category" value="' . $arr[$s] . '" >All of ' . $name . ' </label>';  
                           } else{
                                    $form .= '<label><input type="checkbox" id="' . $arr[$s] . '" class="typeCat"  onchange="rid_change(' . $LinkId . ')" name="category" value="' . $arr[$s] . '" >All of ' . $name . ' </label>';  
                           
                           }
                    $z ++;
                }
                $form .= '<label><input type="checkbox" id="' . $json->uid . '" checked class="typeCat"  onchange="rid_change(' . $LinkId . ')" name="category" value="' . $json->uid . '" >' . $json->rname . ' </label>';
            } else {
                if ($z <= 0) {
                    
                                if ($json->parentid <= 9) {
                                $rid_CatNr1 = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->parentid . '=') + 11, 1);
                            } else {
                                $rid_CatNr1 = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat' . $json->parentid . '=') + 12, 1);
                            }
                        
                           
                            if($rid_CatNr1 == 1){
                                 $form .= '<label><input type="checkbox" id="' . $arr[$s] . '" class="typeCat" checked onchange="rid_change(' . $LinkId . ')" name="category" value="' . $arr[$s] . '" >All of ' . $name . ' </label>';
                           } else{
                                 $form .= '<label><input type="checkbox" id="' . $arr[$s] . '" class="typeCat"  onchange="rid_change(' . $LinkId . ')" name="category" value="' . $arr[$s] . '" >All of ' . $name . ' </label>';
                            }
                            
               #  $form .= '<label><input type="checkbox" id="' . $arr[$s] . '" class=" typeCat"onchange="rid_change(' . $LinkId . ')" name="category" value="' . $arr[$s] . '" >All of ' . $name . ' </label>';
                    $z ++;
                }
                $form .= '<label><input type="checkbox" id="' . $json->uid . '" class="typeCat"  onchange="rid_change(' . $LinkId . ')" name="category" value="' . $json->uid . '" >' . $json->rname . ' </label>';
            }
        }
    }
    $form .= '</div>';
}



/*    foreach ($jsons->categories as $json) {

  if($json->uid <= 9){
  $rid_CatNr = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat'.$json->uid.'=')+11, 1);
  } else{
  $rid_CatNr = substr($rid_frameSource, strpos($rid_frameSource, 'riddleCat'.$json->uid.'=')+12, 1);
  }

  if($rid_CatNr == 1){
  $form .= '<label><input type="checkbox" id="'.$json->uid.'" class="typeCat" onchange="rid_change('.$LinkId.')" name="category" value="'.$json->uid.'" checked >'.$json->rname.' </label> ';
  } else{
  $form .= '<label><input type="checkbox" id="'.$json->uid.'" class="typeCat" onchange="rid_change('.$LinkId.')" name="category" value="'.$json->uid.'" >'.$json->rname.' </label> ';
  }
  } */



$form .= '<td>';
$form .= '</tr>';
$form .= '<tr>';
$form .= '<td>';
$form .= '<span id="ridSpan">Widget</span>';
$form .= '</td>';
$form .= '<td>';
if ($rid_Layout == 0) {
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="thumbnails" class="typeWidget" name="widget" value="thumbnails" checked>Thumbnails </label> ';
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="imagelist" class="typeWidget" name="widget" value="imagelist">Image List </label> ';
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="list" class="typeWidget" name="widget" value="list">List </label> ';
} else if ($rid_Layout == 1) {
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="thumbnails" class="typeWidget" name="widget" value="thumbnails" >Thumbnails </label> ';
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="imagelist" class="typeWidget" name="widget" value="imagelist" checked>Image List </label> ';
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="list" class="typeWidget" name="widget" value="list">List </label> ';
} else if ($rid_Layout == 2) {
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="thumbnails" class="typeWidget" name="widget" value="thumbnails" >Thumbnails </label> ';
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="imagelist" class="typeWidget" name="widget" value="imagelist" >Image List </label> ';
    $form .= '<label><input onchange="rid_change(' . $LinkId . ')" type="radio" id="list" class="typeWidget" name="widget" value="list" checked>List </label> ';
}
$form .= '</td>';
$form .= '</tr>';
// number of items

$form .= '<tr>';
$form .= '<td>';
$form .= '<span id="ridSpan">Number of Items</span>';
$form .= '</td>';
$form .= '<td>';
$form .= ' <select style="height:25px"class="numitems" onchange="rid_change(' . $LinkId . ')">';

for ($i = 1; $i <= 16; $i++) {
    if ($i == $rid_numitems) {
        $form .= '<option selected>' . $i . '</option>';
    } else {
        $form .= '<option>' . $i . '</option>';
    }
}
$form .= '</select>';
$form .= '</td>';
$form .= '</tr>';

$form .= '<tr>';
$form .= '<td>';
$form .= '<span id="ridSpan">Open links on your website</span>';
$form .= '</td>';
$form .= '<td>';

if($openLinks == 1 ){
$form .= '<label><input type="radio" name="openLinks" value="yes" id="openLinksYes"  checked onchange="rid_change(' . $LinkId . ')">Open on riddle.com </label> ';
$form .= '<label><input type="radio" name="openLinks" value="no" id="openLinksYes"  onchange="rid_change(' . $LinkId . ')">Open on your Website </label> ';
} else{
    $form .= '<label><input type="radio" name="openLinks" value="yes"id="openLinksYes"  onchange="rid_change(' . $LinkId . ')">Open on riddle.com </label> ';
$form .= '<label><input type="radio" name="openLinks" value="no" id="openLinksYes"  checked onchange="rid_change(' . $LinkId . ')">Open on your Website </label> ';
}
$form .= '</td>';
$form .= '</tr>';

$form .= '<tr><td>';
   $form .= '<b>Size</b>';
$form .= '</td><td>';

if( is_array($rid_metadata)){

    $form .= '<label> Width <input name="ridWidthCat"type ="text" value="'.$rid_metadata[$b]["ridWidth"].'"style="width: 70px"></label>';
      $form .= '<label> Height <input name="ridHeightCat"type ="text" style="width: 70px" value="'.$rid_metadata[$b]["ridHeight"].'"></label>';
}
$form .= '</td></tr>';
$form .= '<tr  > <td style="padding-top: 0px; width="auto" colspan="2" >';
$form .= ' <input type="hidden" name="rid_hidFr" id ="rid_hidFr" value="' . $rid_frameSource . '">';
$form .= ' <input type="hidden" name="rid_hidID" id ="rid_hidID" value="' . $post->ID . '">';
$form .= '<a href ="' . admin_url() . 'post.php?post=' . $post->ID . '&action=edit"><input type="button" style=" width: 100px; height: 30px;" class ="button"  value="Details" ></a>';
$form .= '<input class ="button" type="submit" name="rid_updateCat" value="Update" style="width: 100px; height: 30px; left: 3px; position: relative;" >  <input type="submit" class ="button" name="rid_removeCat" value="Remove" style=" width: 100px; height: 30px; left: 3px; position: relative;">';


$form .= '</td></tr>';
$form .= '</table>';
