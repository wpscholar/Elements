<?php

namespace wpscholar\Elements;

/**
 * Class Attributes
 */
class Attributes implements \IteratorAggregate, \Countable {

	/**
	 * Internal storage for attribute data
	 *
	 * @var array
	 */
	protected $_atts = array();

	/**
	 * Create a new instance
	 *
	 * @param array|string|self $atts
	 */
	public function __construct( $atts = array() ) {
		$this->populate( $atts );
	}

	/**
	 * Checks if attribute exists, or if attribute contains a value
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return bool
	 */
	public function has( $name, $value = '' ) {
		return empty( $value ) ? isset( $this->_atts[ $name ] ) : in_array( $value, $this->get( $name, 'array' ) );
	}

	/**
	 * Get an attribute value
	 *
	 * @param string $name
	 * @param string $format
	 *
	 * @return array|null
	 */
	public function get( $name, $format = 'string' ) {
		$value = null;
		if ( 'array' === $format ) {
			$value = $this->has( $name ) ? explode( ' ', $this->_atts[ $name ] ) : array();
		} else {
			$value = $this->has( $name ) ? $this->_atts[ $name ] : null;
		}

		return $value;
	}

	/**
	 * Sets an attribute
	 *
	 * @param string $name
	 * @param string|array $value
	 */
	public function set( $name, $value ) {
		if ( is_array( $value ) ) {
			$value = join( ' ', array_unique( array_filter( array_map( 'trim', $value ) ) ) );
		}
		$this->_atts[ $name ] = trim( $value );
	}

	/**
	 * Append to an attribute value.
	 *
	 * @param string $name
	 * @param string|array $value
	 */
	public function add( $name, $value ) {
		if ( $this->has( $name ) ) {
			$values = is_array( $value ) ? $value : explode( ' ', $value );
			$this->set( $name, array_merge( $this->get( $name, 'array' ), $values ) );
		} else {
			$this->set( $name, $value );
		}
	}

	/**
	 * Remove an attribute, or value from an attribute
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function remove( $name, $value = '' ) {
		if ( empty( $value ) ) {
			unset( $this->_atts[ $name ] );
		} else if ( $this->has( $name ) ) {
			$parts = $this->get( $name, 'array' );
			$key = array_search( $value, $parts );
			if ( false !== $key ) {
				unset( $parts[ $key ] );
				if ( empty( $parts ) ) {
					unset( $this->_atts[ $name ] );
				} else {
					$this->set( $name, $parts );
				}
			}
		}
	}

	/**
	 * Sets multiple attributes at once
	 *
	 * @param array|string|self $atts
	 */
	public function populate( $atts ) {

		if ( is_string( $atts ) ) {
			$atts = self::parse( $atts );
		} else if ( is_object( $atts ) && is_a( $atts, get_class() ) ) {
			/**
			 * @var self $atts
			 */
			$atts = $atts->toArray();
		}

		foreach ( $atts as $name => $value ) {
			$this->set( $name, $value );
		}
	}

	/**
	 * Parse attribute string
	 *
	 * @param $string
	 *
	 * @return array
	 */
	public static function parse( $string ) {
		$atts = array();
		foreach ( explode( ' ', $string ) as $pair ) {
			list( $name, $value ) = explode( '=', $pair );
			$atts[ $name ] = trim( $value, '\'"' );
		}

		return $atts;
	}

	/**
	 * Get all attributes as an array
	 *
	 * @return array
	 */
	public function toArray() {
		return $this->_atts;
	}

	/**
	 * Get all attributes as a string
	 *
	 * @return string
	 */
	public function toString() {
		$atts = array();
		foreach ( $this->_atts as $name => $value ) {
			$atts[] = "{$name}=\"{$value}\"";
		}

		return join( ' ', $atts );
	}

	/**
	 * Allow for array iteration through attributes
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator() {
		return new \ArrayIterator( $this->_atts );
	}

	/**
	 * Count the number of attributes
	 *
	 * @return int
	 */
	public function count() {
		return count( $this->_atts );
	}

	/**
	 * Get all attributes as a string on output
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->toString();
	}

}