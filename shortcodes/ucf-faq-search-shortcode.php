<?php
/**
 * Provides a shortcode for the UCF FAQ Search
 */
if ( ! class_exists( 'UCF_FAQ_Search_Shortcode' ) ) {
	class UCF_FAQ_Search_Shortcode {
		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'title'         => 'Search All FAQs',
				'title_tag'     => 'h2',
				'title_classes' => 'h3 text-secondary',
				'placeholder'   => 'Search&hellip;'
			), $atts );

			$title         = $atts['title'];
			$title_tag     = $atts['title_tag'];
			$title_classes = $atts['title_classes'];

			ob_start();
		?>
			<<?php echo $title_tag; ?> class="<?php echo $title_classes; ?>"><?php echo $title; ?></<?php echo $title_tag; ?>>
			<input class="faq-typeahead form-control" type="text" placeholder="<?php echo $atts['placeholder']; ?>">
		<?php
			return ob_get_clean();
		}
	}

	if ( ! shortcode_exists( 'ucf-faq-search' ) ) {
		add_shortcode( 'ucf-faq-search', array( 'UCF_FAQ_Search_Shortcode', 'shortcode' ) );
	}
}
