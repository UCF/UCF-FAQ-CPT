<?php
/**
 * General functions for displaying FAQ searches.
 *
 * @author Jo Dickson
 * @since 1.3.1
 **/
if ( ! class_exists( 'UCF_FAQ_Search_Common' ) ) {
	class UCF_FAQ_Search_Common {
		/**
		 * Displays a FAQ search typeahead.
		 * @since 1.3.1
		 * @author Jo Dickson
		 * @return string
		 */
		public static function display_faq_search( $args ) {
			$title         = $args['title'];
			$title_classes = $args['title_classes'];

			$random_hash = substr( md5( rand( 0, 500 ) ), 0, 16 );
			$id          = "faq-typeahead-$random_hash";

			ob_start();
		?>
			<label class="<?php echo $title_classes; ?>" for="<?php echo $id; ?>"><?php echo $title; ?></label>
			<input id="<?php echo $id; ?>" class="faq-typeahead form-control" type="text" placeholder="<?php echo $args['placeholder']; ?>">
		<?php
			return ob_get_clean();
		}
	}
}

