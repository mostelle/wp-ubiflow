<?php

namespace Xmtk; // Yet anoter XML writer (vasily.blinkov@gmail.com)

define('XMTK_DOCTYPE', "<?xml version='1.0'?>");
define('XMTK_INDENT_SIZE', 4);
define('XMTK_INDENTATION', str_repeat(' ', XMTK_INDENT_SIZE));

class Writer {

	private function xmlChild($tag, $array, $level) {
		$xml = $this->xmlFragmentFromArray($array, $level+1);
		return str_repeat(XMTK_INDENTATION, $level).
			"<$tag>".PHP_EOL."$xml".
			str_repeat(XMTK_INDENTATION, $level).
			"</$tag>".
			PHP_EOL;
	} // xmlChild()

	private function xmlCollection($tag, $array, $level) {
		$xml = '';
		foreach ($array as $element):
			$xml .= $this->writeElement($tag, $element, $level);
		endforeach; // collection $element
		return $xml;
	} // xmlCollection()

	private function xmlValue($tag, $value, $level) {
		return str_repeat(XMTK_INDENTATION, $level).
			"<$tag>$value</$tag>".
			PHP_EOL;
	} // xmlValue();

	private function writeElement($tag, $value, $level) {
		if (! is_array($value)): // value
			$xml = $this->xmlValue($tag, $value, $level);
		elseif (count($value) !== 0 && is_numeric(array_keys($value)[0])): // collection
			$xml = $this->xmlCollection($tag, $value, $level);
		else: // child
			$xml = $this->xmlChild($tag, $value, $level);
		endif; // write node
		return $xml;
	} // writeElement()

	private function xmlFragmentFromArray($array, $level) {
		$xml = '';
		foreach (array_keys($array) as $tag):
			$xml .= $this->writeElement($tag, $array[$tag], $level);
		endforeach; // $tag in $array
		return $xml;
	} // xmlFragmentFromArray()

	function xmlWriteFromArray($array) {
		if (! is_array($array)):
			die('\\Xmtk\\Writer: xmlWriteFromArray() expects an array.'.PHP_EOL);
		endif; // invalid argument

		return XMTK_DOCTYPE.PHP_EOL.
			$this->xmlFragmentFromArray($array, 0);
	} // passArrayIntoWriter()

}  // class Writer

?>
