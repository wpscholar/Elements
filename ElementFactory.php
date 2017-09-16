<?php

namespace wpscholar\Elements;

/**
 * Class ElementFactory
 */
final class ElementFactory {

	/**
	 * A collection of all empty HTML elements.
	 *
	 * @var array
	 */
	private static $_empty_elements = array(
		'area',
		'base',
		'br',
		'col',
		'embed',
		'hr',
		'img',
		'input',
		'keygen',
		'link',
		'meta',
		'param',
		'wbr',
	);

	/**
	 * Instantiates an element object from the element type, or tag name.
	 *
	 * @param string $tag
	 * @param array $atts
	 * @param string $class
	 *
	 * @return ElementNode
	 */
	public static function createElement( $tag, array $atts = array(), $class = '' ) {
		$tag = strtolower( $tag );
		if ( ! class_exists( $class ) ) {
			if ( in_array( $tag, self::$_empty_elements ) ) {
				$class = __NAMESPACE__ . '\\EmptyElement';
			} else {
				$class = __NAMESPACE__ . '\\EnclosingElement';
			}
		}

		return new $class( $tag, $atts );
	}

	/**
	 * Builds an element object based on the element type and additional arguments.
	 *
	 * @param array $args
	 *
	 * @return ElementNode
	 */
	public static function buildElement( array $args = array() ) {

		// Set default args
		$args = array_merge( array(
			'tag'     => 'div',
			'atts'    => array(),
			'content' => '',
		), $args );

		// Create the appropriate element object
		$element = self::createElement( $args['tag'], $args['atts'] );

		// Add content, if provided and element is an enclosing element
		if ( $args['content'] && is_a( $element, __NAMESPACE__ . '\\EnclosingElement' ) ) {
			/**
			 * @var EnclosingElement $element
			 */
			$element->content = $args['content'];
		}

		return $element;
	}

}
