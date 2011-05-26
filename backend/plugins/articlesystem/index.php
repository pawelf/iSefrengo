<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

if (empty($_AS['db']))
	$_AS['db']='articlesystem';

//Zutritt erlaubt?
if($perm->have_perm('area_plug_'.$_AS['db'])) {

    //Pfad ermitteln
    $_AS['basedir'] = str_replace ('\\', '/', dirname(__FILE__) . '/');

    //CMS Webrequest erstllen
    $_AS['cms_wr'] =& $GLOBALS['sf_factory']->getObject('HTTP', 'WebRequest');

			
    include_once $_AS['basedir'] . 'inc/class.articlesystem.php'; //Basisklasse
    include_once $_AS['basedir'] . 'inc/class.lang.php'; //Sprachobjekt

    //AdoDB initialtisieren
    $adodb =& $GLOBALS['sf_factory']->getObject('DATABASE', 'Ado');

    //Artikelsystem initializieren
    $_AS['article_obj'] = new Articlesystem;
    

    //JS laden
    echo '<script type="text/javascript">
      lng_nothing_found = "'.$_AS['article_obj']->lang->get('nothing_found').'";
      lng_found_error = "'.$_AS['article_obj']->lang->get('found_error').'";
    </script>';
   	echo '<link rel="stylesheet" href="plugins/articlesystem/tpl/standard/css/thickbox.css" type="text/css" />';
   	echo '<link rel="stylesheet" href="plugins/articlesystem/tpl/standard/css/datePicker.css" type="text/css" />';
    echo '<script type="text/javascript" src="plugins/articlesystem/js/articlesystem.js"></script>';
    //Navigation erstellen
    $_AS['article_obj']->getNavigation();


    //Config
    $_AS['config'] = $_AS['article_obj']->default['display'];

    $_AS['subarea'] = $_AS['cms_wr']->getVal('subarea');
    $_AS['action'] = $_AS['cms_wr']->getVal('action');
		if ($_POST['settings']==='Array')
			$_AS['action']='show_settings';
    switch($_AS['subarea'])
    {
#        case 'organizer':
#            if ($perm->have_perm(1, 'area_plug_articlesystem', 0)) {
#                switch($_AS['action'])
#                {
#                    case 'new_organizer':
#                    case 'edit_organizer':
#                    case 'save_organizer':
#                      include_once $_AS['basedir'] . 'inc/inc.edit_organizer.php';
#                      break;
#
#                    //Tabelle anzeigen
#                    default:
#                        include_once $_AS['basedir'] . 'inc/inc.show_organizer.php';
#                      break;
#                }//Ende switch($action)
#            } else {
#                echo "access denied";
#            }
#          break;
#
        case 'category':
            if ($perm->have_perm(1, 'area_plug_'.$_AS['db'], 0)) {


                switch($_AS['action'])
                {
                    case 'show_category':                
                    case 'save_category':
                      include_once $_AS['basedir'] . 'inc/inc.show_category.php';
                      
                      break;

                    $_AS['subarea'] = 'category';
                }//Ende switch($action)
            } else {
                echo "access denied";
            }
          break;
          
        case 'settings':
            if ($perm->have_perm(2, 'area_plug_'.$_AS['db'], 0)) {


                switch($_AS['action'])
                {
                    case 'show_settings':
                    case 'save_settings':
                      include_once $_AS['basedir'] . 'inc/inc.show_settings.php';
                      break;
                    case 'show_article_settings': 
                    case 'save_article_settings':  
                      include_once $_AS['basedir'] . 'inc/inc.show_article_settings.php';
                      break; 
                    case 'show_settings_specialfunctions': 
                    case 'save_settings_specialfunctions':  
                      include_once $_AS['basedir'] . 'inc/inc.show_settings_specialfunctions.php';
                      break; 
                    case 'show_article_element_settings': 
                    case 'save_article_element_settings':  
                      include_once $_AS['basedir'] . 'inc/inc.show_article_element_settings.php';
                      break; 
                    $_AS['subarea'] = 'settings';
                }//Ende switch($action)
            } else {
                echo "access denied";
            }
          break;

        case 'archive':
            switch($_AS['action'])
            {   
                case 'edit_article':
                case 'dupl_article':
                case 'save_article':
                  include_once $_AS['basedir'] . 'inc/inc.edit_article.php';
                  break;

                //Tabelle anzeigen
                default:
                    include_once $_AS['basedir'] . 'inc/inc.show_article.php';
                  break;
            }//Ende switch($action)
            
          break;

        case 'article':
        default:
    
            switch($_AS['action'])
            {
                case 'new_article':    
                case 'edit_article':
                case 'dupl_article':
                case 'save_article':
                  include_once $_AS['basedir'] . 'inc/inc.edit_article.php';
                  break;

                //Tabelle anzeigen
                default:
                    include_once $_AS['basedir'] . 'inc/inc.show_article.php';
                  break;
            }//Ende switch($action)
            
          break;
          
          
        case 'admin':

            case 'show_db_settings': 
            case 'save_db_settings':  
              include_once $_AS['basedir'] . 'inc/inc.show_admin.php';
              break; 

          break;          
          
          
          
    }//Ende switch($subarea)

    unset($_AS, $adodb);

//Kein Zutritt erlaubt
} else {
  echo "access denied";
}

echo '</div>';
?>


