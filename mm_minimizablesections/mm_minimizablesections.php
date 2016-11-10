<?php
/**
 * mm_minimizableSections
 * @version 0.2 (2015-05-30)
 * 
 * @desc A widget for ManagerManager plugin that allows one, few or all sections to be minimizable on the document edit page.
 * 
 * @uses ManagerManager plugin 0.6.2.
 * 
 * @param $sections {string_commaSeparated} — The id(s) of the sections this should apply to. Use '*' for apply to all. @required
 * @param $roles {string_commaSeparated} — The roles that the widget is applied to (when this parameter is empty then widget is applied to the all roles). Default: ''.
 * @param $templates {string_commaSeparated} — Id of the templates to which this widget is applied (when this parameter is empty then widget is applied to the all templates). Default: ''.
 * @param $minimizedByDefault {string_commaSeparated} — The id(s) of the sections this should be minimized by default. Default: ''.
 * 
 * @author Sergey Davydov <webmaster@sdcollection.com>
 * 
 * @copyright 2015
 */

function mm_minimizableSections(
	$sections,
	$roles = '',
	$templates = '',
	$minimizedByDefault = ''
){
	if (!useThisRule($roles, $templates)){return;}
	
	global $modx;
	$e = &$modx->Event;
	
	$output = '';
	
	if ($e->name == 'OnDocFormPrerender'){
		$widgetDir = $modx->config['site_url'].'assets/plugins/managermanager/widgets/mm_minimizablesections/';
		
		$output .= includeJsCss($widgetDir.'minimizablesections.css', 'html');
		
		$e->output($output);
	}else if ($e->name == 'OnDocFormRender'){
		$sections = makeArray($sections);
		$minimizedByDefault = makeArray($minimizedByDefault);
		
		$sections = array_map('mm_minimizableSections_prepareSectionHeaderSelector', $sections);
		$minimizedByDefault = array_map('mm_minimizableSections_prepareSectionHeaderSelector', $minimizedByDefault);
		
		$output .= '//---------- mm_minimizableSections :: Begin -----'.PHP_EOL;
		
		$output .= '
$j("'.implode(',', $sections).'", "#documentPane").addClass("minimizable").on("click", function(){
	var $this = $j(this);
	
	$this.next().slideToggle(400, function(){$this.toggleClass("minimized");});
});
$j(".minimizable").filter("'.implode(',', $minimizedByDefault).'").addClass("minimized").next().hide();
';
		
		$output .= '//---------- mm_minimizableSections :: End -----'.PHP_EOL;
		
		$e->output($output);
	}
}

/**
 * mm_minimizableSections_prepareSectionHeaderSelector
 * @version 1.0.1 (2016-11-10)
 * 
 * @param $sectionId {string} — Section name. @required
 * 
 * @return {string}
 */
function mm_minimizableSections_prepareSectionHeaderSelector($sectionId){
	$result = '';
	
	switch ($sectionId){
		case 'access':
			$result = '#sectionAccessHeader';
		break;
		
		case '*':
			$result = '.sectionHeader';
		break;
		
		default:
			$sectionId = prepareSectionId($sectionId);
			
			$result = '#'.$sectionId.'_header';
		break;
	}
	
	return $result;
}
?>
