<?php
/**
 * Contains the templates and filters
 * for the FAQ Search Shortcode
 */

class UCF_FAQ_Search_Templates {
	/**
	 * Returns the 'empty' template.
	 * This template is used when there are
	 * no suggestions to display in the typeahead.
	 * @author Jim Barnes
	 * @since 1.3.0
	 * @return string
	 */
	public static function empty() {
		ob_start();
	?>
		<div class="faq-typeahead-empty tt-empty">No FAQs found.</div>
	<?php
		return apply_filters( 'ucf_faq_search_empty_template', ob_get_clean() );
	}

	/**
	 * The suggestion template.
	 * This is the template used for each
	 * typeahead suggestion.
	 * @author Jim Barnes
	 * @since 1.3.0
	 * @return string
	 */
	public static function suggestion() {
		ob_start();
	?>
		<a class="faq-typeahead-suggestion tt-suggestion" href="{{link}}">{{title.rendered}}</a>
	<?php
		return apply_filters( 'ucf_faq_search_suggestion_template', ob_get_clean() );
	}

	/**
	 * The footer template.
	 * This is the template used for the footer
	 * that is always underneath suggestions or the
	 * empty template if there are no suggestions.
	 * @author Jim Barnes
	 * @since 1.3.0
	 * @return string
	 */
	public static function footer() {
		// Return the output of any filters registered.
		return apply_filters( 'ucf_faq_search_footer_template', '' );
	}
}
