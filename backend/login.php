<?php

function riddle_loginView() {

    global $wpdb;
    $user = $wpdb->get_row("SELECT * FROM wp_riddleuser ;");

    if ($user != null) {

        //show users riddle
        
        rid_myRiddles();
    } else { // user is not logged in yet

        /*         * * Add the Login Form ** */
        ?>
        <div id="rid_Container login">
            <h1 style="margin-top: 30px; margin-bottom: 30px; ">Login</h1>
            <div class="description">
                Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.  Lorem ipsum dolor sit amet. 
            </div>
            <div class="formLogin">
                <form method="POST" name="wp_loginForm">
                    <label>Email</label><input type="text" name="wp_loginEmail"/>
                    <label>Password</label><input type="password" name="wp_loginPassword"/>
                    <input type="submit" name="wp_loginSubmit" class="button button-primary button-hero"/>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST["wp_loginSubmit"])) {
            //if Loginform is submitted
            //check if email and password arnt empty

            if ($_POST["wp_loginEmail"] == "" || $_POST["wp_loginEmail"] == null || $_POST["wp_loginPassword"] == "" || $_POST["wp_loginPassword"] == null) {
                //throw error
                ?>
                <div class="wp_error">Please fill in email and password. </div>
                <?php
            } else {
                //password and email are not empty

                $password = sha1(trim($_POST["wp_loginPassword"]));
                $email = $_POST["wp_loginEmail"];

                //check if email and password match  http://staging.riddle.com/apiv3/embed/auth/test/123

                $content = riddle_loadremote("http://staging.riddle.com/apiv3/embed/auth/" . $email . "/a?sha1=" . $password);

                $json = json_decode($content);

                if ($json->error != null) {
                    //echo error
                    ?>
                    <div class="wp_error"> <?php echo $json->error ?> </div>
                    <?php
                } else if ($json->access_token != null) {
                    
                   
                    //do login
                    addLoginTable();

                    //check if user is already logged in
                    global $wpdb;
                    $user = $wpdb->get_row("SELECT * FROM wp_riddleuser WHERE email = '" . $email . "';");

                    if ($user == null) { // user is not logged in yet
                        //store userdata to database
                        $wpdb->insert(
                                'wp_riddleuser', array(
                            'email' => $email,
                            'password' => $password,
                            'access_token' => $json->access_token
                                ), array(
                            '%s',
                            '%s',
                            '%s'
                                )
                        );

                     //reload page
                        
                           echo '<script type="text/javascript">location.reload();</script>';
                    } else { // user is already logged in
                        ?>
                        <div class="wp_error">You are already logged in. </div>
                        <?php
                    }
                }
            }
        }
    }
}

$your_db_name = $wpdb->prefix . 'riddleuser';

// function to create the DB / Options / Defaults					
function addLoginTable() {
    global $wpdb;
    global $your_db_name;

    // create the ECPT metabox database table
    if ($wpdb->get_var("show tables like '$your_db_name'") != $your_db_name) {
        $sql = "CREATE TABLE " . $your_db_name . " (
		`id` mediumint(9) NOT NULL AUTO_INCREMENT,
		`email` text NOT NULL,
		`password` text NOT NULL,
		`access_token` text NOT NULL,
		
		UNIQUE KEY id (id)
		);";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
?>