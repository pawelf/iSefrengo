<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}
//Collectionklasse laden
include_once $_AS['basedir'] . 'inc/class.articlecollection.php';
include_once $_AS['basedir'] . 'inc/class.elementcollection.php';
include_once $_AS['basedir'] . 'inc/class.categorycollection.php';
include_once $_AS['basedir'] . 'inc/fnc.articlesystem_utilities.php'; //Basisklasse

//catcol intialisieren
$_AS['current_usergroup']=$perm->get_group();

if ($_AS['article_obj']->getSetting('use_categories_rm')=='true' && $_AS['current_usergroup'][1]>2) {

	$_AS['catcol'] = new CategoryCollection();
	//Eintr&auml;ge laden
	$_AS['catcol']->setGroups((array($_AS['current_usergroup'][1])));
	$_AS['catcol']->generate();
	$_AS['temp']['group_cats']=array();
	for($iter = $_AS['catcol']->get(); $iter->valid(); $iter->next() ) {
		$_AS['item'] =& $iter->current();
		if ($_AS['item']->getDataByKey('idlang')==$lang)
		$_AS['temp']['group_cats'][]=$_AS['item']->getDataByKey('idcategory');
	}
	unset($_AS['catcol']);
}
//Externe Variablen per CMS WebRequest holen
$_AS['idarticle'] = $_AS['cms_wr']->getVal('idarticle');

$_AS['idarticlemem'] = $_AS['cms_wr']->getVal('idarticlemem');
$_AS['onlinemem'] = $_AS['cms_wr']->getVal('onlinemem');

// set custom fields filter

$_AS['temp']['lv_cf']['urladdon']='';
for ($i=1;$i<36;$i++){
	$_AS['temp']['lv_cf']['postdata']=$_AS['cms_wr']->getVal('custom'.$i.'_filter');
	if (trim($_AS['temp']['lv_cf']['postdata'])!='') {
		$_AS['temp']['lv_cf']['urladdon'].='&amp;custom'.$i.'_filter='.urlencode($_AS['temp']['lv_cf']['postdata']);
	}
}






//UPLOAD
include($cfg_cms['cms_path'].'inc/class.filemanager.php');
$fm = &new filemanager();

foreach ($_FILES as $k => $v){
	if (!empty($v['name'][0]) && (strpos($k,'custom')!==false || strpos($k,'file')!==false)) {

		$_AS['upload'][str_replace('_upload','',$k)]['error']=@$fm->upload_file_2($_POST[$k.'_dir'],$client,$k);
		if (!empty($fm->edit_files[0])) {
			$_AS['upload'][str_replace('_upload','',$k)]['file']=$v['name'][0];
			$_AS['upload'][str_replace('_upload','',$k)]['id']=$fm->edit_files[0];
		}
	}
}


$_AS['subarea']=$_AS['cms_wr']->getVal('subarea');;
$_AS['hash'] = $_AS['cms_wr']->getVal('hash');

$_AS['config']['imgpath'] = $cfg_cms['cms_html_path'].'plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/';

$_AS['temp']['startmonth'] = $_AS['cms_wr']->getVal('startmonth');
$_AS['config']['startmonth'] = (empty($_AS['temp']['startmonth'])) ? date("m") : $_AS['temp']['startmonth'];

$_AS['temp']['monthback'] = $_AS['cms_wr']->getVal('monthback');
$_AS['config']['monthback'] = (empty($_AS['temp']['monthback'])) ? $_AS['article_obj']->getSetting('number_of_month') : $_AS['temp']['monthback'];

$_AS['idarticle_langcopy'] = $_AS['cms_wr']->getVal('langcopy');

$_AS['valid']=(empty($_POST['valid'])?'false':$_POST['valid']);


// field validation
$_AS['validation_fields']=array();
$_AS['validation_fields'][]='teaser';
$_AS['validation_fields'][]='text';
for ($i=1;$i<36;$i++)
	$_AS['validation_fields'][]='custom'.$i;
$_AS['valid']='true';
$_AS['validation_errors']=array();

foreach ($_AS['validation_fields'] as $v){
	$_AS['validation_errors'][$v]['text']=array();
	if (($_AS['article_obj']->getSetting('article_'.$v.'_validation')=='true' &&
			 $_AS['article_obj']->getSetting('article_'.$v)=='true') || 
			($_AS['article_obj']->getSetting('article_'.$v.'_validation')=='true' && 
			 $_AS['article_obj']->getSetting('article_'.$v.'_label')!='')) {
#		if (empty($_POST['article'][$v])){
		if (trim($_POST['article'][$v])==''){
			$_AS['valid']='false';
		}
	} else if (strpos($v,'custom')!==false && 
						(($_AS['article_obj']->getSetting('article_'.$v.'_validation')=='regexp' && 
		     			$_AS['article_obj']->getSetting('article_'.$v)=='true') || 
						 ($_AS['article_obj']->getSetting('article_'.$v.'_validation')=='regexp' && 
				 			$_AS['article_obj']->getSetting('article_'.$v.'_label')!=''))) {
			$regexp_arr=explode("\n",$_AS['article_obj']->getSetting('article_'.$v.'_validation_rule_regexp'));
			$regexperrorstr_arr=explode("\n",$_AS['article_obj']->getSetting('article_'.$v.'_validation_rule_text'));
			foreach ($regexp_arr as $kk => $vv) {
				if ( !empty($vv) && 
						(!$_AS['idarticle'] || is_array($_POST['article']) ) &&
						 preg_match(trim($vv),trim($_POST['article'][$v]))==0 && 
						 !empty($regexperrorstr_arr[$kk]) ) {
					$_AS['valid']='false';
					$_AS['validation_errors'][$v]['text'][]=$regexperrorstr_arr[$kk];
				}
			}
		}
	}

if (trim($_POST['article']['title'])=='')
	$_AS['valid']='false';


$_AS['validation_fields']=array();
$_AS['validation_fields'][]='picture1';
$_AS['validation_fields'][]='link';
$_AS['validation_fields'][]='date';
$_AS['validation_fields'][]='file1';

if (is_array($_POST['artel']['image']['value_txt']))
	$_AS['validation_image']=array_filter($_POST['artel']['image']['value_txt']);
if (is_array($_POST['artel']['file']['value_txt']))
	$_AS['validation_file']=array_filter($_POST['artel']['file']['value_txt']);
if (is_array($_POST['artel']['link']['value_txt'])) 
	$_AS['validation_link']=array_filter($_POST['artel']['link']['value_txt']);
if (is_array($_POST['artel']['date']['value_txt'])) 
	$_AS['validation_date']=array_filter($_POST['artel']['date']['value_txt']);
	
$_AS['valid2']=array();	
	
foreach ($_AS['validation_fields'] as $v)
	if ($_AS['article_obj']->getSetting('article_'.$v.'_validation')=='true' &&
			$_AS['article_obj']->getSetting('article_'.$v)=='true' ) {
		if ($v=='picture1' && count($_AS['validation_image'])<1) {
			$_AS['valid']='false';
			$_AS['valid2']['image']=false;
			}	
		if ($v=='file1' && count($_AS['validation_file'])<1) {
			$_AS['valid']='false';
			$_AS['valid2']['file']=false;
			}	
		if ($v=='link' && count($_AS['validation_link'])<1) {
			$_AS['valid']='false';
			$_AS['valid2']['link']=false;
			}	
		if ($v=='date' && count($_AS['validation_date'])<1) {
			$_AS['valid']='false';
			$_AS['valid2']['date']=false;
			}	
		}				
//Tpl einladen
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.article_edit.php';

//Artikel intialisieren
$_AS['item'] = new SingleArticle;

//init article's element
$_AS['elements'] = new ArticleElements;

if (!empty($_AS['idarticle_langcopy'])){
	$_AS['idarticle'] = $_AS['idarticle_langcopy'];
	$_AS['action']='edit_article';
} else
	$_AS['onlinemem']='';
	
//Artikel bearbeiten
if( $_AS['action']=='edit_article' || 
	  $_AS['action']=='dupl_article' || 
	  ($_POST['action']=='save_article' && $_AS['valid']=='false') || 
	  $_AS['cms_wr']->getVal('apply')=='3' ) {

    if (isset($change_show_tree)) {
        echo $_AS['temp']['url'] = $sess->urlRaw($cfg_cms['cms_html_path'].'main.php?area=plugin&lang='.$lang.'&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category'));
      	header ('Location:' . $_AS['temp']['url'] );
      	exit;
    }

#   	$_AS['item']->loadById($_AS['idarticle']);
   
    if (!empty($_AS['idarticle']) && 
    		($_AS['valid']=='true' || $_POST['action']!='save_article') && 
    		$_AS['cms_wr']->getVal('apply')!='3' ) {     

#			$_AS['article'] = $_AS['cms_wr']->getVal('article'); //$_POST-Array
#    	$_AS['item']->loadByData($_AS['article'], true);
	
	   	$_AS['item']->loadById($_AS['idarticle']);

			$_AS['elements']->loadById($_AS['idarticle'], true);

		} else {

			$_AS['article'] = $_AS['cms_wr']->getVal('article'); 
    	$_AS['item']->loadByData($_AS['article'], true);

			$_AS['artel'] = $_AS['cms_wr']->getVal('artel'); 
			$_AS['elements']->loadByData($_AS['artel'], true);
		}

//Artikel speichern
} else if($_POST['action']=='save_article' && $_AS['valid']=='true') {
    //Wenn die Sprache gewechselt wurde, dann hier zur Übersicht, da der Eintrag nur für alte Sprache gilt
    if (isset($change_show_tree)) {
        echo $_AS['temp']['url'] = $sess->urlRaw($cfg_cms['cms_html_path'].'main.php?area=plugin&lang='.$lang.'&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category'));
      	header ('Location:' . $_AS['temp']['url'] );
      	exit;
    }

    $_AS['article'] = $_AS['cms_wr']->getVal('article');
    $_AS['item']->loadByData($_AS['article'], true);

    $_AS['artel'] = $_AS['cms_wr']->getVal('artel'); 
		$_AS['elements']->loadByData($_AS['artel'], true);

    //Bei Bearbeiten: Wenn ID vorhanden -> hinzufügen
    if(is_numeric($_AS['idarticle']) && $_AS['idarticle']>0) {
        $_AS['item']->setData('idarticle', $_AS['idarticle']);
        $_AS['item']->setData('hash', $_AS['hash']);
    } else {
        $_AS['item']->setData('hash', md5(time()));
    }

    $_AS['temp']['article_startdate'] = $_AS['temp']['article_starttime'] = mktime(
                $_AS['article']['article_start_hour'],
                $_AS['article']['article_start_minute'],
                0,
                (($_AS['article']['article_start_month'])?$_AS['article']['article_start_month']:date('m')) ,
                (($_AS['article']['article_start_day'])?$_AS['article']['article_start_day']:date('d')) ,
                (($_AS['article']['article_start_year'])?$_AS['article']['article_start_year']:date('Y')) 
                );

    $_AS['temp']['article_enddate'] = $_AS['temp']['article_endtime'] = mktime(
                ((isset($_AS['article']['article_endtime_yn']))?$_AS['article']['article_end_hour']:23),
                ((isset($_AS['article']['article_endtime_yn']))?$_AS['article']['article_end_minute']:59),
                0,
                $_AS['article']['article_end_month'],
                $_AS['article']['article_end_day'],
                $_AS['article']['article_end_year']);


       	$_AS['item']->setData('article_startdate', $_AS['item']->convTimestamp2Date($_AS['temp']['article_startdate']));

        if(isset($_AS['article']['article_starttime_yn'])) {
            $_AS['item']->setData('article_starttime', $_AS['item']->convTimestamp2Date($_AS['temp']['article_starttime']));
        } else {
        		$_AS['item']->setData('article_starttime', '0000-00-00 00:00:00');
        }
        
        if(isset($_AS['article']['article_enddate_yn'])) {
            $_AS['item']->setData('article_enddate', $_AS['item']->convTimestamp2Date($_AS['temp']['article_enddate']));
        } else {
        		$_AS['item']->setData('article_enddate','0000-00-00 00:00:00');
        }

        if(isset($_AS['article']['article_endtime_yn'])) {
            $_AS['item']->setData('article_endtime', $_AS['item']->convTimestamp2Date($_AS['temp']['article_endtime']));
        } else {
        		$_AS['item']->setData('article_endtime', '0000-00-00 00:00:00');
        }
        //Speichern

        $_AS['item']->save();
        
				if (count($_AS['item']->_new_ids)<2) {
          $_AS['elements']->setData('idarticle',$_AS['item']->getDataByKey('idarticle'), 'global');
          $_AS['elements']->save();  
        } else {
        	foreach ($_AS['item']->_new_ids as $k => $v) {
							$_AS['elements']->loadByData($_AS['artel'], true);
							$_AS['elements']->setData('idlang',$_AS['item']->_new_langs[$k]);
							$_AS['elements']->setData('idclient',$client);
							$_AS['elements']->setData('idarticle',$v, 'global');
	            $_AS['elements']->save();
            }		
        }
                  
#				$_AS['temp']['arteldel']= $_AS['cms_wr']->getVal('arteldel');
#					if (!empty($_AS['temp']['arteldel']))
#						$_AS['elements']->delete( $_AS['cms_wr']->getVal('artelsel'));
            
    //Speichern -> zurück zur Übersicht
      if($_AS['cms_wr']->getVal('apply')==0) {
          $_AS['temp']['url'] = $sess->urlRaw($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['cms_wr']->getVal('callist_search').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['cms_wr']->getVal('sort'));
        	header ('Location:' . $_AS['temp']['url'] );
        	exit;
      } else {
          $_AS['action'] = 'edit_article'; //Aktion nach dem "Übernehmen" auf Bearbeiten setzen
          $_AS['idarticle'] = &$_AS['item']->getDataByKey('idarticle'); //ID nach dem Übernehmen noch holen, falls ein neuer Eintrag übernommen wurde
					$_AS['item']->loadById($_AS['idarticle']);
					$_AS['elements']->loadById($_AS['idarticle'], true);
					
      }
}





//Zur&uuml;ck

$_AS['output']['back']  = str_replace(array(
        '{back}',
        '{back_url}',
        '{back_label}',
    ),
    array(
				'<a class="action" href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['cms_wr']->getVal('callist_search').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback']).'">'.$_AS['article_obj']->lang->get('back').'</a>',
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['cms_wr']->getVal('callist_search').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback']),
        $_AS['article_obj']->lang->get('back')
    ),
    $_AS['tpl']['back']);
//Online?

$_AS['temp']['online']=$_AS['item']->getDataByKey('online');
if ($_AS['onlinemem']==='0' || $_AS['onlinemem']==='1' )
	 $_AS['temp']['online']=$_AS['onlinemem'];
 
$_AS['row']['online'] = str_replace(array(
        '{lng_online}',
        '{lng_online_desc}',
        '{checked}'
    ),
    array(
        $_AS['article_obj']->lang->get('article_online'),
        $_AS['article_obj']->lang->get('article_online_desc'),
        ( $_AS['temp']['online'] == 1 || 
        ((empty($_AS['idarticle']) || $_GET['action']=='dupl_article') && $_AS['article_obj']->getSetting('new_articles_online')=='true')) ? ' checked="checked"' : ''
       
    ),
    $_AS['tpl']['online']);


//Start Artikel
$_AS['row']['article_start'] = str_replace(array(
        '{lng_article_start}',
        '{day}',
        '{month}',
        '{year}',
        '{hour}',
        '{minute}',
        '{starttime_checked}',
        '{path}'
    ),
    array(
        $_AS['article_obj']->lang->get('article_article_start'),
        ($_AS['item']->getDataByKey('article_startdate')==0) ? date("d") : date("d", $_AS['item']->convDate2Timestamp('', 'article_startdate')),
        ($_AS['item']->getDataByKey('article_startdate')==0) ? date("m") : date("m", $_AS['item']->convDate2Timestamp('', 'article_startdate')),
        ($_AS['item']->getDataByKey('article_startdate')==0) ? date("Y") : date("Y", $_AS['item']->convDate2Timestamp('', 'article_startdate')),
        ($_AS['item']->getDataByKey('article_starttime')==0) ? date("H") : date("H", $_AS['item']->convDate2Timestamp('', 'article_starttime')),
        ($_AS['item']->getDataByKey('article_starttime')==0) ? date("i") : date("i", $_AS['item']->convDate2Timestamp('', 'article_starttime')),
        ($_AS['item']->getDataByKey('article_starttime_yn')==1) ? ' checked="checked"' : '',
        $_AS['config']['imgpath']
    ),
    $_AS['tpl']['article_start']);


//End Artikel
$_AS['row']['article_end'] = str_replace(array(
        '{lng_article_end}',
        '{day}',
        '{month}',
        '{year}',
        '{hour}',
        '{minute}',
        '{enddate_checked}',
        '{endtime_checked}',
        '{path}',
        '{error_to_small_enddate}',
        '{error_to_small_endtime}'
    ),
    array(
        $_AS['article_obj']->lang->get('article_article_end'),
        ($_AS['item']->getDataByKey('article_enddate')==0) ? date("d") : date("d", $_AS['item']->convDate2Timestamp('', 'article_enddate')),
        ($_AS['item']->getDataByKey('article_enddate')==0) ? date("m") : date("m", $_AS['item']->convDate2Timestamp('', 'article_enddate')),
        ($_AS['item']->getDataByKey('article_enddate')==0) ? date("Y") : date("Y", $_AS['item']->convDate2Timestamp('', 'article_enddate')),
        ($_AS['item']->getDataByKey('article_endtime')==0) ? date("H") : date("H", $_AS['item']->convDate2Timestamp('', 'article_endtime')),
        ($_AS['item']->getDataByKey('article_endtime')==0) ? date("i") : date("i", $_AS['item']->convDate2Timestamp('', 'article_endtime')),
        ($_AS['item']->getDataByKey('article_enddate_yn')==1) ? ' checked="checked"' : '',
        ($_AS['item']->getDataByKey('article_endtime_yn')==1) ? ' checked="checked"' : '',
        $_AS['config']['imgpath'],
        $_AS['article_obj']->lang->get('article_error_to_small_enddate'),
        $_AS['article_obj']->lang->get('article_error_to_small_endtime')
    ),
    $_AS['tpl']['article_end']);


//Wochentag erstellen
$_AS['select']['weekday'] = '<select id="weekday" name="article[article_weekday]">';
for($i=1;$i<8;$i++) {
    $_AS['temp']['selected'] = ($_AS['item']->getDataByKey('article_weekday') == $i) ? ' selected="selected"' : '';

    $_AS['select']['weekday'] .= '
            <option value="'.$i.'"'.$_AS['temp']['selected'].'>'.$_AS['article_obj']->lang->get('weekday_'.$i).'</option>';
}
$_AS['select']['weekday'] .= '
    </select>';

//Wochentag
$_AS['row']['article_weekday'] = str_replace(array(
        '{lng_article_weekday}',
        '{select_weekday}'
    ),
    array(
        $_AS['article_obj']->lang->get('article_article_weekday'),
        $_AS['select']['weekday']
    ),
    $_AS['tpl']['article_weekday']);

$_AS['temp']['category'] = $_AS['article_obj']->getCategory();
 
if ($_AS['article_obj']->getSetting('set_category')==1 && count($_AS['temp']['category'])>0){ 
	// collect categories data
	$_AS['select']['catdata']=array();
	$_AS['select']['catdata']['']=$_AS['article_obj']->lang->get('article_non_selected_string');
	//$_AS['temp']['selected'] = $_AS['item']->getDataByKey('idcategory');
	foreach($_AS['temp']['category'] as $_AS['temp']['idcategory'] => $_AS['temp']['name'])
	if ((is_array($_AS['temp']['group_cats']) && 
			in_array($_AS['temp']['idcategory'],$_AS['temp']['group_cats'])) ||
			!is_array($_AS['temp']['group_cats']))			
		$_AS['select']['catdata'][$_AS['temp']['idcategory']]=$_AS['temp']['name'];

	if (strpos($_AS['item']->getDataByKey('idcategory'),'|')!==false) {
		$_AS['select']['catselected']=explode('|',$_AS['item']->getDataByKey('idcategory'));
		$_AS['select']['catselected']=array_filter($_AS['select']['catselected']);
	} else
		$_AS['select']['catselected']=$_AS['item']->getDataByKey('idcategory');
	
	if (empty($_AS['select']['catselected']))
		$_AS['select']['catselected']=$_AS['cms_wr']->getVal('callist_flt_category');
		
	if (empty($_AS['select']['catselected']))
		$_AS['select']['catselected']='0';

	if ( count($_AS['select']['catdata'])>1)
		$_AS['row']['category'] = str_replace(array(
		        '{lng_category}',
		        '{select_category}'
		    ),
		    array(
		        $_AS['article_obj']->lang->get('article_category'),
		        $_AS['article_obj']->getSelectUni(	'article[idcategory][]',
																	 $_AS['select']['catselected'],
																	 $_AS['select']['catdata'],
																		'category',
																		'',
																		(($_AS['article_obj']->getSetting('set_category_multiple')==1)?'multiple="multiple" size="5"':''))
		    ),
		    $_AS['tpl']['category']);
}

//Title
$_AS['temp']['value']=$_AS['item']->getDataByKey('title',true);
if ($_AS['action']=='dupl_article')
	$_AS['temp']['value'].=' ('.$_AS['article_obj']->lang->get('article_copy').')';
$_AS['row']['title'] = str_replace(array(
        '{lng_title}',
        '{title}',
        '{validation_error_cssdisplay}',
        '{path}',
        '{error_empty}'
    ),
    array(
        $_AS['article_obj']->lang->get('article_title'),
       	$_AS['temp']['value'],
        ((trim($_AS['temp']['value'])=='')?'inline':'none'),
        $_AS['config']['imgpath'],
        $_AS['article_obj']->lang->get('article_error_empty_field')
    ),
    $_AS['tpl']['title']);

//Teaser
$_AS['temp']['value']=$_AS['item']->getDataByKey('teaser',true);
if ($_AS['article_obj']->getSetting('article_teaser') =="true"){ 
  $_AS['row']['teaser'] = str_replace(array(
          '{lng_teaser}',
          '{teaser}',
          '{validation_error_cssdisplay}',
          '{path}',
          '{error_empty}'
      ),
      array(
          ($_AS['article_obj']->getSetting('article_teaser_label')==''?$_AS['article_obj']->lang->get('article_teaser'):$_AS['article_obj']->getSetting('article_teaser_label')),
         	$_AS['temp']['value'],
          (($_AS['article_obj']->getSetting('article_teaser_validation')=='true' &&
           trim($_AS['temp']['value'])=='')?'inline':'none'),
          $_AS['config']['imgpath'],
          $_AS['article_obj']->lang->get('article_error_empty_field')
      ),
      $_AS['tpl']['teaser']);
}
    
//Text
$_AS['temp']['value']=$_AS['item']->getDataByKey('text',true);
if ($_AS['article_obj']->getSetting('article_text') =="true"){ 
  $_AS['row']['text'] = str_replace(array(
          '{lng_text}',
          '{text}',
          '{validation_error_cssdisplay}',
          '{path}',
          '{error_empty}',
          '{tinymce_class}' 
      ),
      array(
      		($_AS['article_obj']->getSetting('article_text_label')==''?$_AS['article_obj']->lang->get('article_text'):$_AS['article_obj']->getSetting('article_text_label')),
         	$_AS['temp']['value'],
          (($_AS['article_obj']->getSetting('article_text_validation')=='true' &&
           trim($_AS['temp']['value'])=='')?'inline':'none'),
          $_AS['config']['imgpath'],
          $_AS['article_obj']->lang->get('article_error_empty_field'),
          ($_AS['article_obj']->getSetting('wysiwyg')=="true"?'mceEditor ':'')  
      ),
      $_AS['tpl']['text']);
}

//Picture1
if ($_AS['article_obj']->getSetting('article_picture1') =="true"){      
		// generate image list
	$filetypes_s = 'jpg,jpeg,gif,png';
	$filetypes = explode(',', $filetypes_s);
	$folders_s = $_AS['article_obj']->getSetting('picture_select_folders');
	if (!empty($folders_s))
		$folders = explode(',', $folders_s);
	else
		$folders = array();

	// ressource browser init  	
  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
  $res_image = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'FileManager');
  $res_image->setFiletypes($filetypes);
  $res_image->setFolderIds($folders);
  $res_image->setWithSubfoders( $_AS['article_obj']->getSetting('picture_select_subfolders')=="true" ? true : false );
  $res_image->setReturnValueMode('sefrengolink');
  $rb->addRessource($res_image);
  $rb->setJSCallbackFunction('sf_getImage_as', array('picked_name', 'picked_value'));
  $rb_image_url = $rb->exportConfigURL();

  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
  $res_links = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'InternalLink');
  $rb->addRessource($res_links);
  $rb->setJSCallbackFunction('sf_getImageLink_as', array('picked_name', 'picked_value'));
  $rb_link_url = $rb->exportConfigURL();
   	
	$sql = "SELECT iddirectory, parentid, name FROM ".$cms_db['directory']." WHERE idclient=".$client." AND dirname NOT LIKE('cms/%') ORDER BY dirname";
	$db -> query($sql);
	
	$tree = array();
	while($db -> next_record()) {
		if($perm->have_perm(1, 'folder', $db->f('iddirectory'))) {
			$tree[$db->f('parentid')][] = $db->f('iddirectory');
			$folder[$db->f('iddirectory')] = str_replace("'", "\\'", $db->f('name'));
		}
	}

	$allfolders=array();
	foreach($folders as $a){
		$allfolders[]=$a;
		if( $_AS['article_obj']->getSetting('picture_select_subfolders')=='true') {
			if (is_array($tree[$a]))
				foreach($tree[$a] as $b) {
					$allfolders[]=$b;
					if (is_array($tree[$b])) foreach($tree[$b] as $c) $allfolders[]=$c;
				}
		}
	}

	$sql = "SELECT A.idupl idupl, A.filename filename, A.iddirectory iddirectory, A.titel titel, A.pictwidth width, A.pictheight height, B.filetype as filetype, C.dirname as directory FROM ".$cms_db['upl']." AS A, ".$cms_db['filetype']." AS B, ".$cms_db['directory']." AS C WHERE A.idclient=".$client." AND C.idclient=".$client." AND A.idfiletype = B.idfiletype AND B.filetype IN ('".join($filetypes, "','")."') AND C.iddirectory = A.iddirectory ORDER BY directory,filename";
	$db -> query($sql);
	$file_array = array();
	while($db -> next_record()) {
		if($perm->have_perm( 17, 'file', $db->f('idupl'), $db->f('iddirectory'))) {
			if (in_array($db->f('iddirectory'),$allfolders) || empty($folders_s)) {
				$file_array[$db->f('idupl')] = array(
					'name'		=> str_replace("'", "\\'", $db->f('filename')),
					'title'		=> str_replace("'", "\\'", $db->f('titel')),
					'dir'		=> $db->f('directory'), 
					'id'		=> $db->f('idupl')
				);
			}
		}
	}
	
	
	$_AS['temp']['selected'] = $_AS['item']->getDataByKey('picture1');


	$_AS['temp']['values']=$_AS['elements']->getDataByType('image');
	$_AS['temp']['values_number']=count($_AS['temp']['values']['sort_index']);

	if ($_AS['temp']['values_number']<1)
		$_AS['temp']['values_number']=1;

	$_AS['temp']['add_elements']=(int) $_AS['cms_wr']->getVal('picadd');

	$_AS['temp']['elementvalid']=false;
	
	$_AS['temp']['currentelementcount']=$_AS['temp']['values_number']+$_AS['temp']['add_elements'];



	$_AS['temp']['elementmaxno']=$_AS['article_obj']->getSetting('article_picture1_no');
	if (!empty($_AS['temp']['elementmaxno'])) {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');
		$h=1;
		for ($i=$_AS['temp']['currentelementcount'];$i<$_AS['temp']['elementmaxno'];$i++) {
			if ($_AS['temp']['values_number']+$h<=$_AS['temp']['elementmaxno'])
				$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	} else {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');			
		$h=1;
		for ($i=0;$i<4;$i++) {
			$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	}

	if (count($_AS['temp']['values']['add_elements'])>1)
		$_AS['temp']['add_elements_select'] =	
		$_AS['article_obj']->getSelectUni('picadd',
																			'0',
																		 	$_AS['temp']['values']['add_elements'],
																			'',
																			'document.getElementById(\'apply\').value = 3; CheckEventForm(document.getElementById(\'articleform\'));',
																			'style="width:75px;"');
	else
		$_AS['temp']['add_elements_select']='';

	if ($_AS['temp']['currentelementcount']>$_AS['temp']['elementmaxno'] && !empty($_AS['temp']['elementmaxno']))
		$_AS['temp']['currentelementcount']=$_AS['temp']['elementmaxno'];




	for($i=0;$i<$_AS['temp']['currentelementcount'];$i++) {

		if (empty($_AS['temp']['values']['sort_index'][$i])){
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$_AS['temp']['values_number']-1]+$i-$_AS['temp']['values_number']+1;
			if (empty($_AS['temp']['sort_index']))
				$_AS['temp']['sort_index']=1;
		} else 
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$i];

		if (empty($_AS['temp']['values']['idelement'][$i]))
			$_AS['temp']['idelement']='newimage'.$i;
		else
			$_AS['temp']['idelement']=$_AS['temp']['values']['idelement'][$i];


#		$_AS['new_uploaded_file']='';
		$_AS['select']['tempdata']=array();
		$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_non_selected_string');



		if ( count($file_array) <= (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {

			foreach($file_array as $a) {
	
				$imagetitle=$a['dir'].$a['name'];
				$_AS['temp']['image']=str_replace($cfg_client["htmlpath"],'',$cfg_client["upl_htmlpath"]).$a['dir'].$a['name'];
	
#				if (!empty($_AS['upload']['custom'.$i]['id']) && $a['id']==$_AS['upload']['custom'.$i]['id'])
#					$_AS['new_uploaded_picture']=$_AS['temp']['image'];
	
				$_AS['select']['tempdata'][$_AS['temp']['image']]=addslashes($imagetitle);
			}
			
		} else { 
			if ( count($file_array) > (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {
				$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_settings_max_number_use_rb');
			
#				if(empty($_AS['upload']['custom'.$i]['id'])) {
					if (!empty($_AS['temp']['values']['value_txt'][$i]))
						$_AS['select']['tempdata'][$_AS['temp']['values']['value_txt'][$i]]=addslashes($_AS['temp']['values']['value_txt'][$i]);
#				} else {
#					$_AS['new_uploaded_picture']=str_replace($cfg_client["htmlpath"],
#																								'',
#																								$cfg_client["upl_htmlpath"]).
#																								$file_array[$_AS['upload']['custom'.$i]['id']]['dir'].
#																								$file_array[$_AS['upload']['custom'.$i]['id']]['name'];
#				
#					$_AS['select']['tempdata'][$_AS['new_uploaded_picture']]=addslashes($_AS['new_uploaded_picture']);
#	
#				}
			}
		}
















    $_AS['temp']['row']['picture1sub'] .= str_replace(array(
    				'{idelement}',
    				'{idel}',
            '{select_picture1}',
            '{picture1_uni}',
						'{sort_index}',
            '{path}',
            '{selected_picture1}',
            '{htmlpath}',
            '{thumb_ext}',
            '{rb_image_url}',
            '{rb_link_url}',
            '{ic}',
            '{lng_picture1_description}',
            '{lng_picture1_title}',
            '{lng_picture}',
            '{lng_picture_link}',
            '{lng_sort_index_input_title}',
            '{picture1_description}',
            '{picture1_title}',
            '{showhide_desc}',
            '{showhide_link}',
            '{showhide_checkbox}'
        ),
        array(

        		$_AS['temp']['idelement'],
        		$_AS['temp']['values']['idelement'][$i],
						$_AS['article_obj']->getSelectUni(	'artel[image][value_txt][]',
																								 $_AS['temp']['values']['value_txt'][$i],
																								 $_AS['select']['tempdata'],
																									'picture'.$_AS['temp']['idelement'],
																									'previewpicture(this.value,\''.$cfg_client["htmlpath"].'\',\''.$cfg_client["thumbext"].'\',\''.$_AS['temp']['idelement'].'\');return false;',
																									'style="width:303px;"'),
						$_AS['temp']['values']['value_uni'][$i],																			
						$_AS['temp']['sort_index'],
            $_AS['config']['imgpath'],
						$_AS['temp']['values']['value_txt'][$i],
						$cfg_client['htmlpath'],
						$cfg_client["thumbext"],
						$rb_image_url,
						$rb_link_url,
            $i+1,
            $_AS['article_obj']->lang->get('article_picture1_description'),
            $_AS['article_obj']->lang->get('article_picture1_title'),
            $_AS['article_obj']->lang->get('article_picture'),
            $_AS['article_obj']->lang->get('article_picture_link'),
            $_AS['article_obj']->lang->get('sort_index_input_title'),
           	htmlentities($_AS['temp']['values']['description'][$i],ENT_COMPAT,'UTF-8'),
           	htmlentities($_AS['temp']['values']['title'][$i],ENT_COMPAT,'UTF-8'),	            
            (($_AS['article_obj']->getSetting('article_picture1_desc')=='true')?'inline':'none'),
            (($_AS['article_obj']->getSetting('article_picture1_link')=='true')?'':'none'),
            ((!empty($_AS['temp']['values']['idelement'][$i]))?'inline':'none')
        ),
        $_AS['tpl']['picture1sub']);
			
			if (!empty($_AS['temp']['values']['value_txt'][$i]))
				$_AS['temp']['elementvalid']=true;

	}

	if ($_AS['valid2']['image']===false)
		$_AS['temp']['elementvalid']=false;


  $_AS['row']['picture1'] = str_replace(array(
  				'{lng_pictures}',
          '{lng_elements_sel}',
          '{lng_elements_del}',
          '{validation_error_cssdisplay}',
          '{error_empty}',
  				'{picture1sub}',
          '{path}',
   				'{add_elements}'
      ),
      array(
          ($_AS['article_obj']->getSetting('article_picture1_label')==''?$_AS['article_obj']->lang->get('article_pictures'):$_AS['article_obj']->getSetting('article_picture1_label')),
          $_AS['article_obj']->lang->get('article_elements_sel'),
          $_AS['article_obj']->lang->get('article_elements_del'),
					(($_AS['article_obj']->getSetting('article_picture1_validation')=='true' &&
          $_AS['temp']['elementvalid']===false)?'inline':'none'),
          $_AS['article_obj']->lang->get('article_error_empty_field'),
          $_AS['temp']['row']['picture1sub'],
          $_AS['config']['imgpath'],
					$_AS['temp']['add_elements_select']
      ),
      $_AS['tpl']['picture1']);
}

//link
if ($_AS['article_obj']->getSetting('article_link') =="true"){      

  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
  $res_links = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'InternalLink');
 	$res_links->setCatIds(explode(',',$_AS['article_obj']->getSetting('link_select_idcats')));
	$res_links->setWithSubcats(($_AS['article_obj']->getSetting('link_select_subcats')!='false'?true:false));
	$res_links->setShowStartpages(($_AS['article_obj']->getSetting('link_select_startpages')!='false'?true:false));
	$res_links->setShowPages(($_AS['article_obj']->getSetting('link_select_showpages')!='false'?true:false));
	$res_links->setCatsAreChosable(($_AS['article_obj']->getSetting('link_select_choosecats')!='false'?true:false));
  $rb->addRessource($res_links);
  $rb->setJSCallbackFunction('sf_getLink_as', array('picked_name', 'picked_value'));
  $rb_link_url = $rb->exportConfigURL();
        
	$_AS['temp']['values']=$_AS['elements']->getDataByType('link');
	$_AS['temp']['values_number']=count($_AS['temp']['values']['sort_index']);

	if ($_AS['temp']['values_number']<1)
		$_AS['temp']['values_number']=1;

	$_AS['temp']['add_elements']=(int) $_AS['cms_wr']->getVal('linkadd');

	$_AS['temp']['elementvalid']=false;

	$_AS['temp']['currentelementcount']=$_AS['temp']['values_number']+$_AS['temp']['add_elements'];



	$_AS['temp']['elementmaxno']=$_AS['article_obj']->getSetting('article_link_no');
	if (!empty($_AS['temp']['elementmaxno'])) {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');
		$h=1;
		for ($i=$_AS['temp']['currentelementcount'];$i<$_AS['temp']['elementmaxno'];$i++) {
			if ($_AS['temp']['values_number']+$h<=$_AS['temp']['elementmaxno'])
				$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	} else {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');			
		$h=1;
		for ($i=0;$i<4;$i++) {
			$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	}

	if (count($_AS['temp']['values']['add_elements'])>1)
		$_AS['temp']['add_elements_select'] =	
		$_AS['article_obj']->getSelectUni('linkadd',
																			'0',
																		 	$_AS['temp']['values']['add_elements'],
																			'',
																			'document.getElementById(\'apply\').value = 3; CheckEventForm(document.getElementById(\'articleform\'));',
																			'style="width:75px;"');
	else
		$_AS['temp']['add_elements_select']='';

	if ($_AS['temp']['currentelementcount']>$_AS['temp']['elementmaxno'] && !empty($_AS['temp']['elementmaxno']))
		$_AS['temp']['currentelementcount']=$_AS['temp']['elementmaxno'];




	for($i=0;$i<$_AS['temp']['currentelementcount'];$i++) {

		if (empty($_AS['temp']['values']['sort_index'][$i])){
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$_AS['temp']['values_number']-1]+$i-$_AS['temp']['values_number']+1;
			if (empty($_AS['temp']['sort_index']))
				$_AS['temp']['sort_index']=1;
		} else 
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$i];

		if (empty($_AS['temp']['values']['idelement'][$i]))
			$_AS['temp']['idelement']='newlink'.$i;
		else
			$_AS['temp']['idelement']=$_AS['temp']['values']['idelement'][$i];

    $_AS['temp']['row']['linksub'] .= str_replace(array(
    				'{idelement}',
    				'{idel}',
						'{sort_index}',
            '{path}',
						'{link_txt}',
            '{htmlpath}',
            '{rb_link_url}',
            '{ic}',
            '{lng_link_description}',
            '{lng_link_title}',
            '{lng_link_url}',
            '{lng_sort_index_input_title}',
            '{link_description}',
            '{link_title}',
            '{showhide_desc}',
            '{showhide_checkbox}'
        ),
        array(
        		$_AS['temp']['idelement'],
        		$_AS['temp']['values']['idelement'][$i],
						$_AS['temp']['sort_index'],
            $_AS['config']['imgpath'],
						$_AS['temp']['values']['value_txt'][$i],
						$cfg_client['htmlpath'],
						$rb_link_url,
            $i+1,
            $_AS['article_obj']->lang->get('article_link_description'),
            $_AS['article_obj']->lang->get('article_link_title'),
            $_AS['article_obj']->lang->get('article_link_url'),
            $_AS['article_obj']->lang->get('sort_index_input_title'),
            htmlentities($_AS['temp']['values']['description'][$i],ENT_COMPAT,'UTF-8'),
           	htmlentities($_AS['temp']['values']['title'][$i],ENT_COMPAT,'UTF-8'),
            (($_AS['article_obj']->getSetting('article_link_desc')=='true')?'inline':'none'),
            ((!empty($_AS['temp']['values']['idelement'][$i]))?'inline':'none')
        ),
        $_AS['tpl']['linksub']);
			
			if (!empty($_AS['temp']['values']['value_txt'][$i]))
				$_AS['temp']['elementvalid']=true;

	}

	if ($_AS['valid2']['link']===false)
		$_AS['temp']['elementvalid']=false;
	
  $_AS['row']['link'] = str_replace(array(
  				'{lng_link}',
          '{lng_elements_sel}',
          '{lng_elements_del}',
          '{lng_add}',
          '{validation_error_cssdisplay}',
          '{error_empty}',
  				'{linksub}',
          '{path}',
          '{add_elements}'
      ),
      array(
          ($_AS['article_obj']->getSetting('article_link_label')==''?$_AS['article_obj']->lang->get('article_links'):$_AS['article_obj']->getSetting('article_link_label')),
          $_AS['article_obj']->lang->get('article_elements_sel'),
          $_AS['article_obj']->lang->get('article_elements_del'),
          $_AS['article_obj']->lang->get('add'),
					(($_AS['article_obj']->getSetting('article_link_validation')=='true' &&
          $_AS['temp']['elementvalid']===false)?'inline':'none'),
          $_AS['article_obj']->lang->get('article_error_empty_field'),
          $_AS['temp']['row']['linksub'],
          $_AS['config']['imgpath'],
          $_AS['temp']['add_elements_select']
      ),
      $_AS['tpl']['link']);	        

}

//file1
if ($_AS['article_obj']->getSetting('article_file1') =="true"){      

	$filetypes_s = $_AS['article_obj']->getSetting('file_select_filetypes');
	if (!empty($filetypes_s))
		$filetypes = explode(',', $filetypes_s);
	else {
			$sql = "SELECT filetype, description FROM ". $cms_db['filetype'] ." ORDER BY description, filetype";		          
			$db->query($sql);
			while ($db->next_record())
				$filetypes[] = $db->f('filetype');
	}
	$folders_s = $_AS['article_obj']->getSetting('file_select_folders');
	if (!empty($folders_s))
		$folders = explode(',', $folders_s);
	else
		$folders = array();

  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
  $res_file = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'FileManager');

  $res_file->setFiletypes($filetypes);
  $res_file->setFolderIds($folders);
  $res_file->setWithSubfoders( $_AS['article_obj']->getSetting('file_select_subfolders')=="true" ? true : false );
  $res_file->setReturnValueMode('sefrengolink');
  $rb->addRessource($res_file);
	//$res_links =&$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'InternalLink');
	//$rb->addRessource($res_links);
  $rb->setJSCallbackFunction('sf_getFile_as', array('picked_name', 'picked_value'));
  $rb_file_url = $rb->exportConfigURL();

	$sql = "SELECT iddirectory, parentid, name FROM ".$cms_db['directory']." WHERE idclient=".$client." AND dirname NOT LIKE('cms/%') ORDER BY dirname";
	$db -> query($sql);
	
	$tree = array();
	while($db -> next_record()) {
		if($perm->have_perm(1, 'folder', $db->f('iddirectory'))) {
			$tree[$db->f('parentid')][] = $db->f('iddirectory');
			$folder[$db->f('iddirectory')] = str_replace("'", "\\'", $db->f('name'));
		}
	}

	$allfolders=array();
	foreach($folders as $a){
		$allfolders[]=$a;
		if( $_AS['article_obj']->getSetting('file_select_subfolders')=='true') {
			if (is_array($tree[$a]))
				foreach($tree[$a] as $b) {
					$allfolders[]=$b;
					if (is_array($tree[$b])) foreach($tree[$b] as $c) $allfolders[]=$c;
				}
		}
	}
	
	$sql = "SELECT A.idupl idupl, A.filename filename, A.iddirectory iddirectory, A.titel titel, A.pictwidth width, A.pictheight height, B.filetype as filetype, C.dirname as directory FROM ".$cms_db['upl']." AS A, ".$cms_db['filetype']." AS B, ".$cms_db['directory']." AS C WHERE A.idclient=".$client." AND C.idclient=".$client." AND A.idfiletype = B.idfiletype AND B.filetype IN ('".join($filetypes, "','")."') AND C.iddirectory = A.iddirectory ORDER BY directory,filename";
	$db -> query($sql);
	$file_array = array();
	while($db -> next_record()) {
		if($perm->have_perm( 17, 'file', $db->f('idupl'), $db->f('iddirectory'))) {
			if (in_array($db->f('iddirectory'),$allfolders) || empty($folders_s)) {
				$file_array[$db->f('idupl')] = array(
					'name'		=> str_replace("'", "\\'", $db->f('filename')),
					'title'		=> str_replace("'", "\\'", $db->f('titel')),
					'dir'		=> $db->f('directory'), 
					'id'		=> $db->f('idupl')
				);
			}
		}
	}
	

	$_AS['temp']['selected'] = $_AS['item']->getDataByKey('file1');
	
 
	$_AS['temp']['values']=$_AS['elements']->getDataByType('file');
	$_AS['temp']['values_number']=count($_AS['temp']['values']['sort_index']);

	if ($_AS['temp']['values_number']<1)
		$_AS['temp']['values_number']=1;

	$_AS['temp']['add_elements']=(int) $_AS['cms_wr']->getVal('fileadd');

	$_AS['temp']['elementvalid']=false;

	$_AS['temp']['currentelementcount']=$_AS['temp']['values_number']+$_AS['temp']['add_elements'];



	$_AS['temp']['elementmaxno']=$_AS['article_obj']->getSetting('article_file1_no');
	if (!empty($_AS['temp']['elementmaxno'])) {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');
		$h=1;
		for ($i=$_AS['temp']['currentelementcount'];$i<$_AS['temp']['elementmaxno'];$i++) {
			if ($_AS['temp']['values_number']+$h<=$_AS['temp']['elementmaxno'])
				$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	} else {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');			
		$h=1;
		for ($i=0;$i<4;$i++) {
			$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	}

	if (count($_AS['temp']['values']['add_elements'])>1)
		$_AS['temp']['add_elements_select'] =	
		$_AS['article_obj']->getSelectUni('fileadd',
																			'0',
																		 	$_AS['temp']['values']['add_elements'],
																			'',
																			'document.getElementById(\'apply\').value = 3; CheckEventForm(document.getElementById(\'articleform\'));',
																			'style="width:75px;"');
	else
		$_AS['temp']['add_elements_select']='';

	if ($_AS['temp']['currentelementcount']>$_AS['temp']['elementmaxno'] && !empty($_AS['temp']['elementmaxno']))
		$_AS['temp']['currentelementcount']=$_AS['temp']['elementmaxno'];
		
		
		
		
	for($i=0;$i<$_AS['temp']['currentelementcount'];$i++) {


		if (empty($_AS['temp']['values']['sort_index'][$i])){
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$_AS['temp']['values_number']-1]+$i-$_AS['temp']['values_number']+1;
			if (empty($_AS['temp']['sort_index']))
				$_AS['temp']['sort_index']=1;
		} else 
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$i];

		if (empty($_AS['temp']['values']['idelement'][$i]))
			$_AS['temp']['idelement']='newfile'.$i;
		else
			$_AS['temp']['idelement']=$_AS['temp']['values']['idelement'][$i];

	
		$_AS['new_uploaded_file']='';
		$_AS['select']['tempdata']=array();
		$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_non_selected_string');


		if ( count($file_array) <= (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {

			foreach($file_array as $a) {
	
				$filetitle=$a['dir'].$a['name'];
				$_AS['temp']['file']=str_replace($cfg_client["htmlpath"],'',$cfg_client["upl_htmlpath"]).$a['dir'].$a['name'];
	
				if (!empty($_AS['upload']['file'.$_AS['temp']['idelement']]['id']) &&
					$a['id']==$_AS['upload']['file'.$_AS['temp']['idelement']]['id']) 
						$_AS['new_uploaded_file']=$_AS['temp']['file'];
	
				$_AS['select']['tempdata'][$_AS['temp']['file']]=addslashes($filetitle);
			}
			
		}  else {

			if ( count($file_array) > (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {

				$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_settings_max_number_use_rb');
			
				if (empty($_AS['upload']['file'.$_AS['temp']['idelement']]['id'])) {
					if (!empty($_AS['temp']['values']['value_txt'][$i]))
						$_AS['select']['tempdata'][$_AS['temp']['values']['value_txt'][$i]]=addslashes($_AS['temp']['values']['value_txt'][$i]);
				} else {
					$_AS['new_uploaded_file']=str_replace($cfg_client["htmlpath"],
																								'',
																								$cfg_client["upl_htmlpath"]).
																								$file_array[$_AS['upload']['file'.$_AS['temp']['idelement']]['id']]['dir'].
																								$file_array[$_AS['upload']['file'.$_AS['temp']['idelement']]['id']]['name'];
				
					$_AS['select']['tempdata'][$_AS['new_uploaded_file']]=addslashes($_AS['new_uploaded_file']);
	
				}
			}
		}
		
		// upload	 
		$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
		$db->query($sql);
		
		$_AS['temp']['tempdata_upload']=array();
		$_AS['temp']['tempdata_upload_folders_s']=$_AS['article_obj']->getSetting('article_file_upload_folders');
		$_AS['temp']['tempdata_upload_folders']=explode(',',$_AS['temp']['tempdata_upload_folders_s']);
		while ($db->next_record())
			if (in_array($db->f('iddirectory'),$_AS['temp']['tempdata_upload_folders']) ||
					(empty($_AS['temp']['tempdata_upload_folders_s']) && in_array($db->f('iddirectory'),$folders)) ||
					(empty($_AS['temp']['tempdata_upload_folders_s']) && empty($folders_s)) )
				$_AS['temp']['tempdata_upload'][$db->f('iddirectory')]=addslashes($db->f('dirname'));
		

    $_AS['temp']['row']['file1sub'] .= str_replace(array(
    				'{idelement}',
    				'{idel}',
            '{select_file1}',
						'{sort_index}',
            '{path}',
            '{selected_file1}',
            '{htmlpath}',
            '{rb_file_url}',
            '{ic}',
            '{lng_file1_description}',
            '{lng_file1_title}',
            '{lng_file}',
            '{lng_sort_index_input_title}',
            '{file1_description}',
            '{file1_title}',
            '{showhide_desc}',
            '{showhide_checkbox}',
	          '{showhide_upload}',
	          '{lng_file_upload}',
	          '{select_file_upload_folder}'
        ),
        array(
        		$_AS['temp']['idelement'],
        		$_AS['temp']['values']['idelement'][$i],
						$_AS['article_obj']->getSelectUni(	'artel[file][value_txt][]',
																								 (empty($_AS['upload']['file'.$_AS['temp']['idelement']]['id'])?
																								  $_AS['temp']['values']['value_txt'][$i]:
																								  $_AS['new_uploaded_file']),																								 
																								 	$_AS['select']['tempdata'],
																									'file'.$_AS['temp']['idelement'],
																									'previewfile(this.value,\''.$cfg_client["htmlpath"].'\',\''.$_AS['temp']['values']['title'][$i].'\',\''.$_AS['temp']['idelement'].'\');return false;',
																									'style="width:303px;"'),
						$_AS['temp']['sort_index'],
            $_AS['config']['imgpath'],
						(empty($_AS['upload']['file'.$_AS['temp']['idelement']]['id'])?
							$_AS['temp']['values']['value_txt'][$i]:
							$_AS['new_uploaded_file']),
						$cfg_client['htmlpath'],
						$rb_file_url,
            $i+1,
            $_AS['article_obj']->lang->get('article_file1_description'),
            $_AS['article_obj']->lang->get('article_file1_title'),
            $_AS['article_obj']->lang->get('article_file'),
            $_AS['article_obj']->lang->get('sort_index_input_title'),
           	htmlentities($_AS['temp']['values']['description'][$i],ENT_COMPAT,'UTF-8'),
           	htmlentities($_AS['temp']['values']['title'][$i],ENT_COMPAT,'UTF-8'),
            (($_AS['article_obj']->getSetting('article_file1_desc')=='true')?'inline':'none'),
            ((!empty($_AS['temp']['values']['idelement'][$i]))?'inline':'none'),
	          (($_AS['article_obj']->getSetting('article_file_upload')=='true')?'table-row':''),
	          $_AS['article_obj']->lang->get('article_file_upload'),
						$_AS['article_obj']->getSelectUni(	'file'.$_AS['temp']['idelement'].'_upload_dir',
																								 $_POST['file'.$_AS['temp']['idelement'].'_upload_dir'],
																								 $_AS['temp']['tempdata_upload'],
																									'',
																									'',
																									'style="width:303px;"')
        ),
        $_AS['tpl']['file1sub']);
			
			if (!empty($_AS['temp']['values']['value_txt'][$i]))
				$_AS['temp']['elementvalid']=true;

	}

	if ($_AS['valid2']['file']===false)
		$_AS['temp']['elementvalid']=false;
	
  $_AS['row']['file1'] = str_replace(array(
  				'{lng_files}',
          '{lng_elements_sel}',
          '{lng_elements_del}',
          '{lng_add}',
          '{validation_error_cssdisplay}',
          '{error_empty}',
  				'{file1sub}',
          '{path}',
          '{add_elements}'
      ),
      array(
          ($_AS['article_obj']->getSetting('article_file1_label')==''?$_AS['article_obj']->lang->get('article_files'):$_AS['article_obj']->getSetting('article_file1_label')),
          $_AS['article_obj']->lang->get('article_elements_sel'),
          $_AS['article_obj']->lang->get('article_elements_del'),
          $_AS['article_obj']->lang->get('add'),
					(($_AS['article_obj']->getSetting('article_file1_validation')=='true' &&
          $_AS['temp']['elementvalid']===false)?'inline':'none'),
          $_AS['article_obj']->lang->get('article_error_empty_field'),
          $_AS['temp']['row']['file1sub'],
          $_AS['config']['imgpath'],
          $_AS['temp']['add_elements_select']
      ),
      $_AS['tpl']['file1']);	        
      
        
}





//date
if ($_AS['article_obj']->getSetting('article_date') =="true"){      

	$_AS['temp']['values']=$_AS['elements']->getDataByType('date');
	$_AS['temp']['values_number']=count($_AS['temp']['values']['sort_index']);

	if ($_AS['temp']['values_number']<1)
		$_AS['temp']['values_number']=1;

	$_AS['temp']['add_elements']=(int) $_AS['cms_wr']->getVal('dateadd');

	$_AS['temp']['elementvalid']=false;

	$_AS['temp']['currentelementcount']=$_AS['temp']['values_number']+$_AS['temp']['add_elements'];



	$_AS['temp']['elementmaxno']=$_AS['article_obj']->getSetting('article_date_no');
	if (!empty($_AS['temp']['elementmaxno'])) {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');
		$h=1;
		for ($i=$_AS['temp']['currentelementcount'];$i<$_AS['temp']['elementmaxno'];$i++) {
			if ($_AS['temp']['values_number']+$h<=$_AS['temp']['elementmaxno'])
				$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	} else {
		$_AS['temp']['values']['add_elements']=array();
		$_AS['temp']['values']['add_elements'][0]=$_AS['article_obj']->lang->get('add');			
		$h=1;
		for ($i=0;$i<4;$i++) {
			$_AS['temp']['values']['add_elements'][$h]='+'.$h;
			$h=$h*2;
		}
	}

	if (count($_AS['temp']['values']['add_elements'])>1)
		$_AS['temp']['add_elements_select'] =	
		$_AS['article_obj']->getSelectUni('dateadd',
																			'0',
																		 	$_AS['temp']['values']['add_elements'],
																			'',
																			'document.getElementById(\'apply\').value = 3; CheckEventForm(document.getElementById(\'articleform\'));',
																			'style="width:75px;"');
	else
		$_AS['temp']['add_elements_select']='';

	if ($_AS['temp']['currentelementcount']>$_AS['temp']['elementmaxno'] && !empty($_AS['temp']['elementmaxno']))
		$_AS['temp']['currentelementcount']=$_AS['temp']['elementmaxno'];



	for($i=0;$i<$_AS['temp']['currentelementcount'];$i++) {

		if (empty($_AS['temp']['values']['sort_index'][$i])){
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$_AS['temp']['values_number']-1]+$i-$_AS['temp']['values_number']+1;
			if (empty($_AS['temp']['sort_index']))
				$_AS['temp']['sort_index']=1;
		} else 
			$_AS['temp']['sort_index']=$_AS['temp']['values']['sort_index'][$i];

		if (empty($_AS['temp']['values']['idelement'][$i]))
			$_AS['temp']['idelement']='newdate'.$i;
		else
			$_AS['temp']['idelement']=$_AS['temp']['values']['idelement'][$i];


		$_AS['temp']['value_date']=explode(' ',$_AS['temp']['values']['value_txt'][$i]);
	  $_AS['temp']['date_splited']=explode('-',$_AS['temp']['value_date'][0]);
	  $_AS['temp']['time_splited']=explode(':',$_AS['temp']['value_date'][1]);

    $_AS['temp']['row']['datesub'] .= str_replace(array(
    				'{idelement}',
    				'{idel}',
						'{sort_index}',
            '{path}',
						'{date_txt}',
            '{htmlpath}',
            '{ic}',
            '{lng_date_description}',
            '{lng_date_title}',
            '{lng_date_url}',
            '{lng_date_date}',
            '{lng_date_time}',
            '{lng_date_duration}',
            '{lng_sort_index_input_title}',
            '{date_description}',
            '{date_title}',
            '{showhide_desc}',
            '{showhide_time}',
            '{showhide_duration}',
            '{showhide_checkbox}',
            '{date}',
            '{date_date}',
            '{date_day}',
            '{date_month}',
            '{date_year}',
            '{date_time}',
            '{date_minute}',
            '{date_hour}',
            '{date_duration}'
        ),
        array(
        		$_AS['temp']['idelement'],
        		$_AS['temp']['values']['idelement'][$i],
						$_AS['temp']['sort_index'],
            $_AS['config']['imgpath'],
						$_AS['temp']['values']['value_txt'][$i],
						$cfg_client['htmlpath'],
            $i+1,
            $_AS['article_obj']->lang->get('article_date_description'),
            $_AS['article_obj']->lang->get('article_date_title'),
            $_AS['article_obj']->lang->get('article_date_url'),
            $_AS['article_obj']->lang->get('article_date_date'),
            $_AS['article_obj']->lang->get('article_date_time'),
            $_AS['article_obj']->lang->get('article_date_duration'),
            $_AS['article_obj']->lang->get('sort_index_input_title'),
            htmlentities($_AS['temp']['values']['description'][$i],ENT_COMPAT,'UTF-8'),
           	htmlentities($_AS['temp']['values']['title'][$i],ENT_COMPAT,'UTF-8'),
            (($_AS['article_obj']->getSetting('article_date_desc')=='true')?'inline':'none'),
            (($_AS['article_obj']->getSetting('article_date_time')=='true')?'inline':'none'),
            (($_AS['article_obj']->getSetting('article_date_duration')=='true')?'inline':'none'),
            ((!empty($_AS['temp']['values']['idelement'][$i]))?'inline':'none'),
            $_AS['temp']['values']['value_txt'][$i],
            ((empty($_AS['temp']['value']))?'0000-00-00':$_AS['temp']['value']),
            ((empty($_AS['temp']['date_splited'][2]))?'':sprintf ("%02d",(int) $_AS['temp']['date_splited'][2])) ,
            ((empty($_AS['temp']['date_splited'][1]))?'':sprintf ("%02d",(int) $_AS['temp']['date_splited'][1])),
            ((empty($_AS['temp']['date_splited'][0]))?'':sprintf ("%04d",(int) $_AS['temp']['date_splited'][0])),
            ((empty($_AS['temp']['value']))?'00:00':$_AS['temp']['value']),
            ((empty($_AS['temp']['time_splited'][1]))?'':sprintf ("%02d",(int) $_AS['temp']['time_splited'][1])),
            ((empty($_AS['temp']['time_splited'][0]))?'':sprintf ("%02d",(int) $_AS['temp']['time_splited'][0])),
            $_AS['temp']['values']['value_uni'][$i],

        ),
        $_AS['tpl']['datesub']);
			
			if (!empty($_AS['temp']['values']['value_txt'][$i]))
				$_AS['temp']['elementvalid']=true;

	}

	if ($_AS['valid2']['date']===false)
		$_AS['temp']['elementvalid']=false;
	
  $_AS['row']['date'] = str_replace(array(
  				'{lng_date}',
          '{lng_elements_sel}',
          '{lng_elements_del}',
          '{lng_add}',
          '{validation_error_cssdisplay}',
          '{error_empty}',
  				'{datesub}',
          '{path}',
          '{add_elements}'
      ),
      array(
          ($_AS['article_obj']->getSetting('article_date_label')==''?$_AS['article_obj']->lang->get('article_dates'):$_AS['article_obj']->getSetting('article_date_label')),
          $_AS['article_obj']->lang->get('article_elements_sel'),
          $_AS['article_obj']->lang->get('article_elements_del'),
          $_AS['article_obj']->lang->get('add'),
					(($_AS['article_obj']->getSetting('article_date_validation')=='true' &&
          $_AS['temp']['elementvalid']===false)?'inline':'none'),
          $_AS['article_obj']->lang->get('article_error_empty_field'),
          $_AS['temp']['row']['datesub'],
          $_AS['config']['imgpath'],
          $_AS['temp']['add_elements_select']
      ),
      $_AS['tpl']['date']);	        

}



//custom
for ($i=1;$i<36;$i++){
	if ( $_AS['article_obj']->getSetting('article_custom'.$i.'_label')) {

		$_AS['temp']['value']=$_AS['item']->getDataByKey('custom'.$i,true);

		if ($_AS['action']=='dupl_article' && $_AS['article_obj']->getSetting('article_custom'.$i.'_vmode')=='defcopy') {
			$_AS['temp']['value'] = $_AS['article_obj']->getSetting('article_custom'.$i.'_value');
			$_AS['temp']['vmode'] = $_AS['article_obj']->getSetting('article_custom'.$i.'_vmode');
		}
			
	 // text
	 if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='pic') {
	
	// generate image list
		$filetypes_s = 'jpg,jpeg,gif,png';
		$filetypes = explode(',', $filetypes_s);
		$folders_s = $_AS['article_obj']->getSetting('article_custom'.$i.'_picture_select_folders');
		if (!empty($folders_s))
			$folders = explode(',', $folders_s);
		else
			$folders = array();		
	
		// ressource browser init  	
	  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
	  $res_image = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'FileManager');
	  $res_image->setFiletypes($filetypes);
	  $res_image->setFolderIds($folders);
	  $res_image->setWithSubfoders( $_AS['article_obj']->getSetting('article_custom'.$i.'_picture_select_subfolders')=="true" ? true : false );
	  $res_image->setReturnValueMode('sefrengolink');
	  $rb->addRessource($res_image);
	  $rb->setJSCallbackFunction('sf_getImage_as', array('picked_name', 'picked_value'));
	  $rb_image_url = $rb->exportConfigURL();
	
	  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
	  $res_links = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'InternalLink');
	  $rb->addRessource($res_links);
	  $rb->setJSCallbackFunction('sf_getImageLink_as', array('picked_name', 'picked_value'));
	  $rb_link_url = $rb->exportConfigURL();
	   	
		$sql = "SELECT iddirectory, parentid, name FROM ".$cms_db['directory']." WHERE idclient=".$client." AND dirname NOT LIKE('cms/%') ORDER BY dirname";
		$db -> query($sql);
	
		
		$tree = array();
		while($db -> next_record()) {
			if($perm->have_perm(1, 'folder', $db->f('iddirectory'))) {
				$tree[$db->f('parentid')][] = $db->f('iddirectory');
				$folder[$db->f('iddirectory')] = str_replace("'", "\\'", $db->f('name'));
			}
		}		
	
		$allfolders=array();
		foreach($folders as $a){
			$allfolders[]=$a;
			if( $_AS['article_obj']->getSetting('article_custom'.$i.'_picture_select_subfolders')=='true') {
				if (is_array($tree[$a]))
					foreach($tree[$a] as $b) {
						$allfolders[]=$b;
						if (is_array($tree[$b])) foreach($tree[$b] as $c) $allfolders[]=$c;
					}
			}
		}		
	
		$sql = "SELECT A.idupl idupl, A.filename filename, A.iddirectory iddirectory, A.titel titel, A.pictwidth width, A.pictheight height, B.filetype as filetype, C.dirname as directory FROM ".$cms_db['upl']." AS A, ".$cms_db['filetype']." AS B, ".$cms_db['directory']." AS C WHERE A.idclient=".$client." AND C.idclient=".$client." AND A.idfiletype = B.idfiletype AND B.filetype IN ('".join($filetypes, "','")."') AND C.iddirectory = A.iddirectory ORDER BY directory,filename";
		$db -> query($sql);
		$file_array = array();
		while($db -> next_record()) {
			if($perm->have_perm( 17, 'file', $db->f('idupl'), $db->f('iddirectory'))) {
				if (in_array($db->f('iddirectory'),$allfolders) || empty($folders_s)) {
					$file_array[$db->f('idupl')] = array(
						'name'=> str_replace("'", "\\'", $db->f('filename')),
						'title'=> str_replace("'", "\\'", $db->f('titel')),
						'dir'=> $db->f('directory'), 
						'id'		=> $db->f('idupl')
					);
				}
			}
		}
		
	
		$_AS['select']['tempdata']=array();
		$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_non_selected_string');		
		$_AS['new_uploaded_picture']='';

		$_AS['temp']['value_arr']=explode("\n",$_AS['temp']['value']);
		$_AS['temp']['values']['value_txt'][$i]=trim($_AS['temp']['value_arr'][0]);//url
		$_AS['temp']['values']['title'][$i]=trim($_AS['temp']['value_arr'][1]);
		$_AS['temp']['values']['value_uni'][$i]=trim($_AS['temp']['value_arr'][2]);//link
		$_AS['temp']['value_arr'][0]='';
		$_AS['temp']['value_arr'][1]='';
		$_AS['temp']['value_arr'][2]='';
		$_AS['temp']['values']['description'][$i]=trim(implode("\n",$_AS['temp']['value_arr']));		



		if ( count($file_array) <= (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {

			foreach($file_array as $a) {
	
				$imagetitle=$a['dir'].$a['name'];
				$_AS['temp']['image']=str_replace($cfg_client["htmlpath"],'',$cfg_client["upl_htmlpath"]).$a['dir'].$a['name'];
	
				if (!empty($_AS['upload']['custom'.$i]['id']) && $a['id']==$_AS['upload']['custom'.$i]['id'])
					$_AS['new_uploaded_picture']=$_AS['temp']['image'];
	
				$_AS['select']['tempdata'][$_AS['temp']['image']]=addslashes($imagetitle);
			}
			
		} else {

			if ( count($file_array) > (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {
				$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_settings_max_number_use_rb');
			
				if(empty($_AS['upload']['custom'.$i]['id'])) {
					if (!empty($_AS['temp']['values']['value_txt'][$i]))
						$_AS['select']['tempdata'][$_AS['temp']['values']['value_txt'][$i]]=addslashes($_AS['temp']['values']['value_txt'][$i]);
				} else {
					$_AS['new_uploaded_picture']=str_replace($cfg_client["htmlpath"],
																								'',
																								$cfg_client["upl_htmlpath"]).
																								$file_array[$_AS['upload']['custom'.$i]['id']]['dir'].
																								$file_array[$_AS['upload']['custom'.$i]['id']]['name'];
				
					$_AS['select']['tempdata'][$_AS['new_uploaded_picture']]=addslashes($_AS['new_uploaded_picture']);
	
				}
			}
		}


		// upload	 
		$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
		$db->query($sql);

		$_AS['temp']['tempdata_upload']=array();
		$_AS['temp']['tempdata_upload_folders_s']=$_AS['article_obj']->getSetting('article_custom'.$i.'_picture_upload_folders');
		$_AS['temp']['tempdata_upload_folders']=explode(',',$_AS['temp']['tempdata_upload_folders_s']);
		while ($db->next_record())
			if (in_array($db->f('iddirectory'),$_AS['temp']['tempdata_upload_folders']) ||
					(empty($_AS['temp']['tempdata_upload_folders_s']) && in_array($db->f('iddirectory'),$folders)) ||
					(empty($_AS['temp']['tempdata_upload_folders_s']) && empty($folders_s)) )
				$_AS['temp']['tempdata_upload'][$db->f('iddirectory')]=addslashes($db->f('dirname'));
		
					 

		$_AS['temp']['row']['custom'.$i] = str_replace(array(
		            '{custom_field_raw_value}',
								'{custom_field}',
								'{idelement}',
								'{idel}',
								'{select_picture1}',
								'{custom_field_link}',
								'{sort_index}',
								'{path}',
								'{selected_picture1}',
								'{htmlpath}',
								'{thumb_ext}',
								'{rb_image_url}',
								'{rb_link_url}',
								'{ic}',
								'{lng_picture1_description}',
								'{lng_picture1_title}',
								'{lng_picture}',
								'{lng_picture_link}',
								'{lng_sort_index_input_title}',
								'{custom_field_desc_value}',
								'{custom_field_title_value}',
								'{showhide_desc}',
								'{showhide_link}',
								'{showhide_checkbox}',
			          '{showhide_upload}',
			          '{lng_picture_upload}',
			          '{select_picture_upload_folder}'
								),
								array(
								$_AS['temp']['value'],
								'custom'.$i,
								'c'.$i,
								$_AS['temp']['values']['idelement'][$i],
								$_AS['article_obj']->getSelectUni('article[custom'.$i.'_value]',
																									(empty($_AS['upload']['custom'.$i]['id'])?
																								  $_AS['temp']['values']['value_txt'][$i]:$_AS['new_uploaded_picture']),
																									$_AS['select']['tempdata'],
																									'picture'.'c'.$i,
																									'previewpicture(this.value,\''.$cfg_client["htmlpath"].'\',\''.$cfg_client["thumbext"].'\',\''.'c'.$i.'\');set_custom_pic(\'custom'.$i.'\',\'c'.$i.'\');return false;',
																									'style="width:303px;"'),
								$_AS['temp']['values']['value_uni'][$i],	
								$_AS['temp']['sort_index'],
								$_AS['config']['imgpath'],
								(empty($_AS['upload']['custom'.$i]['id'])?
							  $_AS['temp']['values']['value_txt'][$i]:$_AS['new_uploaded_picture']),
								$cfg_client['htmlpath'],
								$cfg_client["thumbext"],
								$rb_image_url,
								$rb_link_url,
								$i+1,
								$_AS['article_obj']->lang->get('article_picture1_description'),
								$_AS['article_obj']->lang->get('article_picture1_title'),
								$_AS['article_obj']->lang->get('article_picture'),
								$_AS['article_obj']->lang->get('article_picture_link'),
								$_AS['article_obj']->lang->get('sort_index_input_title'),
								htmlentities($_AS['temp']['values']['description'][$i],ENT_COMPAT,'UTF-8'),
								htmlentities($_AS['temp']['values']['title'][$i],ENT_COMPAT,'UTF-8'),	            
								(($_AS['article_obj']->getSetting('article_custom'.$i.'_picture1_desc')=='true')?'inline':'none'),
								(($_AS['article_obj']->getSetting('article_custom'.$i.'_picture1_link')=='true')?'':'none'),
								((!empty($_AS['temp']['values']['idelement'][$i]))?'inline':'none'),
			          (($_AS['article_obj']->getSetting('article_custom'.$i.'_picture_upload')=='true')?'table-row':'none'),
			          $_AS['article_obj']->lang->get('article_picture_upload'),
								$_AS['article_obj']->getSelectUni(	'custom'.$i.'_upload_dir',
																										 $_POST['custom'.$i.'_upload_dir'],
																										 $_AS['temp']['tempdata_upload'],
																											'',
																											'',
																											'style="width:303px;"'),
							),
							$_AS['tpl']['custom_picture_sub']);
		
			if (!empty($_AS['temp']['values']['value_txt'][$i]))
				$_AS['temp']['elementvalid']=true;
	
			$_AS['row']['custom'.$i] = str_replace(array(
							'{lng_pictures}',
							'{lng_elements_sel}',
							'{lng_elements_del}',
							'{validation_error_cssdisplay}',
							'{error_empty}',
							'{picture1sub}',
							'{path}',
							'{add_elements}'
						),
						array(
							$_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
							$_AS['article_obj']->lang->get('article_elements_sel'),
							$_AS['article_obj']->lang->get('article_elements_del'),
	          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
							$_AS['article_obj']->lang->get('article_error_empty_field'),
							$_AS['temp']['row']['custom'.$i],
							$_AS['config']['imgpath'],
							$_AS['temp']['add_elements_select']
						),
						$_AS['tpl']['custom_picture']);
						
	}    
	
	// link
  if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='link') {
	
	  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
	  $res_links = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'InternalLink');
	 	$res_links->setCatIds(explode(',',$_AS['article_obj']->getSetting('article_custom'.$i.'_link_select_idcats')));
		$res_links->setWithSubcats(($_AS['article_obj']->getSetting('article_custom'.$i.'_link_select_subcats')!='false'?true:false));
		$res_links->setShowStartpages(($_AS['article_obj']->getSetting('article_custom'.$i.'_link_select_startpages')!='false'?true:false));
		$res_links->setShowPages(($_AS['article_obj']->getSetting('article_custom'.$i.'_link_select_showpages')!='false'?true:false));
		$res_links->setCatsAreChosable(($_AS['article_obj']->getSetting('article_custom'.$i.'_link_select_choosecats')!='false'?true:false));
	  $rb->addRessource($res_links);
	  $rb->setJSCallbackFunction('sf_getLink_as', array('picked_name', 'picked_value'));
	  $rb_link_url = $rb->exportConfigURL();
	        
		$_AS['temp']['values']=$_AS['elements']->getDataByType('link');
	
		$_AS['temp']['value_arr']=explode("\n",$_AS['temp']['value']);
		$_AS['temp']['values']['value_txt'][$i]=trim($_AS['temp']['value_arr'][0]);//url
		$_AS['temp']['values']['title'][$i]=trim($_AS['temp']['value_arr'][1]);
	
		$_AS['temp']['value_arr'][0]='';
		$_AS['temp']['value_arr'][1]='';
		$_AS['temp']['values']['description'][$i]=trim(implode("\n",$_AS['temp']['value_arr']));
	
    $_AS['temp']['row']['custom'.$i] = str_replace(array(
						'{custom_field}',
    				'{idelement}',
            '{path}',
						'{link_txt}',
            '{htmlpath}',
            '{rb_link_url}',
            '{ic}',
            '{lng_link_description}',
            '{lng_link_title}',
            '{lng_link_url}',
            '{lng_sort_index_input_title}',
            '{link_description}',
            '{link_title}',
            '{showhide_title}',
            '{showhide_desc}',
            '{showhide_checkbox}'
        ),
        array(
						'custom'.$i,
        		'c'.$i,
            $_AS['config']['imgpath'],
						$_AS['temp']['values']['value_txt'][$i],
						$cfg_client['htmlpath'],
						$rb_link_url,
            $i+1,
            $_AS['article_obj']->lang->get('article_link_description'),
            $_AS['article_obj']->lang->get('article_link_title'),
            $_AS['article_obj']->lang->get('article_link_url'),
            $_AS['article_obj']->lang->get('sort_index_input_title'),
            htmlentities($_AS['temp']['values']['description'][$i],ENT_COMPAT,'UTF-8'),
           	htmlentities($_AS['temp']['values']['title'][$i],ENT_COMPAT,'UTF-8'),
            (($_AS['article_obj']->getSetting('article_custom'.$i.'_link_show_title_input')=='true')?'inline':'none'),
            (($_AS['article_obj']->getSetting('article_custom'.$i.'_link_desc')=='true')?'inline':'none'),
            ((!empty($_AS['temp']['values']['idelement'][$i]))?'inline':'none')
        ),
        $_AS['tpl']['custom_link_sub']);
			
			if (!empty($_AS['temp']['values']['value_txt'][$i]))
				$_AS['temp']['elementvalid']=true;

	
	
	    $_AS['row']['custom'.$i] = str_replace(array(
	    				'{lng_link}',
	            '{lng_elements_sel}',
	            '{lng_elements_del}',
	            '{lng_add}',
	            '{validation_error_cssdisplay}',
	            '{error_empty}',
	    				'{linksub}',
	            '{path}',
	            '{add_elements}'
	        ),
	        array(
	            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
	            $_AS['article_obj']->lang->get('article_elements_sel'),
	            $_AS['article_obj']->lang->get('article_elements_del'),
	            $_AS['article_obj']->lang->get('add'),
	          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
	          	  empty($_AS['temp']['value'])) ||
	          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
	          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
	            $_AS['article_obj']->lang->get('article_error_empty_field'),
	            $_AS['temp']['row']['custom'.$i],
	            $_AS['config']['imgpath'],
	            $_AS['temp']['add_elements_select']
	        ),
	        $_AS['tpl']['custom_link']);	        
	

   }    
   
	// file   
	if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='file') {
	
	        
		$filetypes_s = $_AS['article_obj']->getSetting('article_custom'.$i.'_file_select_filetypes');
		if (!empty($filetypes_s))
			$filetypes = explode(',', $filetypes_s);
		else {
				$sql = "SELECT filetype, description FROM ". $cms_db['filetype'] ." ORDER BY description, filetype";		          
				$db->query($sql);
				while ($db->next_record())
					$filetypes[] = $db->f('filetype');
		}
		$folders_s = $_AS['article_obj']->getSetting('article_custom'.$i.'_file_select_folders');
		if (!empty($folders_s))
			$folders = explode(',', $folders_s);
		else
			$folders = array();
	
	  $rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
	  $res_file = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'FileManager');
	
	  $res_file->setFiletypes($filetypes);
	  $res_file->setFolderIds($folders);
	  $res_file->setWithSubfoders( $_AS['article_obj']->getSetting('article_custom'.$i.'_file_select_subfolders')=="true" ? true : false );
	  $res_file->setReturnValueMode('sefrengolink');
	  $rb->addRessource($res_file);
	  $rb->setJSCallbackFunction('sf_getFile_as', array('picked_name', 'picked_value'));
	  $rb_file_url = $rb->exportConfigURL();
	
		$sql = "SELECT iddirectory, parentid, name FROM ".$cms_db['directory']." WHERE idclient=".$client." AND dirname NOT LIKE('cms/%') ORDER BY dirname";
		$db -> query($sql);
		
		$tree = array();
		while($db -> next_record()) {
			if($perm->have_perm(1, 'folder', $db->f('iddirectory'))) {
				$tree[$db->f('parentid')][] = $db->f('iddirectory');
				$folder[$db->f('iddirectory')] = str_replace("'", "\\'", $db->f('name'));
			}
		}

		$allfolders=array();
		foreach($folders as $a){
			$allfolders[]=$a;
			if( $_AS['article_obj']->getSetting('article_custom'.$i.'_file_select_subfolders')=='true') {
				if (is_array($tree[$a]))
					foreach($tree[$a] as $b) {
						$allfolders[]=$b;
						if (is_array($tree[$b])) foreach($tree[$b] as $c) $allfolders[]=$c;
					}
			}
		}

		$sql = "SELECT A.idupl idupl, A.filename filename, A.iddirectory iddirectory, A.titel titel, A.pictwidth width, A.pictheight height, B.filetype as filetype, C.dirname as directory FROM ".$cms_db['upl']." AS A, ".$cms_db['filetype']." AS B, ".$cms_db['directory']." AS C WHERE A.idclient=".$client." AND C.idclient=".$client." AND A.idfiletype = B.idfiletype AND B.filetype IN ('".join($filetypes, "','")."') AND C.iddirectory = A.iddirectory ORDER BY directory,filename";
		$db -> query($sql);
		$file_array = array();
		while($db -> next_record()) {
			if($perm->have_perm( 17, 'file', $db->f('idupl'), $db->f('iddirectory'))) {
				if (in_array($db->f('iddirectory'),$allfolders) || empty($folders_s)) {
					$file_array[$db->f('idupl')] = array(
						'name'		=> str_replace("'", "\\'", $db->f('filename')),
						'title'		=> str_replace("'", "\\'", $db->f('titel')),
						'dir'		=> $db->f('directory'), 
						'id'		=> $db->f('idupl'),
					);
				}
			}
		}
		

		$_AS['temp']['selected'] = $_AS['item']->getDataByKey('file1');
		
		$_AS['select']['tempdata']=array();
		$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_non_selected_string');
		$_AS['new_uploaded_file']='';

		$_AS['temp']['value_arr']=explode("\n",$_AS['temp']['value']);
		$_AS['temp']['values']['value_txt'][$i]=trim($_AS['temp']['value_arr'][0]);//url
		$_AS['temp']['values']['title'][$i]=trim($_AS['temp']['value_arr'][1]);
	
		$_AS['temp']['value_arr'][0]='';
		$_AS['temp']['value_arr'][1]='';
		$_AS['temp']['values']['description'][$i]=trim(implode("\n",$_AS['temp']['value_arr']));


		if ( count($file_array) <= (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {

			foreach($file_array as $a) {
	
				$filetitle=$a['dir'].$a['name'];
				$_AS['temp']['file']=str_replace($cfg_client["htmlpath"],'',$cfg_client["upl_htmlpath"]).$a['dir'].$a['name'];
	
				if (!empty($_AS['upload']['custom'.$i]['id']) && $a['id']==$_AS['upload']['custom'.$i]['id'])
					$_AS['new_uploaded_file']=$_AS['temp']['file'];
	
				$_AS['select']['tempdata'][$_AS['temp']['file']]=addslashes($filetitle);
			}
			
		} else {

			if ( count($file_array) > (int) $_AS['article_obj']->getSetting('max_number_files_select') ) {
				$_AS['select']['tempdata']['']=$_AS['article_obj']->lang->get('article_settings_max_number_use_rb');
			
				if(empty($_AS['upload']['custom'.$i]['id'])) {
					if (!empty($_AS['temp']['values']['value_txt'][$i]))
						$_AS['select']['tempdata'][$_AS['temp']['values']['value_txt'][$i]]=addslashes($_AS['temp']['values']['value_txt'][$i]);
				} else {
					$_AS['new_uploaded_file']=str_replace($cfg_client["htmlpath"],
																								'',
																								$cfg_client["upl_htmlpath"]).
																								$file_array[$_AS['upload']['custom'.$i]['id']]['dir'].
																								$file_array[$_AS['upload']['custom'.$i]['id']]['name'];
				
					$_AS['select']['tempdata'][$_AS['new_uploaded_file']]=addslashes($_AS['new_uploaded_file']);
	
				}
			}
		}

		// upload	 
		$sql = "SELECT iddirectory, dirname FROM ".$cms_db['directory']." WHERE status < 4 AND idclient='$client' ORDER BY dirname";
		$db->query($sql);
		
		$_AS['temp']['tempdata_upload']=array();
		$_AS['temp']['tempdata_upload_folders_s']=$_AS['article_obj']->getSetting('article_custom'.$i.'_file_upload_folders');
		$_AS['temp']['tempdata_upload_folders']=explode(',',$_AS['temp']['tempdata_upload_folders_s']);
		while ($db->next_record())
			if (in_array($db->f('iddirectory'),$_AS['temp']['tempdata_upload_folders']) ||
					(empty($_AS['temp']['tempdata_upload_folders_s']) && in_array($db->f('iddirectory'),$folders)) ||
					(empty($_AS['temp']['tempdata_upload_folders_s']) && empty($folders_s)) )
				$_AS['temp']['tempdata_upload'][$db->f('iddirectory')]=addslashes($db->f('dirname'));
		
	

	  $_AS['temp']['row']['custom'.$i] = str_replace(array(
						'{custom_field}',
	  				'{idelement}',
	          '{select_file1}',
	          '{path}',
	          '{selected_file1}',
	          '{htmlpath}',
	          '{rb_file_url}',
	          '{ic}',
	          '{lng_file1_description}',
	          '{lng_file1_title}',
	          '{lng_file}',
	          '{lng_sort_index_input_title}',
	          '{file1_description}',
	          '{file1_title}',
	          '{showhide_desc}',
	          '{showhide_checkbox}',
	          '{showhide_upload}',
	          '{lng_file_upload}',
	          '{select_file_upload_folder}'
	      ),
	      array(
						'custom'.$i,
	      		'c'.$i,
						$_AS['article_obj']->getSelectUni(	'article[custom'.$i.'_value]',
																								 (empty($_AS['upload']['custom'.$i]['id'])?
																								  $_AS['temp']['values']['value_txt'][$i]:
																								  $_AS['new_uploaded_file']),
																								  $_AS['select']['tempdata'],
																									'file'.'c'.$i,
																									'previewfile(this.value,\''.$cfg_client["htmlpath"].'\',\''.$_AS['temp']['values']['title'][$i].'\',\''.'c'.$i.'\');set_custom_file(\'custom'.$i.'\',\'c'.$i.'\');return false;',
																									'style="width:303px;"'),
	          $_AS['config']['imgpath'],
						(empty($_AS['upload']['custom'.$i]['id'])?
						$_AS['temp']['values']['value_txt'][$i]:
						$_AS['new_uploaded_file']),
						$cfg_client['htmlpath'],
						$rb_file_url,
	          $i+1,
	          $_AS['article_obj']->lang->get('article_file1_description'),
	          $_AS['article_obj']->lang->get('article_file1_title'),
	          $_AS['article_obj']->lang->get('article_file'),
	          $_AS['article_obj']->lang->get('sort_index_input_title'),
	         	htmlentities($_AS['temp']['values']['description'][$i],ENT_COMPAT,'UTF-8'),
	         	htmlentities($_AS['temp']['values']['title'][$i],ENT_COMPAT,'UTF-8'),
	          (($_AS['article_obj']->getSetting('article_custom'.$i.'_file1_desc')=='true')?'inline':'none'),
	          ((!empty($_AS['temp']['values']['idelement'][$i]))?'inline':'none'),
	          (($_AS['article_obj']->getSetting('article_custom'.$i.'_file_upload')=='true')?'table-row':'none'),
	          $_AS['article_obj']->lang->get('article_file_upload'),
						$_AS['article_obj']->getSelectUni(	'custom'.$i.'_upload_dir',
																								 $_POST['custom'.$i.'_upload_dir'],
																								 $_AS['temp']['tempdata_upload'],
																									'',
																									'',
																									'style="width:303px;"')
	      ),
	      $_AS['tpl']['custom_file_sub']);
			
			if (!empty($_AS['temp']['values']['value_txt'][$i]))
				$_AS['temp']['elementvalid']=true;
	
	
	
	  $_AS['row']['custom'.$i]  = str_replace(array(
	  				'{lng_files}',
	          '{lng_elements_sel}',
	          '{lng_elements_del}',
	          '{lng_add}',
	          '{validation_error_cssdisplay}',
	          '{error_empty}',
	  				'{file1sub}',
	          '{path}',
	          '{add_elements}'
	      ),
	      array(
	          $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
	          $_AS['article_obj']->lang->get('article_elements_sel'),
	          $_AS['article_obj']->lang->get('article_elements_del'),
	          $_AS['article_obj']->lang->get('add'),
          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
	          $_AS['article_obj']->lang->get('article_error_empty_field'),
	          $_AS['temp']['row']['custom'.$i],
	          $_AS['config']['imgpath'],
	          $_AS['temp']['add_elements_select']
	      ),
	      $_AS['tpl']['custom_file']);	        
	    
        
  } 

	 // text
	 if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='text')
    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{custom'.$i.'}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}',
          	'{readonly}'
        ),
        array(
            trim(str_replace('[readonly]','',$_AS['article_obj']->getSetting('article_custom'.$i.'_label'))),
            ((empty($_AS['idarticle']) && empty($_AS['temp']['value'])) || $_AS['temp']['vmode']=='defcopy') ? $_AS['article_obj']->getSetting('article_custom'.$i.'_value'):$_AS['temp']['value'],
          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field'),
          	(strpos($_AS['article_obj']->getSetting('article_custom'.$i.'_label'),'[readonly]')!==false)?'readonly="readonly"':''
        ),
        $_AS['tpl']['custom'.$i]);
   // textarea
	 if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='textarea' || $_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='wysiwyg')
    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{custom'.$i.'}',
            '{validation_error_cssdisplay}',
            '{wysiwyg}',
            '{path}',
         		'{error_empty}',
          	'{readonly}'
             
        ),
        array(
            trim(str_replace('[readonly]','',$_AS['article_obj']->getSetting('article_custom'.$i.'_label'))),
           ((empty($_AS['idarticle']) && empty($_AS['temp']['value'])) || $_AS['temp']['vmode']=='defcopy') ? $_AS['article_obj']->getSetting('article_custom'.$i.'_value'):$_AS['temp']['value'],
          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
            (($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='wysiwyg')?'class="mceEditor w800"':''),
          	$_AS['config']['imgpath'],
         		$_AS['article_obj']->lang->get('article_error_empty_field'),
          	(strpos($_AS['article_obj']->getSetting('article_custom'.$i.'_label'),'[readonly]')!==false)?'readonly="readonly"':''

        ),
        $_AS['tpl']['custom'.$i.'_textarea']);
	// checkbox
  if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='check') {
		$_AS['custom']['tempdataarray']=array();
  	$_AS['custom']['tempdata']=trim($_AS['article_obj']->getSetting('article_custom'.$i.'_select_values'));
		if (!empty($_AS['custom']['tempdata'])){
    	$_AS['custom']['temparray']=explode("\n",$_AS['custom']['tempdata']);
  		foreach ($_AS['custom']['temparray'] as $k => $v) {
  			$va=explode('||',htmlentities(trim($v),ENT_COMPAT,'UTF-8'));
  			$_AS['custom']['tempdataarray'][trim($va[0])]=empty($va[1])?trim($va[0]):trim($va[1]);
  		}
  	}

		if ((empty($_AS['idarticle']) && $_AS['item']->getDataByKey('custom'.$i)=='') || $_AS['temp']['vmode']=='defcopy')
			$_AS['custom']['select_value']=@explode("\n",htmlentities($_AS['article_obj']->getSetting('article_custom'.$i.'_value_default_select'),ENT_COMPAT,'UTF-8'));
		else
			$_AS['custom']['select_value']=explode("||",htmlentities($_AS['item']->getDataByKey('custom'.$i),ENT_COMPAT,'UTF-8'));

    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{custom'.$i.'_select}',
            '{custom'.$i.'_mem}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}'
        ),
        array(
            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
            $_AS['article_obj']->getCheckRadio(	'article[custom'.$i.'_select]',	
            																		$_AS['custom']['select_value'],
																								$_AS['custom']['tempdataarray'],
																								'custom'.$i,
																								'setcheckbox(\'article[custom'.$i.'_select]\',\'article[custom'.$i.']\');' ),
						'<input type="hidden" value="'.htmlentities($_AS['item']->getDataByKey('custom'.$i)).'" name="article[custom'.$i.']" id="article[custom'.$i.']"/>',
          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field')
        ),
        $_AS['tpl']['custom'.$i.'_checkradio']);	
            
    }
	// radio
  if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='radio') {
		$_AS['custom']['tempdataarray']=array();
  	$_AS['custom']['tempdata']=trim($_AS['article_obj']->getSetting('article_custom'.$i.'_select_values'));
		if (!empty($_AS['custom']['tempdata'])){
    	$_AS['custom']['temparray']=explode("\n",$_AS['custom']['tempdata']);
  		foreach ($_AS['custom']['temparray'] as $k => $v) {
  			$va=explode('||',htmlentities(trim($v),ENT_COMPAT,'UTF-8'));
  			$_AS['custom']['tempdataarray'][trim($va[0])]=empty($va[1])?trim($va[0]):trim($va[1]);
  		}
  	}
		if ((empty($_AS['idarticle']) && $_AS['item']->getDataByKey('custom'.$i)=='') || $_AS['temp']['vmode']=='defcopy')
			$_AS['custom']['select_value']=@explode("\n",htmlentities($_AS['article_obj']->getSetting('article_custom'.$i.'_value_default_select'),ENT_COMPAT,'UTF-8'));
		else
			$_AS['custom']['select_value']=explode("||",htmlentities($_AS['item']->getDataByKey('custom'.$i),ENT_COMPAT,'UTF-8'));

    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{custom'.$i.'_select}',
            '{custom'.$i.'_mem}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}'
        ),
        array(
            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
            $_AS['article_obj']->getCheckRadio(	'article[custom'.$i.']',	
            																		$_AS['custom']['select_value'],
																								$_AS['custom']['tempdataarray'],
																								'custom'.$i,
																								'setcheckbox(\'article[custom'.$i.'_select]\',\'article[custom'.$i.']\');',
																								'radio' ),
						'',
						((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field')
        ),
        $_AS['tpl']['custom'.$i.'_checkradio']);	
            
    }
   // date		       
	 if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='date'){
	  $_AS['temp']['date_splited']=explode('-',$_AS['temp']['value']);
    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{lng_day}',
            '{lng_month}',
            '{lng_year}',
            '{custom'.$i.'}',
            '{custom'.$i.'_day}',
            '{custom'.$i.'_month}',
            '{custom'.$i.'_year}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}'
        ),
        array(
            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
            $_AS['article_obj']->lang->get('day'),
            $_AS['article_obj']->lang->get('month'),
            $_AS['article_obj']->lang->get('year'),
#		            ((empty($_AS['temp']['value']))?date('Y').'-'.date('m').'-'.date('d'):$_AS['temp']['value']),
            ((empty($_AS['temp']['value']))?'0000-00-00':$_AS['temp']['value']),
            ((empty($_AS['temp']['date_splited'][2]))?'':sprintf ("%02d",(int) $_AS['temp']['date_splited'][2])) ,
            ((empty($_AS['temp']['date_splited'][1]))?'':sprintf ("%02d",(int) $_AS['temp']['date_splited'][1])),
            ((empty($_AS['temp']['date_splited'][0]))?'':sprintf ("%04d",(int) $_AS['temp']['date_splited'][0])),
          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field')
        ),
        $_AS['tpl']['custom'.$i.'_date']);		     
    }   
   // time		       
	 if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='time'){
	  $_AS['temp']['time_splited']=explode(':',$_AS['temp']['value']);
    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{lng_hour}',
            '{lng_minute}',
            '{custom'.$i.'}',
            '{custom'.$i.'_minute}',
            '{custom'.$i.'_hour}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}'
        ),
        array(
            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
            $_AS['article_obj']->lang->get('hour'),
            $_AS['article_obj']->lang->get('minute'),
#		            ((empty($_AS['temp']['value']))?date('H').':'.date('i'):$_AS['temp']['value']),
            ((empty($_AS['temp']['value']))?'':$_AS['temp']['value']),
            ((empty($_AS['temp']['time_splited'][1]))?'':sprintf ("%02d",(int) $_AS['temp']['time_splited'][1])),
            ((empty($_AS['temp']['time_splited'][0]))?'':sprintf ("%02d",(int) $_AS['temp']['time_splited'][0])),
          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field')
        ),
        $_AS['tpl']['custom'.$i.'_time']);		     
    }   		        
   // date+time      
	 if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='datetime'){
	  $_AS['temp']['datetime_splited']=explode(' ',$_AS['temp']['value']);


	  $_AS['temp']['date_splited']=explode('-',$_AS['temp']['datetime_splited'][0]);
	  $_AS['temp']['time_splited']=explode(':',$_AS['temp']['datetime_splited'][1]);
	  

    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{lng_day}',
            '{lng_month}',
            '{lng_year}',
            '{lng_hour}',
            '{lng_minute}',
            '{custom'.$i.'}',
            '{custom'.$i.'_day}',
            '{custom'.$i.'_month}',
            '{custom'.$i.'_year}',
            '{custom'.$i.'_minute}',
            '{custom'.$i.'_hour}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}',
          	'{readonly}',
          	'{hidecalicon}'
        ),
        array(
            trim(str_replace('[readonly]','',$_AS['article_obj']->getSetting('article_custom'.$i.'_label'))),
            $_AS['article_obj']->lang->get('day'),
            $_AS['article_obj']->lang->get('month'),
            $_AS['article_obj']->lang->get('year'),
            $_AS['article_obj']->lang->get('hour'),
            $_AS['article_obj']->lang->get('minute'),
#		            ((empty($_AS['temp']['value']))?date('Y').'-'.date('m').'-'.date('d'):$_AS['temp']['value']),
            ((empty($_AS['temp']['value']))?'0000-00-00 00:00':$_AS['temp']['value']),
            ((empty($_AS['temp']['date_splited'][2]))?'':sprintf ("%02d",(int) $_AS['temp']['date_splited'][2])) ,
            ((empty($_AS['temp']['date_splited'][1]))?'':sprintf ("%02d",(int) $_AS['temp']['date_splited'][1])),
            ((empty($_AS['temp']['date_splited'][0]))?'':sprintf ("%04d",(int) $_AS['temp']['date_splited'][0])),
            ((empty($_AS['temp']['time_splited'][1]))?'':sprintf ("%02d",(int) $_AS['temp']['time_splited'][1])),
            ((empty($_AS['temp']['time_splited'][0]))?'':sprintf ("%02d",(int) $_AS['temp']['time_splited'][0])),
          	((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field'),
          	(strpos($_AS['article_obj']->getSetting('article_custom'.$i.'_label'),'[readonly]')!==false)?'readonly="readonly"':'',
          	(strpos($_AS['article_obj']->getSetting('article_custom'.$i.'_label'),'[readonly]')!==false)?'visibility:hidden"':''
        ),
        $_AS['tpl']['custom'.$i.'_datetime']);		     
    }           

	// select
  if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='select') {
		$_AS['custom']['tempdataarray']=array();
  	$_AS['custom']['tempdataarray']['']=$_AS['article_obj']->lang->get('article_non_selected_string');
  	$_AS['custom']['tempdata']=trim($_AS['article_obj']->getSetting('article_custom'.$i.'_select_values'));

		if (!empty($_AS['custom']['tempdata'])){
    	$_AS['custom']['temparray']=explode("\n",$_AS['custom']['tempdata']);
  		foreach ($_AS['custom']['temparray'] as $k => $v) {
  			$va=explode('||',htmlentities(trim($v),ENT_COMPAT,'UTF-8'));
  			$_AS['custom']['tempdataarray'][trim($va[0])]=empty($va[1])?trim($va[0]):trim($va[1]);
#	    			$v=htmlentities(trim($v),ENT_COMPAT,'UTF-8');
#	    			$_AS['custom']['tempdataarray'][$v]=$v;
  		}
  	}

		if ((empty($_AS['idarticle']) && $_AS['item']->getDataByKey('custom'.$i)=='') || $_AS['temp']['vmode']=='defcopy')
			$_AS['custom']['select_value']=@explode("\n",htmlentities(trim($_AS['article_obj']->getSetting('article_custom'.$i.'_value_default_select')),ENT_COMPAT,'UTF-8'));
		else if ($_AS['article_obj']->getSetting('article_custom'.$i.'_multi_select')=='true')
			$_AS['custom']['select_value']=array_filter(@explode("\n",htmlentities(trim($_AS['item']->getDataByKey('custom'.$i)),ENT_COMPAT,'UTF-8')));
		else {
			$_AS['custom']['select_value']=$_AS['item']->getDataByKey('custom'.$i);
			$_AS['custom']['select_value']=htmlentities(trim($_AS['custom']['select_value']),ENT_COMPAT,'UTF-8');
		}


		if (is_array($_AS['custom']['select_value']))
			foreach ($_AS['custom']['select_value'] as $k => $v)
				$_AS['custom']['select_value'][$k]=trim($v);

    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{custom'.$i.'_select}',
            '{custom'.$i.'_mem}',
            '{custom'.$i.'_input}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}'
        ),
        array(
            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
            $_AS['article_obj']->getSelectUni(	'article[custom'.$i.'select]',	
            																		$_AS['custom']['select_value'],
																								$_AS['custom']['tempdataarray'],
																								'custom'.$i.'select',
																								'selectedoptionstostring(\'custom'.$i.'select\',\'custom'.$i.'\');',
																								($_AS['article_obj']->getSetting('article_custom'.$i.'_multi_select')=='true'?'multiple="multiple" size="5"':'').
																								'class="w800"  style="font-size:1em;"'),
						'',
						'<input id="'.'custom'.$i.'" name="'.'article[custom'.$i.']'.'" value="'.(is_array($_AS['custom']['select_value'])?implode("\n",$_AS['custom']['select_value']):$_AS['custom']['select_value']).'" type="hidden"/>',
						((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field')
        ),
        $_AS['tpl']['custom'.$i.'_select']);	
            
    }
  // select2
  if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='select2') {
		$_AS['custom']['tempdataarray']=array();
  	$_AS['custom']['tempdatastatic']=trim($_AS['article_obj']->getSetting('article_custom'.$i.'_select_values'));
  	$_AS['custom']['temparray']=explode("\n",$_AS['custom']['tempdatastatic']);

		// fill option-array with static vals
		foreach ($_AS['custom']['temparray'] as $v) {
			$v=stripslashes(str_replace('&amp;','&',$v));
			$v=htmlentities($v,ENT_COMPAT,'UTF-8');
			if (!empty($v)) {
  			$va=explode('||',$v);
  			$_AS['custom']['tempdataarray'][trim($va[0])]=empty($va[1])?trim($va[0]):trim($va[1]);
			}
#    				$_AS['custom']['tempdataarray'][trim($v)]=trim($v);
		}
		
		$_AS['custom']['tempdataarraybu']=$_AS['custom']['tempdataarray'];
		// fill option-array with vals from articles
		$sql = "SELECT custom".$i." FROM ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']." 
						WHERE idclient=".$client." AND idlang=".$lang;
    $db -> query($sql);
		while($db -> next_record()) {
			$vb=htmlentities(trim($db->f('custom'.$i)),ENT_COMPAT,'UTF-8');
			foreach (explode("\n",$vb) as $v) {
				$v=trim($v);
				if (!empty($v)) {
					if (!empty($_AS['custom']['tempdataarraybu'][$v]))
						$_AS['custom']['tempdataarray'][$v]=$_AS['custom']['tempdataarraybu'][$v];
					else
						$_AS['custom']['tempdataarray'][$v]=$v;
						
				}
			}
		}	
		
#		print_r($_AS['custom']['tempdataarray']);		
#		$v=htmlentities(trim($_AS['item']->getDataByKey('custom'.$i)),ENT_COMPAT,'UTF-8');
#				$_AS['custom']['tempdataarray'][$v]=$v;

		$_AS['custom']['tempdataarray']=array_unique($_AS['custom']['tempdataarray']);
		$_AS['custom']['tempdataarray']=array_filter($_AS['custom']['tempdataarray']);
#		natcasesort($_AS['custom']['tempdataarray']);
		$_AS['custom']['tempdataarray']=as_natksort($_AS['custom']['tempdataarray']);
  	$_AS['custom']['tempdataarray']=as_array_merge(array(''=>$_AS['article_obj']->lang->get('article_non_selected_string')),$_AS['custom']['tempdataarray']);

		if ((empty($_AS['idarticle']) && $_AS['item']->getDataByKey('custom'.$i)=='') || $_AS['temp']['vmode']=='defcopy')
			$_AS['custom']['select_value']=array_filter(@explode("\n",htmlentities(trim($_AS['article_obj']->getSetting('article_custom'.$i.'_value_default_select')),ENT_COMPAT,'UTF-8')));
		else if ($_AS['article_obj']->getSetting('article_custom'.$i.'_multi_select')=='true')
			$_AS['custom']['select_value']=array_filter(@explode("\n",htmlentities(trim($_AS['item']->getDataByKey('custom'.$i)),ENT_COMPAT,'UTF-8')));
		else {
			$_AS['custom']['select_value']=$_AS['item']->getDataByKey('custom'.$i);
			$_AS['custom']['select_value']=htmlentities(trim($_AS['custom']['select_value']),ENT_COMPAT,'UTF-8');
		}

		if (is_array($_AS['custom']['select_value']))
			foreach ($_AS['custom']['select_value'] as $k => $v)
				$_AS['custom']['select_value'][$k]=trim($v);

    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{custom'.$i.'_select}',
            '{custom'.$i.'_mem}',
            '{custom'.$i.'_input}',
            '{validation_error_cssdisplay}',
            '{path}',
          	'{error_empty}'
        ),
        array(
            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
            $_AS['article_obj']->getSelectUni(	'article[custom'.$i.'select]',	$_AS['custom']['select_value'],
																																					$_AS['custom']['tempdataarray'],
																																					'custom'.$i.'select',
																																					'selectedoptionstostring(\'custom'.$i.'select\',\'custom'.$i.'\');',
																																					($_AS['article_obj']->getSetting('article_custom'.$i.'_multi_select')=='true'?'multiple="multiple" size="5"':'').
																																					'class="w800"  style="width:392px;font-size:1em;"'),
            '',
						'<div style="float:right"><input id="'.'custom'.$i.'input'.'" name="'.'article[custom'.$i.'input]'.'" value="" class="w800" style="width:392px;font-size:1em;margin-left:5px;" onchange="addoptiontoselect(\'custom'.$i.'\',this.value);selectedoptionstostring(\'custom'.$i.'select\',\'custom'.$i.'\');return false"/></div>
						<input id="'.'custom'.$i.'" name="'.'article[custom'.$i.']'.'" value="'.(is_array($_AS['custom']['select_value'])?implode("\n",$_AS['custom']['select_value']):$_AS['custom']['select_value']).'" type="hidden"/>',
						((($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='true' &&	
          	  empty($_AS['temp']['value'])) ||
          	  ($_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
          	  count($_AS['validation_errors']['custom'.$i]['text'])>0))?'inline':'none'),
          	$_AS['config']['imgpath'],
          	$_AS['article_obj']->lang->get('article_error_empty_field')
        ),
        $_AS['tpl']['custom'.$i.'_select']);	    
    }
    
   // info
	 if ($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='info')
    $_AS['row']['custom'.$i] = str_replace(array(
            '{lng_custom'.$i.'}',
            '{custom'.$i.'}',
            '{validation_error_cssdisplay}',
            '{wysiwyg}',
            '{path}',
         		'{error_empty}'		             
        ),
        array(
            $_AS['article_obj']->getSetting('article_custom'.$i.'_label'),
            $_AS['article_obj']->getSetting('article_custom'.$i.'_value'),
            (($_AS['article_obj']->getSetting('article_custom'.$i.'_type')=='wysiwyg')?'class="mceEditor w800"':''),
          	$_AS['config']['imgpath'],
         		$_AS['article_obj']->lang->get('article_error_empty_field')
        ),
        $_AS['tpl']['custom'.$i.'_info']);    
    
    
  }
  
  
  
  
}

$_AS['validation_error_msgs'] = array();
if ($_POST['action']=='save_article' && $_AS['valid']!='true')
  for ($i=1;$i<36;$i++){
  	if ( $_AS['article_obj']->getSetting('article_custom'.$i.'_label') &&
  	     $_AS['article_obj']->getSetting('article_custom'.$i.'_validation')=='regexp' &&	
         count($_AS['validation_errors']['custom'.$i]['text'])>0 ) {
			if (is_array($_AS['validation_errors']['custom'.$i]['text']))
				foreach ($_AS['validation_errors']['custom'.$i]['text'] as $v)
					$_AS['validation_error_msgs'][] = $_AS['article_obj']->getSetting('article_custom'.$i.'_label').': '.$v;
		}
} 
if (count($_AS['validation_error_msgs'])>0)
  echo '<p class="errormsg">'.implode("<br/>",$_AS['validation_error_msgs'])."</p>";

$_AS['upload_error_msgs'] = array();
for ($i=1;$i<36;$i++){
	if (!empty($_AS['upload']['custom'.$i]['error']))
		$_AS['upload_error_msgs'][] = $_AS['article_obj']->lang->get('upload').
																	' - '.
																	$_AS['article_obj']->getSetting('article_custom'.$i.'_label').
																	': '.
																	$_AS['article_obj']->lang->get('err_'.$_AS['upload']['custom'.$i]['error']);
}
if (count($_AS['upload_error_msgs'])>0)
  echo '<p class="errormsg">'.implode("<br/>",$_AS['upload_error_msgs'])."</p>";
         	  
          	  
//Buttons
$_AS['row']['buttons'] = str_replace(array(
        '{back}',
        '{back_url}',
        '{back_label}',
    ),
    array(
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['cms_wr']->getVal('callist_search').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['cms_wr']->getVal('sort')),
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['cms_wr']->getVal('callist_search').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['cms_wr']->getVal('sort')),
        $_AS['article_obj']->lang->get('back')
    ),
    $_AS['tpl']['buttons']);



//Tpls je nach Einstellung zusammenbauen
$_AS['temp']['output'] = '';
$_AS['temp']['output'] .= $_AS['row']['online'];
$_AS['temp']['output'] .= $_AS['row']['article_start'];
$_AS['temp']['output'] .= $_AS['row']['article_end'];
$_AS['temp']['output'] .= ($_AS['article_obj']->getSetting('set_category') == 1) ? $_AS['row']['category'] : '';
$_AS['temp']['output'] .= $_AS['row']['title'];

$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_teaser_sortindex')][] = $_AS['row']['teaser'];
$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_text_sortindex')][] = $_AS['row']['text'];
for ($i=1;$i<36;$i++)
	$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_custom'.$i.'_sortindex')][] = $_AS['row']['custom'.$i];
$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_picture1_sortindex')][] = $_AS['row']['picture1'];
$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_file1_sortindex')][] = $_AS['row']['file1'];
$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_link_sortindex')][] = $_AS['row']['link'];
$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_date_sortindex')][] = $_AS['row']['date'];
//   	$_AS['temp']['output_sortable_elements'][$_AS['article_obj']->getSetting('article_link2_sortindex')][] = $_AS['row']['link2'].$_AS['row']['link2_title'];

ksort($_AS['temp']['output_sortable_elements'],SORT_NUMERIC);
foreach($_AS['temp']['output_sortable_elements'] as $v1){
	natsort($v1);
	foreach($v1 as $v2)
	$_AS['temp']['output'] .=$v2;
}
#    $_AS['temp']['output'] .= ($_AS['article_obj']->getSetting('set_organizer') == 1) ? $_AS['row']['organizer'] : '';
$_AS['temp']['output'] .= $_AS['row']['buttons'];

// try to get the cms-ui-language from backend language  
$_AS['tinylanguage']=strtolower(substr($cfg_cms['backend_lang'],0,2));
// no supported language > English
if ($_AS['tinylanguage']!="de" && $_AS['tinylanguage']!="en" && $_AS['tinylanguage']!="fr") $_AS['tinylanguage']='en';
$_AS['tpl']['tinyscripts']=str_replace('{language}',$_AS['tinylanguage'],$_AS['tpl']['tinyscripts']);




// resource browser inits
$rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
$res_file = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'FileManager');

$filetypes_s = $_AS['article_obj']->getSetting('wysiwyg_file_select_filetypes');
	if (!empty($filetypes_s))
		$filetypes = explode(',', $filetypes_s);
	else {
			$sql = "SELECT filetype, description FROM ". $cms_db['filetype'] ." ORDER BY description, filetype";		          
			$db->query($sql);
			while ($db->next_record())
				$filetypes[] = $db->f('filetype');
	}
	$folders_s = $_AS['article_obj']->getSetting('wysiwyg_file_select_folders');
	if (!empty($folders_s))
		$folders = explode(',', $folders_s);
	else
		$folders = array();

$res_file->setFiletypes($filetypes);
$res_file->setFolderIds($folders);
$res_file->setWithSubfoders( $_AS['article_obj']->getSetting('wysiwyg_file_select_subfolders')=="true" ? true : false );
$res_file->setReturnValueMode('sefrengolink');
$rb->addRessource($res_file);
$res_links =&$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'InternalLink');
#$res_links->setCatIds(explode(',',$_AS['article_obj']->getSetting('newsletter_sfcontents_select_idcats')));
#$res_links->setWithSubcats(($_AS['article_obj']->getSetting('newsletter_sfcontents_select_subcats')=='true'?true:false));
#$res_links->setShowStartpages(($_AS['article_obj']->getSetting('newsletter_sfcontents_select_startpages')=='true'?true:false));
#$res_links->setCatsAreChosable(($_AS['article_obj']->getSetting('newsletter_sfcontents_select_choosecats')=='true'?true:false));
$rb->addRessource($res_links);
$rb->setJSCallbackFunction('sf_getFile', array('picked_name', 'picked_value'));
$rb_file_url = $rb->exportConfigURL();

$filetypes_s = 'jpg,jpeg,gif,png';
$filetypes = explode(',', $filetypes_s);
$folders_s = $_AS['article_obj']->getSetting('wysiwyg_picture_select_folders');
if (!empty($folders_s))
	$folders = explode(',', $folders_s);
else
	$folders = array();

$rb = &$GLOBALS['sf_factory']->getObjectForced('GUI', 'RessourceBrowser');
$res_image = &$GLOBALS['sf_factory']->getObjectForced('GUI/RESSOURCES', 'FileManager');
$res_image->setFiletypes($filetypes);
$res_image->setFolderIds($folders);
$res_image->setWithSubfoders( $_AS['article_obj']->getSetting('wysiwyg_picture_select_subfolders')=="true" ? true : false );
$res_image->setReturnValueMode('sefrengolink');
$rb->addRessource($res_image);
$rb->setJSCallbackFunction('sf_getImage', array('picked_name', 'picked_value'));
$rb_image_url = $rb->exportConfigURL();			

$_AS['tpl']['tinyscripts']=str_replace('{sf_rb_file_url}',$rb_file_url, $_AS['tpl']['tinyscripts']);
$_AS['tpl']['tinyscripts']=str_replace('{sf_rb_image_url}', $rb_image_url, $_AS['tpl']['tinyscripts']);

$_AS['tpl']['tinyscripts']=str_replace('{tinymce_docbaseurl}', $cfg_client['htmlpath'], $_AS['tpl']['tinyscripts']);












$_AS['temp']['othlangarticles']=array();
$_AS['temp']['othlangarticlesall']=array();
$_AS['temp']['othlangarticlesall']=$_AS['item']->getIdAndLangFromHash($_AS['item']->getDataByKey('hash'));

if (!empty($_AS['idarticlemem']))
	$_AS['temp']['filterlang']=$_AS['temp']['othlangarticlesall'][$_AS['idarticlemem']];
else 
	$_AS['temp']['filterlang']=$_AS['item']->getDataByKey('idlang');

$_AS['temp']['othlangarticles']	=	$_AS['item']->getIdAndLangFromHash($_AS['item']->getDataByKey('hash'),$_AS['temp']['filterlang']);

$langs=array();
$langs=$_AS['article_obj']->getClientLangs();	


$_AS['temp']['othlangcopyselarr'][0]=$_AS['article_obj']->lang->get('article_langcopyfrom');

foreach($_AS['temp']['othlangarticles'] as $k => $v)
	$_AS['temp']['othlangcopyselarr'][$k]=$langs[$v];

$_AS['temp']['othlangcopyselect']='';
if (count($_AS['temp']['othlangcopyselarr'])>1 && $_AS['idarticle']!='')
 $_AS['temp']['othlangcopyselect'] = $_AS['article_obj']->getSelectUni(	'langcopy','',
																							$_AS['temp']['othlangcopyselarr'],
																							'langcopy',
																							'',
																							'onchange=" document.getElementById(\'apply\').value = 1;document.getElementById(\'articleform\').submit();" style="font-size:1.1em;margin-top:-5px;margin-bottom:-3px;margin-right:15px;"');

$_AS['output']['body'] = str_replace(array(
				'{idarticlemem}',
				'{onlinemem}',
				'{langcopyselect}',
				'{valid}',
        '{body}',
        '{action}',
        '{formurl}',
        '{jspath}',
        '{idarticle}',
        '{hash}',
        '{archived}',
        '{htmlpath}',
        '{uplhtmlpath}',
        '{thumbext}',
        '{additional_body_scripts}',
        '{validation_icon}',
        '{question_delete}',
        '{question_reset}',
        '{js_get_title1}',
        '{js_get_title2}',
				'{save}',
				'{saveback2}',
				'{cancel}',
    ),
    array(
    		((!empty($_AS['idarticlemem']))?$_AS['idarticlemem']:$_AS['item']->getDataByKey('idarticle')),
    		( $_AS['temp']['online'] == 1 || 
        ((empty($_AS['idarticle']) || $_GET['action']=='dupl_article') && $_AS['article_obj']->getSetting('new_articles_online')=='true')) ? '1' : '0',
    		$_AS['temp']['othlangcopyselect'],
    		$_AS['valid'],
        $_AS['temp']['output'],
        $_AS['article_obj']->lang->get('action_'.$_AS['action']),
        $_AS['form_url'] = $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&page='.$_AS['cms_wr']->getVal('page').$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['cms_wr']->getVal('callist_search').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['cms_wr']->getVal('sort')),
        $cfg_cms['cms_html_path'].'plugins/articlesystem/js/',
        ((!empty($_AS['idarticlemem']))?$_AS['idarticlemem']:$_AS['item']->getDataByKey('idarticle')),
        ($_AS['item']->getDataByKey('hash') != '') ? $_AS['item']->getDataByKey('hash') : '',
        $_AS['item']->getDataByKey('archived'),
        $cfg_client["htmlpath"],
				$cfg_client["upl_htmlpath"],
				$cfg_client["thumbext"],
				$_AS['tpl']['tinyscripts'],
				(($_POST['action']=='save_article')?'info_error.gif':'info_warning.gif'),
				$_AS['article_obj']->lang->get('question_delete'),
				$_AS['article_obj']->lang->get('question_reset'),
				$_AS['article_obj']->lang->get('js_get_title1'),
				$_AS['article_obj']->lang->get('js_get_title2'),
				$_AS['article_obj']->lang->get('save'),
				$_AS['article_obj']->lang->get('saveback2'),
				$_AS['article_obj']->lang->get('cancel'),

    ),
    $_AS['tpl']['body']);

//Ausgabe der ersetzten Tpls
echo $_AS['output']['back'];
echo $_AS['output']['body'];

    
#    
#function kill($AlterArray)
#{
#    $AlterArray = array_unique($AlterArray);
#    $i = 0;
#
#    foreach($AlterArray as $Wert)
#    {
#        $NeuerArray[$i] = $Wert;
#        $i++;
#    }
#
#    return $NeuerArray;
#}
#
#
#$Liste = array("Hamburg", "München", "Rhede", "Frankfurt", "München", "Rhede", "Berlin", "Rhede");
#
#$EinfacheListe = DoppelteWerteEntfernen($Liste);
#    
?>
