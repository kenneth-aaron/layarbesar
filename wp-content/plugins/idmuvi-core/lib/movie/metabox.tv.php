<?php
/**
 * Add Simple Metaboxes Settings
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
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
class Idmuvi_Core_Metabox_Settings_TvShow {

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
	public function post_metabox_setup(){
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	/**
	 * Register the JavaScript.
	 */
	public function idmuvi_admin_enqueue_scripts() {
		global $post_type;
		if ( 'tv' === $post_type ) {

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
							var languange = "&language=<?php echo esc_html( $language ); ?>&include_image_language=<?php echo esc_html( $language ); ?>,null";
							var apikey = "&api_key=<?php echo esc_html( $apikey ); ?>";
							var target = document.URL;
							var isoCountries = {'AF':'Afghanistan','AX':'Aland Islands','AL':'Albania','DZ':'Algeria','AS':'American Samoa','AD':'Andorra','AO':'Angola','AI':'Anguilla','AQ':'Antarctica','AG':'Antigua And Barbuda','AR':'Argentina','AM':'Armenia','AW':'Aruba','AU':'Australia','AT':'Austria','AZ':'Azerbaijan','BS':'Bahamas','BH':'Bahrain','BD':'Bangladesh','BB':'Barbados','BY':'Belarus','BE':'Belgium','BZ':'Belize','BJ':'Benin','BM':'Bermuda','BT':'Bhutan','BO':'Bolivia','BA':'Bosnia And Herzegovina','BW':'Botswana','BV':'Bouvet Island','BR':'Brazil','IO':'British Indian Ocean Territory','BN':'Brunei Darussalam','BG':'Bulgaria','BF':'Burkina Faso','BI':'Burundi','KH':'Cambodia','CM':'Cameroon','CA':'Canada','CV':'Cape Verde','KY':'Cayman Islands','CF':'Central African Republic','TD':'Chad','CL':'Chile','CN':'China','CX':'Christmas Island','CC':'Cocos (Keeling) Islands','CO':'Colombia','KM':'Comoros','CG':'Congo','CD':'Congo, Democratic Republic','CK':'Cook Islands','CR':'Costa Rica','CI':'Cote D\'Ivoire','HR':'Croatia','CU':'Cuba','CY':'Cyprus','CZ':'Czech Republic','DK':'Denmark','DJ':'Djibouti','DM':'Dominica','DO':'Dominican Republic','EC':'Ecuador','EG':'Egypt','SV':'El Salvador','GQ':'Equatorial Guinea','ER':'Eritrea','EE':'Estonia','ET':'Ethiopia','FK':'Falkland Islands (Malvinas)','FO':'Faroe Islands','FJ':'Fiji','FI':'Finland','FR':'France','GF':'French Guiana','PF':'French Polynesia','TF':'French Southern Territories','GA':'Gabon','GM':'Gambia','GE':'Georgia','DE':'Germany','GH':'Ghana','GI':'Gibraltar','GR':'Greece','GL':'Greenland','GD':'Grenada','GP':'Guadeloupe','GU':'Guam','GT':'Guatemala','GG':'Guernsey','GN':'Guinea','GW':'Guinea-Bissau','GY':'Guyana','HT':'Haiti','HM':'Heard Island & Mcdonald Islands','VA':'Holy See (Vatican City State)','HN':'Honduras','HK':'Hong Kong','HU':'Hungary','IS':'Iceland','IN':'India','ID':'Indonesia','IR':'Iran, Islamic Republic Of','IQ':'Iraq','IE':'Ireland','IM':'Isle Of Man','IL':'Israel','IT':'Italy','JM':'Jamaica','JP':'Japan','JE':'Jersey','JO':'Jordan','KZ':'Kazakhstan','KE':'Kenya','KI':'Kiribati','KR':'Korea','KW':'Kuwait','KG':'Kyrgyzstan','LA':'Lao People\'s Democratic Republic','LV':'Latvia','LB':'Lebanon','LS':'Lesotho','LR':'Liberia','LY':'Libyan Arab Jamahiriya','LI':'Liechtenstein','LT':'Lithuania','LU':'Luxembourg','MO':'Macao','MK':'Macedonia','MG':'Madagascar','MW':'Malawi','MY':'Malaysia','MV':'Maldives','ML':'Mali','MT':'Malta','MH':'Marshall Islands','MQ':'Martinique','MR':'Mauritania','MU':'Mauritius','YT':'Mayotte','MX':'Mexico','FM':'Micronesia, Federated States Of','MD':'Moldova','MC':'Monaco','MN':'Mongolia','ME':'Montenegro','MS':'Montserrat','MA':'Morocco','MZ':'Mozambique','MM':'Myanmar','NA':'Namibia','NR':'Nauru','NP':'Nepal','NL':'Netherlands','AN':'Netherlands Antilles','NC':'New Caledonia','NZ':'New Zealand','NI':'Nicaragua','NE':'Niger','NG':'Nigeria','NU':'Niue','NF':'Norfolk Island','MP':'Northern Mariana Islands','NO':'Norway','OM':'Oman','PK':'Pakistan','PW':'Palau','PS':'Palestinian Territory, Occupied','PA':'Panama','PG':'Papua New Guinea','PY':'Paraguay','PE':'Peru','PH':'Philippines','PN':'Pitcairn','PL':'Poland','PT':'Portugal','PR':'Puerto Rico','QA':'Qatar','RE':'Reunion','RO':'Romania','RU':'Russian Federation','RW':'Rwanda','BL':'Saint Barthelemy','SH':'Saint Helena','KN':'Saint Kitts And Nevis','LC':'Saint Lucia','MF':'Saint Martin','PM':'Saint Pierre And Miquelon','VC':'Saint Vincent And Grenadines','WS':'Samoa','SM':'San Marino','ST':'Sao Tome And Principe','SA':'Saudi Arabia','SN':'Senegal','RS':'Serbia','SC':'Seychelles','SL':'Sierra Leone','SG':'Singapore','SK':'Slovakia','SI':'Slovenia','SB':'Solomon Islands','SO':'Somalia','ZA':'South Africa','GS':'South Georgia And Sandwich Isl.','ES':'Spain','LK':'Sri Lanka','SD':'Sudan','SR':'Suriname','SJ':'Svalbard And Jan Mayen','SZ':'Swaziland','SE':'Sweden','CH':'Switzerland','SY':'Syrian Arab Republic','TW':'Taiwan','TJ':'Tajikistan','TZ':'Tanzania','TH':'Thailand','TL':'Timor-Leste','TG':'Togo','TK':'Tokelau','TO':'Tonga','TT':'Trinidad And Tobago','TN':'Tunisia','TR':'Turkey','TM':'Turkmenistan','TC':'Turks And Caicos Islands','TV':'Tuvalu','UG':'Uganda','UA':'Ukraine','AE':'United Arab Emirates','GB':'United Kingdom','US':'USA','UM':'United States Outlying Islands','UY':'Uruguay','UZ':'Uzbekistan','VU':'Vanuatu','VE':'Venezuela','VN':'Viet Nam','VG':'Virgin Islands, British','VI':'Virgin Islands, U.S.','WF':'Wallis And Futuna','EH':'Western Sahara','YE':'Yemen','ZM':'Zambia','ZW':'Zimbabwe'}

							// Request Using getJSON
							$.getJSON( "https://api.themoviedb.org/3/tv/" + valTMDBid + "?append_to_response=videos,keywords,images,credits" + languange + apikey, function(json) {
								$.each(json, function(key, val) {
									/* Title */
									var valTitle = "";
									if(key == "name"){
										valTitle+= ""+val+"";
										$('input[name=idmuvi-core-title-value]').val(valTitle);
										$("input[name=post_title]").val(valTitle);
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

									/* Runtime */
									var valRunTime = "";
									if(key == "episode_run_time"){
										// Remove min value
										valRunTime+= ""+val+"";
										$('input[name=idmuvi-core-runtime-value]').val(valRunTime);
									}

									/* Runtime */
									var valNumEpisode = "";
									if(key == "number_of_episodes"){
										valNumEpisode+= ""+val+"";
										$('input[name=idmuvi-core-numberepisode-value]').val(valNumEpisode);
									}

									/* Date Release and Year Release */
									var valRelease = "";
									var valYear = "";
									if(key == "first_air_date"){
										var m_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
										var d = new Date(val);
										var curr_date = d.getDate();
										var curr_month = d.getMonth();
										var curr_year = d.getFullYear();
										// Remove min value
										valRelease+= curr_date + " " + m_names[curr_month] + " " + curr_year;
										// Add Only Year
										valYear+= curr_year;
										$('input[name=idmuvi-core-released-value]').val(valRelease);
										$('input[id=new-tag-muviyear]').val(valYear);
										$('input[name=idmuvi-core-year-value]').val(valYear);
									}

									var valLastiar = "";
									if(key == "last_air_date"){
										var m_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
										var d = new Date(val);
										var curr_date = d.getDate();
										var curr_month = d.getMonth();
										var curr_year = d.getFullYear();
										// Remove min value
										valLastiar+= curr_date + " " + m_names[curr_month] + " " + curr_year;
										// Add Only Year
										valYear+= curr_year;
										$('input[name=idmuvi-core-last-air-value]').val(valLastiar);
									}

									/* Genres since wp v 4.8 this function change with tag. and add new jquery function, see below
									var valGenr = "";
									var valGenr1 = "";
									if(key == "genres"){
										$.each( json.genres, function( i, item ) {
											valGenr += "" + item.name + ", ";
											valGenr1 = item.name;
											$('input[name=newcategory]').val( valGenr1 );
											$('#category-add-submit').trigger('click');
											$('#category-add-submit').prop("disabled", false);
											$('input[name=newcategory]').val("");
										});
									} */

									var valGenr = "";
									if(key == "genres"){
										$.each( json.genres, function( i, item ) {
											valGenr = item.name;
											$('a#category-add-toggle').click();
											$('input[name=newcategory]').val( valGenr );
											$('#category-add-submit').trigger('click');
											$('#category-add-submit').prop("disabled", false);
											$('input[name=newcategory]').val("");

										});
									}

									/* Keyword */
									var valKeyw = "";
									if(key == "keywords"){
										$.each(json.keywords.results, function(i, item) {
											// add commas separator
											valKeyw += "" + item.name + ", ";
											return i<0;
										});
										$('input[id=new-tag-post_tag]').val( valKeyw );
									}

									/* Country */
									var valCountry = "";
									if(key == "origin_country"){
										$.each(json.origin_country, function(i, item) {
											if (isoCountries.hasOwnProperty(item)) {
												// add commas separator using country name
												valCountry += "" + isoCountries[item] + ", ";
											} else {
												// add commas separator
												valCountry += "" + item + ", ";
											}
										});
										$('input[id=new-tag-muvicountry]').val( valCountry );
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

									/* Director */
									var valDirector = "";
									if(key == "created_by"){
										$.each(json.created_by, function(i, item) {
											valDirector += "" + item.name + ", ";
											return i<0;
										});
										$('input[id=new-tag-muvidirector]').val( valDirector );
									}

									/* Network */
									var valNetwork = "";
									if(key == "networks"){
										$.each(json.networks, function(i, item) {
											valNetwork += "" + item.name + ", ";
											return i<2;
										});
										$('input[id=new-tag-muvinetwork]').val( valNetwork );
									}

									/* Trailer and only one video */
									var valVidTrailer = "";
									if(key == "videos"){
										$.each(json.videos.results, function(i, item) {
											// get index only first object json
											if( i == 0 ) {
												// add commas separator
												valVidTrailer += "" + item.key + "";
											}
										});
										$("input[name=idmuvi-core-trailer-value]").val( valVidTrailer );
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
									if(key == "poster_path"){
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

									/* TMDB ID */
									var valTmdbID = "";
									if(key == "id"){
										// Remove min value
										valTmdbID+= ""+val+"";
										$('input[name=idmuvi-core-tmdbid-value]').val(valTmdbID);
									}
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
		if ( 'tv' === $post_type ) {
			?>
			<style type="text/css">
			body.post-new-php #titlediv #title-prompt-text {display: none !important;}
			.idmuvi-core-metabox-common-fields p {margin-bottom: 20px;}
			.idmuvi-core-metabox-common-fields input.display-block,
			.idmuvi-core-metabox-common-fields textarea.display-block{display:block;width:100%;}
			.idmuvi-core-metabox-common-fields input[type="button"].display-block {margin-top:10px;}
			.idmuvi-core-metabox-common-fields label {display: block;margin-bottom: 5px;}
			.idmuvi-core-metabox-common-fields input[disabled] {background: #ddd;}
			.idmuvi-core-metabox-common-fields .nav-tab-active,
			.idmuvi-core-metabox-common-fields .nav-tab-active:focus,
			.idmuvi-core-metabox-common-fields .nav-tab-active:focus:active,
			.idmuvi-core-metabox-common-fields .nav-tab-active:hover {
				border-bottom: 1px solid #ffffff !important;
				background: #ffffff !important;
				color: #000;
			}
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
		$post_types = array( 'tv' );
		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box(
				'idmuvi_core_movie_meta_metabox',
				__( 'Find TV Shows', 'idmuvi-core' ),
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
		if ( ! isset( $_POST['idmuvi_core_tv_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['idmuvi_core_tv_meta_nonce'] ) ), basename( __FILE__ ) ) ) {
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
			'idmuvi-core-title-value'         => 'IDMUVICORE_Title',
			'idmuvi-core-trailer-value'       => 'IDMUVICORE_Trailer',
			'idmuvi-core-poster-value'        => 'IDMUVICORE_Poster',
			'idmuvi-core-tmdbvotes-value'     => 'IDMUVICORE_tmdbVotes',
			'idmuvi-core-tmdbrating-value'    => 'IDMUVICORE_tmdbRating',
			'idmuvi-core-runtime-value'       => 'IDMUVICORE_Runtime',
			'idmuvi-core-numberepisode-value' => 'IDMUVICORE_Numbepisode',
			'idmuvi-core-released-value'      => 'IDMUVICORE_Released',
			'idmuvi-core-year-value'          => 'IDMUVICORE_Year',
			'idmuvi-core-last-air-value'      => 'IDMUVICORE_Lastdate',
			'idmuvi-core-tmdbid-value'        => 'IDMUVICORE_tmdbID',
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
		wp_nonce_field( basename( __FILE__ ), 'idmuvi_core_tv_meta_nonce' );

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
					<a class="nav-tab nav-tab-active" id="muvi-settings-tab" href="#muvi-settings"><?php esc_html_e( 'TV Shows Settings:', 'idmuvi-core' ); ?></a>
				</h3>

				<div id="muvi-settings" class="group">

					<?php
					if ( 'on' === $enable_tmdb_opsi ) {
						$status = trim( get_option( 'newidmuvi_core_license_status' . md5( home_url() ) ) );

						if ( ! empty( $status ) && 'ok' === $status ) {
							?>

					<p>
						<label for="idmuvi-core-id"><strong><?php esc_html_e( 'Enter TMDB ID:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" value="" class="regular-text display-block" name="tmdbID" id="idmuvi-core-id" />
						<input class="button button-primary display-block" type="button" name="idmuvi-ret-gmr-button" id="idmuvi-core-id-submit" value="<?php esc_attr_e( 'Retrieve Information', 'idmuvi-core' ); ?>" />
						<span class="howto"><?php echo __( 'Please insert id tmdb.<br/>Example link from tmdb https://www.themoviedb.org/tv/<strong>30991</strong>-cowboy-bebop (Just insert with <strong>30991</strong>).', 'idmuvi-core' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</p>
							<?php
						}
					}
					?>

					<p>
						<label for="opsi-title"><strong><?php esc_html_e( 'Original Name (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-title" name="idmuvi-core-title-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Title', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with original tv show name', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-release"><strong><?php esc_html_e( 'Relase Date (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-release" name="idmuvi-core-released-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Released', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with tv show release date. Format (dd mmm yyyy) example 23 Jan 2015', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-year"><strong><?php esc_html_e( 'Relase Year (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-year" name="idmuvi-core-year-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Year', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with tv show release year. Format (yyyy) example 2015', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-air"><strong><?php esc_html_e( 'Last Air Date (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-air" name="idmuvi-core-last-air-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Lastdate', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with tv show last air date', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-runtime"><strong><?php esc_html_e( 'Runtime in minutes (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-runtime" name="idmuvi-core-runtime-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Runtime', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with tv show runtime (in minutes)', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-episode"><strong><?php esc_html_e( 'Number Of Episode (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block" id="opsi-episode" name="idmuvi-core-numberepisode-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Numbepisode', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Fill with number of episode this tv show', 'idmuvi-core' ); ?></span>
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
						<span class="howto"><?php esc_attr_e( 'Fill with youtube id for tv show trailer. Example: https://www.youtube.com/watch?v=YROTBt1sae8 just fill with YROTBt1sae8', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-imageposter"><strong><?php esc_html_e( 'Poster Url (TMDB):', 'idmuvi-core' ); ?></strong></label>
						<input type="text" class="regular-text display-block muvipro-metaposer-url" name="idmuvi-core-poster-value" id="opsi-imageposter" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_Poster', true ) ); ?>" />
						<input style="margin-top: 10px;" class="button button-primary muvipro-metaposer-browse" type="button" value="<?php esc_attr_e( 'Upload', 'idmuvi-core' ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Please upload image for tv show poster. Please using internal image only', 'idmuvi-core' ); ?></span>
					</p>

					<p>
						<label for="opsi-tmdbid"><strong><?php esc_html_e( 'tmdbID:', 'idmuvi-core' ); ?></strong></label>
						<input type="text" style="max-width:120px" class="regular-text display-block" id="opsi-tmdbid" name="idmuvi-core-tmdbid-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'IDMUVICORE_tmdbID', true ) ); ?>" />
						<span class="howto"><?php esc_attr_e( 'Example link https://www.themoviedb.org/movie/244786-whiplash (Just insert with 244786)', 'idmuvi-core' ); ?></span>
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
	new Idmuvi_Core_Metabox_Settings_TvShow();
}
