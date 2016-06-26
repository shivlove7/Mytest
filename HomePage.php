<?php
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
    
        //If the session exists
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
        //getting basic user info
	$user = $connection->get("account/verify_credentials");
	//Getting Basic info of user
        $user_name = $user->name;
        $user_screen = $user->screen_name;
        $ufollowers = $user->followers_count;
        $ufollowing = $user->friends_count;
        $usr_tweets = $user->statuses_count; //Total no of user tweets
        //Profile picture of dimension 48px by 48px (i.e. normal)
        $normalurl = $user->profile_image_url;
        //Profile picture of dimension 73px by 73px (i.e. bigger)
        $biggerurl = str_replace("_normal","_bigger",$normalurl);
        //Profile banner 
        $bannerurl = $user->profile_banner_url;
        $bannerurl .= "/300x100"; //Banner of dimension 300px by 100px
        
        
        //Getting Followers of User
        $usrfollowers = $connection->get('followers/list', ['count' => $ufollowers, 'screen_name' => $user_screen, 'skip_status' => True]);
        $page = 0;
        $start = 0;        
        foreach ($usrfollowers as $page){
            if (is_array($page) || is_object($page)){
                foreach ($page as $key){
                    $myfollowers[$start] = $key->name;
                    $start++;
                }
            }
        }
     
        for($i=0;$i<$start;$i++){
           echo $myfollowers[$i] . '<br>';
        }
        

	// getting recent tweeets by user 'Shahrukh Khan' on twitter
        $tweetsof = 'iamsrk';            
	$tweets = $connection->get('statuses/user_timeline', ['count' => 10, 'screen_name' => $tweetsof]);
	$totalTweets[] = $tweets;//10 latest tweets
      
}

?>

<!DOCTYPE html>
<!--
The Home Page
-->
<html>
    <head>
        <title>Get Latest Tweets!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="res/css/main.css">
        <script src="res/script/jquery-2.2.4.js"></script>
        <script type="text/javascript" src="res/script/main.js"></script>
    </head>
    <body>
        <div class="top_label">
            <img id="logoutimg" alt="logout" src="<?php echo $normalurl; ?>">
            <input type="text" id="search_box" placeholder="Search Followers">
        </div>
        <div class="logo">
            <div id="twit1logo"></div>
        </div>
        <div id="main_wrapper">
            
            <div class="profile_box">
                <img id="banner" src="<?php echo $bannerurl; ?>" alt="Banner">
                <img id="userimg" src="<?php echo $biggerurl; ?>" alt="Profile_Pic">
                <h3><?php echo $user_name; ?></h3>
                <span><?php echo "@" . $user_screen; ?></span>
                <div id="ufollowers">FOLLOWERS
                    <div id="ufollowers_cnt">
                        <?php echo $ufollowers; ?>
                    </div>   
                </div>
                
                <div id="ufollowing">FOLLOWING
                    <div id="ufollowing_cnt">
                        <?php echo $ufollowing; ?>
                    </div>        
                </div>
                
                <div id="usr_tweets">TWEETS
                    <div id="usr_tweets_cnt">
                        <?php echo $usr_tweets; ?>
                    </div>      
                </div>
            </div>
            <div id="twit2logo"></div>
            <div class="container">
                <a id="arrow_up" ></a>
                <a id="arrow_down"></a>

            <div class="header">
                <h1><?php echo $tweetsof ;?>'s Tweets:</h1>
            </div>

            <div id="slider">
                <ul class="slides">
                    <?php
                        //list 10 (max = 10) latest tweets 
                        $start = 1;
                        foreach ($totalTweets as $page) {
                            foreach ($page as $key) {
                                echo  '<li class="slide">' . '<br>' . '<span style="color: #9D582E;">' . $start . '.' . '</span>' . ' ' . $key->text . '</li>' ;
                                    $start++;
                            }
                        }

                        //If total number of tweets > 3 
                        //Then list latest 3 tweets once again, as we are using the slider 
                        //with window of three tweets
                        if($start > 3){
                            $start = 1;
                            foreach ($totalTweets as $page) {
                                foreach ($page as $key) {
                                    echo '<li class="slide">' . '<br>' . '<span style="color: #9D582E;">' . $start . '.' . '</span>' . ' ' . $key->text . '</li>';
                                    $start++;
                                    if($start == 4){
                                        break;
                                    }
                                }
                            }
                        }
                    ?>
                </ul>

            </div>
                
            </div>
            <div class="followers"><br> Followers </div>
        </div>
        <div class="bottom-box"> Footer </div>
               
    </body>
</html>

