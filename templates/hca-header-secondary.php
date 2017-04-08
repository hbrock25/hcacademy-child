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
        <div class="fusion-alignleft">
	    <img src="/wp-content/uploads/2016/06/HCA-logo-web.png" height="50"/>
	</div>
        <?php if ( $content_2 ) : ?>
            <div class="fusion-alignright"><?php echo $content_2; ?></div>
        <?php endif; ?>
    </div>
</div>



