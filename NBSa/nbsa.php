<?php
/**
 * @version   	1.0
 * @package     Joomla
 * @subpackage  System
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters. All rights reserved.
 * @license     GNU GPL v2.0
 */
 
defined('_JEXEC') or die;

class plgButtonNBSa extends JPlugin
{
    public function onDisplay($name)
    {
		$label = $this->params->get('label', 'Custom 1 Text');
		$NBSafter = $this->params->get('NBSafter', '');
		$NBSbefore = $this->params->get('NBSbefore', '');
		$jsCode = "
                function addNBS(editor) { // original function created by effrit
					
					var str = Joomla.editors.instances[editor].getValue();
					const regex = /((\>|&nbsp;|\s|[()])([A-Za-z0-9]" . (empty($NBSafter)? "" : "|") . preg_replace('/\s+/', '|' , preg_quote($NBSafter, '/')) . "))\s(?![\s])/gi; //tychapogoy added &nbsp; parentheses and others to match in the pattern
					const subst = '$1&nbsp;';
					" . (!empty($NBSbefore)? "
					const strr = str.replace(regex, subst);
					const regexx = /([0-9])\s(?=(" . preg_replace('/\s+/' , '|', preg_quote($NBSbefore, '/')) . ")(\b|\W))/gi; // match digit(s) with units
					const substt = '$1&nbsp;';

					const result = strr.replace(regexx, substt);
					" : "
					const result = str.replace(regex, subst);
					") . "
					Joomla.editors.instances[editor].setValue(result);
                }
				";
				
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($jsCode);
		
        $button = new JObject();
		$button->modal = false;
		$button->class = 'btn';
        $button->text = $label;
        $button->name = 'plus';
		$button->onclick = 'addNBS(\''.$name.'\');addNBS(\''.$name.'\');return false;';				$button->link = '#'; //tychapogoy added double run of a function
        return $button;
    }
}
?>