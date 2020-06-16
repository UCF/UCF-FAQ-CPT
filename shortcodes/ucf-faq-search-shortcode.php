<?php
/**
 * Provides a shortcode for the UCF FAQ Search
 */
if ( ! class_exists( 'UCF_FAQ_Search_Shortcode' ) ) {
	class UCF_FAQ_Search_Shortcode {
		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'title'         => 'Search All FAQs',
				'title_classes' => 'h3 text-secondary',
				'placeholder'   => 'Search&hellip;'
			), $atts );

			$title         = $atts['title'];
			$title_classes = $atts['title_classes'];

			$random_hash = substr( md5( rand( 0, 500 ) ), 0, 16 );
			$id          = "faq-typeahead-$random_hash";

			ob_start();
		?>
			<label class="<?php echo $title_classes; ?>" for="<?php echo $id; ?>"><?php echo $title; ?></label>
			<input id="<?php echo $id; ?>" class="faq-typeahead form-control" type="text" placeholder="<?php echo $atts['placeholder']; ?>">
		<?php
			return ob_get_clean();
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-search' ) ) {
		add_shortcode( 'ucf-faq-search', array( 'UCF_FAQ_Search_Shortcode', 'shortcode' ) );
	}
}
