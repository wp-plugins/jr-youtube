<?php
/*
Plugin Name: JR_YouTube
Plugin URI: http://www.jakeruston.co.uk/2009/11/wordpress-plugin-jr-youtube/
Description: Displays your recent youtube videos and videos from search queries as a widget.
Version: 1.4.1
Author: Jake Ruston
Author URI: http://www.jakeruston.co.uk
*/

/*  Copyright 2009 Jake Ruston - the.escapist22@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Hook for adding admin menus
add_action('admin_menu', 'jr_youtube_add_pages');
add_action('wp_head','youtube_delete_cache');
add_action('delete_youtube_cache','delete_youtube_cache');
register_activation_hook(__FILE__,'youtube_choice');

function youtube_choice () {
if (get_option("jr_youtube_links_choice")=="") {
if (!defined("ch"))
{
function setupch()
{
$ch = curl_init();
$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
return($ch);
}

define("ch", setupch());

function curl_get_contents($url)
{
$c = curl_setopt(ch, CURLOPT_URL, $url);
return(curl_exec(ch));
}
}

$content = curl_get_contents("http://www.jakeruston.co.uk/pluginslink4.php");

update_option("jr_youtube_links_choice", $content);
}
}

// action function for above hook
function jr_youtube_add_pages() {
    add_options_page('JR YouTube', 'JR YouTube', 'administrator', 'jr_youtube', 'jr_youtube_options_page');
}

// jr_youtube_options_page() displays the page content for the Test Options submenu
function jr_youtube_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_youtube_account';
    $opt_name_2 = 'mt_youtube_limit';
	$opt_name_3 = 'mt_youtube_query';
	$opt_name_4 = 'mt_youtube_title2';
    $opt_name_5 = 'mt_youtube_plugin_support';
    $opt_name_6 = 'mt_youtube_title';
    $opt_name_9 = 'mt_youtube_cache';
    $hidden_field_name = 'mt_youtube_submit_hidden';
    $data_field_name = 'mt_youtube_account';
    $data_field_name_2 = 'mt_youtube_limit';
	$data_field_name_3 = 'mt_youtube_query';
	$data_field_name_4 = 'mt_youtube_title2';
    $data_field_name_5 = 'mt_youtube_plugin_support';
    $data_field_name_6 = 'mt_youtube_title';
    $data_field_name_9 = 'mt_youtube_cache';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $opt_val_2 = get_option($opt_name_2);
	$opt_val_3 = get_option($opt_name_3);
	$opt_val_4 = get_option($opt_name_4);
    $opt_val_5 = get_option($opt_name_5);
    $opt_val_6 = get_option($opt_name_6);
    $opt_val_9 = get_option($opt_name_9);
    
if ($_POST['delcache']=="true") {
update_option("mt_youtube_cachey", "");
update_option("mt_youtube_cachey2", "");
}

if (!$_POST['feedback']=='') {
$my_email1="the.escapist22@gmail.com";
$plugin_name="JR YouTube";
$blog_url_feedback=get_bloginfo('url');
$user_email=$_POST['email'];
$subject=$_POST['subject'];
$feedback_feedback=$_POST['feedback'];
$headers1 = "From: feedback@jakeruston.co.uk";
$emailsubject1=$plugin_name." - ".$subject;
$emailmessage1="Blog: $blog_url_feedback\n\nUser E-Mail: $user_email\n\nMessage: $feedback_feedback";
mail($my_email1,$emailsubject1,$emailmessage1,$headers1);

?>

<div class="updated"><p><strong><?php _e('Feedback Sent!', 'mt_trans_domain' ); ?></strong></p></div>

<?php
}
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
        $opt_val_2 = $_POST[$data_field_name_2];
		$opt_val_3 = $_POST[$data_field_name_3];
		$opt_val_4 = $_POST[$data_field_name_4];
        $opt_val_5 = $_POST[$data_field_name_5];
        $opt_val_6 = $_POST[$data_field_name_6];
        $opt_val_9 = $_POST[$data_field_name_9];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
        update_option( $opt_name_2, $opt_val_2 );
		update_option( $opt_name_3, $opt_val_3 );
		update_option( $opt_name_4, $opt_val_4 );
        update_option( $opt_name_5, $opt_val_5 );
        update_option( $opt_name_6, $opt_val_6 ); 
        update_option( $opt_name_9, $opt_val_9 );
		update_option("mt_youtube_cachey", "");
		update_option("mt_youtube_cachey2", "");

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'JR YouTube Plugin Options', 'mt_trans_domain' ) . "</h2>";

    // options form
   
    $change3 = get_option("mt_youtube_plugin_support");
    $change6 = get_option("mt_youtube_cache");

if ($change3=="Yes" || $change3=="") {
$change3="checked";
$change31="";
} else {
$change3="";
$change31="checked";
}

if ($change5=="user" || $change5=="") {
$change5="checked";
$change51="";
} else {
$change5="";
$change51="checked";
}

    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("User Widget Title:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_6; ?>" value="<?php echo $opt_val_6; ?>" size="50">
</p><hr />

<p><?php _e("Search Widget Title:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_4; ?>" value="<?php echo $opt_val_4; ?>" size="50">
</p><hr />

<p><?php _e("USER VIDEOS: YouTube Username:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p><?php _e("SEARCH RESULT: Search Query:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_3; ?>" value="<?php echo $opt_val_3; ?>" size="20">
</p><hr />

<p><?php _e("Number of Videos to Show:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_2; ?>" value="<?php echo $opt_val_2; ?>" size="3">
</p><hr />

<p><?php _e("How long should the cache last for? Recommended 10 minutes.", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_9; ?>" value="<?php echo $opt_val_9; ?>" size="4"> Minutes
</p><hr />

<p><?php _e("Show Plugin Support?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change3; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change31; ?> id="Please do not disable plugin support - This is the only thing I get from creating this free plugin!" onClick="alert(id)">No
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>

<form action="" method="post"><input type="hidden" name="delcache" value="true" /><input type="submit" value="Delete Cache" /></form><br /><br />

<h3>Give Me Feedback!</h3>
<form name="form2" method="post" action="">
<p><?php _e("E-Mail (Optional):", 'mt_trans_domain' ); ?> 
<input type="text" name="email" /></p>
<p><?php _e("Subject:", 'mt_trans_domain' ); ?>
<input type="text" name="subject" /></p>
<p><?php _e("Comment:", 'mt_trans_domain' ); ?> 
<textarea name="feedback"></textarea>
</p>
<p class="submit">
<input type="submit" name="Send" value="<?php _e('Send', 'mt_trans_domain' ) ?>" />
</p><hr />
</form>
</div>
<?php
 
}

if (get_option("jr_youtube_links_choice")=="") {
youtube_choice();
}

function youtube_delete_cache() {
$optionyoutubecache = get_option("mt_youtube_cache");

$optionyoutubecache=$optionyoutubecache*60;

$schedule=wp_next_scheduled("delete_youtube_cache");

if ($schedule=="") {
wp_schedule_single_event(time()+$optionyoutubecache, 'delete_youtube_cache'); 
}
}

function delete_youtube_cache() {
update_option("mt_youtube_cachey", "");
update_option("mt_youtube_cachey2", "");
}

function show_youtube_user($args) {

extract($args);

  $widget_title = get_option("mt_youtube_title"); 
  $max_tracks = get_option("mt_youtube_limit");  
  $optionyoutube = get_option("mt_youtube_account");
  $supportplugin = get_option("mt_youtube_plugin_support"); 
  $optionyoutubecache = get_option("mt_youtube_cache");
  $youtubechoice = "user";
  $youtubequery = get_option("mt_youtube_query");
  
if (!$optionyoutube=="") {

$widget_title=str_replace("%user%", $optionyoutube, $widget_title);

$doc = new DOMDocument();

if ($youtubechoice=="" || $youtubechoice=="user") {
$docload='http://gdata.youtube.com/feeds/api/users/'.$optionyoutube.'/uploads';
} else if ($youtubechoice=="search") {
$docload='http://gdata.youtube.com/feeds/api/videos?q='.$youtubequery.'&max-results='.$max_tracks.'&v=2';
}

if($doc->load($docload)) {

  $i = 1;

$cachey = get_option("mt_youtube_cachey");

if (!$cachey=="") {
if (!$optionyoutubecache=="0") {
echo $cachey;

youtube_delete_cache();
}

} else {
$youtubedisp="";

  $youtubedisp .= $before_title; 

  $youtubedisp .= $widget_title.$after_title."<br />".$before_widget."<ul>";

  foreach ($doc->getElementsByTagName('entry') as $node) {

    $t_title = $node->getElementsByTagName('title')->item(0);
    $title = $t_title->nodeValue;	
	$t_url = $node->getElementsByTagName('id')->item(0);
	$url = $t_url->nodeValue;
	
if ($youtubechoice=="" || $youtubechoice=="user") {
ereg("http://gdata.youtube.com/feeds/api/videos/(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)",$url,$regs);
} else if ($youtubechoice=="search") {
ereg("video:(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)",$url,$regs);
}

$ending="{$regs[1]}{$regs[2]}{$regs[3]}{$regs[4]}{$regs[5]}{$regs[6]}{$regs[7]}{$regs[8]}{$regs[9]}{$regs[10]}{$regs[11]}";

$url = "http://www.youtube.com/watch?v=".$ending;

    $youtubedisp .= '<li><font color="#000000" size="2"><a href="'.$url.'">'.$title.'</a></font></li><br />';
 
    if($i++ >= $max_tracks) break;
  }

  $youtubedisp .= "</ul>";
  
if ($supportplugin=="Yes" || $supportplugin=="") {
$youtubedisp .= "<p style='font-size:x-small'>Plugin created by <a href='http://www.jakeruston.co.uk'>Jake Ruston</a> - ".get_option('jr_youtube_links_choice')."</p>";
}

$youtubedisp .= $after_widget;

echo $youtubedisp;

update_option("mt_youtube_cachey", $youtubedisp);

}

}

}

}

function show_youtube_query($args) {

extract($args);

  $widget_title = get_option("mt_youtube_title2"); 
  $max_tracks = get_option("mt_youtube_limit");  
  $optionyoutube = get_option("mt_youtube_account");
  $supportplugin = get_option("mt_youtube_plugin_support"); 
  $optionyoutubecache = get_option("mt_youtube_cache");
  $youtubechoice = "search";
  $youtubequery = get_option("mt_youtube_query");
  
if (!$optionyoutube=="") {

$widget_title=str_replace("%user%", $optionyoutube, $widget_title);

$doc = new DOMDocument();

if ($youtubechoice=="" || $youtubechoice=="user") {
$docload='http://gdata.youtube.com/feeds/api/users/'.$optionyoutube.'/uploads';
} else if ($youtubechoice=="search") {
$docload='http://gdata.youtube.com/feeds/api/videos?q='.$youtubequery.'&max-results='.$max_tracks.'&v=2';
}

if($doc->load($docload)) {

  $i = 1;

$cachey = get_option("mt_youtube_cachey2");

if (!$cachey=="") {
if (!$optionyoutubecache=="0") {
echo $cachey;

youtube_delete_cache();
}

} else {
$youtubedisp="";

  $youtubedisp .= $before_title; 

  $youtubedisp .= $widget_title.$after_title."<br />".$before_widget."<ul>";

  foreach ($doc->getElementsByTagName('entry') as $node) {

    $t_title = $node->getElementsByTagName('title')->item(0);
    $title = $t_title->nodeValue;	
	$t_url = $node->getElementsByTagName('id')->item(0);
	$url = $t_url->nodeValue;
	
if ($youtubechoice=="" || $youtubechoice=="user") {
ereg("http://gdata.youtube.com/feeds/api/videos/(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)",$url,$regs);
} else if ($youtubechoice=="search") {
ereg("video:(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)(.)",$url,$regs);
}

$ending="{$regs[1]}{$regs[2]}{$regs[3]}{$regs[4]}{$regs[5]}{$regs[6]}{$regs[7]}{$regs[8]}{$regs[9]}{$regs[10]}{$regs[11]}";

$url = "http://www.youtube.com/watch?v=".$ending;

    $youtubedisp .= '<li><font color="#000000" size="2"><a href="'.$url.'">'.$title.'</a></font></li><br />';
 
    if($i++ >= $max_tracks) break;
  }

  $youtubedisp .= "</ul>";
  
if ($supportplugin=="Yes" || $supportplugin=="") {
$youtubedisp .= "<p style='font-size:x-small'>Plugin created by <a href='http://www.jakeruston.co.uk'>Jake</a> Ruston - ".get_option('jr_youtube_links_choice')."</p>";
}

$youtubedisp .= $after_widget;

echo $youtubedisp;

update_option("mt_youtube_cachey2", $youtubedisp);

}

}

}

}

function init_youtube_widget() {
register_sidebar_widget("JR YouTube User Videos", "show_youtube_user");
register_sidebar_widget("JR YouTube Search Query Videos", "show_youtube_query");
}

add_action("plugins_loaded", "init_youtube_widget");

?>
