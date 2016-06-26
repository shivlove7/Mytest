<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
--> 

<?php
/*
 * USING "twitteroauth" LIBRARY BY ABRAHAM WILLIAMS: "https://github.com/abraham/twitteroauth"
 */

require 'res/conf.php';
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

if (!isset($_SESSION['access_token'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	
} else {
    session_destroy();
	/*$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
        $user = $connection->get("account/verify_credentials");
	$user->screen_name;*/
        //$url = header ("Location: http://localhost/Twitlogin/callback.php");
}

?>
<!--
    ********GET-LATEST-TWEETS********
    *********The-Login-Page**********
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Get Latest Tweets</title>
        
        <!--STYLESHEET-->
        <link href="res/css/login.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        <!--MAIN WRAPPER-->
        <div id="wrapper">
            
            <!--REDIRECTION FORM-->
            <form name="main-form" class="main-form" action="" method="get">

                <!--HEADER-->
                <div class="header">
                    <div class ="twitlogo">

                    </div>
                <!--TITLE--><h1>Get Latest Tweets</h1><!--END TITLE-->
                <!--DESCRIPTION--><span>Please press the "Sign-in through Twitter" icon to get started with the awesome Get Latest Tweets App!</span><!--END DESCRIPTION-->
                </div>
                <!--END HEADER-->

                <!--FOOTER-->
                <div class="footer">
                <!-- HYPERLINK THAT WILL BE USED TO REDIRECT USER TO TWITTER AUTHENTICATION PAGE -->
                    <a class="button" href="<?php echo $url;?>"> Sign-In using Twitter </a>

                </div>
                <!--END FOOTER-->

            </form>
            <!--END REDIRECTION FORM-->

        </div>
        <!--END MAIN WRAPPER-->
        
        <!--GRADIENT-->
        <div class="gradient"></div>
        <!--END GRADIENT-->
        
    </body>
</html>
