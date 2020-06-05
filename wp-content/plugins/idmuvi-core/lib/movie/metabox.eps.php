<?php
/**
 * Add Simple Metaboxes Settings
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Idmuvi Core
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a meta box using a class.
 *
 * @since 1.0.0
 */
class Idmuvi_Core_Metabox_Settings_TvShow_Episode {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_footer', array( $this, 'idmuvi_admin_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'idmuvi_admin_enqueue_style' ) );
		add_action( 'load-post.php', array( $this, 'post_metabox_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'post_metabox_setup' ) );
		add_action( 'admin_init', array( $this, 'save_poster' ) );
	}

	/**
	 * Metabox setup function
	 */
	public function post_metabox_setup() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	/**
	 * Register the JavaScript.
	 */
	public function idmuvi_admin_enqueue_scripts() {
		global $post_type;
		if ( 'episode' === $post_type ) {

			$idmuv_tmdb = get_option( 'idmuv_tmdb' );

			if ( isset( $idmuv_tmdb['enable_tmdb_api'] ) && ! empty( $idmuv_tmdb['enable_tmdb_api'] ) ) {
				// option, section, default.
				$enable_tmdb_opsi = $idmuv_tmdb['enable_tmdb_api'];
			} else {
				$enable_tmdb_opsi = 'off';
			}

			if ( isset( $idmuv_tmdb['tmdb_api'] ) && ! empty( $idmuv_tmdb['tmdb_api'] ) ) {
				// option, section, default.
				$apikey = $idmuv_tmdb['tmdb_api'];
			} else {
				$apikey = '';
			}

			if ( isset( $idmuv_tmdb['tmdb_lang'] ) && ! empty( $idmuv_tmdb['tmdb_lang'] ) ) {
				// option, section, default.
				$language = $idmuv_tmdb['tmdb_lang'];
			} else {
				$language = '';
			}

			?>
			<script type="text/javascript">
				(function( $ ) {
					'use strict';

					/**
					 * From this point every thing related to metabox
					 */
					$('document').ready(function(){

						$('h3.nav-tab-wrapper span:first').addClass('current');
						$('.tab-content:first').addClass('current');
						$('h3.nav-tab-wrapper span').click(function(){
							var t = $(this).attr('id');

							$('h3.nav-tab-wrapper span').removeClass('current');
							$('.tab-content').removeClass('current');

							$(this).addClass('current');
							$('#'+ t + 'C').addClass('current');
						});

						// First tab inner
						$('ul.nav-tab-wrapper li:first').addClass('current');
						$('.tab-content-inner:first').addClass('current');
						$('ul.nav-tab-wrapper li').click(function(){
							var t = $(this).attr('id');

							$('ul.nav-tab-wrapper li').removeClass('current');
							$('.tab-content-inner').removeClass('current');

							$(this).addClass('current');
							$('#'+ t + 'C').addClass('current');
						});

						// Second tab inner
						$('ul.nav-tab-wrapperdl li:first').addClass('current');
						$('.tab-content-innerdl:first').addClass('current');
						$('ul.nav-tab-wrapperdl li').click(function(){
							var t = $(this).attr('id');

							$('ul.nav-tab-wrapperdl li').removeClass('current');
							$('.tab-content-innerdl').removeClass('current');

							$(this).addClass('current');
							$('#'+ t + 'C').addClass('current');
						});

						// Start uploader
						$('.muvipro-metaposer-browse').on('click', function (event) {
							event.preventDefault();

							var self = $(this);

							// Create the media frame.
							var file_frame = wp.media.frames.file_frame = wp.media({
								title: self.data('uploader_title'),
								button: {
									text: self.data('uploader_button_text'),
								},
								multiple: false
							});

							file_frame.on('select', function () {
								var attachment = file_frame.state().get('selection').first().toJSON();
								self.prev('.muvipro-metaposer-url').val(attachment.url).change();
							});

							// Finally, open the modal
							file_frame.open();
						});

						<?php
						if ( 'on' === $enable_tmdb_opsi ) {
							?>

						// Start grabbing from tmdb using API
						$('input[name=idmuvi-ret-gmr-button]').click(function() {

							var valTMDBid = $('input[name=tmdbID]').get(0).value;
							var valTMDBid_Session = $('input[name=tmdbID_Session]').get(0).value;
							var valTMDBid_Eps = $('input[name=tmdbID_Eps]').get(0).value;
							var languange = "&language=<?php echo esc_html( $language ); ?>&include_image_language=<?php echo esc_html( $language ); ?>,null";
							var apikey = "&api_key=<?php echo esc_html( $apikey ); ?>";
							var target = document.URL;

							// Request Using getJSON
							$.getJSON( "https://api.themoviedb.org/3/tv/" + valTMDBid + "/season/" + valTMDBid_Session + "/episode/" + valTMDBid_Eps + "?append_to_response=videos,images" + languange + apikey, function(json) {
								$.each(json, function(key, val) {
									/* Title */
									var valTitle = "";
									if(key == "name"){
										valTitle+= ""+val+"";
										$('input[name=idmuvi-core-title-episode-value]').val(valTitle);
									}

									/* TMDB Rating */
									var valTmdbRating = "";
									if(key == "vote_average"){
										valTmdbRating+= ""+val+"";
										$('input[name=idmuvi-core-tmdbrating-value]').val(valTmdbRating);
									}

									/* TMDB Vote */
									var valTmdbVote = "";
									if(key == "vote_count"){
										valTmdbVote+= ""+val+"";
										$('input[name=idmuvi-core-tmdbvotes-value]').val(valTmdbVote);
									}

									/* Episode Number */
									var valNumEpisode = "";
									if(key == "episode_number"){
										valNumEpisode+= ""+val+"";
										$('input[name=idmuvi-core-episodenumber-value]').val(valNumEpisode);
									}

									/* Session Number */
									var valSesNumber = "";
									if(key == "season_number"){
										valSesNumber+= ""+val+"";
										$('input[name=idmuvi-core-sessionnumber-value]').val(valSesNumber);
									}

									/* Date Release and Year Release */
									var valRelease = "";
									if(key == "air_date"){
										var m_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
										var d = new Date(val);
										var curr_date = d.getDate();
										var curr_month = d.getMonth();
										var curr_year = d.getFullYear();
										// Remove min value
										valRelease+= curr_date + " " + m_names[curr_month] + " " + curr_year;
										$('input[name=idmuvi-core-released-value]').val(valRelease);
									}

									/* Cast */
									var valCast = "";
									if(key == "credits"){
										$.each(json.credits.cast, function(i, item) {
											// add commas separator
											valCast += "" + item.name + ", ";
											return i<2;
										});
										$('input[id=new-tag-muvicast]').val( valCast );
									}

									/* Plot or description */
									var valDesc = "";
									if(key == "overview"){
										var output = val.replace(/\n/g, "<br />");
										valDesc+= ""+output+"";
										if( typeof tinyMCE != "undefined" ) {
											var editor_id = wpActiveEditor;
											if ( $('#wp-'+editor_id+'-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id) ) {
												tinyMCE.get(editor_id).setContent(valDesc);
											} else {
												$("textarea[name=content]").val(valDesc);
											}
										}
									}

									/* Image and automatic upload via ajax */
									var valImg = "";
									if(key == "still_path"){
										valImg+= "https://image.tmdb.org/t/p/w300"+val+"";
										// Insert image using ajax
										if( valImg !== null ){
											var poster = valImg;
											//alert(poster);
											$.ajax({
												type: "POST",
												url: target,
												data: {
													'poster_url':poster,
												},
												success: function(response){
													$("input[name=idmuvi-core-poster-value]").val(response);
												}
											});
										} else {
											$("input[name=idmuvi-core-poster-value]").val(valImg);
										}
									}
								});

								$.getJSON( "https://api.themoviedb.org/3/tv/" + valTMDBid + "?append_to_response=images" + languange + apikey, function(json) {

									$.each(json, function(key, item) {
										if (key == "name") {
											$("input[name=idmuvi-core-serie-value]").val(item);
											$("input[name=post_title]").val(item + " Season " + valTMDBid_Session + " Episode " + valTMDBid_Eps);
										}

										/* TMDB ID */
										var valTmdbID = "";
										if(key == "id"){
											// Remove min value
											valTmdbID+= ""+item+"";
											$('input[name=idmuvi-core-tmdbid-value]').val(valTmdbID);
										}
									});
								});


							});

						});

							<?php
						}
						?>

					});
				})( jQuery );
			</script>
			<?php
		}
	}

	/**
	 * Register the Css.
	 */
	public function idmuvi_admin_enqueue_style() {
		global $post_type;
		if ( 'episode' === $post_type ) {
			?>
			<style type="text/css">
			body.post-new-php #titlediv #title-prompt-text {display: none !important;}
			.nav-tab-wrapperdl {border-bottom: 1px solid #ccc;margin: 0;padding-top: 9px;padding-bottom: 0;line-height: inherit;}
			ul.nav-tab-wrapperdl,
			ul.nav-tab-wrapper {display:block;width: 100%;}
			ul.nav-tab-wrapperdl li,
			ul.nav-tab-wrapper li{background: none;color: #0073aa;padding: 3px 5px;display: inline-block;cursor: pointer;margin-right:3px;}
			h3.nav-tab-wrapper span{background: none;color: #0073aa;display: inline-block;padding: 10px 15px;cursor: pointer;}
			ul.nav-tab-wrapperdl li.current,
			ul.nav-tab-wrapper li.current,
			h3.nav-tab-wrapper span.current{background: #ededed;color: #222;cursor: default;}
			.tab-content-innerdl,
			.tab-content-inner,
			.tab-content{display: none;}
			.tab-content-innerdl.current,
			.tab-content-inner.current,
			.tab-content.current{display: inherit;padding-top: 20px;}
			.idmuvi-core-metabox-common-fields p {margin-bottom: 20px;}
			.idmuvi-core-metabox-common-fields input.display-block,
			.idmuvi-core-metabox-common-fields textarea.display-block{display:block;width:100%;}
			.idmuvi-core-metabox-common-fields input[type="button"].display-block {margin-top:10px;}
			.idmuvi-core-metabox-common-fields label {display: block;margin-bottom: 5px;}
			.idmuvi-core-metabox-common-fields input[disabled] {background: #ddd;}
			</style>
			<?php
		}
	}

	/**
	 * Adds the meta box.
	 *
	 * @param string $post_type Post Type.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'episode' );
		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box(
				'idmuvi_core_movie_meta_metabox',
				__( 'Find Episode', 'idmuvi-core' ),
				array( $this, 'metabox_callback' ),
				$post_type,
				'advanced',
				'default'
			);
		}
	}

	/**
	 * Save the meta box.
	 *
	 * @param int $post_id Post ID.
	 * @param int $post Post.
	 *
	 * @return int $post_id
	 */
	public function save( $post_id, $post ) {
		/* Verify the nonce before proceeding. */
		if ( ! isset( $_POST['idmuvi_core_episode_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['idmuvi_core_episode_meta_nonce'] ) ), basename( __FILE__ ) ) ) {
			return $post_id;
		}

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
			return $post_id;
		}

		/* List of meta box fields (name => meta_key) */
		$fields = array(
			'idmuvi-core-title-episode-value'    => 'IDMUVICORE_Title_Episode',
			'idmuvi-core-serie-value'            => 'IDMUVICORE_Serie',
			'idmuvi-core-trailer-value'          => 'IDMUVICORE_Trailer',
			'idmuvi-core-poster-value'           => 'IDMUVICORE_Poster',
			'idmuvi-core-tmdbvotes-value'        => 'IDMUVICORE_tmdbVotes',
			'idmuvi-core-tmdbrating-value'       => 'IDMUVICORE_tmdbRating',
			'idmuvi-core-released-value'         => 'IDMUVICORE_Released',
			'idmuvi-core-episodenumber-value'    => 'IDMUVICORE_Episodenumber',
			'idmuvi-core-sessionnumber-value'    => 'IDMUVICORE_Sessionnumber',
			'idmuvi-core-tmdbid-value'           => 'IDMUVICORE_tmdbID',
			'idmuvi-core-notif-value'            => 'IDMUVICORE_Notif',
			'idmuvi-core-player1-value'          => 'IDMUVICORE_Player1',
			'idmuvi-core-title-player1-value'    => 'IDMUVICORE_Title_Player1',
			'idmuvi-core-player2-value'          => 'IDMUVICORE_Player2',
			'idmuvi-core-title-player2-value'    => 'IDMUVICORE_Title_Player2',
			'idmuvi-core-player3-value'          => 'IDMUVICORE_Player3',
			'idmuvi-core-title-player3-value'    => 'IDMUVICORE_Title_Player3',
			'idmuvi-core-player4-value'          => 'IDMUVICORE_Player4',
			'idmuvi-core-title-player4-value'    => 'IDMUVICORE_Title_Player4',
			'idmuvi-core-player5-value'          => 'IDMUVICORE_Player5',
			'idmuvi-core-title-player5-value'    => 'IDMUVICORE_Title_Player5',
			'idmuvi-core-player6-value'          => 'IDMUVICORE_Player6',
			'idmuvi-core-title-player6-value'    => 'IDMUVICORE_Title_Player6',
			'idmuvi-core-player7-value'          => 'IDMUVICORE_Player7',
			'idmuvi-core-title-player7-value'    => 'IDMUVICORE_Title_Player7',
			'idmuvi-core-player8-value'          => 'IDMUVICORE_Player8',
			'idmuvi-core-title-player8-value'    => 'IDMUVICORE_Title_Player8',
			'idmuvi-core-player9-value'          => 'IDMUVICORE_Player9',
			'idmuvi-core-title-player9-value'    => 'IDMUVICORE_Title_Player9',
			'idmuvi-core-player10-value'         => 'IDMUVICORE_Player10',
			'idmuvi-core-title-player10-value'   => 'IDMUVICORE_Title_Player10',
			'idmuvi-core-player11-value'         => 'IDMUVICORE_Player11',
			'idmuvi-core-title-player11-value'   => 'IDMUVICORE_Title_Player11',
			'idmuvi-core-player12-value'         => 'IDMUVICORE_Player12',
			'idmuvi-core-title-player12-value'   => 'IDMUVICORE_Title_Player12',
			'idmuvi-core-player13-value'         => 'IDMUVICORE_Player13',
			'idmuvi-core-title-player13-value'   => 'IDMUVICORE_Title_Player13',
			'idmuvi-core-player14-value'         => 'IDMUVICORE_Player14',
			'idmuvi-core-title-player14-value'   => 'IDMUVICORE_Title_Player14',
			'idmuvi-core-player15-value'         => 'IDMUVICORE_Player15',
			'idmuvi-core-title-player15-value'   => 'IDMUVICORE_Title_Player15',
			'idmuvi-core-download1-value'        => 'IDMUVICORE_Download1',
			'idmuvi-core-title-download1-value'  => 'IDMUVICORE_Title_Download1',
			'idmuvi-core-download2-value'        => 'IDMUVICORE_Download2',
			'idmuvi-core-title-download2-value'  => 'IDMUVICORE_Title_Download2',
			'idmuvi-core-download3-value'        => 'IDMUVICORE_Download3',
			'idmuvi-core-title-download3-value'  => 'IDMUVICORE_Title_Download3',
			'idmuvi-core-download4-value'        => 'IDMUVICORE_Download4',
			'idmuvi-core-title-download4-value'  => 'IDMUVICORE_Title_Download4',
			'idmuvi-core-download5-value'        => 'IDMUVICORE_Download5',
			'idmuvi-core-title-download5-value'  => 'IDMUVICORE_Title_Download5',
			'idmuvi-core-download6-value'        => 'IDMUVICORE_Download6',
			'idmuvi-core-title-download6-value'  => 'IDMUVICORE_Title_Download6',
			'idmuvi-core-download7-value'        => 'IDMUVICORE_Download7',
			'idmuvi-core-title-download7-value'  => 'IDMUVICORE_Title_Download7',
			'idmuvi-core-download8-value'        => 'IDMUVICORE_Download8',
			'idmuvi-core-title-download8-value'  => 'IDMUVICORE_Title_Download8',
			'idmuvi-core-download9-value'        => 'IDMUVICORE_Download9',
			'idmuvi-core-title-download9-value'  => 'IDMUVICORE_Title_Download9',
			'idmuvi-core-download10-value'       => 'IDMUVICORE_Download10',
			'idmuvi-core-title-download10-value' => 'IDMUVICORE_Title_Download10',
			'idmuvi-core-download11-value'       => 'IDMUVICORE_Download11',
			'idmuvi-core-title-download11-value' => 'IDMUVICORE_Title_Download11',
			'idmuvi-core-download12-value'       => 'IDMUVICORE_Download12',
			'idmuvi-core-title-download12-value' => 'IDMUVICORE_Title_Download12',
			'idmuvi-core-download13-value'       => 'IDMUVICORE_Download13',
			'idmuvi-core-title-download13-value' => 'IDMUVICORE_Title_Download13',
			'idmuvi-core-download14-value'       => 'IDMUVICORE_Download14',
			'idmuvi-core-title-download14-value' => 'IDMUVICORE_Title_Download14',
			'idmuvi-core-download15-value'       => 'IDMUVICORE_Download15',
			'idmuvi-core-title-download15-value' => 'IDMUVICORE_Title_Download15',
		);

		foreach ( $fields as $name => $meta_key ) {
			/* Check if meta box fields has a proper value */
			if ( isset( $_POST[ $name ] ) && 'N/A' !== $_POST[ $name ] ) {
				/* Set thumbnail */
				if ( 'idmuvi-core-poster-value' === $name ) {
					global $wpdb;
					$image_src     = $_POST[ $name ];
					$query         = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
					$attachment_id = $wpdb->get_var( $query );
					set_post_thumbnail( $post_id, $attachment_id );
				}
				$new_meta_value = $_POST[ $name ];
			} else {
				$new_meta_value = '';
			}

			/* Get the meta value of the custom field key */
			$meta_value = get_post_meta( $post_id, $meta_key, true );

			if ( ! empty( $new_meta_value ) ) {
				update_post_meta( $post_id, $meta_key, $new_meta_value );
			} else {
				/*
				 * Do you really expect to have multiple meta keys named exactly the same ('city_id')?
				 * If you don't, you can skip the third parameter from 'delete_post_meta'.
				 */
				delete_post_meta( $post_id, $meta_key );
			}
		}
	}

	/**
	 * Meta box html view
	 *
	 * @param array  $object Object Post Type.
	 * @param string $box returning string.
	 */
	public function metabox_callback( $object, $box ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( basename( __FILE__ ), 'idmuvi_core_episode_meta_nonce' );

		$idmuv_tmdb = get_option( 'idmuv_tmdb' );

		if ( isset( $idmuv_tmdb['enable_tmdb_api'] ) && ! empty( $idmuv_tmdb['enable_tmdb_api'] ) ) {
			// option, section, default.
			$enable_tmdb_opsi = $idmuv_tmdb['enable_tmdb_api'];
		} else {
			$enable_tmdb_opsi = 'off';
		}
		?>
		<div id="col-container">
			<div class="metabox-holder idmuvi-core-metabox-common-fields">

				<h3 class="nav-tab-wrapper">
					<span class="nav-tab tab-link" id="tab-1"><?php esc_html_e( 'Episode Settings:', 'idmuvi-core' ); ?></span>
					<span class="nav-tab tab-link" id="tab-2"><?php esc_html_e( 'Player Settings:', 'idmuvi-core' ); ?></span>
					<span class="nav-tab tab-link" id="tab-3"><?php esc_html_e( 'Download Settings:', 'idmuvi-core' ); ?></span>
				</h3>

				<div id="tab-1C" class="group tab-content">

					<?php
					if ( 'on' === $enable_tmdb_opsi ) {
						$status = trim( get_option( 'newidmuvi_core_license_status' . md5( home_url() ) ) );

						if ( ! empty( $status ) && 'ok' === $status ) {
							?>
					<p>
						<label for="idmuvi-core-id"><strong><?php esc_html_e( 'Enter TMDB ID:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" style="max-width:80px" value="" placeholder="30991" class="regular-text" name="tmdbID" id="idmuvi-core-id" /> -
						<input type="text" style="max-width:80px" value="" placeholder="1" class="regular-text" name="tmdbID_Session" id="idmuvi-core-id-session" /> -
						<input type="text" style="max-width:80px" value="" placeholder="25" class="regular-text" name="tmdbID_Eps" id="idmuvi-core-id-episode" />
						<input class="button button-primary display-block" type="button" name="idmuvi-ret-gmr-button" id="idmuvi-core-id-submit" value="<?php esc_attr_e( 'Retrieve Information', 'idmuvi-core' ); ?>" />
						<span class="howto"><?php echo __( 'Please insert id tmdb for episode.<br/>Example link from tmdb https://www.themoviedb.org/tv/<strong>30991</strong>/season/<strong>1</strong>/episode/<strong>25</strong> (Just insert with <strong>30991</strong> - <strong>1</strong> - <strong>25</strong>).', 'idmuvi-core' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</p>
							<?php
						}
					}
					?>

					<p>
						<label for="opsi-serie"><strong><?php esc_html_e( 'Serie Name (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-serie" name="idmuvi-core-serie-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Serie', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with original tv show/ serie name', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-title"><strong><?php esc_html_e( 'Episode Name (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title" name="idmuvi-core-title-episode-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Episode', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with original episode name', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-airdate"><strong><?php esc_html_e( 'Air Date (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-airdate" name="idmuvi-core-released-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Released', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with air date this episode', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-number"><strong><?php esc_html_e( 'Episode Number (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-number" name="idmuvi-core-episodenumber-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Episodenumber', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with number of this episode', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-sesnumber"><strong><?php esc_html_e( 'Season Number (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-sesnumber" name="idmuvi-core-sessionnumber-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Sessionnumber', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Season number this episode', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-rating"><strong><?php esc_html_e( 'TMDB Rating:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" style="max-width:80px" class="regular-text" id="opsi-rating" name="idmuvi-core-tmdbrating-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_tmdbRating', true ) ); ?>" /> /
						<input type="text" style="max-width:120px" class="regular-text" id="opsi-votes" name="idmuvi-core-tmdbvotes-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_tmdbVotes', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with TMDB rating (Average/Votes)', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-trailer"><strong><?php esc_html_e( 'Youtube ID For Trailer (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" name="idmuvi-core-trailer-value" id="opsi-trailer" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Trailer', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with youtube id for this episode trailer. Example: https://www.youtube.com/watch?v=YROTBt1sae8 just fill with YROTBt1sae8', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-imageposter"><strong><?php esc_html_e( 'Poster Url (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block muvipro-metaposer-url" name="idmuvi-core-poster-value" id="opsi-imageposter" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Poster', true ) ); ?>" />
						<input style="margin-top: 10px;" class="button button-primary muvipro-metaposer-browse" type="button" value="<?php esc_attr_e( 'Upload', 'idmuvi-core' ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Please upload image for episode poster. Please using internal image only', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-tmdbid"><strong><?php esc_html_e( 'tmdbID:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" style="max-width:120px" class="regular-text display-block" id="opsi-tmdbid" name="idmuvi-core-tmdbid-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_tmdbID', true ) ); ?>" />
						<span class="howto"><?php echo __( 'Example link from tmdb https://www.themoviedb.org/tv/<strong>30991</strong>/season/1/episode/25 (Just insert with <strong>30991</strong>.', 'idmuvi-core' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</p>

				</div>
				<div id="tab-2C" class="group tab-content">
					<p id="muvi-notif" class="muvi-notif">
						<label for="muvi-notif"><strong><?php esc_html_e( 'Player Notification', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-notif-value" id="muvi-notif" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Notif', true ) ); ?></textarea>
						<span class="howto"><?php esc_attr_e( 'Add notification before player', 'idmuvi-core' ); ?></span>
					</p>
					<ul class="subsubsub nav-tab-wrapper">
						<li class="nav-tab tab-link" id="tabserver-1"><?php esc_html_e( 'Server 1', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-2"><?php esc_html_e( 'Server 2', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-3"><?php esc_html_e( 'Server 3', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-4"><?php esc_html_e( 'Server 4', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-5"><?php esc_html_e( 'Server 5', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-6"><?php esc_html_e( 'Server 6', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-7"><?php esc_html_e( 'Server 7', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-8"><?php esc_html_e( 'Server 8', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-9"><?php esc_html_e( 'Server 9', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-10"><?php esc_html_e( 'Server 10', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-11"><?php esc_html_e( 'Server 11', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-12"><?php esc_html_e( 'Server 12', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-13"><?php esc_html_e( 'Server 13', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-14"><?php esc_html_e( 'Server 14', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabserver-15"><?php esc_html_e( 'Server 15', 'idmuvi-core' ); ?></li>
					</ul>
					<div class="clear"></div>
					<p id="tabserver-1C" class="innergroup tab-content-inner">
						<label for="opsi-title-player1"><strong><?php esc_html_e( 'Title tab 1:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player1" name="idmuvi-core-title-player1-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player1', true ) ); ?>" />
						<br />
						<label for="opsi-player1"><strong><?php esc_html_e( 'Embed Code 1:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player1-value" id="opsi-player1" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player1', true ) ); ?></textarea>
					</p>
					<p id="tabserver-2C" class="innergroup tab-content-inner">
						<label for="opsi-title-player2"><strong><?php esc_html_e( 'Title tab 2:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player2" name="idmuvi-core-title-player2-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player2', true ) ); ?>" />
						<br />
						<label for="opsi-player2"><strong><?php esc_html_e( 'Embed Code 2:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player2-value" id="opsi-player2" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player2', true ) ); ?></textarea>
					</p>
					<p id="tabserver-3C" class="innergroup tab-content-inner">
						<label for="opsi-title-player3"><strong><?php esc_html_e( 'Title tab 3:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player3" name="idmuvi-core-title-player3-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player3', true ) ); ?>" />
						<br />
						<label for="opsi-player3"><strong><?php esc_html_e( 'Embed Code 3:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player3-value" id="opsi-player3" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player3', true ) ); ?></textarea>
					</p>
					<p id="tabserver-4C" class="innergroup tab-content-inner">
						<label for="opsi-title-player4"><strong><?php esc_html_e( 'Title tab 4:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player4" name="idmuvi-core-title-player4-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player4', true ) ); ?>" />
						<br />
						<label for="opsi-player4"><strong><?php esc_html_e( 'Embed Code 4:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player4-value" id="opsi-player4" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player4', true ) ); ?></textarea>
					</p>
					<p id="tabserver-5C" class="innergroup tab-content-inner">
						<label for="opsi-title-player5"><strong><?php esc_html_e( 'Title tab 5:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player5" name="idmuvi-core-title-player5-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player5', true ) ); ?>" />
						<br />
						<label for="opsi-player5"><strong><?php esc_html_e( 'Embed Code 5:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player5-value" id="opsi-player5" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player5', true ) ); ?></textarea>
					</p>
					<p id="tabserver-6C" class="innergroup tab-content-inner">
						<label for="opsi-title-player6"><strong><?php esc_html_e( 'Title tab 6:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player6" name="idmuvi-core-title-player6-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player6', true ) ); ?>" />
						<br />
						<label for="opsi-player6"><strong><?php esc_html_e( 'Embed Code 6:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player6-value" id="opsi-player6" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player6', true ) ); ?></textarea>
					</p>
					<p id="tabserver-7C" class="innergroup tab-content-inner">
						<label for="opsi-title-player7"><strong><?php esc_html_e( 'Title tab 7:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player7" name="idmuvi-core-title-player7-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player7', true ) ); ?>" />
						<br />
						<label for="opsi-player7"><strong><?php esc_html_e( 'Embed Code 7:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player7-value" id="opsi-player7" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player7', true ) ); ?></textarea>
					</p>
					<p id="tabserver-8C" class="innergroup tab-content-inner">
						<label for="opsi-title-player8"><strong><?php esc_html_e( 'Title tab 8:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player8" name="idmuvi-core-title-player8-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player8', true ) ); ?>" />
						<br />
						<label for="opsi-player8"><strong><?php esc_html_e( 'Embed Code 8:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player8-value" id="opsi-player8" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player8', true ) ); ?></textarea>
					</p>
					<p id="tabserver-9C" class="innergroup tab-content-inner">
						<label for="opsi-title-player9"><strong><?php esc_html_e( 'Title tab 9:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player9" name="idmuvi-core-title-player9-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player9', true ) ); ?>" />
						<br />
						<label for="opsi-player9"><strong><?php esc_html_e( 'Embed Code 9:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player9-value" id="opsi-player9" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player9', true ) ); ?></textarea>
					</p>
					<p id="tabserver-10C" class="innergroup tab-content-inner">
						<label for="opsi-title-player10"><strong><?php esc_html_e( 'Title tab 10:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player10" name="idmuvi-core-title-player10-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player10', true ) ); ?>" />
						<br />
						<label for="opsi-player10"><strong><?php esc_html_e( 'Embed Code 10:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player10-value" id="opsi-player10" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player10', true ) ); ?></textarea>
					</p>
					<p id="tabserver-11C" class="innergroup tab-content-inner">
						<label for="opsi-title-player11"><strong><?php esc_html_e( 'Title tab 11:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player11" name="idmuvi-core-title-player11-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player11', true ) ); ?>" />
						<br />
						<label for="opsi-player11"><strong><?php esc_html_e( 'Embed Code 11:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player11-value" id="opsi-player11" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player11', true ) ); ?></textarea>
					</p>
					<p id="tabserver-12C" class="innergroup tab-content-inner">
						<label for="opsi-title-player12"><strong><?php esc_html_e( 'Title tab 12:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player12" name="idmuvi-core-title-player12-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player12', true ) ); ?>" />
						<br />
						<label for="opsi-player12"><strong><?php esc_html_e( 'Embed Code 12:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player12-value" id="opsi-player12" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player12', true ) ); ?></textarea>
					</p>
					<p id="tabserver-13C" class="innergroup tab-content-inner">
						<label for="opsi-title-player13"><strong><?php esc_html_e( 'Title tab 13:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player13" name="idmuvi-core-title-player13-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player13', true ) ); ?>" />
						<br />
						<label for="opsi-player13"><strong><?php esc_html_e( 'Embed Code 13:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player13-value" id="opsi-player13" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player13', true ) ); ?></textarea>
					</p>
					<p id="tabserver-14C" class="innergroup tab-content-inner">
						<label for="opsi-title-player14"><strong><?php esc_html_e( 'Title tab 14:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player14" name="idmuvi-core-title-player14-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player14', true ) ); ?>" />
						<br />
						<label for="opsi-player14"><strong><?php esc_html_e( 'Embed Code 14:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player14-value" id="opsi-player14" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player14', true ) ); ?></textarea>
					</p>
					<p id="tabserver-15C" class="innergroup tab-content-inner">
						<label for="opsi-title-player15"><strong><?php esc_html_e( 'Title tab 15:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-player15" name="idmuvi-core-title-player15-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Player15', true ) ); ?>" />
						<br />
						<label for="opsi-player15"><strong><?php esc_html_e( 'Embed Code 15:', 'idmuvi-core' ); ?></strong></label>
						<textarea name="idmuvi-core-player15-value" id="opsi-player15" rows="4" cols="55" class="regular-text display-block"><?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Player15', true ) ); ?></textarea>
					</p>
				</div>
				<div id="tab-3C" class="group tab-content">
					<ul class="subsubsub nav-tab-wrapperdl">
						<li class="nav-tab tab-link" id="tabdl-1"><?php esc_html_e( 'Download 1', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-2"><?php esc_html_e( 'Download 2', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-3"><?php esc_html_e( 'Download 3', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-4"><?php esc_html_e( 'Download 4', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-5"><?php esc_html_e( 'Download 5', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-6"><?php esc_html_e( 'Download 6', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-7"><?php esc_html_e( 'Download 7', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-8"><?php esc_html_e( 'Download 8', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-9"><?php esc_html_e( 'Download 9', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-10"><?php esc_html_e( 'Download 10', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-11"><?php esc_html_e( 'Download 11', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-12"><?php esc_html_e( 'Download 12', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-13"><?php esc_html_e( 'Download 13', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-14"><?php esc_html_e( 'Download 14', 'idmuvi-core' ); ?></li>
						<li class="nav-tab tab-link" id="tabdl-15"><?php esc_html_e( 'Download 15', 'idmuvi-core' ); ?></li>
					</ul>
					<div class="clear"></div>
					<p id="tabdl-1C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download1"><strong><?php esc_html_e( 'Title Download 1:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download1" name="idmuvi-core-title-download1-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download1', true ) ); ?>" />
						<br />
						<label for="opsi-download1"><strong><?php esc_html_e( 'URL Download 1:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download1" name="idmuvi-core-download1-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download1', true ) ); ?>" />
					</p>
					<p id="tabdl-2C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download2"><strong><?php esc_html_e( 'Title Download 2:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download2" name="idmuvi-core-title-download2-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download2', true ) ); ?>" />
						<br />
						<label for="opsi-download2"><strong><?php esc_html_e( 'URL Download 2:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download2" name="idmuvi-core-download2-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download2', true ) ); ?>" />
					</p>
					<p id="tabdl-3C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download3"><strong><?php esc_html_e( 'Title Download 3:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download3" name="idmuvi-core-title-download3-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download3', true ) ); ?>" />
						<br />
						<label for="opsi-download3"><strong><?php esc_html_e( 'URL Download 3:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download3" name="idmuvi-core-download3-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download3', true ) ); ?>" />
					</p>
					<p id="tabdl-4C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download4"><strong><?php esc_html_e( 'Title Download 4:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download4" name="idmuvi-core-title-download4-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download4', true ) ); ?>" />
						<br />
						<label for="opsi-download4"><strong><?php esc_html_e( 'URL Download 4:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download4" name="idmuvi-core-download4-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download4', true ) ); ?>" />
					</p>
					<p id="tabdl-5C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download5"><strong><?php esc_html_e( 'Title Download 5:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download5" name="idmuvi-core-title-download5-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download5', true ) ); ?>" />
						<br />
						<label for="opsi-download5"><strong><?php esc_html_e( 'URL Download 5:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download5" name="idmuvi-core-download5-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download5', true ) ); ?>" />
					</p>
					<p id="tabdl-6C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download6"><strong><?php esc_html_e( 'Title Download 6:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download6" name="idmuvi-core-title-download6-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download6', true ) ); ?>" />
						<br />
						<label for="opsi-download6"><strong><?php esc_html_e( 'URL Download 6:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download6" name="idmuvi-core-download6-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download6', true ) ); ?>" />
					</p>
					<p id="tabdl-7C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download7"><strong><?php esc_html_e( 'Title Download 7:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download7" name="idmuvi-core-title-download7-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download7', true ) ); ?>" />
						<br />
						<label for="opsi-download7"><strong><?php esc_html_e( 'URL Download 7:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download7" name="idmuvi-core-download7-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download7', true ) ); ?>" />
					</p>
					<p id="tabdl-8C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download8"><strong><?php esc_html_e( 'Title Download 8:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download8" name="idmuvi-core-title-download8-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download8', true ) ); ?>" />
						<br />
						<label for="opsi-download8"><strong><?php esc_html_e( 'URL Download 8:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download8" name="idmuvi-core-download8-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download8', true ) ); ?>" />
					</p>
					<p id="tabdl-9C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download9"><strong><?php esc_html_e( 'Title Download 9:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download9" name="idmuvi-core-title-download9-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download9', true ) ); ?>" />
						<br />
						<label for="opsi-download9"><strong><?php esc_html_e( 'URL Download 9:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download9" name="idmuvi-core-download9-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download9', true ) ); ?>" />
					</p>
					<p id="tabdl-10C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download10"><strong><?php esc_html_e( 'Title Download 10:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download10" name="idmuvi-core-title-download10-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download10', true ) ); ?>" />
						<br />
						<label for="opsi-download10"><strong><?php esc_html_e( 'URL Download 10:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download10" name="idmuvi-core-download10-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download10', true ) ); ?>" />
					</p>
					<p id="tabdl-11C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download11"><strong><?php esc_html_e( 'Title Download 11:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download11" name="idmuvi-core-title-download11-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download11', true ) ); ?>" />
						<br />
						<label for="opsi-download11"><strong><?php esc_html_e( 'URL Download 11:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download11" name="idmuvi-core-download11-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download11', true ) ); ?>" />
					</p>
					<p id="tabdl-12C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download12"><strong><?php esc_html_e( 'Title Download 12:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download12" name="idmuvi-core-title-download12-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download12', true ) ); ?>" />
						<br />
						<label for="opsi-download12"><strong><?php esc_html_e( 'URL Download 12:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download12" name="idmuvi-core-download12-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download12', true ) ); ?>" />
					</p>
					<p id="tabdl-13C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download13"><strong><?php esc_html_e( 'Title Download 13:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download13" name="idmuvi-core-title-download13-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download13', true ) ); ?>" />
						<br />
						<label for="opsi-download13"><strong><?php esc_html_e( 'URL Download 13:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download13" name="idmuvi-core-download13-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download13', true ) ); ?>" />
					</p>
					<p id="tabdl-14C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download14"><strong><?php esc_html_e( 'Title Download 14:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download14" name="idmuvi-core-title-download14-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download14', true ) ); ?>" />
						<br />
						<label for="opsi-download14"><strong><?php esc_html_e( 'URL Download 14:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download14" name="idmuvi-core-download14-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download14', true ) ); ?>" />
					</p>
					<p id="tabdl-15C" class="innergroup tab-content-innerdl">
						<label for="opsi-title-download15"><strong><?php esc_html_e( 'Title Download 15:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title-download15" name="idmuvi-core-title-download15-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title_Download15', true ) ); ?>" />
						<br />
						<label for="opsi-download15"><strong><?php esc_html_e( 'URL Download 15:', 'idmuvi-core' ); ?></strong></label>
						<input type="url" class="regular-text display-block" placeholder="http://" id="opsi-download15" name="idmuvi-core-download15-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Download15', true ) ); ?>" />
					</p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Uploading poster via url and save it as thumbnail.
	 */
	public function save_poster() {

		isset( $_REQUEST['poster_url'] ) ? $poster_url = $_REQUEST['poster_url'] : $poster_url = null;
		global $wpdb;
		$wp_upload_dir = wp_upload_dir();

		if ( $poster_url !== null ) {
			// let's assume that poster already exist (uploaded once before).
			$file_name = rtrim( basename( $poster_url ), '.jpg' );
			// Searching.
			$query = "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_title='$file_name'";
			$count = $wpdb->get_var( $query );

			if ( $count == 0 ) {
				/*
				* so poster wasn’t uploaded before.
				*/
				$tmp = download_url( $poster_url );

				$file_array = array(
					'name'     => basename( $poster_url ),
					'tmp_name' => $tmp,
				);

				// Check for download errors.
				if ( is_wp_error( $tmp ) ) {
					@chown( $file_array['tmp_name'], 465 );
					@unlink( $file_array['tmp_name'] );
					echo esc_html__( 'Something went wrong while downloading this file.', 'idmuvi-core' );
					die();
				}

				$id = media_handle_sideload( $file_array, 0 );

				// Check for handle sideload errors.
				if ( is_wp_error( $id ) ) {
					@chown( $file_array['tmp_name'], 465 );
					@unlink( $file_array['tmp_name'] );
					echo esc_html__( 'something went wrong. movie/xxx.php:665', 'idmuvi-core' );
					die();
				}
				$attachment_url = wp_get_attachment_url( $id );
				echo esc_url( $attachment_url );

				die();
			} else {
				$query = "SELECT guid FROM {$wpdb->posts} WHERE post_title='$file_name'";
				$poster_path = $wpdb->get_var( $query );
				echo esc_url( $poster_path );
				die();
			}
		}

	}

}

// Load only if dashboard.
if ( is_admin() ) {
	new Idmuvi_Core_Metabox_Settings_TvShow_Episode();
}
