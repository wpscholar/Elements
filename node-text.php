<?php

namespace wpscholar\Elements;

/**
 * Class TextNode
 *
 * @property string $text
 */
class TextNode extends Node {

	/**
	 * Text content
	 *
	 * @var string
	 */
	protected $_text = '';

	/**
	 * Create a new text node instance
	 *
	 * @param string $text
	 */
	public function __construct( $text = '' ) {
		$this->_text = $text;
	}

	/**
	 * Get node type
	 *
	 * @return string
	 */
	final public function get_type() {
		return 'text';
	}

	/**
	 * Get text content
	 *
	 * @return string
	 */
	final public function get_text() {
		return $this->_text;
	}

	/**
	 * Set text content
	 *
	 * @param string $text
	 */
	final protected function set_text( $text ) {
		$this->_text = (string) $text;
	}

	/**
	 * Get text content on output
	 *
	 * @return string
	 */
	final public function __toString() {
		return $this->_text;
	}

}