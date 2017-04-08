<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
        exit( 'Direct script access denied.' );
}
?>
<?php

$content_2 = avada_secondary_header_content( 'header_right_content' );
?>

<div class="fusion-secondary-header" style="background-color: #FFF; border-bottom-color: #cdb200">
    <div class="fusion-row">
        <div class="fusion-alignleft" style="padding-top: 10px">
	    <a href="https://www.harpcolumn.com">
		<img style="height: 70px; margin-right: 10px; padding-bottom: 10px" src="/wp-content/themes/hcacademy-child/images/hc-banner-logo.jpg" />
	    </a>
	    <a href="https://harpcolumnmusic.com">
		<img style="height: 70px; margin-right: 10px; padding-bottom: 10px" src="/wp-content/uploads/2016/06/HCA-logo-web.png" />
	    </a>
	    <a href="/">
		<img style="height: 70px; margin-right: 10px; padding-bottom: 10px; background-color: #ddd" src="/wp-content/uploads/2016/06/HCA-logo-web.png" />
	    </a>
	</div>
        <?php if ( $content_2 ) : ?>
            <div class="fusion-alignright"><?php echo $content_2; ?></div>
        <?php endif; ?>
    </div>
</div>


