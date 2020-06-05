<?php
/* 
 * FB comments template file.
 * This replaces the theme's comment template when fb comments are enable
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$idmuv_social = get_option( 'idmuv_social' );

if ( isset ( $idmuv_social['social_app_id_facebook'] ) && $idmuv_social['social_app_id_facebook'] != '' ) {
	// option, section, default
	$appid = $idmuv_social['social_app_id_facebook'];
} else {
	$appid = '1703072823350490';
}
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/<?php bloginfo('language'); ?>/sdk.js#xfbml=1&appId=<?php echo $appid; ?>&version=v2.11";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="comments" class="idmuvi-fb-comments">
	<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-width="100%"></div>
</div>