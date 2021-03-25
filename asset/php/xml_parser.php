<?php

namespace Xmtk; // Yet Another XML Parser (vasily.blinkov@gmail.com)

// If an array has this key, then it is a complex tag, not collection.
define('XMTK_HINT_TAG', Parser::getHintKey('TAG'));
define('XMTK_REGPATTERN_HINT', '/'.Parser::getHintKey('.*').'/');

class Parser {

	private function pushChild(&$parent, $tag, &$child) {
		if (array_key_exists($tag, $parent)):
			if (! is_array($parent[$tag]) ||
			    array_key_exists(XMTK_HINT_TAG, $parent[$tag])):
				if (is_string($parent[$tag])):
				$parent[$tag] = array(
					$parent[$tag]
				);
				else:
				// writing not a value tag
				$parent[$tag] = array(
					// not by reference to prevent recursion
					// just copy the previous XML node
					$parent[$tag]
				);
				endif; // create a collection from tag
			endif; // existing tag was not a collection
			if (is_string($child)):
				$parent[$tag] []= $child;
			else: // the child is a tag
				$parent[$tag] []=& $child;
			endif; // push a sibling into a collection
		else: // not a collection (at least for now)
			if (is_string($child)):
				$parent[$tag] = $child;
			else: // the child is a tag
				$parent[$tag] =& $child;
			endif; // create a child node
		endif; // push sibling or create child
	} // pushChild()

	static function getHintKey($var_key_part) {
		return "__XMTK_HINT__{$var_key_part}__";
	} // getHintKey()

	private function structParseIntoArray($struct_values) {

		if (! is_array($struct_values)):
			die('parse_struct_into_array() requires an array argument.'
				.PHP_EOL);
		endif; // struct values is not an array

		$result = array();
		$current =& $result;
		$path = array(&$current);

		foreach ($struct_values as $tag):

			switch ($tag['type']):
				case 'open':
					$path []= array(XMTK_HINT_TAG => '');
					$child =& $path[sizeof($path)-1];
					$this->pushChild($current,
						$tag['tag'], $child);
					$current =& $child;
				break; // open
				case 'close':
					array_pop($path);
					$current =& $path[count($path)-1];
				break; // close
				case 'complete':
					$this->pushChild($current,
						$tag['tag'], $tag['value']);
				break; // complete
			endswitch; // tag type

		endforeach; // struct item

		return $result;

	} // structParseIntoArray()

	private function removeHints(&$array) {
		// this func. removes all hint items from arr. recursively
		if (! is_array($array)):
			return $array;
		endif; // not an array
		$keys = array_keys($array);
		foreach ($array as $key => $item):
			if (1 === preg_match(XMTK_REGPATTERN_HINT,
				$key)):
				$hint_idx = array_search($key, $keys);
				if (FALSE !== $hint_idx):
					array_splice($array, $hint_idx, 1);
				endif;
			elseif (is_array($item)): // not a hint
				$array[$key] = $this->removeHints($item);
			endif;
		endforeach; // array items
		return $array;
	} // removeHints()

	function xmlParseIntoArray($xml) {

		$p = xml_parser_create();
		xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);
		xml_parse_into_struct($p, $xml, $vals, $index);
		xml_parser_free($p);

		$hinted = $this->structParseIntoArray($vals);
		return $this->removeHints($hinted);

	} // xmlParseIntoArray()

} // class Parser

?>
