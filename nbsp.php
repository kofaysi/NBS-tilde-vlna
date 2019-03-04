<?php
/**
 * @version   	1.1
 * @package     Joomla
 * @subpackage  System
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters. All rights reserved.
 * @license     GNU GPL v2.0
 */
 
defined('_JEXEC') or die;

class plgButtonNBSP extends JPlugin
{
    public function onDisplay($name)
    {
		$labela = $this->params->get('labeladd', 'add NBSPs');
		$NBSPafter = $this->params->get('NBSPafter', '');
		$NBSPbefore = $this->params->get('NBSPbefore', '');
		$jsCode = "
function addNBSP(editor) {
	
	var str = Joomla.editors.instances[editor].getValue();
	const regex = /((\>|&nbsp;|\s|[()])([A-Za-z0-9]" . (empty($NBSPafter)? "" : "|") . preg_replace('/\s+/', '|' , preg_quote($NBSPafter, '/')) . "))(?=\s(?![\s]|[^{]*}))/gi;
	const subst = '$1&nbsp;';
	" . (!empty($NBSPbefore)? "
	const strr = str.replace(regex, subst);
	const regexx = /([0-9])\s(?=(" . preg_replace('/\s+/' , '|', preg_quote($NBSPbefore, '/')) . ")(\b|\W))/gi;
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
		
        $buttona = new JObject();
		$buttona->modal = false;
		$buttona->class = 'btn';
        $buttona->text = $labela;
        $buttona->name = 'plus';
		$buttona->onclick = 'addNBSP(\''.$name.'\');return false;';
		$buttona->link = '#';
		
		$labelr = $this->params->get('labelremove');
		$jsCode = "
function removeNBSP(editor) {
	
	var str = Joomla.editors.instances[editor].getValue();
	const regex = /\&nbsp\;/gi;
	const subst = ' ';

	const result = str.replace(regex, subst);
	Joomla.editors.instances[editor].setValue(result);
}
";
				
		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($jsCode);
		
        $buttonr = new JObject();
		$buttonr->modal = false;
		$buttonr->class = 'btn';
        $buttonr->text = $labelr;
        $buttonr->name = 'minus';
		$buttonr->onclick = 'removeNBSP(\''.$name.'\');return false;';
		$buttonr->link = '#';
		return array($buttona, $buttonr);
    }
}
?>