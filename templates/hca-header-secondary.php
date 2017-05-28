<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
        exit( 'Direct script access denied.' );
}
?>
<?php

$content_2 = avada_secondary_header_content( 'header_right_content' );
?>

<div class="fusion-secondary-header">
    <div class="fusion-row">
        <div class="fusion-alignleft" >
	    <a href="https://www.harpcolumn.com">
		<img class="hca-banner" src="/wp-content/themes/hcacademy-child/images/hc-banner-navigation.png" />
	    </a>
	    <a href="https://harpcolumnmusic.com">
		<img class="hca-banner" src="/wp-content/themes/hcacademy-child/images/hcm-banner-navigation.png" />
	    </a>
	    <a href="/">
		<img class="hca-banner hca-selected" src="/wp-content/themes/hcacademy-child/images/hca-banner-navigation.png" />
	    </a>
	</div>
	<div class="hc-pmpro-exp-widget">
	    [pmpro_status_widget]
	</div>
        <?php if ( $content_2 ) : ?>
            <div class="fusion-alignright"><?php echo $content_2; ?></div>
        <?php endif; ?>
    </div>
</div>


