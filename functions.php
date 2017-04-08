<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

function pmpro_shortcode_protection_text($atts, $content=null, $code="")
{
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// $code    ::= the shortcode found, when == callback name
	// examples: [membership level="3"]...[/membership]

global $current_user;

//use globals if no values supplied
if(!$user_id)
  $user_id = $current_user->ID;

$pmpro_content_message_pre = '<div class="pmpro_content_message">';
$pmpro_content_message_post = '</div>';

//get the correct message to show at the bottom
if($current_user->ID)
  {
    //not a member
    $newcontent = apply_filters("pmpro_non_member_text_filter", stripslashes(pmpro_getOption("nonmembertext")));
    $content = $pmpro_content_message_pre . $newcontent . $pmpro_content_message_post;
  }
 else
   {
     //not logged in!
     $newcontent = apply_filters("pmpro_not_logged_in_text_filter", stripslashes(pmpro_getOption("notloggedintext")));
     $content = $pmpro_content_message_pre . $newcontent . $pmpro_content_message_post;
   }

return do_shortcode($content);

}
add_shortcode("protection_text", "pmpro_shortcode_protection_text");

add_filter( 'tml_action_links', 'hc_add_back_register_link', 10, 2);

/*
	Shortcode to show a member's expiration date.
	
	Add this code to your active theme's functions.php or a custom plugin.
	
	Then add the shortcode [pmpro_expiration_date] where you want the current user's
	expiration date to appear.
	
	If the user is logged out or doesn't have an expiration date, then --- is shown.
*/

function pmpro_expiration_date_shortcode( $atts ) {
	//make sure PMPro is active
	if(!function_exists('pmpro_getMembershipLevelForUser'))
		return;
	
	//get attributes
	$a = shortcode_atts( array(
	    'user' => '',
	), $atts );
	
	//find user
	if(!empty($a['user']) && is_numeric($a['user'])) {
		$user_id = $a['user'];
	} elseif(!empty($a['user']) && strpos($a['user'], '@') !== false) {
		$user = get_user_by('email', $a['user']);
		$user_id = $user->ID;
	} elseif(!empty($a['user'])) {
		$user = get_user_by('login', $a['user']);
		$user_id = $user->ID;
	} else {
		$user_id = false;
	}
	
	//no user ID? bail
	if(!isset($user_id))
		return;

	//get the user's level
	$level = pmpro_getMembershipLevelForUser($user_id);

	if(!empty($level) && !empty($level->enddate))
		$content = date(get_option('date_format'), $level->enddate);
	else
		$content = "---";

	return $content;
}

add_shortcode('pmpro_expiration_date', 'pmpro_expiration_date_shortcode');
  
function pmpro_level_name_shortcode( $atts ) {
        //make sure PMPro is active                                                                     
        if(!function_exists('pmpro_getMembershipLevelForUser'))
                return;

        //get attributes                                                                                
        $a = shortcode_atts( array(
            'user' => '',
        ), $atts );

        //find user                                                                                     
        if(!empty($a['user']) && is_numeric($a['user'])) {
                $user_id = $a['user'];
        } elseif(!empty($a['user']) && strpos($a['user'], '@') !== false) {
                $user = get_user_by('email', $a['user']);
                $user_id = $user->ID;
        } elseif(!empty($a['user'])) {
                $user = get_user_by('login', $a['user']);
                $user_id = $user->ID;
        } else {
                $user_id = false;
        }

        //no user ID? bail                                                                              
        if(!isset($user_id))
                return;

        //get the user's level                                                                          
        $level = pmpro_getMembershipLevelForUser($user_id);

        if(!empty($level) && !empty($level->enddate))
                $content = $level->name;
        else
                $content = "None";

        return $content;
}

add_shortcode('pmpro_level_name', 'pmpro_level_name_shortcode');

function pmpro_expire_text_shortcode( $atts ) {
        //make sure PMPro is active                                                                     
        if(!function_exists('pmpro_getMembershipLevelForUser'))
                return;

        //get attributes                                                                                
        $a = shortcode_atts( array(
            'user' => '',
        ), $atts );

        //find user                                                                                     
        if(!empty($a['user']) && is_numeric($a['user'])) {
                $user_id = $a['user'];
        } elseif(!empty($a['user']) && strpos($a['user'], '@') !== false) {
                $user = get_user_by('email', $a['user']);
                $user_id = $user->ID;
        } elseif(!empty($a['user'])) {
                $user = get_user_by('login', $a['user']);
                $user_id = $user->ID;
        } else {
                $user_id = false;
        }

        //no user ID? bail                                                                              
        if(!isset($user_id))
                return;

        //get the user's level                                                                          
        $level = pmpro_getMembershipLevelForUser($user_id);

        if(!empty($level) && !empty($level->enddate))
                $content = "<p><strong>Your membership level:</strong> " . $level->name . "<br /><strong>Expires: </strong> " . date(get_option('date_format'), $level->enddate) . "</p>";
        else
                $content = "";

        return $content;
}

add_shortcode('pmpro_expire_text', 'pmpro_expire_text_shortcode');

/* Avada code that adds the secondary header actions -- to override */

function hca_avada_secondary_header() {
    if ( ! in_array( Avada()->settings->get( 'header_layout' ), array( 'v2', 'v3', 'v4', 'v5' ) ) ) {
        return;
    }
 	echo "Potrzebie";
}

function hca_change_secondary_header_action() {
    remove_action('avada_header', 'avada_secondary_header', 10);
    add_action('avada_header', 'hca_avada_secondary_header', 10);
}
add_action( "init", "hca_change_secondary_header_action", 1000 );



