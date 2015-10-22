<?php

namespace wpscholar\Elements;

/**
 * Class EnclosingElement
 *
 * @property string $content
 * @property string $children
 */
class EnclosingElement extends ElementNode {

	/**
	 * Storage for child nodes
	 *
	 * @var array
	 */
	protected $_children = array();

	/**
	 * Prepend a node
	 *
	 * @param Node $node
	 */
	public function prepend( Node $node ) {
		$node->parent = $this;
		array_unshift( $this->_children, $node );
	}

	/**
	 * Append a node
	 *
	 * @param Node $node
	 */
	public function append( Node $node ) {
		$node->parent = $this;
		array_push( $this->_children, $node );
	}

	/**
	 * Remove a node by index
	 *
	 * @param int $index
	 */
	public function remove( $index ) {
		unset( $this->_children[ $index ] );
	}

	/**
	 * Remove all nodes
	 */
	public function removeAll() {
		$this->_children = array();
	}

	/**
	 * Get the element's content
	 *
	 * @return string
	 */
	final public function get_content() {
		return join( PHP_EOL, $this->_children );
	}

	/**
	 * Set element content
	 *
	 * @param Node|string|array $content
	 */
	final public function set_content( $content ) {
		$this->removeAll();
		$nodes = (array) $content;
		foreach ( $nodes as $node ) {
			if ( is_string( $node ) ) {
				$node = new TextNode( $node );
			} else if ( is_array( $node ) ) {
				$node = ElementFactory::buildElement( $node );
			}
			$this->append( $node );
		}
	}

	/**
	 * Get children
	 *
	 * @return array
	 */
	final public function get_children() {
		return $this->_children;
	}

	/**
	 * Set children
	 *
	 * @param Node|string|array $children
	 */
	final public function set_children( $children ) {
		$this->set_content( $children );
	}

	/**
	 * Return element as a string
	 *
	 * @return string
	 */
	final public function __toString() {
		return "<{$this->tag} {$this->atts}>{$this->content}</{$this->tag}>";
	}

}