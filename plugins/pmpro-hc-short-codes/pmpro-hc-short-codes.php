<?php
/*
Plugin Name: Paid Memberships Pro: Harp Column Short Codes
Plugin URI: http://www.harpcolumn.com
Description: Short codes to display custom membership data for Harp Column
Version: 1.0
Requires: 4.5.3
Author: Hugh Brock <hbrock@harpcolumn.com>
Author URI: http://wwwharpcolumn.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
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

  //use globals if no values supplied
  if(!$user_id)
    $user_id = get_current_user_id();

  //no user ID? bail
  if(!$user_id)
		return '<a href="/my-account">Login</a> | <a href="/my-account">Register</a>';

	//get the user's level
	$level = pmpro_getMembershipLevelForUser($user_id);

	if(!empty($level) && !empty($level->enddate) && $level->id > 1)
		$content = 'Your membership expires on ' . date(get_option('date_format'), $level->enddate) . '. <a href="/renew">Renew</a> | <a href="/my-account">My Account</a> | <a href="/my-account/customer-logout">Logout</a>';
	else
		$content = '<a href="/join">Join</a> | <a href="/my-account">My Account</a> | <a href="/my-account/customer-logout">Logout</a>';

	return $content;
}

add_shortcode('pmpro_expiration_date', 'pmpro_expiration_date_shortcode');
  

/*
	Shortcode to show membership account information
*/
function pmpro_hc_shortcode_account($atts, $content=null, $code="")
{
	global $wpdb, $pmpro_msg, $pmpro_msgt, $pmpro_levels, $current_user, $levels;
	
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// $code    ::= the shortcode found, when == callback name
	// examples: [pmpro_account]

	ob_start();
	
	//if a member is logged in, show them some info here (1. past invoices. 2. billing information with button to update.)
	if(pmpro_hasMembershipLevel())
	{
		$ssorder = new MemberOrder();
		$ssorder->getLastMemberOrder();
		$mylevels = pmpro_getMembershipLevelsForUser();
		$pmpro_levels = pmpro_getAllLevels(false, true); // just to be sure - include only the ones that allow signups
		$invoices = $wpdb->get_results("SELECT *, UNIX_TIMESTAMP(timestamp) as timestamp FROM $wpdb->pmpro_membership_orders WHERE user_id = '$current_user->ID' AND status NOT IN('refunded', 'review', 'token', 'error') ORDER BY timestamp DESC LIMIT 6");
		?>	
	<div id="pmpro_account">		

	              <div id="pmpro_account-membership" class="pmpro_box">
				
				<h2><?php _e("My Subscription", "pmpro");?></h2>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<thead>
						<tr>
							<th><?php _e("Subscription", "pmpro");?></th>
							<th><?php _e("Price", "pmpro"); ?></th>
							<th><?php _e("Expiration", "pmpro"); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($mylevels as $level) {
						?>
						<tr>
							<td class="pmpro_account-membership-levelname">
								<?php echo $level->name?>
								<div class="pmpro_actionlinks">
									<?php do_action("pmpro_member_action_links_before"); ?>
									
									<?php if( array_key_exists($level->id, $pmpro_levels) && pmpro_isLevelExpiringSoon( $level ) ) { ?>
										<a href="/subscribe"><?php _e("Renew", "pmpro");?></a>
									<?php } ?>

									<a href="<?php echo pmpro_url("cancel", "?levelstocancel=" . $level->id)?>"><?php _e("Cancel", "pmpro");?></a>
									<?php do_action("pmpro_member_action_links_after"); ?>
								</div> <!-- end pmpro_actionlinks -->
							</td>
							<td class="pmpro_account-membership-levelfee">
								<p><?php echo pmpro_getLevelCost($level, true, true);?></p>
							</td>
							<td class="pmpro_account-membership-expiration">
							<?php 
								if($level->enddate) 
									echo date_i18n(get_option('date_format'), $level->enddate);
								else
									echo "---";
							?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div> <!-- end pmpro_account-membership -->
		
	</div> <!-- end pmpro_account -->		
	<?php
					    }
	
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}
add_shortcode('pmpro_hc_account', 'pmpro_hc_shortcode_account');
