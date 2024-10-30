<?php
/**
 * Plugin Name: corona-virus-covid19-banner
 * Plugin URI: https://www.bridgement.com
 * Description: Display South African COVID-19 banner
 * Version: 0.4.6
 * Author: Bridgement
 * License: GPL2
 *
 * @package corona-virus-covid19-banner
 * @version 0.4.6
 * @author Bridgement <support@bridgement.com>
 */

define( 'VERSION', '0.4.5' );

add_action( 'wp_enqueue_scripts', 'covid_banner' );
/**
 * Register styles and scripts
 *
 * @return void
 */
function covid_banner() {
	wp_register_style( 'covid-banner-style', plugin_dir_url( __FILE__ ) . 'corona-virus-covid19-banner.css', '', VERSION );
	wp_enqueue_style( 'covid-banner-style' );

	$script_params = array(
		'in_array'                 => in_array( get_the_ID(), explode( ',', get_option( 'disabled_pages_array' ) ), true ),
		'disabled_pages_array'     => explode( ',', get_option( 'disabled_pages_array' ) ),
		'debug_mode'               => get_option( 'debug_mode' ),
		'id'                       => get_the_ID(),
		'img_src'                  => plugin_dir_url( __FILE__ ) . 'img/coat.png',
		'covid_banner_color'       => get_option( 'covid_banner_color' ),
		'covid_banner_text_color'  => get_option( 'covid_banner_text_color' ),
		'covid_banner_link_color'  => get_option( 'covid_banner_link_color' ),
		'covid_banner_share'       => get_option( 'covid_banner_share' ),
		'covid_banner_header_text' => get_option( 'covid_banner_header_text' ),
		'covid_banner_body_text'   => get_option( 'covid_banner_body_text' ),
		'covid_banner_link_text'   => get_option( 'covid_banner_link_text' ),
	);

	wp_register_style( 'font-script', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap', '', VERSION );
	wp_enqueue_style( 'font-script' );

	wp_register_script( 'covid-banner-script', plugin_dir_url( __FILE__ ) . 'corona-virus-covid19-banner.js', array( 'jquery' ), VERSION, true );
	wp_localize_script( 'covid-banner-script', 'scriptParams', $script_params );
	wp_enqueue_script( 'covid-banner-script' );
}

add_action( 'wp_head', 'covid_banner_custom_color' );
/**
 * Sets custom colors from settings
 *
 * @return void
 */
function covid_banner_custom_color() {
	if ( get_option( 'covid_banner_color' ) !== '' ) {
		echo '<style type="text/css" media="screen">.covid-banner{background:' . esc_attr( get_option( 'covid_banner_color' ) ) . '}</style>';
	} else {
		echo '<style type="text/css" media="screen">.covid-banner{background: #ffffff;}</style>';
		echo '<style type="text/css" media="screen">.covid-footer button{background: #ffffff;}</style>';
	}

	if ( get_option( 'covid_banner_text_color' ) !== '' ) {
		echo '<style type="text/css" media="screen">.covid-banner .covid-text{color:' . esc_attr( get_option( 'covid_banner_text_color' ) ) . '}</style>';
	} else {
		echo '<style type="text/css" media="screen">.covid-banner .covid-text{color: #606060;}</style>';
	}

	if ( get_option( 'covid_banner_header_color' ) !== '' ) {
		echo '<style type="text/css" media="screen">.covid-banner .covid-header{color:' . esc_attr( get_option( 'covid_banner_text_color' ) ) . '}</style>';
	} else {
		echo '<style type="text/css" media="screen">.covid-banner .covid-header{color: #606060;}</style>';
	}

	if ( get_option( 'covid_banner_link_color' ) !== '' ) {
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a{color:' . esc_attr( get_option( 'covid_banner_link_color' ) ) . '}</style>';
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a:visited{color:' . esc_attr( get_option( 'covid_banner_link_color' ) ) . '}</style>';
		echo '<style type="text/css" media="screen">.covid-footer a:visited{color:' . esc_attr( get_option( 'covid_banner_link_color' ) ) . '}</style>';
		echo '<style type="text/css" media="screen">.covid-footer a{color:' . esc_attr( get_option( 'covid_banner_link_color' ) ) . '}</style>';
	} else {
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a{color: #065fd4;}</style>';
		echo '<style type="text/css" media="screen">.covid-banner .covid-body a:visited{color: #065fd4;}</style>';
		echo '<style type="text/css" media="screen">.covid-footer a:visited{color: #065fd4;}</style>';
		echo '<style type="text/css" media="screen">.covid-footer a{color: #065fd4;}</style>';
	}
}
add_action( 'admin_menu', 'covid_banner_menu' );
/**
 * Adds settings page
 *
 * @return void
 */
function covid_banner_menu() {
	add_menu_page( 'Corona Virus Covid19 Banner Settings', 'Covid Banner', 'administrator', 'covid-banner-settings', 'covid_banner_settings_page', 'dashicons-admin-generic' );
}

add_action( 'admin_init', 'covid_banner_settings' );
/**
 * Registers settings
 *
 * @return void
 */
function covid_banner_settings() {
	register_setting( 'covid-banner-settings-group', 'covid_banner_color' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_text_color' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_header_color' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_link_color' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_dismiss_color' );
	register_setting( 'covid-banner-settings-group', 'disabled_pages_array' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_share' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_header_text' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_body_text' );
	register_setting( 'covid-banner-settings-group', 'covid_banner_link_text' );
}

/**
 * Display the settings for the banner
 *
 * @return void
 */
function covid_banner_settings_page() {     ?>
	<div class="wrap">
		<div style="display: flex;justify-content: space-between;">
			<h2>Corona Virus Covid19 Banner Settings</h2>
		</div>

		<div class="settings-page-row">
			<div class="settings-page-column">
			<form method="post" action="options.php">
			<?php settings_fields( 'covid-banner-settings-group' ); ?>
			<?php do_settings_sections( 'covid-banner-settings-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row-covid-banner">Share this plugin<br><span style="font-weight:400;">(Include a download link for others to get this plugin)</span></th>
					<td style="vertical-align:top;">
						<input type="checkbox" id="covid_banner_share" name="covid_banner_share" placeholder="Hex value" value="<?php echo esc_attr( get_option( 'covid_banner_share' ) ); ?>" <?php echo( esc_attr( get_option( 'covid_banner_share' ) ) === 'true' ? 'checked ' : '' ); ?> />
					</td>
				</tr>

				<tr valign="top">
					<p>Use Hex color values for the color fields. Leaving this blank will set the color to the default value.</p>
				</tr>
				<tr valign="top">
					<th scope="row-covid-banner">Covid Banner Background Color</th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_color" name="covid_banner_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option( 'covid_banner_color' ) ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_color_show"
										value="<?php echo( ( get_option( 'covid_banner_color' ) === '' ) ? '#ffffff' : esc_attr( get_option( 'covid_banner_color' ) ) ); ?>">
					</td>
				</tr>

				<tr valign="top">
					<th scope="row-covid-banner">Covid Banner Text Color</th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_text_color" name="covid_banner_text_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option( 'covid_banner_text_color' ) ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_text_color_show"
										value="<?php echo( ( get_option( 'covid_banner_text_color' ) === '' ) ? '#606060' : esc_attr( get_option( 'covid_banner_text_color' ) ) ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row-covid-banner">Covid Banner Header Color</th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_header_color" name="covid_banner_header_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option( 'covid_banner_header_color' ) ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_header_color_show"
										value="<?php echo( ( get_option( 'covid_banner_header_color' ) === '' ) ? '#030303' : esc_attr( get_option( 'covid_banner_header_color' ) ) ); ?>">
					</td>
				</tr>

				<tr valign="top">
					<th scope="row-covid-banner">Covid Banner Link Color</th>
					<td style="vertical-align:top;">
						<input type="text" id="covid_banner_link_color" name="covid_banner_link_color" placeholder="Hex value"
										value="<?php echo esc_attr( get_option( 'covid_banner_link_color' ) ); ?>" />
						<input style="height: 30px;width: 100px;" type="color" id="covid_banner_link_color_show"
										value="<?php echo( ( get_option( 'covid_banner_link_color' ) === '' ) ? '#065fd4' : esc_attr( get_option( 'covid_banner_link_color' ) ) ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<p>Links in the banner text must be typed in with HTML <code>&lt;a&gt;</code> tags.
					<br />e.g. <code>This is a &lt;a href=&#34;http:&#47;&#47;www.wordpress.com&#34;&gt;Link to WordPress&lt;&#47;a&gt;</code>.</p>
				</tr>
				<tr valign="top">
					<th scope="row-covid-banner">
						Header Text (Limited to 20 characters)
					</th>
					<td>
						<input maxlength="20" type="text" id="covid_banner_header_text" style="width: 75%;" name="covid_banner_header_text"><?php echo esc_attr( get_option( 'covid_banner_header_text' ) ); ?></input>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row-covid-banner">
						Body Text (Limited to 50 characters)
					</th>
					<td>
						<input maxlength="50" type="text" id="covid_banner_body_text" style="width: 75%;" name="covid_banner_body_text"><?php echo esc_attr( get_option( 'covid_banner_body_text' ) ); ?></input>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row-covid-banner">
						Link Text (Limited to 20 characters)
					</th>
					<td>
						<input maxlength="20" type="text" id="covid_banner_link_text" style="width: 75%;" name="covid_banner_link_text"><?php echo esc_attr( get_option( 'covid_banner_link_text' ) ); ?></input>
					</td>
				</tr>

				<tr valign="top">
						<th scope="row-covid-banner">
							Disabled Pages
							<br><span style="font-weight:400;">Disable Covid banner on the following pages.</span>
						</th>
						<td>
							<div id="covid_banner_disabled_pages">
								<?php
									$pages            = get_pages();
								$disabled             = false;
								$disabled_pages_array = get_option( 'disabled_pages_array' );
								$parent_checkbox      = '<div style="margin: 10px;" class="settings-page-row"><div class="settings-page-column-small"><input type="checkbox" ';
								$parent_checkbox     .= $disabled ? 'disabled ' : '';
								$parent_checkbox     .= ( ! $disabled && in_array( 1, explode( ',', $disabled_pages_array ), true ) ) ? 'checked ' : '';
								$parent_checkbox     .= 'value="1"></input></div><div class="settings-page-column-large"><span>';
								$parent_checkbox     .= get_option( 'blogname' ) . ' | ' . get_site_url() . ' ';
								$parent_checkbox     .= '</span></div></div>';
								echo $parent_checkbox;
								foreach ( $pages as $page ) {
									$checkbox  = '<div style="margin: 10px;" class="settings-page-row"><div class="settings-page-column-small"><input type="checkbox"';
									$checkbox .= $disabled ? 'disabled ' : '';
									$checkbox .= ( ! $disabled && in_array( $page->ID, explode( ',', $disabled_pages_array ), true ) ) ? 'checked ' : '';
									$checkbox .= 'value="' . $page->ID . '"></input></div><div class="settings-page-column-large"><span>';
									$checkbox .= $page->post_title . ' | ' . get_page_link( $page->ID ) . ' ';
									$checkbox .= '</span></div></div>';
									echo $checkbox;
								}
								?>
							</div>
							<?php
								echo '<input type="text" hidden id="disabled_pages_array" name="disabled_pages_array" value="' . esc_attr( get_option( 'disabled_pages_array' ) ) . '" />';
							?>
						</td>
					</tr>
			</table>


			<?php submit_button(); ?>
		</form>
			</div>
			<div class="settings-page-column">
			<div id="covid-banner-preview" class="covid-banner">
			<div class="covid-group">
				<div class="covid-img">
					<img class="coat" src="<?php echo( plugin_dir_url( __FILE__ ) . 'img/coat.png' ); ?>" style="background-color: transparent;">
				</div>
				<div class="covid-body">
					<h2 id="preview_header_text" class="covid-header">COVID-19</h2>
					<p id="preview_body_text" class="covid-text">Stay informed with official news &amp; stats:</p>
					<a class="covid-link" href="https://sacoronavirus.co.za/"  target="_blank">
						<span id="preview_link_text">SAcoronavirus.co.za</span>
					</a>
				</div>
				<button id="covid-banner-dismiss-button" class="covid-close-button">
					<div class="covid-close-div">
						<svg
							viewBox="0 0 24 24"
							preserveAspectRatio="xMidYMid meet"
							focusable="false"
							class="style-scope yt-icon"
							style="
								pointer-events: none;
								display: block;
								width: 100%;
								height: 100%;
								fill: rgb(144, 144, 144);
							"
						>
							<g class="style-scope yt-icon">
								<path
									d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"
									class="style-scope yt-icon"
								></path>
							</g>
						</svg>
					</div>
				</button>
			</div>
			<div id="covid_preview_share" class="covid-footer">
				<a href="https://www.bridgement.com/blog/business-advice/how-to-comply-with-covid-19-regulations-for-south-africa-website/" target="_blank">ADD THIS BANNER TO YOUR SITE</a>
			</div>

		</div>
							</div>
		</div>


	</div>

	<script type="text/javascript">
		var style_background_color = document.createElement('style');
		var style_link_color = document.createElement('style');
		var style_text_color = document.createElement('style');
		var global_style = document.createElement('style');

		global_style.id = 'global-settings-style'
		global_style.appendChild(document.createTextNode(`

			.form-table tr td {
				display: flex;
				align-items: center;
				justify-content: center;
				align-content: center;
			}

			.settings-page-row {
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;
				width: 100%;
			}

			.settings-page-column {
				display: flex;
				flex-direction: column;
				flex-basis: 100%;
				flex: 1;
			}

			.settings-page-column-small {
				display: flex;
				flex-direction: column;
				flex-basis: 100%;
				flex: 1;
				justify-content: center;
				max-width: 25px;
			}

			.settings-page-column-small input {
				margin-top: 1px;
			}

			.settings-page-column-large {
				display: flex;
				flex-direction: column;
				flex-basis: 100%;
				flex: 2;
			}

			.covid-banner {
				outline: none;
				top: auto;
				left: auto;
				right: 0px;
				bottom: 100px;
				max-width: 450px;
				margin: 16px;
				z-index: 2202;
				box-sizing: border-box;
				max-height: 192px;

				font-family: "Roboto", "Noto", sans-serif;
				font-size: 14px;
				font-weight: 400;
				line-height: 20px;
				box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14),
					0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.4);
			}

			.covid-group {
				display: flex;
				flex-direction: row;
				max-width: 648px;
			}

			.covid-img {
				max-height: 115px;
				opacity: 1;
				display: inline-block;
				flex: none;
			}

			.covid-img .coat {
				padding: 10px;
				display: block;
				box-sizing: border-box;
				margin-left: auto;
				margin-right: auto;
				max-height: 115px;
				max-width: 100%;
				border-radius: none;
			}

			.covid-body {
				display: flex;
				flex-direction: column;
				width: 100%;
			}

			.covid-header {
				display: block;
				font-size: 1rem;
				font-weight: 400;
				line-height: 2rem;
				margin: 10px 0 0 0;
				padding: 0 10px;
			}

			.covid-text {
				margin: 0px;
				padding: 0 10px;
				padding-right: 24px;
				-ms-flex: 1 1 1e-9px;
				-webkit-flex: 1;
				flex: 1;
				-webkit-flex-basis: 1e-9px;
				flex-basis: 1e-9px;
				font-size: 0.8rem;
				font-weight: 400;
				line-height: 1.5rem;
			}

			.covid-link {
				margin: 0px;
				padding: 0 10px;
				padding-right: 24px;
				padding-bottom: 5px;
				-ms-flex: 1 1 1e-9px;
				-webkit-flex: 1;
				flex: 1;
				-webkit-flex-basis: 1e-9px;
				flex-basis: 1e-9px;
				font-size: 0.8rem;
				font-weight: 400;
				line-height: 1rem;
				text-decoration: none !important;
			}

			.covid-footer {
				display: -ms-flexbox;
				display: -webkit-flex;
				display: flex;
				-ms-flex-direction: row;
				-webkit-flex-direction: row;
				flex-direction: row;
				-ms-flex-pack: end;
				-webkit-justify-content: flex-end;
				justify-content: flex-end;
				padding: 2px;
				padding: 2px;
				padding-right: 8px;
				border-top: 1px solid rgba(0, 0, 0, 0.1);
				font-size: 9px;
			}

			.covid-footer a {
				text-transform: uppercase;
				text-decoration: none;
				background-color: #ffffff;
				font-size: 12px;
				padding: 5px;
				border: 0;
			}

			.row-covid-banner {
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;
				width: 100%;
			}

			.column-covid-bannerr {
				display: flex;
				flex-direction: column;
				flex-basis: 100%;
				flex: 1;
			}

			.covid-close-div {
				display: inline-flex;
				width: 24px;
				height: 24px;
			}

			.covid-close-button {
				vertical-align: middle;
				color: inherit;
				outline: none;
				background: none;
				margin-top: 4px;
				margin-left: 4px;
				border: none;
				padding: 8px;
				width: 40px;
				height: 40px;
				line-height: 0;
				cursor: pointer;
				-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
				-webkit-tap-highlight-color: transparent;
			}

			.covid-share a {
				text-decoration: none;
			}
		`));
		document.getElementsByTagName('head')[0].appendChild(global_style);

		document.getElementById('covid_preview_share').style.display = document.getElementById('covid_banner_share').value === "true" ? '' : 'none';
		document.getElementById('covid_banner_share').onchange=function(e){
				console.log(e.target.value)
				document.getElementById('covid_preview_share').style.display = e.target.value === "true" ? '' : 'none';
		};

		// Banner Text
		document.getElementById('preview_header_text').innerHTML = document.getElementById('covid_banner_header_text').value !== "" ? document.getElementById('covid_banner_header_text').value : 'COVID-19';
		document.getElementById('covid_banner_header_text').onchange=function(e){
				document.getElementById('preview_header_text').innerHTML = e.target.value !== "" ? e.target.value : 'COVID-19';
		};

		document.getElementById('preview_body_text').innerHTML = document.getElementById('covid_banner_body_text').value !== "" ? document.getElementById('covid_banner_body_text').value : 'Stay informed with official news &amp; stats:';
		document.getElementById('covid_banner_body_text').onchange=function(e){
				document.getElementById('preview_body_text').innerHTML = e.target.value !== "" ? e.target.value : 'Stay informed with official news &amp; stats:';
		};

		document.getElementById('preview_link_text').innerHTML = document.getElementById('covid_banner_link_text').value !== "" ? document.getElementById('covid_banner_link_text').value : 'SAcoronavirus.co.za';
		document.getElementById('covid_banner_link_text').onchange=function(e){
				document.getElementById('preview_link_text').innerHTML = e.target.value !== "" ? e.target.value : 'SAcoronavirus.co.za';
		};
		// Background Color
		style_background_color.type = 'text/css';
		style_background_color.id = 'preview_banner_background_color'
		style_background_color.appendChild(document.createTextNode('.covid-banner {background:' + (document.getElementById('covid_banner_color').value || '#ffffff') + '}'));
		style_background_color.appendChild(document.createTextNode('.covid-footer a{background:' + (document.getElementById('covid_banner_color').value || '#ffffff') + '}'));
		document.getElementsByTagName('head')[0].appendChild(style_background_color);

		document.getElementById('covid_banner_color').onchange=function(e){
				document.getElementById('covid_banner_color_show').value = e.target.value || '#ffffff';
				var child = document.getElementById('preview_banner_background_color');
				if (child){child.innerText = "";child.id='';}

				var style_dynamic = document.createElement('style');
				style_dynamic.type = 'text/css';
				style_dynamic.id = 'preview_banner_background_color';
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-banner{background:' + (document.getElementById('covid_banner_color').value || '#ffffff') + '}'
						)
				);
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-footer a{background:' + (document.getElementById('covid_banner_color').value || '#ffffff') + '}'
						)
				);
				document.getElementsByTagName('head')[0].appendChild(style_dynamic);
		};
		document.getElementById('covid_banner_color_show').onchange=function(e){
				document.getElementById('covid_banner_color').value = e.target.value;
				document.getElementById('covid_banner_color').dispatchEvent(new Event('change'));
		};

		// Text Color
		style_text_color.type = 'text/css';
		style_text_color.id = 'preview_banner_header_color'
		style_text_color.appendChild(document.createTextNode('.covid-banner .covid-header{color:' + (document.getElementById('covid_banner_header_color').value || '#606060') + '}'));
		document.getElementsByTagName('head')[0].appendChild(style_text_color);

		document.getElementById('covid_banner_header_color').onchange=function(e){
				document.getElementById('covid_banner_header_color_show').value = e.target.value || '#606060';
				var child = document.getElementById('preview_banner_header_color');
				if (child){child.innerText = "";child.id='';}

				var style_dynamic = document.createElement('style');
				style_dynamic.type = 'text/css';
				style_dynamic.id = 'preview_banner_header_color';
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-banner .covid-header{color:' + (document.getElementById('covid_banner_header_color').value || '#606060') + '}'
						)
				);
				document.getElementsByTagName('head')[0].appendChild(style_dynamic);
		};
		document.getElementById('covid_banner_header_color_show').onchange=function(e){
				document.getElementById('covid_banner_header_color').value = e.target.value;
				document.getElementById('covid_banner_header_color').dispatchEvent(new Event('change'));
		};


		style_text_color.type = 'text/css';
		style_text_color.id = 'preview_banner_text_color'
		style_text_color.appendChild(document.createTextNode('.covid-banner .covid-text{color:' + (document.getElementById('covid_banner_text_color').value || '#606060') + '}'));
		document.getElementsByTagName('head')[0].appendChild(style_text_color);

		document.getElementById('covid_banner_text_color').onchange=function(e){
				document.getElementById('covid_banner_text_color_show').value = e.target.value || '#606060';
				var child = document.getElementById('preview_banner_text_color');
				if (child){child.innerText = "";child.id='';}

				var style_dynamic = document.createElement('style');
				style_dynamic.type = 'text/css';
				style_dynamic.id = 'preview_banner_text_color';
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-banner .covid-text{color:' + (document.getElementById('covid_banner_text_color').value || '#606060') + '}'
						)
				);
				document.getElementsByTagName('head')[0].appendChild(style_dynamic);
		};
		document.getElementById('covid_banner_text_color_show').onchange=function(e){
				document.getElementById('covid_banner_text_color').value = e.target.value;
				document.getElementById('covid_banner_text_color').dispatchEvent(new Event('change'));
		};

		// Link Color
		style_link_color.type = 'text/css';
		style_link_color.id = 'preview_banner_link_color'
		style_link_color.appendChild(document.createTextNode('.covid-banner .covid-body a{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'));
		style_link_color.appendChild(document.createTextNode('.covid-banner .covid-body a:visited{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'));
		style_link_color.appendChild(document.createTextNode('.covid-footer a{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'));
		style_link_color.appendChild(document.createTextNode('.covid-footer a:visited{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'));
		document.getElementsByTagName('head')[0].appendChild(style_link_color);

		document.getElementById('covid_banner_link_color').onchange=function(e){
				document.getElementById('covid_banner_link_color_show').value = e.target.value || '#065fd4';
				var child = document.getElementById('preview_banner_link_color');
				if (child){child.innerText = "";child.id='';}

				var style_dynamic = document.createElement('style');
				style_dynamic.type = 'text/css';
				style_dynamic.id = 'preview_banner_link_color';
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-banner .covid-body a{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'
						)
				);
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-banner .covid-body a:visited{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'
						)
				);
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-footer a{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'
						)
				);
				style_dynamic.appendChild(
						document.createTextNode(
								'.covid-footer a:visited{color:' + (document.getElementById('covid_banner_link_color').value || '#065fd4') + '}'
						)
				);
				document.getElementsByTagName('head')[0].appendChild(style_dynamic);
		};
		document.getElementById('covid_banner_link_color_show').onchange=function(e){
				document.getElementById('covid_banner_link_color').value = e.target.value;
				document.getElementById('covid_banner_link_color').dispatchEvent(new Event('change'));
		};
	</script>

	<script type="text/javascript">
		document.getElementById('covid_banner_disabled_pages').onclick=function(e){
			let disabledPagesArray = [];
			Array.from(document.getElementById('covid_banner_disabled_pages').getElementsByTagName('input')).forEach(function(e) {
				if (e.checked) {
					disabledPagesArray.push(e.value);
				}
			});
			document.getElementById('disabled_pages_array').value = disabledPagesArray;
		};

		document.getElementById('covid_banner_share').onclick=function(e){
			document.getElementById('covid_banner_share').value = e.target.checked;
		};


	</script>
	<?php
}
?>
