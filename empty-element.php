<?php

namespace wpscholar\Elements;

/**
 * Class EmptyElement
 */
class EmptyElement extends ElementNode {

	/**
	 * Get the element as a string
	 *
	 * @return string
	 */
	final public function __toString() {
		return "<{$this->tag} {$this->atts} />";
	}

}