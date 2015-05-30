<?php
/**
 * mm_minimizablesections
 * @version 0.1 (2015-05-30)
 *
 * @desc A widget for ManagerManager plugin that allows one or a few sections to be minimizable on the document edit page.
 *
 * @uses ManagerManager plugin 0.6.2.
 *
 * @param $sections {comma separated string} - The id(s) of the sections this should apply to. @required
 * @param $roles {comma separated string} - The roles that the widget is applied to (when this parameter is empty then widget is applied to the all roles). Default: ''.
 * @param $templates {comma separated string} - Id of the templates to which this widget is applied (when this parameter is empty then widget is applied to the all templates). Default: ''.
 * @param $default {"closed"} - set closed by default
 *
 * @author Sergey Davydov <webmaster@sdcollection.com>
 *
 * @copyright 2015
 */

function mm_minimizablesections($sections, $roles = '', $templates = '',$default = '') {
 if (!useThisRule($roles, $templates)){return;}
 
// if (!in_array($default,explode(",","open,close"))) $default = "open";
 if ($default != "closed") $default = ""; // default is open
 
 global $modx;
 $e = &$modx->Event;
 $site = $modx->config['site_url'];
 $widgetDir = $site.'assets/plugins/managermanager/widgets/mm_minimizablesections/';

 $output='';
 if ($e->name == 'OnDocFormPrerender') {
  $output .= includeJsCss($widgetDir.'minimizablesections.css', 'html');

  $e->output($output);
 } else if ($e->name == 'OnDocFormRender') {
  $sections = makeArray($sections);

  $output .= "//---------- mm_minimizablesections :: Begin -----\n";
  $sectionIDS = array();
  foreach ($sections as $section) {
   switch ($section) {
    case 'access':
     $sectionIDS[] = "#sectionAccessHeader";
     break;
    
    case '*':
     $sectionIDS[] = ".sectionHeader";
     break;
    
    default:
     $section = prepareSectionId($section);
     $sectionIDS[] = "#{$section}_header";

     break;
   }
  }
  $output .= '$j("'.implode(",",$sectionIDS).'","#documentPane").addClass("minimizable").addClass("'.$default.'").on("click",function(){
     var _t = $j(this);
     _t.next().slideToggle(400,function(){_t.toggleClass("closed");})
    });
    $j(".minimizable.closed").next().hide();
  ';

  $output .= "//---------- mm_minimizablesections :: End -----\n";

  $e->output($output);
 }
}

?>