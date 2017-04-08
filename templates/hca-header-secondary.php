<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
        exit( 'Direct script access denied.' );
}
?>
<?php

$content_1 = "Potrzebie"
$content_2 = avada_secondary_header_content( 'header_right_content' );
?>

<div class="fusion-secondary-header">
        <div class="fusion-row">
                <?php if ( $content_1 ) : ?>
                        <div class="fusion-alignleft"><?php echo $content_1; ?></div>
                <?php endif; ?>
                <?php if ( $content_2 ) : ?>
                        <div class="fusion-alignright"><?php echo $content_2; ?></div>
                <?php endif; ?>
        </div>
</div>



