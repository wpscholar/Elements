<?php

namespace wpscholar\Elements;

/**
 * Class Node
 *
 * @property string $type
 * @property Node $parent
 */
abstract class Node {

	/**
	 * Parent node
	 *
	 * @var Node|null
	 */
	protected $_parent = null;

	/**
	 * Get the node type
	 *
	 * @return string
	 */
	abstract public function get_type();

	/**
	 * Get parent node
	 *
	 * @return Node
	 */
	final public function get_parent() {
		return $this->_parent;
	}

	/**
	 * Set parent node
	 *
	 * @param Node $node
	 */
	final public function set_parent( Node $node ) {
		$this->_parent = $node;
	}

	/**
	 * Magic method for getting properties.
	 *
	 * @param $property
	 *
	 * @return mixed
	 */
	final public function __get( $property ) {
		$value = null;
		$method = 'get_' . $property;
		if ( method_exists( $this, $method ) && is_callable( array( $this, $method ) ) ) {
			$value = call_user_func( array( $this, $method ) );
		}

		return $value;
	}

	/**
	 * Magic method for setting properties.
	 *
	 * @param string $property
	 * @param mixed $value
	 */
	final public function __set( $property, $value ) {
		$method = 'set_' . $property;
		if ( method_exists( $this, $method ) && is_callable( array( $this, $method ) ) ) {
			call_user_func( array( $this, $method ), $value );
		}
	}

	/**
	 * Get node as a string
	 *
	 * @return string
	 */
	abstract public function __toString();

}