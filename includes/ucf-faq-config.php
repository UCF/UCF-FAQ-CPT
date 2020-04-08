<?php
/**
 * Handles plugin configuration
 */
if ( ! class_exists( 'UCF_FAQ_Config' ) ) {
	class UCF_FAQ_Config {
		public static $option_prefix = 'ucf_faq_',
		$option_defaults = array(
			'include_athena_classes'  => true,
			'disable_faq_archive'     => false,
			'default_sort_order'      => false,
			'add_microdata'           => false
		);


		/**
		 * Creates options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin activation.
		 *
		 * @return void
		 **/
		public static function add_options() {
			$defaults = self::$option_defaults; // don't use self::get_option_defaults() here (default options haven't been set yet)
			add_option( self::$option_prefix . 'include_athena_classes', $defaults['include_athena_classes'] );
			add_option( self::$option_prefix . 'disable_faq_archive', $defaults['disable_faq_archive'] );
			add_option( self::$option_prefix . 'default_sort_order', $defaults['default_sort_order'] );
			add_option( self::$option_prefix . 'add_microdata', $defaults['add_microdata'] );
		}


		/**
		 * Deletes options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin uninstallation.
		 *
		 * @return void
		 **/
		public static function delete_options() {
			delete_option( self::$option_prefix . 'include_athena_classes' );
			delete_option( self::$option_prefix . 'disable_faq_archive' );
			delete_option( self::$option_prefix . 'default_sort_order' );
			delete_option( self::$option_prefix . 'add_microdata' );
		}


		/**
		 * Returns a list of default plugin options. Applies any overridden
		 * default values set within the options page.
		 *
		 * @return array
		 **/
		public static function get_option_defaults() {
			$defaults = self::$option_defaults;

			// Apply default values configurable within the options page:
			$configurable_defaults = array(
				'include_athena_classes' => get_option( self::$option_prefix . 'include_athena_classes', $defaults['include_athena_classes'] ),
				'disable_faq_archive'    => get_option( self::$option_prefix . 'disable_faq_archive', $defaults['disable_faq_archive'] ),
				'default_sort_order'     => get_option( self::$option_prefix . 'default_sort_order', $defaults['default_sort_order'] ),
				'add_microdata'          => get_option( self::$option_prefix . 'add_microdata', $defaults['add_microdata'] ),
			);

			// Force configurable options to override $defaults, even if they are empty:
			$defaults = array_merge( $defaults, $configurable_defaults );

			return $defaults;
		}


		/**
		 * Performs typecasting, sanitization, etc on an array of plugin options.
		 *
		 * @param array $list | Assoc. array of plugin options, e.g. [ 'option_name' => 'val', ... ]
		 * @return array
		 **/
		public static function format_options( $list ) {
			foreach ( $list as $key => $val ) {
				switch ( $key ) {
					case 'include_athena_classes':
					case 'disable_faq_archive':
					case 'default_sort_order':
					case 'add_microdata':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
						break;
					default:
						break;
				}
			}
			return $list;
		}


		/**
		 * Applies formatting to a single option. Intended to be passed to the
		 * 'option_{$option}' hook.
		 **/
		public static function format_option( $value, $option_name ) {
			$option_formatted = self::format_options( array( $option_name => $value ) );
			return $option_formatted[$option_name];
		}


		/**
		 * Adds filters for shortcode and plugin options that apply our
		 * formatting rules to attribute/option values.
		 **/
		public static function add_option_formatting_filters() {
			// Options
			$defaults = self::$option_defaults;
			foreach ( $defaults as $option => $default ) {
				add_filter( 'option_{$option}', array( 'UCF_FAQ_Config', 'format_option' ), 10, 2 );
			}
		}


		/**
		 * Convenience method for returning an option from the WP Options API
		 * or a plugin option default.
		 *
		 * @param $option_name
		 * @return mixed
		 **/
		public static function get_option_or_default( $option_name ) {
			// Handle $option_name passed in with or without self::$option_prefix applied:
			$option_name_no_prefix = str_replace( self::$option_prefix, '', $option_name );
			$option_name           = self::$option_prefix . $option_name_no_prefix;
			$defaults              = self::get_option_defaults();

			return get_option( $option_name, $defaults[$option_name_no_prefix] );
		}


		/**
		 * Initializes setting registration with the Settings API.
		 **/
		public static function settings_init() {
			// Register settings
			register_setting( 'ucf_faq', self::$option_prefix . 'include_athena_classes' );
			register_setting( 'ucf_faq', self::$option_prefix . 'disable_faq_archive' );
			register_setting( 'ucf_faq', self::$option_prefix . 'default_sort_order' );
			register_setting( 'ucf_faq', self::$option_prefix . 'add_microdata' );

			// Register setting sections
			add_settings_section(
				'ucf_faq_section_general', // option section slug
				'General Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_faq' // settings page slug
			);

			// Register fields - general
			add_settings_field(
				self::$option_prefix . 'include_athena_classes',
				'Include Athena Classes and Helper Styles',  // formatted field title
				array( 'UCF_FAQ_Config', 'display_settings_field' ),  // display callback
					'ucf_faq',  // settings page slug
					'ucf_faq_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'include_athena_classes',
					'description' => 'Include the UCF Athena Framework classes in HTML and the Athena-specific plugin stylesheet.<br>Leave this checkbox <strong>checked</strong> if you are using a theme that includes the UCF Athena Framework.',
					'type'        => 'checkbox'
				)
			);

			add_settings_field(
				self::$option_prefix . 'disable_faq_archive',
				'Disable FAQ Archive',  // formatted field title
				array( 'UCF_FAQ_Config', 'display_settings_field' ),  // display callback
					'ucf_faq',  // settings page slug
					'ucf_faq_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'disable_faq_archive',
					'description' => 'If checked the FAQ Archive will be disabled.',
					'type'        => 'checkbox'
				)
			);

			add_settings_field(
				self::$option_prefix . 'default_sort_order',
				'Set high default FAQ sort order',
				array( 'UCF_FAQ_Config', 'display_settings_field' ),
				'ucf_faq',
				'ucf_faq_section_general',
				array(
					'label_for'   => self::$option_prefix . 'default_sort_order',
					'description' => 'If checked, new FAQs will have a default sort order value that pushes them to the end of sorted FAQ lists. When left unchecked, new FAQs will not have a default sort order value set, and will be shown at the beginning of sorted FAQ lists.',
					'type'        => 'checkbox'
				)
			);

			add_settings_field(
				self::$option_prefix . 'add_microdata',
				'Add microdata to FAQs',
				array( 'UCF_FAQ_Config', 'display_settings_field' ),
				'ucf_faq',
				'ucf_faq_section_general',
				array(
					'label_for'   => self::$option_prefix . 'add_microdata',
					'description' => 'If checked, microdata will be added to FAQ markup.',
					'type'        => 'checkbox'
				)
			);
		}


		/**
		 * Displays an individual setting's field markup.
		 **/
		public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$current_value = self::get_option_or_default( $option_name );
			$choices       = isset( $args['choices'] ) ? $args['choices'] : null;
			$markup        = '';

			switch ( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo ( $current_value == true ) ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'select':
					ob_start();
				?>
					<select id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>">
					<?php
					if ( $choices ):
						foreach ( $choices as $value => $text ):
					?>
						<option value="<?php echo $value; ?>" <?php echo ( $current_value === $value ) ? 'selected' : ''; ?>><?php echo $text; ?></option>
					<?php
						endforeach;
					endif;
					?>
					</select>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'password':
					ob_start();
				?>
					<input type="password" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="regular-text" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'smalltext':
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="small-text" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="regular-text" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}

			echo $markup;
		}


		/**
		 * Registers the settings page to display in the WordPress admin.
		 **/
		public static function add_options_page() {
			$page_title = 'UCF FAQ Settings';
			$menu_title = 'UCF FAQ';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_faq';
			$callback   = array( 'UCF_FAQ_Config', 'options_page_html' );
			return add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);
		}


		/**
		 * Displays the plugin's settings page form.
		 **/
		public static function options_page_html() {
			ob_start();
		?>

		<div class="wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ucf_faq' );
				do_settings_sections( 'ucf_faq' );
				submit_button();
				?>
			</form>
		</div>

		<?php
			echo ob_get_clean();
		}


		/**
		 * Add athena classes if setting is turned on.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function add_athena_attr( $attr ) {
			echo ( self::get_option_or_default( self::$option_prefix . 'include_athena_classes' ) ) ? $attr : "";
		}


		/**
		 * Flush Rewrite Rules when the faq archive option is updated.
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function faq_archive_option_updated() {
			flush_rewrite_rules();
		}
	}
}

// Register settings and options.
add_action( 'admin_init', array( 'UCF_FAQ_Config', 'settings_init' ) );
add_action( 'admin_menu', array( 'UCF_FAQ_Config', 'add_options_page' ) );
add_action( 'update_option_ucf_faq_disable_faq_archive', array( 'UCF_FAQ_Config', 'faq_archive_option_updated' ), 10, 0 );

// Apply custom formatting to shortcode attributes and options.
UCF_FAQ_Config::add_option_formatting_filters();
?>
