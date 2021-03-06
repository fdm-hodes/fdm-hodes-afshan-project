<?php
// Geo Redirection code - dependent on HTTP_CF_IPCOUNTRY from Cloudflare
// Don't do anything if not home page or if a query string is used

if ($_SERVER["REQUEST_URI"] == '/') {
       
       $location = 'none';
       if ($_SERVER['HTTP_CF_IPCOUNTRY']) {
              $location = $_SERVER['HTTP_CF_IPCOUNTRY'];
       }
       switch (strtoupper($location)) {
              case 'US':
                     header('Location: /en-us/home-us/');
                     exit;
              case 'CA':
                     header('Location: /en-ca/ca-home/');
                     exit;
              case 'SG':
                     header('Location: /en-sg/sg-home/');
                     exit;
              case 'DE':
                     header('Location: /de/de-home/');
		     exit;   	
              case 'CN':
                     header('Location: /cn/cn-home/');
                     exit;
              case 'HK':
                     header('Location: /en-hk/hk-home/');
                     exit;
       }

}
// End of Geo Redirection
?>

<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Template header
 */
$us_layout = US_Layout::instance();
?>
<!DOCTYPE HTML>
<html class="<?php echo $us_layout->html_classes() ?> <?php do_action('html_classes'); ?>" <?php language_attributes( 'html' ) ?>>
<head>
	<meta charset="UTF-8">

	<?php wp_head() ?>

	<?php global $us_generate_css_file;
	if ( ! isset( $us_generate_css_file ) OR ! $us_generate_css_file ): ?>
		<style id='us-theme-options-css' type="text/css"><?php us_load_template( 'templates/theme-options.min.css' ) ?></style>
	<?php endif; ?>
</head>
<body <?php body_class( 'l-body ' . $us_layout->body_classes() ) ?><?php echo $us_layout->body_styles() ?> itemscope="itemscope" itemtype="https://schema.org/WebPage" <?php do_action('body_attributes'); ?>>
<?php do_action('after_body'); ?>
<?php if ( us_get_option( 'preloader' ) != 'disabled' ) {
	add_action( 'us_before_canvas', 'us_display_preloader', 100 );
	function us_display_preloader() {
		$preloader_type = us_get_option( 'preloader' );
		if ( ! in_array( $preloader_type, array( 1, 2, 3, 4, 5, 6, 7, 'custom' ) ) ) {
			$preloader_type = 1;
		}
		$preloader_type_class = ' type_' . $preloader_type;

		$preloader_image = us_get_option( 'preloader_image' );
		$preloader_image_html = '';
		$img = usof_get_image_src( $preloader_image, 'medium' );
		if ( $img[0] != '' ) {
			$preloader_image_html .= '<img src="' . esc_url( $img[0] ) . '"';
			if ( ! empty( $img[1] ) AND ! empty( $img[2] ) ) {
				// Image sizes may be missing when logo is a direct URL
				$preloader_image_html .= ' width="' . $img[1] . '" height="' . $img[2] . '"';
			}
			$preloader_image_html .= ' alt="" />';
		}

		?>
		<div class='l-preloader'><?php echo "<div class='l-preloader-spinner'><div class='g-preloader " . $preloader_type_class . "'><div class='g-preloader-h'>" . $preloader_image_html . "</div></div></div>"; ?></div>
		<?php
	}
}

do_action( 'us_before_canvas' ) ?>

<!-- CANVAS -->
<div class="l-canvas <?php echo $us_layout->canvas_classes() ?>">

	<?php if ( $us_layout->header_show != 'never' ): ?>

		<?php do_action( 'us_before_header' ) ?>

		<?php us_load_template( 'templates/l-header' ) ?>

		<?php do_action( 'us_after_header' ) ?>

	<?php endif/*( $us_layout->header_show != 'never' )*/
	; ?>
