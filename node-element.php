<?php

namespace wpscholar\Elements;

/**
 * Class Element
 *
 * @property string $tag
 * @property Attributes $atts
 */
abstract class ElementNode extends Node {

	/**
	 * The tag name, or element type
	 *
	 * @var string
	 */
	protected $_tag;

	/**
	 * Attributes collection / object
	 *
	 * @var Attributes
	 */
	protected $_atts;

	/**
	 * Create a new instance of an element
	 *
	 * @param string $tag
	 * @param array $atts
	 */
	final public function __construct( $tag, $atts = array() ) {
		$this->_tag = (string) $tag;
		$this->_atts = new Attributes( $atts );
	}

	/**
	 * Get node type
	 *
	 * @return string
	 */
	final public function get_type() {
		return 'element';
	}

	/**
	 * Get tag name
	 *
	 * @return string
	 */
	final public function get_tag() {
		return $this->_tag;
	}

	/**
	 * Get attributes collection / object
	 *
	 * @return Attributes
	 */
	final public function get_atts() {
		return $this->_atts;
	}

}