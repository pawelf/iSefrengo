<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

//Collectionklasse laden
include_once $_AS['basedir'] . 'inc/fnc.articlesystem_utilities.php';

include_once $_AS['basedir'] . 'inc/class.articlecollection.php';
include_once $_AS['basedir'] . 'inc/paginator.php';
include_once $_AS['basedir'] . 'inc/class.categorycollection.php';


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
$_AS['article_sel'] = $_AS['cms_wr']->getVal('article_sel');

$_AS['subarea']=$_AS['cms_wr']->getVal('subarea');;
//Einige Config-Vars direkt holen
$_AS['config']['date'] =  $_AS['article_obj']->defaultval['display']['date'];
$_AS['config']['time'] =  $_AS['article_obj']->defaultval['display']['time'];
$_AS['config']['perpage'] =  $_AS['article_obj']->defaultval['display']['perpage'];

$_AS['temp']['startmonth'] = $_AS['cms_wr']->getVal('startmonth');
$_AS['config']['startmonth'] = ($_AS['temp']['startmonth']=='') ? date("m") : $_AS['temp']['startmonth'];

$_AS['temp']['monthback'] = $_AS['cms_wr']->getVal('monthback');
$_AS['config']['monthback'] = (empty($_AS['temp']['monthback'])) ? $_AS['article_obj']->getSetting('number_of_month') : $_AS['temp']['monthback'];

//
function available($datetime=array())
{

 	if (empty($datetime))
		return true;
  $bool = array();
  $checked = false;
  $current_dz=mktime(0,0,0,date('m'),date('d'),date('Y'));
  $current_d=mktime(23,59,59,date('m'),date('d'),date('Y'));
  $current_dt=mktime(date('H'),date('i'),0,date('m'),date('d'),date('Y'));
  $article_startdate = strtotime($datetime['article_startdate']);
  $article_starttime_yn = $datetime['article_starttime_yn'];
  $article_starttime = strtotime( $datetime['article_starttime']);
  $article_enddate_yn = $datetime['article_enddate_yn'];
  $article_enddate = strtotime($datetime['article_enddate']);
  $article_endtime_yn = $datetime['article_endtime_yn'];
  $article_endtime = strtotime($datetime['article_endtime']);

	if ($article_startdate>$current_d)
		return false;
		
	if (!empty($article_starttime_yn) &&  $article_starttime>$current_dt)
		return false;

	if (!empty($article_endtime_yn) && !empty($article_enddate_yn) &&  $article_enddate<$current_dt)
		return false;

	if (!empty($article_enddate_yn) &&  $article_enddate<$current_dz)
		return false;

	if (!empty($article_endtime_yn) &&  $article_endtime<$current_dt)
		return false;
		
	return true;
}


//Aktionen abarbeiten
if($_AS['action']=='switch_online' || $_AS['action']=='switch_offline') {
    $_AS['singlearticle_obj'] = new SingleArticle;
    if(is_numeric($_AS['idarticle'])) {
        $_AS['singlearticle_obj']->loadById($_AS['idarticle']);
        //Online
        if($_AS['action']=='switch_online') {
            $_AS['singlearticle_obj']->update_online(1);
        } else {
            $_AS['singlearticle_obj']->update_online(0);
        }
    }
} else if ($_AS['action']=='onlineoffline_article' && !empty($_AS['article_sel'])) {
  	if (is_array($_AS['article_sel']))
      $_AS['singlearticle_obj'] = new SingleArticle;
 			if (is_array($_AS['article_sel']))
 				foreach ($_AS['article_sel'] as $v) {
          $_AS['singlearticle_obj']->loadById($v);
          $online=$_AS['singlearticle_obj']->getDataByKey('online');
          //Online
          if($online) {
              $_AS['singlearticle_obj']->update_online(0);
          } else {
              $_AS['singlearticle_obj']->update_online(1);
          }
      }
} else if($_AS['action']=='switch_archive' || $_AS['action']=='switch_dearchive') {
    $_AS['singlearticle_obj'] = new SingleArticle;
    if(is_numeric($_AS['idarticle'])) {
        $_AS['singlearticle_obj']->loadById($_AS['idarticle']);
        //archived
        if($_AS['action']=='switch_archive') {
            $_AS['singlearticle_obj']->update_archived(1);
        } else {
            $_AS['singlearticle_obj']->update_archived(0);
        }
    }
} else if ($_AS['action']=='archivedearchive_article' && !empty($_AS['article_sel'])) {
  	if (is_array($_AS['article_sel']))
      $_AS['singlearticle_obj'] = new SingleArticle;
      if (is_array($_AS['article_sel']))
 				foreach ($_AS['article_sel'] as $v) {
          $_AS['singlearticle_obj']->loadById($v);
          $archived=$_AS['singlearticle_obj']->getDataByKey('archived');
          //archived
          if($archived) {
              $_AS['singlearticle_obj']->update_archived(0);
          } else {
              $_AS['singlearticle_obj']->update_archived(1);
          }
      }
} else if($_AS['action']=='delete_article' && empty($_AS['article_sel'])) {
    $_AS['singlearticle_obj'] = new SingleArticle;
    if(is_numeric($_AS['idarticle'])) {
        $_AS['singlearticle_obj']->loadById($_AS['idarticle']);
        $_AS['singlearticle_obj']->delete();
    }
} else if ($_AS['action']=='delete_article' && !empty($_AS['article_sel'])) {
  	if (is_array($_AS['article_sel']))
      $_AS['singlearticle_obj'] = new SingleArticle;
 			if (is_array($_AS['article_sel']))
 				foreach ($_AS['article_sel'] as $v) {
          $_AS['singlearticle_obj']->loadById($v);
          $_AS['singlearticle_obj']->delete();
    		}        		
}


//Collection intialisieren
$_AS['collection'] = new ArticleCollection();


//
// get sort from links
//

$_AS['temp']['sortlinkelements']=array();
$_AS['temp']['sortlinkvalsold']=array();
$_AS['temp']['sortlinkvalsoldtemp']=array();
$_AS['temp']['sortlinkvalsoldstring'] = $_AS['cms_wr']->getVal($_AS['modkey'].'sort');



$_AS['temp']['searchstring']=stripslashes($_AS['cms_wr']->getVal('callist_search'));
if (!empty($_AS['temp']['searchstring'])) {
	//$_AS['collection']->setDateRange();
	$_AS['config']['monthback']=-1;
	$_AS['temp']['searchfields']=array();
	$_AS['temp']['searchfields'][]='title';
	$_AS['temp']['searchfields'][]='text';
	$_AS['temp']['searchfields'][]='teaser';
  for ($i=1;$i<36;$i++){
  	if ( $_AS['article_obj']->getSetting('article_custom'.$i.'_label'))
			$_AS['temp']['searchfields'][]='custom'.$i;
	}

	$_AS['collection']->setLimit(100);
	$_AS['collection']->setSearchString($_AS['temp']['searchstring'],$_AS['temp']['searchfields']);
}

//Zeitraum NICHT bei "alle Artikele" benutzen
if($_AS['config']['monthback'] > 0) {
    //falsch: //$_AS['collection']->setDateRange( mktime(0,0,0,$_AS['config']['startmonth']-$_AS['config']['monthback']+1,1), mktime(23,59,59,$_AS['config']['startmonth'], date("t",mktime(23,59,59,$_AS['config']['startmonth']))) );
$_AS['collection']->setDateRange( mktime(0,0,0,$_AS['config']['startmonth'],1), mktime(23,59,59,$_AS['config']['startmonth']+$_AS['config']['monthback']-1,date("t",mktime(23,59,59,$_AS['config']['startmonth']+$_AS['config']['monthback']-1))) );
}
//Nur eine bestimmte Kategorie ausw?hlen
if(!empty($_REQUEST['callist_flt_category']))
	$_AS['collection']->setIdcategory($_AS['cms_wr']->getVal('callist_flt_category'));
else if (is_array($_AS['temp']['group_cats']) && count($_AS['temp']['group_cats'])>0)
	$_AS['collection']->setIdcategory(implode(',',$_AS['temp']['group_cats']));

// set custom fields filter
$_AS['temp']['lv_cf']=array();
$_AS['temp']['lv_cf']['urladdon']='';
for ($i=1;$i<36;$i++){
	$_AS['temp']['lv_cf']['postdata']=$_AS['cms_wr']->getVal('custom'.$i.'_filter');
	if (trim($_AS['temp']['lv_cf']['postdata'])!='') {
		if ( $_AS['article_obj']->getSetting('article_custom'.$i.'_multi_select')=="true" || $_AS['article_obj']->getSetting('article_custom'.$i.'_type')=="check")
			$_AS['temp']['lv_cf']['filtearray']['custom'.$i]='%'.$_AS['temp']['lv_cf']['postdata'].'%';
		else
			$_AS['temp']['lv_cf']['filtearray']['custom'.$i]=$_AS['temp']['lv_cf']['postdata'];
		$_AS['temp']['lv_cf']['urladdon'].='&amp;custom'.$i.'_filter='.urlencode($_AS['temp']['lv_cf']['postdata']);
	}
}
$_AS['collection']->setCustomFilters($_AS['temp']['lv_cf']['filtearray']);


$_AS['temp']['searchstring']=htmlentities(stripslashes($_AS['cms_wr']->getVal('callist_search')),ENT_COMPAT,'UTF-8');
//Anzahl eingrenzen
//$_AS['collection']->setLimit($_AS['config']['per_page']);

//Offline geschaltete Artikele anzeigen?
$_AS['collection']->setHideOffline(false);
if ($_AS['subarea']=='archive')
	$_AS['collection']->setHideArchived(false);
//Nur eine bestimmte Kategorie auswählen
//$_AS['collection']->setIdcategory(6);

#    //Eintr&auml;ge laden
#    $_AS['collection']->generate();

// list view sorting
$_AS['sorting']=array();
$_AS['sorting']['area']=trim($_AS['article_obj']->getSetting('lv_sorting'));

if(!empty($_AS['sorting']['area'])) {

	$_AS['sorting']['array'] = array();		

	$_AS['sorting']['raw'] = trim( str_replace(' ', '',$_AS['sorting']['area']));

  $_AS['sorting']['raw_vals'] = explode("\n", $_AS['sorting']['raw']);
  foreach ($_AS['sorting']['raw_vals'] AS $v) {
    $_AS['sorting_pieces'] = explode('>', $v);
    
    if (strpos($_AS['sorting_pieces']['0'],'date')!==false || strpos($_AS['sorting_pieces']['0'],'time'))
    	$_AS['sorting_pieces']['0']='article_'.$_AS['sorting_pieces']['0'];

    if (strpos($_AS['sorting_pieces']['0'],'category')!==false)
    	$_AS['sorting_pieces']['0']='id'.$_AS['sorting_pieces']['0'];
  
    $_AS['sorting']['array'][$_AS['sorting_pieces']['0']]=$_AS['sorting_pieces']['1'];
  }

	if (is_array($_AS['sorting']['array']) && count($_AS['sorting']['array'])>0)
		$_AS['collection']->setSorting( $_AS['sorting']['array']);

}


// list view sorting via table-head-links
$_AS['temp']['sortlinkvalsnew']=array();
$_AS['temp']['sortlinkelements']=array();
for ($i=1;$i<36;$i++)
	if ($i>9)
		$_AS['temp']['sortlinkelements']['C'.$i]='custom'.$i;
	else
		$_AS['temp']['sortlinkelements']['C0'.$i]='custom'.$i;

$_AS['temp']['sortlinkelements']['SDT']='article_startdate';
$_AS['temp']['sortlinkelements']['EDT']='article_enddate';
$_AS['temp']['sortlinkelements']['CTD']='created';
$_AS['temp']['sortlinkelements']['TXT']='text';
$_AS['temp']['sortlinkelements']['TSR']='teaser';
$_AS['temp']['sortlinkelements']['TTL']='title';

if (!empty($_AS['temp']['sortlinkvalsoldstring'])) {
	$_AS['sorting']['array']=array();
	$_AS['temp']['sortlinkvalsoldtemp']=explode(':',$_AS['temp']['sortlinkvalsoldstring']);

	foreach ($_AS['temp']['sortlinkvalsoldtemp'] as $v)
		$_AS['temp']['sortlinkvalsold'][substr($v,0,3)]=substr($v,0,4);
		if (substr($v,3,4)=='A')
			$_AS['sorting']['array'][$_AS['temp']['sortlinkelements'][substr($v,0,3)]]='ASC';
		else if (substr($v,3,4)=='D')
			$_AS['sorting']['array'][$_AS['temp']['sortlinkelements'][substr($v,0,3)]]='DESC';
}

$_AS['temp']['sortlinkelements2']=array_flip($_AS['temp']['sortlinkelements']);

foreach($_AS['temp']['sortlinkelements2'] as $v)
	$_AS['temp']['sortlinkvalsnew'][$v]= $v.((substr($_AS['temp']['sortlinkvalsold'][$v],3,1)=='A')?'D':'A');

$_AS['sort_base_url']=$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'];






//Tpl einladen
include_once $_AS['basedir'] . 'tpl/'.$_AS['article_obj']->getSetting('skin').'/tpl.article_list.php';

	// collect categories data
$_AS['temp']['category'] = $_AS['article_obj']->getCategory();
$_AS['select']['catdata']=array();
$_AS['select']['catdata']['']=$_AS['article_obj']->lang->get('category_filter');
//$_AS['temp']['selected'] = $_AS['item']->getDataByKey('idcategory');
foreach($_AS['temp']['category'] as $_AS['temp']['idcategory'] => $_AS['temp']['name'])
	if ((is_array($_AS['temp']['group_cats']) && 
			in_array($_AS['temp']['idcategory'],$_AS['temp']['group_cats'])) ||
			!is_array($_AS['temp']['group_cats']))			
		$_AS['select']['catdata'][$_AS['temp']['idcategory']]=$_AS['temp']['name'];

// remove category-column header placeholder if no categories are available or feature is off
if($_AS['article_obj']->getSetting('set_category')!=1 || count($_AS['select']['catdata'])<2)
	$_AS['tpl']['list_header']=str_replace('{lng_category}','', $_AS['tpl']['list_header']);



// get list column definition
$_AS['temp']['list_output_header']='';
$_AS['temp']['list_output_header_fieldarr_temp']=explode("\n",trim($_AS['article_obj']->getSetting('lv_fields')));
foreach ($_AS['temp']['list_output_header_fieldarr_temp'] as $v) {
	$_AS['temp']['list_output_header_field']=explode('||',$v);
	$_AS['temp']['list_output_header_fieldarr'][]=$_AS['temp']['list_output_header_field'][0];
	$_AS['temp']['list_output_header_field_width_all']+=(int)$_AS['temp']['list_output_header_field'][1];
	$_AS['temp']['list_output_header_fieldarr_width'][]=$_AS['temp']['list_output_header_field'][1];
}

// calc width-percent for columns without a with definition
$_AS['temp']['list_output_header_field_width_remainder']=100-$_AS['temp']['list_output_header_field_width_all'];
$_AS['temp']['list_output_header_field_width_single_remainder']=count($_AS['temp']['list_output_header_fieldarr_width'])-count(array_filter($_AS['temp']['list_output_header_fieldarr_width']));

if ($_AS['temp']['list_output_header_field_width_remainder']>0) {
	foreach ($_AS['temp']['list_output_header_fieldarr_width'] as $k => $v)
		if (empty($v))
			$_AS['temp']['list_output_header_fieldarr_width'][$k]=round($_AS['temp']['list_output_header_field_width_remainder']/$_AS['temp']['list_output_header_field_width_single_remainder']);
}		


// create list header
foreach ( $_AS['temp']['list_output_header_fieldarr'] as $kk => $vv) {

	$vv=trim($vv);
	$_AS['temp']['label']='';
	$_AS['temp']['csle']=$_AS['temp']['sortlinkvalsnew'][$_AS['temp']['sortlinkelements2'][$vv]];

	if (strpos($vv,'custom')!==false) {

		$i=(int) str_replace('custom','',$vv);
		if ($i>9)
			$_AS['temp']['csle']=$_AS['temp']['sortlinkvalsnew']['C'.$i];
		else
			$_AS['temp']['csle']=$_AS['temp']['sortlinkvalsnew']['C0'.$i];

		$_AS['temp']['label']=stripslashes($_AS['article_obj']->getSetting('article_'.$vv.'_label'));
		$_AS['temp']['label']=trim(str_replace('[readonly]','',$_AS['temp']['label']));
		if (strlen($_AS['temp']['label'])>32)
			$_AS['temp']['label']=substr($_AS['temp']['label'],0,32).' ...';
	}
	
	if (empty($_AS['temp']['label']))
		$_AS['temp']['label']=$_AS['article_obj']->lang->get('article_'.$vv);

  $_AS['temp']['list_output_header'] .= str_replace('{lng_value}',
  																									'<a href="'.$_AS['sort_base_url'].'&sort='.$_AS['temp']['csle'].'">'.$_AS['temp']['label'].'&nbsp;&uarr;&darr;'.'</a>',
  																									$_AS['tpl']['list_header_fieldssub']);
}

$_AS['tpl']['list_header'] = str_replace('{list_header_fieldssub}', $_AS['temp']['list_output_header'],$_AS['tpl']['list_header']);


//Header der Tabelle hinzuf&uuml;gen
$_AS['output']['header'] = str_replace(array(
		'{show_datetime_hide_styleattr}',
    '{lng_start}',
    '{lng_end}',
    '{lng_created}',
    '{lng_title}',
    '{lng_current}',
    '{lng_actions}',
    '{lng_category}'
  ),
  array(
		($_AS['article_obj']->getSetting('lv_show_datetime')!='false'?'':'style="display:none !important;"'),
    '<a href="'.$_AS['sort_base_url'].'&sort='.$_AS['temp']['sortlinkvalsnew']['SDT'].'">'.$_AS['article_obj']->lang->get('start').'&nbsp;&uarr;&darr;'.'</a>',
    '<a href="'.$_AS['sort_base_url'].'&sort='.$_AS['temp']['sortlinkvalsnew']['EDT'].'">'.$_AS['article_obj']->lang->get('end').'&nbsp;&uarr;&darr;'.'</a>',
    '<a href="'.$_AS['sort_base_url'].'&sort='.$_AS['temp']['sortlinkvalsnew']['CTD'].'">'.$_AS['article_obj']->lang->get('created').'&nbsp;&uarr;&darr;'.'</a>',
    $_AS['article_obj']->lang->get('title'),
    $_AS['article_obj']->lang->get('current'),
    $_AS['article_obj']->lang->get('actions'),
    '<th width="20%" align="left">'.$_AS['article_obj']->lang->get('article_category').'&nbsp;</th>'
  ),
  $_AS['tpl']['list_header']);














$i=0;


$_AS['current_page']=$_AS['cms_wr']->getVal('page');;
$_AS['no_of_entries']=$_AS['article_obj']->getSetting('number_of_entries');
if (empty($_AS['current_page']))
	$_AS['current_page']=1;

$_AS['pager'] =& new Paginator($_AS['current_page'],$_AS['collection']->countitems());
//sets the number of records displayed
//defaults to five			
$_AS['pager']->set_Limit($_AS['no_of_entries']);
$_AS['pager']->set_Links(10); 
//if using numbered links this will set the number before and behind 
//the current page.

//gets starting point.
$_AS['pager_limit1'] = $_AS['pager']->getRange1();	 
//gets number of items displayed on page.
$_AS['pager_limit2'] = $_AS['pager']->getRange2();	 

$_AS['pager_links'] = $_AS['pager']->getLinkArr();
$_AS['pager_current']=$_AS['pager']->getCurrent();			

$_AS['pager_base_url']=$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring']);

$_AS['page_nav']='';

if ($_AS['pager']->getTotalPages()>1) {
	if($_AS['article_obj']->getSetting('show_articles_pages_dir')=='false') {

		if($_AS['pager']->getPrevious())
			$_AS['page_nav'] .= '<a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager']->getPrevious().'">&lsaquo;&lsaquo;</a>';
		for($i=0;$i<count($_AS['pager_links']);$i++) {
			$_AS['pager_link']=$_AS['pager_links'][$i];
			if($_AS['pager_link'] == $_AS['current_page'])
					$_AS['page_nav'] .= '&nbsp;<span class="akt"><a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager_link'].'">'.($_AS['pager_link']).'</a></span>';
			else
					$_AS['page_nav'] .= '&nbsp;<a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager_link'].'">'.($_AS['pager_link']).'</a>';
		}
		if($_AS['pager']->getNext())
			$_AS['page_nav'] .= '&nbsp;<a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager']->getNext().'">&rsaquo;&rsaquo;</a>';
	
	} else {
	
		if($_AS['pager']->getNext())
			$_AS['page_nav'] .= '<a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager']->getNext().'">&lsaquo;&lsaquo;</a>';
		for($i=count($_AS['pager_links'])-1;$i>=0;$i--) {
			$_AS['pager_link']=$_AS['pager_links'][$i];
			if($_AS['pager_link'] == $_AS['current_page'])
					$_AS['page_nav'] .= '&nbsp;<span class="akt"><a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager_link'].'">'.(1+$_AS['pager']->getTotalPages()-$_AS['pager_link']).'</a></span>';
			else
					$_AS['page_nav'] .= '&nbsp;<a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager_link'].'">'.(1+$_AS['pager']->getTotalPages()-$_AS['pager_link']).'</a>';
		}
		if($_AS['pager']->getPrevious())
			$_AS['page_nav'] .= '&nbsp;<a href="'.$_AS['pager_base_url'].'&page='.$_AS['pager']->getPrevious().'">&rsaquo;&rsaquo;</a>';	

	}

}






$_AS['collection']->setLimit($_AS['pager_limit2'],$_AS['pager_limit1']);

$_AS['collection']->setSorting( $_AS['sorting']['array']);

$_AS['collection']->generate();

$_AS['items']=$_AS['collection']->get();
$_AS['items_arrays']=$_AS['items']->arr;		

//F&uuml;r jeden geladenenen Eintrag durchlaufen
foreach ($_AS['items_arrays'] as $v) {

    //Tpl in Tmp-Var kopieren
    $_AS['temp']['list_output'] = $_AS['tpl']['list_row'];

		$_AS['current_item']=$v->_data;

    //Anker setzen, wenn ben&ouml;tigt
    if($_AS['cms_wr']->getVal('idarticle') == $_AS['current_item']['idarticle']) {
        $_AS['temp']['list_output'] = str_replace('{anchor}', '<a name="anchor">&nbsp;</a>', $_AS['temp']['list_output']);
    } else {
        $_AS['temp']['list_output'] = str_replace('{anchor}', '&nbsp;', $_AS['temp']['list_output']);
    }

    //Row-ID ersetzen
    $_AS['temp']['list_output'] = str_replace('{trid}', $i, $_AS['temp']['list_output']);
    $i++; //Zeilennummer erh&ouml;hen
    $_AS['temp']['list_output'] = str_replace('{online}', $_AS['current_item']['online'], $_AS['temp']['list_output']);
    $_AS['temp']['list_output'] = str_replace('{turnus_type}', $_AS['current_item']['turnus_type'], $_AS['temp']['list_output']);

    //Startdate
    if($_AS['current_item']['article_startdate_yn'] == 1)
      $_AS['temp']['list_output'] = str_replace('{startdate}', date($_AS['config']['date'], strtotime($_AS['current_item']['article_startdate'])), $_AS['temp']['list_output']);
		else
      $_AS['temp']['list_output'] = str_replace('{startdate}','<span class="grey">'.date($_AS['config']['date'], strtotime($_AS['current_item']['created'])).'</span>', $_AS['temp']['list_output']);
			
    //Starttime
    if($_AS['current_item']['article_startdate_yn'] == 1 && $_AS['current_item']['article_starttime_yn'] == 1) {
      $_AS['temp']['list_output'] = str_replace('{starttime}', date($_AS['config']['time'], strtotime($_AS['current_item']['article_starttime'])).$_AS['article_obj']->lang->get('hour'), $_AS['temp']['list_output']);
    } else {
      $_AS['temp']['list_output'] = str_replace('{starttime}', '', $_AS['temp']['list_output']);
    }

    //Enddate - einmalige gesondert behandeln
    if($_AS['current_item']['article_enddate_yn'] == 1 ) {
      $_AS['temp']['list_output'] = str_replace('{enddate}', date($_AS['config']['date'], strtotime($_AS['current_item']['article_enddate'])), $_AS['temp']['list_output']);
    } else {
      $_AS['temp']['list_output'] = str_replace('{enddate}', '', $_AS['temp']['list_output']);
    }

    //Endtime
    if($_AS['current_item']['article_enddate_yn'] == 1 && $_AS['current_item']['article_endtime_yn'] == 1) {
      $_AS['temp']['list_output'] = str_replace('{endtime}', date($_AS['config']['time'], strtotime($_AS['current_item']['article_endtime'])).$_AS['article_obj']->lang->get('hour'), $_AS['temp']['list_output']);
    } else {
      $_AS['temp']['list_output'] = str_replace('{endtime}', '', $_AS['temp']['list_output']);
    }
    
    //Created date
    $_AS['temp']['list_output'] = str_replace('{created}', date($_AS['config']['date'], strtotime($_AS['current_item']['created'])), $_AS['temp']['list_output']);

    //Katgorie?
    if($_AS['article_obj']->getSetting('set_category')==1 &&
      count($_AS['select']['catdata'])>1 ) {	

    unset($_AS['temp']['categories_string'],$_AS['temp']['categories_string_array']);

		if (strpos($_AS['current_item']['idcategory'],'|')!==false) {
		
			$_AS['temp']['categories_string_array']=array();
		
			foreach(array_filter(explode('|',$_AS['current_item']['idcategory'])) as $v)
				$_AS['temp']['categories_string_array'][]=(strlen($_AS['select']['catdata'][$v])>16)?substr($_AS['select']['catdata'][$v],0,16).'&nbsp;...':$_AS['select']['catdata'][$v];
		
			$_AS['temp']['categories_string']=implode('<br/>',$_AS['temp']['categories_string_array']);
		
		} elseif ($_AS['current_item']['idcategory']!='')					
      $_AS['temp']['categories_string']=$_AS['select']['catdata'][$_AS['current_item']['idcategory']];
    
      $_AS['temp']['list_output'] = str_replace('{category}','<td class="entry">'.$_AS['temp']['categories_string'].'</td>', $_AS['temp']['list_output']);
    
    } else {
    	// remove category-column placeholder if no categories are available or feature is off
      $_AS['temp']['list_output'] = str_replace('{category}', '', $_AS['temp']['list_output']);
    }
    
    //fields
    $_AS['temp']['list_output_fields'] = '';
    $_AS['temp']['list_output_fields_arr'] = $_AS['temp']['list_output_header_fieldarr'];
		foreach ($_AS['temp']['list_output_fields_arr'] as $kk => $vv){
			$vv=trim($vv);
			$_AS['temp']['field_value']=stripslashes($_AS['current_item'][$vv]);
			
			if (strpos($vv,'custom')!==false) {
				$_AS['temp']['field_type']=stripslashes($_AS['article_obj']->getSetting('article_'.$vv.'_type'));
			
				if ($_AS['temp']['field_type']=='pic' ||
						$_AS['temp']['field_type']=='link' ||
						$_AS['temp']['field_type']=='file') {
					$_AS['temp']['value_arr']=explode("\n",$_AS['temp']['field_value']);
					$_AS['temp']['field_value']=trim($_AS['temp']['value_arr'][0]);//url
				}
				if ($_AS['temp']['field_type']=='check' ||
						$_AS['temp']['field_type']=='radio' ||
						$_AS['temp']['field_type']=='select' ||
						$_AS['temp']['field_type']=='select2') {

						$_AS['temp']['tempdataarray']=array();
			    	$_AS['temp']['tempdata']=trim($_AS['article_obj']->getSetting('article_'.$vv.'_select_values'));
						if (!empty($_AS['temp']['tempdata'])){
				    	$_AS['temp']['temparray']=explode("\n",$_AS['temp']['tempdata']);
			    		foreach ($_AS['temp']['temparray'] as $k => $v) {
			    			$va=explode('||',trim($v));
			    			$_AS['temp']['tempdataarray'][$va[0]]=empty($va[1])?$va[0]:$va[1];
			    		}
			    	}
						$_AS['temp']['tempvals'] = explode('||',$_AS['temp']['field_value']);
						$_AS['temp']['tempvalsfinal'] = array();
		
						foreach ($_AS['temp']['tempvals'] as $v)
							$_AS['temp']['tempvalsfinal'][]=$_AS['temp']['tempdataarray'][$v];
												  
						$_AS['temp']['field_value']	=	implode(', ',$_AS['temp']['tempvalsfinal']);
						if (empty($_AS['temp']['field_value']))
							$_AS['temp']['field_value']	=	implode(', ',$_AS['temp']['tempvals']);

				}
				if ($_AS['temp']['field_type']=='date') {
					if($_AS['temp']['field_value']!='0000-00-00' &&
						 $_AS['temp']['field_value']!='--' && 
						 $_AS['temp']['field_value']!=''){
				     $_AS['temp']['field_value']	=	@date($_AS['config']['date'], strtotime($_AS['temp']['field_value']));
		      } else {
		      	$_AS['temp']['field_value']	=	'';
		      }
				}
				if ($_AS['temp']['field_type']=='time') {
					if($_AS['temp']['field_value']!='00:00' &&
						 $_AS['temp']['field_value']!=''){
				     $_AS['temp']['field_value']	=	@date($_AS['config']['time'], strtotime($_AS['temp']['field_value']));
		      } else {
		      	$_AS['temp']['field_value']	=	'';
		      }
				}
				if ($_AS['temp']['field_type']=='datetime') {

					if($_AS['temp']['field_value']!='0000-00-00 00:00' &&
						 $_AS['temp']['field_value']!='-- 00:00' && 
						 $_AS['temp']['field_value']!=''){
				     $_AS['temp']['field_value']	=	@date($_AS['config']['date'].' '.$_AS['config']['time'], strtotime($_AS['temp']['field_value']));
		      } else {
		      	$_AS['temp']['field_value']	=	'';
		      }
				}
				if ($_AS['temp']['field_type']=='textarea')
					$_AS['temp']['field_value']=nl2br($_AS['temp']['field_value']);
			}
      $_AS['temp']['list_output_fields'] .= str_replace('{value}', $_AS['temp']['field_value'], $_AS['tpl']['list_row_fieldssub']);
			$_AS['temp']['column_width']=round(((int) $_AS['temp']['list_output_header_fieldarr_width'][$kk]*85)/100);
			if ($_AS['temp']['column_width']>0)
      	$_AS['temp']['list_output_fields'] = str_replace('{colwidth}', 'width="'.$_AS['temp']['column_width'].'%"', $_AS['temp']['list_output_fields']);
			else
      	$_AS['temp']['list_output_fields'] = str_replace('{colwidth}', '', $_AS['temp']['list_output_fields']);

    }

		$_AS['temp']['list_output'] = str_replace('{list_row_fieldssub}', $_AS['temp']['list_output_fields'],$_AS['temp']['list_output']);

		$valid	= true;
		$valid	= available(array(	'article_startdate' 	=> $_AS['current_item']['article_startdate'],
																'article_starttime_yn' 	=> $_AS['current_item']['article_starttime_yn'],
																'article_starttime' 	=> $_AS['current_item']['article_starttime'],
																'article_enddate_yn' 	=> $_AS['current_item']['article_enddate_yn'],
																'article_enddate' 		=> $_AS['current_item']['article_enddate'],
																'article_endtime_yn' 	=> $_AS['current_item']['article_endtime_yn'],
																'article_endtime' 		=> $_AS['current_item']['article_endtime'] )
											);

		if ($_AS['article_obj']->getSetting('lv_show_onoffline')=='false')
			$_AS['temp']['list_output'] = str_replace('{state}&nbsp;&nbsp;', '',$_AS['temp']['list_output']);


    //Aktionslinks
    if($_AS['current_item']['online'] == 1) {
    		if ($_AS['current_item']['article_enddate_yn']==1 && $valid===true){
					$_AS['temp']['list_output'] = str_replace('{state}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=switch_offline&idarticle='.$_AS['current_item']['idarticle']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring'].'#anchor"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_online_timeron.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('switch_offline').'"/></a>', $_AS['temp']['list_output']);
     		} else if ($_AS['current_item']['article_enddate_yn']==1 && $valid!==true){
					$_AS['temp']['list_output'] = str_replace('{state}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=switch_offline&idarticle='.$_AS['current_item']['idarticle']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring'].'#anchor"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_online_timeroff.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('switch_offline').'"/></a>', $_AS['temp']['list_output']);
    		} else {
          $_AS['temp']['list_output'] = str_replace('{state}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=switch_offline&idarticle='.$_AS['current_item']['idarticle']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring'].'#anchor"><img src="tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_online.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('switch_offline').'"/></a>', $_AS['temp']['list_output']);
    		}
    } else {
        $_AS['temp']['list_output'] = str_replace('{state}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=switch_online&idarticle='.$_AS['current_item']['idarticle']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring'].'#anchor"><img src="tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_offline.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('switch_online').'"/></a>', $_AS['temp']['list_output']);
    }

		if ($_AS['article_obj']->getSetting('use_archive'))
      if($_AS['current_item']['archived'] == 1) {
          $_AS['temp']['list_output'] = str_replace('{archived}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=switch_dearchive&idarticle='.$_AS['current_item']['idarticle']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring'].'#anchor" onClick="return confirmarchive()"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/flag_red.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('switch_dearchive').'"/></a>', $_AS['temp']['list_output']);
      } else {
          $_AS['temp']['list_output'] = str_replace('{archived}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=switch_archive&idarticle='.$_AS['current_item']['idarticle']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring'].'#anchor" onClick="return confirmarchive()"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/flag_green.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('switch_archive').'"/></a>', $_AS['temp']['list_output']);
      }
    else
			$_AS['temp']['list_output'] = str_replace('{archived}&nbsp;&nbsp;', '',$_AS['temp']['list_output']);

    $_AS['temp']['list_output'] = str_replace('{edit}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=edit_article&idarticle='.$_AS['current_item']['idarticle'].'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring']).'"><img src="tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_edit.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('edit').'"/></a>', $_AS['temp']['list_output']);
    $_AS['temp']['list_output'] = str_replace('{dupl}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea=article&action=dupl_article&idarticle='.$_AS['current_item']['idarticle'].'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring']).'"><img src="tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_duplicate.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('dupl').'"/></a>', $_AS['temp']['list_output']);

		if((int) $_AS['current_item']['protected'] < 1)
    	$_AS['temp']['list_output'] = str_replace('{delete}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=delete_article&idarticle='.$_AS['current_item']['idarticle']).'&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring'].'" onClick="return confirmdelete()"><img src="tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_deleteside.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('delete').'"/></a>', $_AS['temp']['list_output']);
		else
    	$_AS['temp']['list_output'] = str_replace('{delete}', '<img src="tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_deleteside.gif" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('notdeletable').'" class="disabled">', $_AS['temp']['list_output']);



    //Aktionslinks
		if ($_AS['article_obj']->getSetting('spfnc_facebook')=='true') {
	    if($_AS['current_item']['online'] == 1) {
	   		if ($_AS['current_item']['article_enddate_yn']==1 && $valid===true){
		    	$_AS['temp']['list_output'] = str_replace('{facebook}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'plugins/articlesystem/export.php?db='.$_AS['db'].'&action=facebook&lang='.$lang.'&client='.$client.'&idarticle='.$_AS['current_item']['idarticle']).'&keepThis=true&TB_iframe=true&width=655&height=50" class="thickbox" title="'.$_AS['article_obj']->lang->get('spfnc_facebook_section').'"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_facebook.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('facebook').'"/></a>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	   		} else if ($_AS['current_item']['article_enddate_yn']==1 && $valid!==true){
		    	$_AS['temp']['list_output'] = str_replace('{facebook}', '<img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_facebook.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('facebook').'" class="disabled"/>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	   		} else {
		    	$_AS['temp']['list_output'] = str_replace('{facebook}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'plugins/articlesystem/export.php?db='.$_AS['db'].'&action=facebook&lang='.$lang.'&client='.$client.'&idarticle='.$_AS['current_item']['idarticle']).'&keepThis=true&TB_iframe=true&width=655&height=50" class="thickbox" title="'.$_AS['article_obj']->lang->get('spfnc_facebook_section').'"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_facebook.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('facebook').'"/></a>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	   		}
	    } else {
		    	$_AS['temp']['list_output'] = str_replace('{facebook}', '<img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_facebook.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('facebook').'" class="disabled"/>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	    }
    } else 
    	$_AS['temp']['list_output'] = str_replace('{facebook}', '', $_AS['temp']['list_output']);

		if ($_AS['article_obj']->getSetting('spfnc_twitter')=='true') {
	    if($_AS['current_item']['online'] == 1) {
	   		if ($_AS['current_item']['article_enddate_yn']==1 && $valid===true){
		    	$_AS['temp']['list_output'] = str_replace('{twitter}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'plugins/articlesystem/export.php?db='.$_AS['db'].'&action=twitter&lang='.$lang.'&client='.$client.'&idarticle='.$_AS['current_item']['idarticle']).'&keepThis=true&TB_iframe=true&width=655&height=140" class="thickbox" title="'.$_AS['article_obj']->lang->get('spfnc_twitter_section').'"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_twitter.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('twitter').'"/></a>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	   		} else if ($_AS['current_item']['article_enddate_yn']==1 && $valid!==true){
		    	$_AS['temp']['list_output'] = str_replace('{twitter}', '<img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_twitter.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('twitter').'" class="disabled"/>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	   		} else {
		    	$_AS['temp']['list_output'] = str_replace('{twitter}', '<a href="'.$sess->url($cfg_cms['cms_html_path'].'plugins/articlesystem/export.php?db='.$_AS['db'].'&action=twitter&lang='.$lang.'&client='.$client.'&idarticle='.$_AS['current_item']['idarticle']).'&keepThis=true&TB_iframe=true&width=655&height=140" class="thickbox" title="'.$_AS['article_obj']->lang->get('spfnc_twitter_section').'"><img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_twitter.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('twitter').'"/></a>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	   		}
	    } else {
		    	$_AS['temp']['list_output'] = str_replace('{twitter}', '<img src="plugins/articlesystem/tpl/'.$_AS['article_obj']->getSetting('skin').'/img/but_twitter.png" width="16" height="16" border="0" title="'.$_AS['article_obj']->lang->get('twitter').'" class="disabled"/>&nbsp;&nbsp;', $_AS['temp']['list_output']);
	    }
    } else 
    	$_AS['temp']['list_output'] = str_replace('{twitter}', '', $_AS['temp']['list_output']);


		$_AS['temp']['list_output'] = str_replace('{idarticle}', $_AS['current_item']['idarticle'], $_AS['temp']['list_output']);

    //Zeile zur Tabelle hinzuf&uuml;gen
		if ($_AS['article_obj']->getSetting('lv_show_datetime')=='false')
			$_AS['temp']['list_output'] = str_replace('{show_datetime_hide_css}','display:none !important;',$_AS['temp']['list_output']);
		else
			$_AS['temp']['list_output'] = str_replace('{show_datetime_hide_css}','',$_AS['temp']['list_output']);
			
    $_AS['output']['body'] .= $_AS['temp']['list_output'];

}//Ende for    

if ($_AS['article_obj']->getSetting('set_category')!=1 || count($_AS['select']['catdata'])<2)
	$_AS['tpl']['list_new_number_filter'] = str_replace('{select_category}','', $_AS['tpl']['list_new_number_filter']);
//Neuer Artikel - Anzahl - Filter ersetzen
$_AS['output']['new_number_filter'] = str_replace(array(    
				'{hide_new_button}',
        '{new}',
        '{new_url}',
        '{new_label}',
        '{select_number}',
        '{select_category}',
        '{searchform_start}',
        '{searchform_end}',
        '{search}',
        '{lng_search}',
        '{lng_showrange}',
        '{range_hide_styleattr}',
        '{startrange}',
        '{endrange}'
      ),
      array(
      	(($_AS['subarea']=='archive')?'display:none;':''),
        '<a class="action" href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=new_article&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback']).'">'.$_AS['article_obj']->lang->get('action_new_article').'</a>',
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=new_article&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback']),
        $_AS['article_obj']->lang->get('action_new_article'),
        '<form name="numberform" method="post" action="main.php" style="display:inline;">
            <input type="hidden" name="area" value="'.$_AS['cms_wr']->getVal('area').'">
            <input type="hidden" name="cms_plugin" value="'.$_AS['cms_wr']->getVal('cms_plugin').'">
            <input type="hidden" name="subarea" value="'.$_AS['cms_wr']->getVal('subarea').'">
            <input type="hidden" name="action" value="'.$_AS['cms_wr']->getVal('action').'">
            <input type="hidden" name="startmonth" value="'.$_AS['config']['startmonth'].'">
            <input type="hidden" name="callist_flt_category" value="'.$_AS['cms_wr']->getVal('callist_flt_category').'">
             <input type="hidden" name="callist_search" value="">
            <input type="hidden" name="'.$sess->name.'" value="'.$sess->id.'">
            '.$_AS['article_obj']->getSelectMonthBack('monthback', $_AS['config']['monthback'], ' style="font-weight:bold;"', ' onChange="numberform.submit()"', true).'
        </form>',
        '<form name="form_callist_flt_category" method="post" action="main.php" style="'.
        ($_AS['article_obj']->getSetting('lv_show_catfilter')!='false'?'display:inline;':'display:none;').'">
            <input type="hidden" name="area" value="'.$_AS['cms_wr']->getVal('area').'">
            <div style="display:none;"><input type="hidden" name="cms_plugin" value="'.$_AS['cms_wr']->getVal('cms_plugin').'">
            <input type="hidden" name="subarea" value="'.$_AS['cms_wr']->getVal('subarea').'">
            <input type="hidden" name="action" value="'.$_AS['cms_wr']->getVal('action').'">
            <input type="hidden" name="startmonth" value="'.$_AS['config']['startmonth'].'">
            <input type="hidden" name="monthback" value="'.$_AS['cms_wr']->getVal('monthback').'">
            <input type="hidden" name="callist_search" value="'.$_AS['temp']['searchstring'].'">
            <input type="hidden" name="'.$sess->name.'" value="'.$sess->id.'"></div>
            '.$_AS['article_obj']->getSelectUni(	'callist_flt_category',
																							 $_AS['cms_wr']->getVal('callist_flt_category'),
																							 $_AS['select']['catdata'],
																								'callist_flt_category',
																								'form_callist_flt_category.submit();return false;',
																								'').'
        </form>',
        '<form name="form_callist_search" method="post" action="main.php" style="'.
        ($_AS['article_obj']->getSetting('lv_show_search')!='false'?'display:inline;':'display:none;').'">
            <input type="hidden" name="area" value="'.$_AS['cms_wr']->getVal('area').'">
            <input type="hidden" name="cms_plugin" value="'.$_AS['cms_wr']->getVal('cms_plugin').'">
            <input type="hidden" name="subarea" value="'.$_AS['cms_wr']->getVal('subarea').'">
            <input type="hidden" name="action" value="'.$_AS['cms_wr']->getVal('action').'">
            <input type="hidden" name="startmonth" value="'.$_AS['config']['startmonth'].'">
            <input type="hidden" name="monthback" value="'.$_AS['cms_wr']->getVal('monthback').'">
            <input type="hidden" name="callist_flt_category" value="'.$_AS['cms_wr']->getVal('callist_flt_category').'">
            <input type="hidden" name="'.$sess->name.'" value="'.$sess->id.'">',
        '</form>',
        '<input type="text" name="callist_search" value="'.$_AS['temp']['searchstring'].'" class="search_input"/>',
        $_AS['article_obj']->lang->get('search'),
        ($_AS['config']['monthback'] != -1) ? $_AS['article_obj']->lang->get('showrange').':':'',
        ($_AS['article_obj']->getSetting('lv_show_range')!='false'?'style="display:inline;"':'style="display:none;"'),
        ($_AS['config']['monthback'] == -1) ? $_AS['article_obj']->lang->get('turnus_all') : date($_AS['config']['date'], mktime(0,0,0,$_AS['config']['startmonth'],1)),
        ($_AS['config']['monthback'] == -1) ? '' : ' - '.date($_AS['config']['date'], mktime(23,59,59,$_AS['config']['startmonth']+$_AS['config']['monthback']-1,date("t",mktime(23,59,59,$_AS['config']['startmonth']+$_AS['config']['monthback']-1))))
      ),
      $_AS['tpl']['list_new_number_filter']);



// custom filter 
$_AS['temp']['lv_cf']['html']='';
$_AS['temp']['lv_cf']['setting'] = $_AS['article_obj']->getSetting('lv_customfilter');
$_AS['temp']['lv_cf']['setting']=trim($_AS['temp']['lv_cf']['setting']);
if (!empty($_AS['temp']['lv_cf']['setting'])) {
	foreach (explode("\n",$_AS['temp']['lv_cf']['setting']) as $i) {
	
			$i=trim($i);
	
			if (  $_AS['article_obj']->getSetting('article_'.$i.'_label')!="" && (
						$_AS['article_obj']->getSetting('article_'.$i.'_type')=="select" ||
						$_AS['article_obj']->getSetting('article_'.$i.'_type')=="select2" ||
						$_AS['article_obj']->getSetting('article_'.$i.'_type')=="radio" ||
						$_AS['article_obj']->getSetting('article_'.$i.'_type')=="check" ) ) {


		$_AS['custom']['tempdataarray']=array();
  	$_AS['custom']['tempdatastatic']=trim($_AS['article_obj']->getSetting('article_'.$i.'_select_values'));
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
		$sql = "SELECT ".$i." FROM ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']." 
						WHERE idclient=".$client." AND idlang=".$lang;
    $db -> query($sql);
		while($db -> next_record()) {
			$vb=htmlentities(trim($db->f($i)),ENT_COMPAT,'UTF-8');
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

		$_AS['custom']['tempdataarray']=array_unique($_AS['custom']['tempdataarray']);
		$_AS['custom']['tempdataarray']=array_filter($_AS['custom']['tempdataarray']);

		$_AS['custom']['tempdataarray']=as_natksort($_AS['custom']['tempdataarray']);
  	$_AS['custom']['tempdataarray']=as_array_merge(array(''=>$_AS['article_obj']->getSetting('article_'.$i.'_label').' '.$_AS['article_obj']->lang->get('filter')),$_AS['custom']['tempdataarray']);

		$_AS['temp']['lv_cf']['html'].=$_AS['article_obj']->getSelectUni(	$i.'_filter',
																							 												$_AS['cms_wr']->getVal($i.'_filter'),
																																			$_AS['custom']['tempdataarray'],
																																			$i.'_filter',
																																			'form_callist_flt_category.submit();return false;',
																																			' ');

	}

}

}





if ($_AS['article_obj']->getSetting('set_category')!=1 || count($_AS['select']['catdata'])<2)
	$_AS['tpl']['list_range_prevnext'] = str_replace('{select_category}','', $_AS['tpl']['list_range_prevnext']);

$_AS['output']['list_range_prevnext'] = str_replace(array(
        '{lng_showrange}',
        '{prev}',
        '{next}',
        '{prev_url}',
        '{next_url}',
        '{prev_label}',
        '{next_label}',
        '{startrange}',
        '{endrange}',
        '{select_number}',
        '{new}',
        '{select_category}',
        '{range_hide_styleattr}',
        '{colspan}'
      ),
      array(
        $_AS['article_obj']->lang->get('showrange'),
        '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']-$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'].'">'.$_AS['article_obj']->lang->get('prev').'</a>',
        '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']+$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'].'">'.$_AS['article_obj']->lang->get('next').'</a>',
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']-$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'],
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']+$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'],
        $_AS['article_obj']->lang->get('prev'),
        $_AS['article_obj']->lang->get('next'),
        ($_AS['config']['monthback'] == -1) ? $_AS['article_obj']->lang->get('turnus_all') : date($_AS['config']['date'], mktime(0,0,0,$_AS['config']['startmonth'],1)),
        ($_AS['config']['monthback'] == -1) ? '' : ' - '.date($_AS['config']['date'], mktime(23,59,59,$_AS['config']['startmonth']+$_AS['config']['monthback']-1,date("t",mktime(23,59,59,$_AS['config']['startmonth']+$_AS['config']['monthback']-1)))),
        '<form name="numberform" method="post" action="main.php" style="'.
        ($_AS['article_obj']->getSetting('lv_show_range')!='false'?'display:inline;':'display:none;').'">
            <input type="hidden" name="area" value="'.$_AS['cms_wr']->getVal('area').'">
            <input type="hidden" name="cms_plugin" value="'.$_AS['cms_wr']->getVal('cms_plugin').'">
            <input type="hidden" name="subarea" value="'.$_AS['cms_wr']->getVal('subarea').'">
            <input type="hidden" name="action" value="'.$_AS['cms_wr']->getVal('action').'">
            <input type="hidden" name="startmonth" value="'.$_AS['config']['startmonth'].'">
            <input type="hidden" name="callist_flt_category" value="'.$_AS['cms_wr']->getVal('callist_flt_category').'">
						<input type="hidden" name="callist_search" value="">          
            <input type="hidden" name="'.$sess->name.'" value="'.$sess->id.'">
            '.$_AS['article_obj']->getSelectMonthBack('monthback', $_AS['config']['monthback'], ' style="font-weight:bold;"', ' onChange="numberform.submit()"', true).'
        </form>',				
        $_AS['output']['new_number_filter'],
        '<form name="form_callist_flt_category" method="post" action="main.php" style="'.
        ($_AS['article_obj']->getSetting('lv_show_catfilter')!='false'?'display:inline;':'display:none;').'">
            <input type="hidden" name="area" value="'.$_AS['cms_wr']->getVal('area').'">
            <div style="display:none;"><input type="hidden" name="cms_plugin" value="'.$_AS['cms_wr']->getVal('cms_plugin').'">
            <input type="hidden" name="subarea" value="'.$_AS['cms_wr']->getVal('subarea').'">
            <input type="hidden" name="action" value="'.$_AS['cms_wr']->getVal('action').'">
            <input type="hidden" name="startmonth" value="'.$_AS['config']['startmonth'].'">
            <input type="hidden" name="monthback" value="'.$_AS['cms_wr']->getVal('monthback').'">
            <input type="hidden" name="callist_search" value="'.$_AS['temp']['searchstring'].'">
            <input type="hidden" name="'.$sess->name.'" value="'.$sess->id.'"></div>
            '.$_AS['article_obj']->getSelectUni(	'callist_flt_category',
																							 $_AS['cms_wr']->getVal('callist_flt_category'),
																							 $_AS['select']['catdata'],
																								'callist_flt_category',
																								'form_callist_flt_category.submit();return false;',
																								' ').
					$_AS['temp']['lv_cf']['html'].'
        </form>',
        ($_AS['article_obj']->getSetting('lv_show_range')!='false'?'':'style="display:none !important;"'),
				(($_AS['article_obj']->getSetting('set_category')==1 && count($_AS['select']['catdata'])>1)?7:6)
      ),
      $_AS['tpl']['list_range_prevnext']);

							
//vorherige - n&auml;chste ersetzen
$_AS['output']['list_prevnext'] = str_replace(array(
				'{archive_selected_icon}',
				'{hide_archive_selected_button}',			
				'{hide_twitter_selected_button}',			
				'{hide_facebook_selected_button}',
				'{facebook_pub}',
				'{twitter_pub}',
				'{page_nav}',
        '{prev}',
        '{next}',
        '{prev_url}',
        '{next_url}',
        '{prev_label}',
        '{next_label}',
        '{select_number}',
#            '{select_turnus}',
        '{new}',
        '{colspan}'
      ),
      array(
      (($_AS['subarea']=='archive')?'flag_red.gif':'flag_green.gif'),
      ((!$_AS['article_obj']->getSetting('use_archive'))?'display:none;':''),
      (($_AS['article_obj']->getSetting('spfnc_twitter')!='true')?'display:none;':''),
      (($_AS['article_obj']->getSetting('spfnc_facebook')!='true')?'display:none;':''),
      $_AS['article_obj']->lang->get('spfnc_facebook_section'),
      $_AS['article_obj']->lang->get('spfnc_twitter_section'),
       $_AS['page_nav'],
        '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']-$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'].'">'.$_AS['article_obj']->lang->get('prev').'</a>',
        '<a href="'.$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']+$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'].'">'.$_AS['article_obj']->lang->get('next').'</a>',
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']-$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'],
        $sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&startmonth='.($_AS['config']['startmonth']+$_AS['config']['monthback'])).'&monthback='.$_AS['config']['monthback'],
        $_AS['article_obj']->lang->get('prev'),
        $_AS['article_obj']->lang->get('next'),
        '<form name="numberform" method="post" action="main.php" style="display:inline;">
            <input type="hidden" name="area" value="'.$_AS['cms_wr']->getVal('area').'">
            <input type="hidden" name="cms_plugin" value="'.$_AS['cms_wr']->getVal('cms_plugin').'">
            <input type="hidden" name="subarea" value="'.$_AS['cms_wr']->getVal('subarea').'">
            <input type="hidden" name="action" value="'.$_AS['cms_wr']->getVal('action').'">
            <input type="hidden" name="startmonth" value="'.$_AS['config']['startmonth'].'">
            <input type="hidden" name="callist_flt_category" value="'.$_AS['cms_wr']->getVal('callist_flt_category').'">
            <input type="hidden" name="callist_search" value="'.$_AS['temp']['searchstring'].'">
            <input type="hidden" name="'.$sess->name.'" value="'.$sess->id.'">
            '.$_AS['article_obj']->getSelectMonthBack('monthback', $_AS['config']['monthback'], ' style="font-weight:bold;"', ' onChange="numberform.submit()"', true).'
        </form>',
#            $_AS['article_obj']->getSelectTurnus('', '', 'onChange="selectFilterTable(\'articlelist\', this);"', true, true),
         $_AS['output']['new_number_filter'],
        (($_AS['article_obj']->getSetting('set_category')==1 && count($_AS['select']['catdata'])>1)?7:6)
      ),
      $_AS['tpl']['list_prevnext']);


//Eintrag gefunden
if($_AS['collection']->count() > 0) {
    $_AS['output']['list_body'] = str_replace('{body}', $_AS['output']['header'].$_AS['output']['body'], $_AS['tpl']['list_body']);

//Keine Einträge gefunden
} else {
    $_AS['temp']['nothing_found'] = $_AS['output']['header'];
    $_AS['temp']['nothing_found'] .= str_replace('{colspan}', (($_AS['article_obj']->getSetting('set_category')==1 && count($_AS['select']['catdata'])>1)?7:6), $_AS['tpl']['nothing_found']);
    $_AS['temp']['nothing_found'] = str_replace('{msg}', $_AS['article_obj']->lang->get('nothing_found'), $_AS['tpl']['nothing_found']);

    $_AS['output']['list_body'] = str_replace('{body}', $_AS['temp']['nothing_found'], $_AS['tpl']['list_body']);
}


//Ausgabe der ersetzten Tpls
echo $_AS['output']['new_number_filter'];

//vorherige - n&auml;chste ersetzen
echo str_replace(array(	
			'{list_prevnext}',
			'{list_range_prevnext}',
			'{question_delete}',
      '{question_reset}',
      '{question_archive}',
      '{revert_selection}',
      '{delete_selected}',
			'{show_onoffline_styleattr}',
      '{formurl}',
      '{skin}',
      '{export_url}',
      '{db}'
      ),
      array(
			$_AS['output']['list_prevnext'],
			$_AS['output']['list_range_prevnext'],
			$_AS['article_obj']->lang->get('question_delete'),
			$_AS['article_obj']->lang->get('question_reset'),
			(($_AS['subarea']=='archive')?$_AS['article_obj']->lang->get('question_dearchive'):$_AS['article_obj']->lang->get('question_archive')),
			$_AS['article_obj']->lang->get('revert_selection'),
			$_AS['article_obj']->lang->get('delete_selected'),
			($_AS['article_obj']->getSetting('lv_show_onoffline')=='false'?'style="display:none;"':''),
			$sess->url($cfg_cms['cms_html_path'].'main.php?area=plugin&cms_plugin='.$_AS['db'].'/index.php&subarea='.$_AS['subarea'].'&action=show_article&page='.$_AS['current_page'].$_AS['temp']['lv_cf']['urladdon'].'&callist_flt_category='.$_AS['cms_wr']->getVal('callist_flt_category').'&callist_search='.$_AS['temp']['searchstring'].'&startmonth='.$_AS['config']['startmonth'].'&monthback='.$_AS['config']['monthback'].'&sort='.$_AS['temp']['sortlinkvalsoldstring']),
			$_AS['article_obj']->getSetting('skin'),
			$sess->url($cfg_cms['cms_html_path'].'plugins/articlesystem/export.php?lang='.$lang.'&client='.$client),
			$_AS['db']
      ),
      $_AS['output']['list_body']);


?>
