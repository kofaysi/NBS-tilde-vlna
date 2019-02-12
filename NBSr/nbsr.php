<?php
/**
 * @version   	1.0
 * @package     Joomla
 * @subpackage  System
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters. All rights reserved.
 * @license     GNU GPL v2.0
 */
 
defined('_JEXEC') or die;

class plgButtonNBSr extends JPlugin
{
    public function onDisplay($name)
    {
		$label = $this->params->get('label');
		$jsCode = "
                function removeNBS(editor) { // original function created by effrit
					
					var str = Joomla.editors.instances[editor].getValue();
					const regex = /\&nbsp\;/gi;
					const subst = ' ';

					const result = str.replace(regex, subst);
					Joomla.editors.instances[editor].setValue(result);
                }
				";
				
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($jsCode);
		
        $button = new JObject();
		$button->modal = false;
		$button->class = 'btn';
        $button->text = $label;
        $button->name = 'minus';
		$button->onclick = 'removeNBS(\''.$name.'\');return false;';				$button->link = '#';
        return $button;
    }
}
?>