<?php
/**
 * Handles plugin configuration
 */
if ( ! class_exists( 'UCF_FAQ_Config' ) ) {
	class UCF_FAQ_Config {
		public static
			$default_plugin_options = array(
				'ucf_faq_include_athena_classes'    => 'on',
			);
		public static function add_options() {
			$defaults = self::$default_plugin_options;
			add_option( 'ucf_faq_include_athena_classes', $defaults['ucf_faq_include_athena_classes'] );
		}
		public static function get_default_plugin_options() {
			$defaults = self::$default_plugin_options;
			return self::format_options( $defaults );
		}
		public static function format_options( $list ) {
			foreach( $list as $key => $val ) {
				switch( $key ) {
					case 'ucf_faq_include_athena_classes':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
						break;
					default:
						break;
				}
			}
			return $list;
		}
		public static function add_options_page() {
			add_options_page(
				'UCF FAQ',
				'UCF FAQ',
				'manage_options',
				'ucf_faq_settings',
				array(
					'UCF_FAQ_Config',
					'add_settings_page'
				)
			);
			add_action( 'admin_init', array( 'UCF_FAQ_Config', 'register_settings' ) );
		}
		public static function register_settings() {
			register_setting( 'ucf-faq-group', 'ucf_faq_include_athena_classes' );
		}
		public static function add_settings_page() {
			$defaults = self::get_default_plugin_options();
			$ucf_faq_include_athena_classes = get_option( 'ucf_faq_include_athena_classes', $defaults['ucf_faq_include_athena_classes'] );
	?>
			<div class="wrap">
				<h1>UCF FAQ Settings</h1>
				<form method="post" action="options.php">
					<?php settings_fields( 'ucf-faq-group' ); ?>
					<?php do_settings_sections( 'ucf-faq-groups' ); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Include Athena Classes</th>
							<td>
								<input type="checkbox" name="ucf_faq_include_athena_classes" <?php echo ( $ucf_faq_include_athena_classes === 'on' ) ? 'checked' : ''; ?>>
								</input>
								<p class="description">
									If checked the UCF Athena Framework classes will be added to the HTML. Check if Athena has been included with the theme in use.
								</p>
							</td>
						</tr>
					</table>
					<?php submit_button(); ?>
				</form>
			</div>
	<?php
		}
	}
}
?>
