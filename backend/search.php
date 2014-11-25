<?php

wp_enqueue_script('preview-script', plugins_url('/js/prev.js', __FILE__), false, '1.0.0');
wp_enqueue_script('zClip-script', plugins_url('/js/zClip.js', __FILE__), false, '1.0.0');
wp_enqueue_script('readmore', plugins_url('/js/readmore.js', __FILE__), false, '1.0.0');

function riddle_search() {

    echo '<div id="rid_Container">';



    echo '<h1 style="margin-top: 30px; margin-bottom: 30px; ">Add Riddle</h1>';
    echo '<div id="rid_text_below"  style=" margin-top: 20px;  margin-bottom: 20px;">';
   // echo 'Find and add a Riddle around almost any topic to any post, page or widget...';
    echo   '<a href="#" onclick="readmore()" id="show" style="text-decoration: none; color: #000;">Find and add a Riddle around almost any topic to any post, page or widget...<span style=" color: #000; text-decoration: none;" >▼</span> </a>';
    echo   '<a href="#" onclick="readless()" id="hide" style="display:none; text-decoration: none; color: #000;">Find and add a Riddle around almost any topic to any post, page or widget...<span style=" color: #000; text-decoration: none;" >▲</span> </a>';
    echo '<div id="more" style="display: none"><p><ol><li>Just type in a few search terms, select your preferred language, then click ‘Search Riddle’.</li><li>Click ‘Get Shortcode’ - and just paste the resulting code anywhere in your Wordpress site.</li><li>Even quicker, you can select ‘Add to Post’ or ‘Add to Page’ to place that Riddle directly into an existing post or page.</li></ol></p></div>';
    echo '</div>';
    echo '<div style="width: 90%; max-width: 1100px;">';
    echo '<form method="POST" id="ridSearchForm">';
    echo '<input type="text" id="text_searchRiddle" name="text_searchRiddle">';

    if ($_POST["lang"] == "") {
        $lang = 'en-US';
        echo ' <select name="lang" style="height: 49px; width: 13%; max-width: 150px;margin-bottom: 6px; margin-right: 4px;" id="ridLang" onchange="changeLang()"> <option value="en-US">English</option> <option value="de-DE">Deutsch</option> </select>';
    } else if ($_POST["lang"] == 'en-US') {
        $lang = $_POST["lang"];
        echo ' <select name="lang" style="height: 49px; width: 13%; max-width: 150px;margin-bottom: 6px; margin-right: 4px;" id="ridLang" onchange="changeLang()"> <option value="en-US">English</option> <option value="de-DE">Deutsch</option> </select>';
    } else if ($_POST["lang"] == 'de-DE') {

        echo ' <select name="lang" style="height: 49px; width: 13%; max-width: 150px; margin-bottom: 6px; margin-right: 4px;" id="ridLang" onchange="changeLang()"> <option value="en-US">English</option> <option selected value="de-DE">Deutsch</option> </select>';
    }
    echo '<input type="submit" id="sub_searchRiddle" name="sub_searchRiddle" value="Search Riddle" class="button" >';

    echo '</form>';
    echo '</div>';


    $option = rid_getPages();
    showSearchedRiddles(0);

    if (isset($_POST["sub_searchRiddle"])) {
        // $option = rid_getPages();

        showSearchedRiddles(0);
    }

    if (isset($_POST["rid_post"])) {
        //create new Post
        $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");
        rid_createPost($postriddleCode["code"], 'wp_riddlepost', $postriddleCode, $_POST["ridSearch_id"]);
    }

    if (isset($_POST["rid_page"])) {

        $content = riddle_loadremote("http://www.riddle.com/Api/Trends?search=" . $_POST["text_searchRiddle"]);
        $jsons = json_decode($content);

        foreach ($jsons->trends as $json) {
            if ($json->uid == $_POST["ridSearch_id"]) {
                $rid_url = $json->data_game;
            }
        }


        showSearchedRiddles($option, $_POST["ridSearch_id"]);
        //  $ridSearchText = htmlentities($_POST["text_searchRiddle"]);
        echo '</div>';
    }

    if (isset($_POST["rid_postAdd"])) {


        $content = riddle_loadremote("http://www.riddle.com/Api/Trends?search=" . $_POST["text_searchRiddle"]);
        $jsons = json_decode($content);

        foreach ($jsons->trends as $json) {
            if ($json->uid == $_POST["ridSearch_id"]) {
                $rid_url = $json->data_game;
            }
        }
        $option = rid_getPosts();
        showSearchedRiddles($option, $_POST["ridSearch_id"]);
        echo '</div>';
    }


    if (isset($_POST["rid_page_implement"])) {

        $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");
        rid_addToPage($_POST["page-dropdown"], $postriddleCode["code"], '', 'wp_riddlepost', $postriddleCode, $_POST["ridSearch_id"]);
    }

    if (isset($_POST["rid_post_implement"])) {


        $postriddleCode = getPostriddleCode($_POST["ridSearch_id"], "100%", "auto");

        rid_addToPost($_POST["page-dropdown1"], $postriddleCode["code"], $_POST["ridSearch_id"], 'wp_riddlepost', $postriddleCode, $_POST["ridSearch_id"]);
    }
}

function showSearchedRiddles($ridID) {

    $f = "";

    echo '<script type="text/javascript"> rid_emptyRiddleSearch()</script>';

    if ($_POST["lang"] == "") {
        $lang = 'en-US';
    } else {
        $lang = $_POST["lang"];
    }
    $content = riddle_loadremote("http://www.riddle.com/Api/Trends?lang=" . $lang . "&search=" . $_POST["text_searchRiddle"]);
    $jsons = json_decode($content);
    $f .= '<div id="riddleSearch">';
    foreach ($jsons->trends as $json) {

        $f .= '<div class="riddle_element">';
        if ($json->rimageurl != null && $json->rimageurl != "") {
            $f .= '<img src="' . $json->rimageurl . '" width="180px" height="120px"><br/>';
        } else {
            $f = '<img src="' . plugins_url("/images/riddle_600x400.jpg", __FILE__) . ' " width="180px" height="120px">';
        }
        $f .= '<div id="textRidSearch">' . htmlspecialchars($json->rname) . ' </div>';
        //     $postriddleCode = getPostriddleCode($json->uid, "100%", "auto");
        $f .= '<form method="POST" name="form_' . $json->uid . '"><input type="button" class="button" style="width: 180px; position: relative; left: 2px; margin-bottom: 1px;" onclick="rid_getShortcode(\'' . $json->uid . '\')"  value="Get Shortcode" name="rid_shortcode"><input type="hidden" name="ridSearch_id" value="' . $json->uid . '"><input type="button" class="button" style="width: 87px;  margin-top: 5px;" id="rid_post"  onclick="rid_ShowAddButton(\'addPost_' . $json->uid . '\')"  value="Add to Post" name="rid_postAdd"> <input type="button" class="button" style="width: 87px;    margin-top: 5px;" id="rid_post" value="Add to Page" name="rid_page" onclick="rid_ShowAddButton(\'addPage_' . $json->uid . '\')">'; //<input type="submit" style="width: 180px; margin-top: 5px; "class="button" value="Create Riddlepost" name="rid_post" id="rid_post">   
        //if(($optionPage != "" || $optionPage != NULL) && ($ridID == $json->uid)) {
        $f .= '<div id="addPage_' . $json->uid . '" class="ridAddButtonHidden">';
        $option = rid_getPages();
        $f.= $option;
        $f.= '<input type="submit" class="button" style=" margin-top: 5px; width:42px; padding-left: 7px;" value="Add!" name="rid_page_implement"> ';
        $f .= '</div>';

        $f .= '<div id="addPost_' . $json->uid . '" class="ridAddButtonHidden">';
        $opt = rid_getPosts();
        $f.= $opt;
        $f.= '<input type="submit" class="button" style=" margin-top: 5px; width:42px; padding-left: 7px;" value="Add!" name="rid_post_implement"> ';
        $f .= '</div>';
        //  }
        $temp1 = getPostriddleCode($ridID, "100%", "auto");
        $f .= '<div style="display:none"><input  name =\'rid_HiddenShortcodePostriddle\'type=\'hidden\' id=\'rid_hiddenShortcodePostriddle' . $json->uid . '\' value=\'' . $temp1["code"] . '\'></div>';
        $f .= '<div style="display:none"><input  name =\'text_searchRiddle\'type=\'hidden\' id=\'rid_hiddenTextPostriddle' . $json->uid . '\' value=\'' . $_POST["text_searchRiddle"] . '\'></div>';
        $f .= '</form>';
        $f .= '</div>';
    }
    $f .= '</div>';
    echo $f;
}
