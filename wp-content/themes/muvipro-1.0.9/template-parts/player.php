<?php
/**
 * Template part for displaying player.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Muvipro
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	$notification = get_post_meta( $post->ID, 'IDMUVICORE_Notif', true );

	$player1 = get_post_meta( $post->ID, 'IDMUVICORE_Player1', true );
	$titleplayer1 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player1', true );
	
	$player2 = get_post_meta( $post->ID, 'IDMUVICORE_Player2', true );
	$titleplayer2 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player2', true );
	
	$player3 = get_post_meta( $post->ID, 'IDMUVICORE_Player3', true );
	$titleplayer3 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player3', true );
	
	$player4 = get_post_meta( $post->ID, 'IDMUVICORE_Player4', true );
	$titleplayer4 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player4', true );
	
	$player5 = get_post_meta( $post->ID, 'IDMUVICORE_Player5', true );
	$titleplayer5 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player5', true );
	
	$player6 = get_post_meta( $post->ID, 'IDMUVICORE_Player6', true );
	$titleplayer6 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player6', true );
	
	$player7 = get_post_meta( $post->ID, 'IDMUVICORE_Player7', true );
	$titleplayer7 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player7', true );
	
	$player8 = get_post_meta( $post->ID, 'IDMUVICORE_Player8', true );
	$titleplayer8 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player8', true );
	
	$player9 = get_post_meta( $post->ID, 'IDMUVICORE_Player9', true );
	$titleplayer9 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player9', true );
	
	$player10 = get_post_meta( $post->ID, 'IDMUVICORE_Player10', true );
	$titleplayer10 = get_post_meta( $post->ID, 'IDMUVICORE_Title_Player10', true );
	
	$trailer = get_post_meta( $post->ID, 'IDMUVICORE_Trailer', true );
	
	$download1 = get_post_meta( $post->ID, 'IDMUVICORE_Download1', true );
	
?>

<?php 
if ( 
   ! empty( $player1 ) 
|| ! empty( $player2 ) 
|| ! empty( $player3 )
|| ! empty( $player4 )
|| ! empty( $player5 )
|| ! empty( $player6 )
|| ! empty( $player7 )
|| ! empty( $player8 )
|| ! empty( $player9 )
|| ! empty( $player10 )
) { 
?>

<?php do_action( 'idmuvi_core_share_action' ); // Social share ?>

<?php do_action( 'idmuvi_core_top_player' ); // Banner before player ?>

<?php $globalnotification = get_theme_mod( 'gmr_notifplayer' ); 

if ( ! empty( $globalnotification ) ) { 
?>
	<div class="gmr-notification player-notification global-notification">
		<?php echo $globalnotification; ?>
	</div>
<?php } ?>

<?php 
if ( ! empty( $notification ) ) { 
?>
	<div class="gmr-notification player-notification">
		<?php echo $notification; ?>
	</div>
<?php } ?>

	<div class="gmr-server-wrap clearfix muvipro_player_content" id="muvipro_player_content_id" data-id="<?php echo $post->ID; ?>">  
		<div class="clearfix">  
			<?php if ( ! empty( $player1 ) ) { ?>
				<div id="player1-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player2 ) ) { ?>
				<div id="player2-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player3 ) ) { ?>
				<div id="player3-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player4 ) ) { ?>
				<div id="player4-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player5 ) ) { ?>
				<div id="player5-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player6 ) ) { ?>
				<div id="player6-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player7 ) ) { ?>
				<div id="player7-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player8 ) ) { ?>
				<div id="player8-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player9 ) ) { ?>
				<div id="player9-tab-content" class="tab-content">
				</div>
			<?php } ?>
			<?php if ( ! empty( $player10 ) ) { ?>
				<div id="player10-tab-content" class="tab-content">
				</div>
			<?php } ?>
		</div>

		<ul class="gmr-player-nav clearfix">
			<li><a href="javascript:void(0)" class="gmr-switch-button" title="<?php echo _e( 'Turn off light','muvipro' ); ?>"><span class="icon_lightbulb" aria-hidden="true"></span>  <span class="text"><?php echo _e( 'Turn off light','muvipro' ); ?></span></a></li>
			<li><a href="#comments" title="<?php echo _e( 'Comments','muvipro' ); ?>"><span class="icon_chat_alt" aria-hidden="true"></span>  <span class="text"><?php echo _e( 'Comments','muvipro' ); ?></span></a></li>
			<?php if ( ! empty( $trailer ) ) { ?>
				<li><a href="https://www.youtube.com/watch?v=<?php echo $trailer; ?>" class="gmr-trailer-popup" title="<?php echo the_title_attribute( array( 'before' => __( 'Trailer for ','muvipro' ), 'after' => '', 'echo' => 0 ) ); ?>"><span class="icon_film" aria-hidden="true"></span>  <span class="text"><?php echo _e( 'Trailer','muvipro' ); ?></span></a></li>
			<?php } ?>
			<?php if ( ! empty( $download1 ) ) { ?>
				<li class="pull-right"><a href="#download" title="<?php echo __( 'Download','muvipro' ); ?>"><span class="icon_download" aria-hidden="true"></span>  <span class="text"><?php echo _e( 'Download','muvipro' ); ?></span></a></li>
			<?php } ?>
		</ul>

		<ul class="muvipro-player-tabs nav nav-tabs clearfix" id="gmr-tab">
			<?php if ( ! empty( $player1 ) ) { ?>
				<li><a href="#" id="player1"><?php if( ! empty( $titleplayer1 ) ) { echo $titleplayer1; } else { echo _e('Server 1', 'muvipro'); } ?></a></li>
			<?php } ?>
			<?php if ( ! empty( $player2 ) ) { ?>
				<li><a href="#" id="player2"><?php if( ! empty( $titleplayer2 ) ) { echo $titleplayer2; } else { echo _e('Server 2', 'muvipro'); } ?></a></li>
			<?php } ?>
			<?php if ( ! empty( $player3 ) ) { ?>
				<li><a href="#" id="player3"><?php if( ! empty( $titleplayer3 ) ) { echo $titleplayer3; } else { echo _e('Server 3', 'muvipro'); } ?></a></li>
			<?php } ?>		
			<?php if ( ! empty( $player4 ) ) { ?>
				<li><a href="#" id="player4"><?php if( ! empty( $titleplayer4 ) ) { echo $titleplayer4; } else { echo _e('Server 4', 'muvipro'); } ?></a></li>
			<?php } ?>	
			<?php if ( ! empty( $player5 ) ) { ?>
				<li><a href="#" id="player5"><?php if( ! empty( $titleplayer5 ) ) { echo $titleplayer5; } else { echo _e('Server 5', 'muvipro'); } ?></a></li>
			<?php } ?>
			<?php if ( ! empty( $player6 ) ) { ?>
				<li><a href="#" id="player6"><?php if( ! empty( $titleplayer6 ) ) { echo $titleplayer6; } else { echo _e('Server 6', 'muvipro'); } ?></a></li>
			<?php } ?>
			<?php if ( ! empty( $player7 ) ) { ?>
				<li><a href="#" id="player7"><?php if( ! empty( $titleplayer7 ) ) { echo $titleplayer7; } else { echo _e('Server 7', 'muvipro'); } ?></a></li>
			<?php } ?>
			<?php if ( ! empty( $player8 ) ) { ?>
				<li><a href="#" id="player8"><?php if( ! empty( $titleplayer8 ) ) { echo $titleplayer8; } else { echo _e('Server 8', 'muvipro'); } ?></a></li>
			<?php } ?>
			<?php if ( ! empty( $player9 ) ) { ?>
				<li><a href="#" id="player9"><?php if( ! empty( $titleplayer9 ) ) { echo $titleplayer9; } else { echo _e('Server 9', 'muvipro'); } ?></a></li>
			<?php } ?>
			<?php if ( ! empty( $player10 ) ) { ?>
				<li><a href="#" id="player10"><?php if( ! empty( $titleplayer10 ) ) { echo $titleplayer10; } else { echo _e('Server 10', 'muvipro'); } ?></a></li>
			<?php } ?>
		</ul>
	</div>

<?php do_action( 'idmuvi_core_after_player' ); // Banner after player ?>

<?php do_action( 'idmuvi_core_share_action' ); ?>

<div id="lightoff"></div>

<?php } else { ?>

	<?php
		// Display content if have no embed code via player metaboxes
		$noembed_setting = get_theme_mod( 'gmr_player_appear', 'trailer' );
		if ( ! empty( $trailer ) && $noembed_setting == 'trailer' ) {
			global $wp_embed;
			$post_embed = $wp_embed->run_shortcode('[embed]http://www.youtube.com/watch?v=' . $trailer . '[/embed]');
	?>
	
		<?php do_action( 'idmuvi_core_share_action' ); // Social share ?>

		<?php do_action( 'idmuvi_core_top_player' ); // Banner before player ?>
		
		<div class="gmr-server-wrap clearfix">
			<div class="tab-content">		
				<div class="gmr-embed-responsive">
					<?php echo $post_embed; ?>
				</div>
			</div>
		
			<ul class="gmr-player-nav clearfix">
				<li><a href="javascript:void(0)" class="gmr-switch-button" title="<?php echo _e( 'Turn off light','muvipro' ); ?>"><span class="icon_lightbulb" aria-hidden="true"></span>  <span class="text"><?php echo _e( 'Turn off light','muvipro' ); ?></span></a></li>
				<li><a href="#comments" title="<?php echo _e( 'Comments','muvipro' ); ?>"><span class="icon_chat_alt" aria-hidden="true"></span>  <span class="text"><?php echo _e( 'Comments','muvipro' ); ?></span></a></li>
				<?php if ( ! empty( $download1 ) ) { ?>
					<li class="pull-right"><a href="#download" title="<?php echo __( 'Download','muvipro' ); ?>"><span class="icon_download" aria-hidden="true"></span>  <span class="text"><?php echo _e( 'Download','muvipro' ); ?></span></a></li>
				<?php } ?>
			</ul>
		</div>
		
		<?php do_action( 'idmuvi_core_after_player' ); // Banner after player ?>

		<?php do_action( 'idmuvi_core_share_action' ); ?>

		<div id="lightoff"></div>

	<?php } elseif ( $noembed_setting == 'text' ) { ?>
		<?php  if ( !is_singular( 'tv' ) ) {
			$textcommingsoon = get_theme_mod( 'gmr_textplayer' ); ?>
			<div class="gmr-server-wrap clearfix">
				<div class="gmr-embed-text">
					<?php 
						if ( $textcommingsoon ) {
							// sanitize html output than convert it again using htmlspecialchars_decode
							echo htmlspecialchars_decode( esc_html ( $textcommingsoon ) );
							
						} else {
							echo __('Comming Soon', 'muvipro');
							
						}
					?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
<?php } ?>