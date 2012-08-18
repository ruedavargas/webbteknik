<?php
/**
 * The interface for all data classes and functions that use that interface
 *
 * @author <gunther@keryx.se>
 * @version "Under construction 1"
 * @license http://www.mozilla.org/MPL/
 * @package webbteknik.nu
 */

/**
 * Data classes
 */
interface data
{
    public function getId();
    public function getName();
    public static function loadOne($id, PDO $dbh);
    public static function loadAll(PDO $dbh);
    // public function save();
    
    /*
     * Constructor must be private
     * 
     * Important that instantiation must come through factory-functions
     * in order to keep invalid data away
     * 
     * However, PHP does not allow private declarations in interface for constructor functions
     * so this must be enforced manually
     */
    // private function __construct();
}

/**
 * A function that makes a select list for HTML from an array of data-objects
 * 
 * @param string $name_id      Used for name and it attributes on the select tag
 * @param array  $list         An array of objects that use the data interface
 * @param string $pre_selected The value that should be set as default (selected attribute)
 * @return string HTML-code
 */
function makeSelectElement($name_id, $list, $pre_selected = '')
{
    $select_elem = "<select name=\"{$name_id}\" id=\"{$name_id}\">\n";
    foreach ( $list as $item ) {
        if ( $item->getId() == $pre_selected ) {
            $selected = ' selected';
        } else {
            $selected = '';
        }
        $select_elem .= '<option value="' . htmlspecialchars($item->getId()) . '"' . "{$selected}>";
        $select_elem .= htmlspecialchars($item->getname());
        $select_elem .= "</option>\n";
    }
    $select_elem .= "</select>\n";
    return $select_elem;
}

/**
 * A function that makes a list of checkboxes for HTML from an array of data-objects
 * 
 * Each checkbox will come before a label element, both wrappen in a paragraph
 * 
 * @param string $name         Used for name attribute on the select tag
 * @param array  $list         An array of objects that use the data interface
 * @return string HTML-code
 */
function makeCheckboxes($name, $list)
{
	$i          = 0;
    $checkboxes = "";
    foreach ( $list as $item ) {
    	// Prepare values
    	$id       = htmlspecialchars($item->getId());
    	$itemname = htmlspecialchars($item->getName());
    	// Make the paragraph
        $checkboxes .= <<<PARA
            <p>
              <input type="checkbox" name="{$name}[]" id="{$name}_{$i}" value="{$id}">
              <label for="{$name}_{$i}">{$itemname}</label>
            </p>
PARA;
         $i++;
    }
    return $checkboxes;
}

