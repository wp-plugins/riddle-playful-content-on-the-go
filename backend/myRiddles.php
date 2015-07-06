<?php


function rid_myRiddles() {
wp_enqueue_script('z-script', plugins_url('/js/zClip.js', __FILE__), false, '1.0.0');
    //check if Riddleitem should be added to post or page
    if (isset($_POST["rid_page_implement"])) {


        $riddleID = $_POST["riddleID"];
        $pageID = $_POST["page-dropdown"];
        $postriddleCode = getPostriddleCode($riddleID);


        rid_addToPage($pageID, $postriddleCode, $riddleID);
    }

    if (isset($_POST["rid_post_implement"])) {

        $riddleID = $_POST["riddleID"];
        $pageID = $_POST["post-dropdown"];
        $postriddleCode = getPostriddleCode($riddleID);


        rid_addToPost($pageID, $postriddleCode, $riddleID);
    }

    // get users access token
    global $wpdb;
    $user = $wpdb->get_row("SELECT access_token FROM wp_riddleuser ;");
    //get json data of the users riddles
    $content = riddle_loadremote("http://staging.riddle.com/apiv3/embed/list/" . $user->access_token);

    $json = json_decode($content);
    ?> <div class="rid_Container myriddles"> 
        <h1>My Riddles</h1>
        <div class="description">
            Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.  Lorem ipsum dolor sit amet. 
        </div>
        <div class="containerMyRiddles">
            <div id="ridPopUp"><h3>Your Shortcode</h3>
                <div>Copy the code below and paste it in a blog post or a blog page where you want your Riddle to appear.</div></br>
                <textarea id="ridPopUpTextbox" rows ="6" readonly="readonly"> </textarea>
                <input type="button" class="button left"  id="rid_CopytoClipboardButton" value="Copy to Clipboard">
                <input type="button" class="button right"  onClick="ridClosePopup()" value="Close"> 
            </div>
            <div id="ridPopUpWrapper"></div>
            <?php
            foreach ($json as $riddle) {
                ?>
                <div class="riddleItemContainer">


                    <div class="image" style="background-image:url(<?php echo $riddle->data->image->thumb ?>);"></div>
                    <div class="details">
                        <div class="title"><?php echo $riddle->data->title; ?></div>
                        <div class="description"><?php echo $riddle->data->desc; ?></div>
                    </div>
                    <div class="buttons">
                        <form method="POST" name="form_<?php echo $riddle->uid ?>">
                            <input type="button" value="Add to Post" class="button button-primary " onclick="rid_ShowAddButton('addPost_<?php echo $riddle->uid ?>')"/>
                            <input type="button" value="Add to Page" class="button button-primary " onclick="rid_ShowAddButton('addPage_<?php echo $riddle->uid ?>')"/>
                            <input type="hidden" name="riddleID" value="<?php echo $riddle->uid ?>"/>
                            <div id="addPage_<?php echo $riddle->uid ?>" class="ridAddButtonHidden">
                                <?php
                                $option = rid_getPages();
                                echo $option;
                                ?>

                                <input type="submit" class="button"  value="Add!" name="rid_page_implement"> 
                            </div>

                            <div id="addPost_<?php echo $riddle->uid ?>" class="ridAddButtonHidden">
                                <?php
                                $opt = rid_getPosts();
                                echo $opt
                                ?>

                                <input type="submit" class="button" value="Add!" name="rid_post_implement"> 
                            </div>
                            <input type="button" value="Get Shortcode" class="button button-primary shortcodeButton" onclick="rid_getShortcode(' <?php echo $riddle->uid ?> ')"/>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?> 
        </div>
    </div>
    <?php
    //show logout button
    ?>

    <form method ="POST" name="wp_logoutForm">
        <input type="submit" name="wp_logoutSubmit" value="Logout" class="button button-primary"/>
    </form>
    <?php
    if (isset($_POST["wp_logoutSubmit"])) {
        //logout
        global $wpdb;
        $wpdb->query('TRUNCATE TABLE wp_riddleuser; ');
        $_SESSION["acces_token"] = "";
        echo '<script type="text/javascript">location.reload();</script>';
    }
}
?>