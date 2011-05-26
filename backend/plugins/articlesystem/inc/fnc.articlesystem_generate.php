<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

	
if(! function_exists(as_str_chop)){
	/**
	* Chop a string into a smaller string.
	* @author			Aidan Lister <aidan@php.net>
	* @author2		Alexander M. Korn <amk@gmx.info>
	* @version		?
	* @link				http://aidanlister.com/repos/v/function.str_chop.php
	* @param				mixed	 $string	 The string you want to shorten
	* @param				int		 $length	 The length you want to shorten the string to
	* @param				bool	 $center	 If true, chop in the middle of the string
	* @param				mixed	 $append	 String appended if it is shortened
	*/
	function as_str_chop($string, $length = 60, $center = true, $append = null, $txttransfrom=true)
	{

		$string=strip_tags($string);
		 // Set the default append string
		if ($append === null) {
				 $append = ($center === true) ? ' ... ' : ' ...';
		}
		
		preg_match_all('#\&(.*)\;#sU',$string,$entities);
		$entities[0]=array_unique($entities[0]);
		if (is_array($entities[0]) && !empty($entities[0]))
			foreach($entities[0] as $v)
				$string=(str_replace( $v,utf8_encode(html_entity_decode( $v)),$string));
		
		if ($center==="true")
			$center=true;			
		
		 // Get some measurements
		 $len_string = strlen($string);
		 $len_append = strlen($append);
		 
		if ($len_string > $length) {
			
		 // If the string is longer than the maximum length, we need to chop it
		 
				 // Check if we want to chop it in half
			if ($center === true) {
				// Get the lengths of each segment
				$len_start = $length / 2;
				$len_end = $len_start - $len_append;
				
				// Get each segment
				$seg_start = substr($string, 0, $len_start);
				$seg_end = substr($string, $len_string - $len_end, $len_end);
				
				$seg_start = substr( $seg_start, 0, strrpos ( $seg_start, " "));
				$seg_end = substr( $seg_end, strpos ( $seg_end, " ")+1);
				
				// Stick them together
				$string = $seg_start . $append . $seg_end;
			} else {
				// Otherwise, just chop the end off
				$string = substr($string, 0, $length - $len_append);
				$string = substr($string, 0, strrpos ($string, " ")) . $append;
			}
		} 
		if ($txttransfrom)
			return htmlentities($string,ENT_COMPAT,'UTF-8');
		else
			return $string;
#		return $string;	
	}
}

//
// as_element_replacement
//

if(! function_exists(as_element_replacement)){
  /**
  * parse article data for final output
  *
  * @param		...
  * @return		array -> for str_replace use
  * @access		public
  */
	function as_element_replacement($item_obj,
																	$artsys_obj,
																	$art_images,
																	$art_files,
																	$art_links,
																	$art_dates,
																	$tpl_main,
																	$tpl_images,
																	$tpl_files,
																	$tpl_links,
																	$tpl_dates,
																	$cat_arr,
																	$cfg_arr=array(),
																	$txttransform=true) {
		global $cfg_client,$lang,$idcat,$idcatside,$lang,$as_externalvars2elements;		
							
		$repl_arr=array();

	  //Startdate
	  $repl_arr['startdate']=date($cfg_arr['date'], $item_obj->convDate2Timestamp(0,'article_startdate'));
	  $repl_arr['startdate:day']=date($cfg_arr['day'], $item_obj->convDate2Timestamp(0,'article_startdate'));
	  $repl_arr['startdate:month']=date($cfg_arr['month'], $item_obj->convDate2Timestamp(0,'article_startdate'));
	  $repl_arr['startdate:year']=date($cfg_arr['year'], $item_obj->convDate2Timestamp(0,'article_startdate'));
	  $repl_arr['startdate:day2']=utf8_encode(strftime($cfg_arr['day2'], $item_obj->convDate2Timestamp(0,'article_startdate')));
	  $repl_arr['startdate:month2']=utf8_encode(strftime($cfg_arr['month2'], $item_obj->convDate2Timestamp(0,'article_startdate')));
	
	  //Starttime
	  if($item_obj->getDataByKey('article_starttime_yn') == 1) {
	    $repl_arr['starttime']=strftime($cfg_arr['time'], $item_obj->convDate2Timestamp(0,'article_starttime'));
	    $repl_arr['starttime24']=strftime($cfg_arr['time24'], $item_obj->convDate2Timestamp(0,'article_starttime'));
	    $repl_arr['starttime12']=strftime($cfg_arr['time12'], $item_obj->convDate2Timestamp(0,'article_starttime'));
	  } else {
	    $repl_arr['starttime']='';
	  }
	
	  //Enddate - einmalige gesondert behandeln
	  if($item_obj->getDataByKey('article_enddate_yn') == 1 ) {
	    $repl_arr['enddate']=date($cfg_arr['date'], $item_obj->convDate2Timestamp(0,'article_enddate'));
	    $repl_arr['enddate:day']=date($cfg_arr['day'], $item_obj->convDate2Timestamp(0,'article_enddate'));
	    $repl_arr['enddate:month']=date($cfg_arr['month'], $item_obj->convDate2Timestamp(0,'article_enddate'));
	    $repl_arr['enddate:year']=date($cfg_arr['year'], $item_obj->convDate2Timestamp(0,'article_enddate'));
	    $repl_arr['enddate:day2']=utf8_encode(strftime($cfg_arr['day'], $item_obj->convDate2Timestamp(0,'article_enddate')));
	    $repl_arr['enddate:month2']=utf8_encode(strftime($cfg_arr['month'], $item_obj->convDate2Timestamp(0,'article_enddate')));
	  } else {
	    $repl_arr['enddate']='';
	    $repl_arr['enddate:day']='';
	    $repl_arr['enddate:month']='';
	    $repl_arr['enddate:year']='';
	    $repl_arr['enddate:day2']='';
	    $repl_arr['enddate:month2']='';
	  }
	
	  //Endtime
	  if($item_obj->getDataByKey('article_enddate_yn') == 1 && $item_obj->getDataByKey('article_endtime_yn') == 1) {
	    $repl_arr['endtime']=strftime($cfg_arr['time'], $item_obj->convDate2Timestamp(0,'article_endtime'));
	    $repl_arr['endtime24']=strftime($cfg_arr['time24'], $item_obj->convDate2Timestamp(0,'article_endtime'));
	    $repl_arr['endtime12']=strftime($cfg_arr['time12'], $item_obj->convDate2Timestamp(0,'article_endtime'));
	  } else {
	    $repl_arr['endtime']='';
	  }

	  //Titel, Teaser, text & Turnus
	  $repl_arr['title']	=	$item_obj->getDataByKey('title',$txttransform);
	  $repl_arr['teaser']	=	nl2br($item_obj->getDataByKey('teaser',$txttransform));

		if($artsys_obj->settings['wysiwyg']=='true')
	    $repl_arr['text']	=	$item_obj->getDataByKey('text');
		else
	    $repl_arr['text']	=	nl2br($item_obj->getDataByKey('text',$txttransform));

#	  $repl_arr['turnus_type']	=	$artsys_obj->lang->get('turnus_'.$item_obj->getDataByKey('turnus_type'));

		//customs
		for ($i=1;$i<36;$i++){
	
			$repl_arr['custom:'.$i] = '';
			$repl_arr['custom_label:'.$i] = '';
			$repl_arr['custom_data:'.$i] = '';
			$repl_arr['custom_html_selectboxoptions:'.$i] = '';
			$repl_arr['custom_file:'.$i] = '';
			$repl_arr['custom_fileurl:'.$i] = '';
			$repl_arr['custom_filedesc:'.$i] = '';
			$repl_arr['custom_filetitle:'.$i] = '';
			$repl_arr['custom_filename:'.$v]			= '';
			$repl_arr['custom_filepath:'.$v]			= '';
			$repl_arr['custom_fileext:'.$v]				= '';
			$repl_arr['custom_filesize:'.$v]			= '';
			$repl_arr['custom_link:'.$i] = '';
			$repl_arr['custom_linkurl:'.$i] = '';
			$repl_arr['custom_linkdesc:'.$i] = '';
			$repl_arr['custom_linktitle:'.$i] = '';
			$repl_arr['custom_linkidcat:'.$i] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcatside_si1'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcatside_si2'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcatside_si3'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si1'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si2'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si3'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcat_si1'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcat_si2'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcat_si3'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcat_name_si1'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcat_name_si2'] = '';
			$repl_arr['custom_linkidcat:'.$i.':idcat_name_si3'] = '';
			$repl_arr['custom_linkidcatside:'.$i] = '';
			$repl_arr['custom_image:'.$i] = '';
			$repl_arr['custom_imageurl:'.$i] = '';
			$repl_arr['custom_imagethumb:'.$i] = '';
			$repl_arr['custom_imagethumburl:'.$i] = '';
			$repl_arr['custom_imagelinkurl:'.$i] = '';
			$repl_arr['custom_imagedesc:'.$i] = '';
			$repl_arr['custom_imagetitle:'.$i] = '';
			$repl_arr['custom_data:'.$i] = '';
			$repl_arr['custom:'.$i.':day'] = '';
			$repl_arr['custom:'.$i.':month'] = '';
			$repl_arr['custom:'.$i.':year'] = '';		
			$repl_arr['custom:'.$i.':day2'] = '';
			$repl_arr['custom:'.$i.':month2'] = '';
		
		// old
			if($artsys_obj->settings['article_custom'.$i.'_type']=='textarea' || 
				($artsys_obj->settings['article_custom'.$i.'_type']=='wysiwyg' && $artsys_obj->settings['wysiwyg']!='true')) {
	      $repl_arr['custom'.$i]	=	nl2br($item_obj->getDataByKey('custom'.$i,$txttransform));
				$repl_arr['custom:'.$i]	=	nl2br($item_obj->getDataByKey('custom'.$i,$txttransform));
				$repl_arr['custom_data:'.$i]	=	$item_obj->getDataByKey('custom'.$i);
			} else if($artsys_obj->settings['article_custom'.$i.'_type']=='date' ) {
				if($item_obj->getDataByKey('custom'.$i)!='0000-00-00' &&
				   $item_obj->getDataByKey('custom'.$i)!='--' && 
				   $item_obj->getDataByKey('custom'.$i)!=''){
		      $repl_arr['custom'.$i]	=	@date($cfg_arr['date'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i]	=	@date($cfg_arr['date'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':date']	=	@date($cfg_arr['date'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':timestamp']	=	strtotime($item_obj->getDataByKey('custom'.$i));
		      $repl_arr['custom:'.$i.':day']	=	@date($cfg_arr['day'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':month']	=	@date($cfg_arr['month'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':year']	=	@date($cfg_arr['year'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':day2']	=	utf8_encode(@strtotime($cfg_arr['day2'], strtotime($item_obj->getDataByKey('custom'.$i))));
		      $repl_arr['custom:'.$i.':month2']	=	utf8_encode(@strtotime($cfg_arr['month2'], strtotime($item_obj->getDataByKey('custom'.$i))));
				} else {
					$repl_arr['custom'.$i]='';
					$repl_arr['custom:'.$i]='';	
		      $repl_arr['custom:'.$i.':timestamp'] = '';
					$repl_arr['custom:'.$i.':date'];			
		      $repl_arr['custom:'.$i.':day']='';	
		      $repl_arr['custom:'.$i.':month']='';	
		      $repl_arr['custom:'.$i.':year']='';
		      $repl_arr['custom:'.$i.':day2']='';	
		      $repl_arr['custom:'.$i.':month2']='';	
				}
			} else if($artsys_obj->settings['article_custom'.$i.'_type']=='time' ) {

				if($item_obj->getDataByKey('custom'.$i)!='00:00' && $item_obj->getDataByKey('custom'.$i)!=''){
		      $repl_arr['custom'.$i]	=	strftime($cfg_arr['time'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i]	=	strftime($cfg_arr['time'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':time']	=	strftime($cfg_arr['time'], strtotime($item_obj->getDataByKey('custom'.$i)));
		    } else {
					$repl_arr['custom'.$i]='';
					$repl_arr['custom:'.$i]='';
					$repl_arr['custom:'.$i.':time'] = '';
				}

			} else if($artsys_obj->settings['article_custom'.$i.'_type']=='datetime' ) {

				if($item_obj->getDataByKey('custom'.$i)!='0000-00-00 00:00' &&
				   $item_obj->getDataByKey('custom'.$i)!='-- 00:00' && 
				   $item_obj->getDataByKey('custom'.$i)!=''){
		      $repl_arr['custom'.$i]	=	@date($cfg_arr['date'], strtotime($item_obj->getDataByKey('custom'.$i))).' '.strftime($cfg_arr['time'], strtotime($item_obj->getDataByKey('custom'.$i)));;
		      $repl_arr['custom:'.$i]	=	@date($cfg_arr['date'], strtotime($item_obj->getDataByKey('custom'.$i))).' '.strftime($cfg_arr['time'], strtotime($item_obj->getDataByKey('custom'.$i)));;
		      $repl_arr['custom:'.$i.':date']	=	@date($cfg_arr['date'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':timestamp']	=	strtotime($item_obj->getDataByKey('custom'.$i));
		      $repl_arr['custom:'.$i.':time']	=	strftime($cfg_arr['time'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':day']	=	@date($cfg_arr['day'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':month']	=	@date($cfg_arr['month'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':year']	=	@date($cfg_arr['year'], strtotime($item_obj->getDataByKey('custom'.$i)));
		      $repl_arr['custom:'.$i.':day2']	=	utf8_encode(@strftime($cfg_arr['day2'], strtotime($item_obj->getDataByKey('custom'.$i))));
		      $repl_arr['custom:'.$i.':month2']	=	utf8_encode(@strftime($cfg_arr['month2'], strtotime($item_obj->getDataByKey('custom'.$i))));
		     
				} else {
					$repl_arr['custom'.$i]='';
					$repl_arr['custom:'.$i]='';				
		      $repl_arr['custom:'.$i.':timestamp'] = '';
		      $repl_arr['custom:'.$i.':date']='';	
		      $repl_arr['custom:'.$i.':time']='';	
		      $repl_arr['custom:'.$i.':day']='';	
		      $repl_arr['custom:'.$i.':month']='';	
		      $repl_arr['custom:'.$i.':year']='';
		      $repl_arr['custom:'.$i.':day2']='';	
		      $repl_arr['custom:'.$i.':month2']='';	
				}

			} else if($artsys_obj->settings['article_custom'.$i.'_type']=='check' ||
							  $artsys_obj->settings['article_custom'.$i.'_type']=='radio' ||
							  $artsys_obj->settings['article_custom'.$i.'_type']=='select' ||
							  $artsys_obj->settings['article_custom'.$i.'_type']=='select2' ) {
							  
				$_AS['temp']['tempdataarray']=array();
	    	$_AS['temp']['tempdata']=trim($artsys_obj->getSetting('article_custom'.$i.'_select_values'));
				if (!empty($_AS['temp']['tempdata'])){
		    	$_AS['temp']['temparray']=explode("\n",$_AS['temp']['tempdata']);
	    		foreach ($_AS['temp']['temparray'] as $k => $v) {
	    			$va=explode('||',trim($v));
	    			$_AS['temp']['tempdataarray'][$va[0]]=empty($va[1])?$va[0]:$va[1];
	    		}
	    	}

				$_AS['temp']['tempvalsfinal'] = array();
				$_AS['temp']['tempvals'] = array();
				
				if ($artsys_obj->getSetting('article_custom'.$i.'_multi_select')=='true') {
					$vb = $item_obj->getDataByKey('custom'.$i);
					
					foreach (explode("\n",$vb) as $v) {
						$v=trim($v);
						if (!empty($v)) {
							if (!empty($_AS['temp']['tempdataarray'][$v]))
								$_AS['temp']['tempvalsfinal'][]=$_AS['temp']['tempdataarray'][$v];
							else
								$_AS['temp']['tempvalsfinal'][]=$v;
							$_AS['temp']['tempvals'][]=$v;
						}
					}				
				
				} else {

					$_AS['temp']['tempvals'] = array_filter(explode('||',trim($item_obj->getDataByKey('custom'.$i))));
				
					$_AS['temp']['tempvalsfinal'] = array();
					foreach ($_AS['temp']['tempvals'] as $v)
						$_AS['temp']['tempvalsfinal'][]=$_AS['temp']['tempdataarray'][$v];
				
				}

				$repl_arr['custom:'.$i]	=	implode(', ',$_AS['temp']['tempvalsfinal']);
				$repl_arr['custom'.$i]	=	$repl_arr['custom:'.$i];
				$_AS['temp']['coptionstemp']=array();
				$repl_arr['custom_html_selectboxoptions:'.$i]	= '';
				foreach ($_AS['temp']['tempvals'] as $v) {
					$v = trim($v);
					$_AS['temp']['coptionstemp'][] = '<option value="'.htmlentities($v,ENT_COMPAT,'UTF-8').'">'.htmlentities($v,ENT_COMPAT,'UTF-8').'</option>';
				}
				$repl_arr['custom_html_selectboxoptions:'.$i]	=	implode("\n",$_AS['temp']['coptionstemp']);
				$repl_arr['custom_data:'.$i]	=	implode(', ',$_AS['temp']['tempvals']);
				$repl_arr['custom_data'.$i]	=	$repl_arr['custom:'.$i];
				if (empty($repl_arr['custom:'.$i]) && !empty($repl_arr['custom_data:'.$i])) {
					$repl_arr['custom:'.$i]=$repl_arr['custom_data:'.$i];
					$repl_arr['custom'.$i]=$repl_arr['custom_data'.$i];
				}

			} else if($artsys_obj->settings['article_custom'.$i.'_type']=='pic') {

				$ctemp = array();
				$ctemp['value']=$item_obj->getDataByKey('custom'.$i);
				$ctemp['value_arr']=explode("\n",$ctemp['value']);
				$ctemp['values']['image']=trim($ctemp['value_arr'][0]);//url
				$ctemp['values']['title']=trim($ctemp['value_arr'][1]);
				$ctemp['values']['link']=trim($ctemp['value_arr'][2]);//link
				$ctemp['value_arr'][0]='';
				$ctemp['value_arr'][1]='';
				$ctemp['value_arr'][2]='';
				$ctemp['values']['description']=trim(implode("\n",$ctemp['value_arr']));		

				if (!empty($ctemp['values']['image'])) {
		      $repl_arr['custom_image:'.$i]				=	'<img src="'.$ctemp['values']['image'].'" alt="'.$ctemp['values']['title'].'"/>';
		     	$repl_arr['custom_imagethumb:'.$i]		=	'<img src="'.
											        													substr($ctemp['values']['image'],0, strrpos($ctemp['values']['image'],".")).
																												$cfg_client["thumbext"].
																												strtolower(substr($ctemp['values']['image'],strrpos($ctemp['values']['image'],"."))).
																												'" alt="'.$ctemp['values']['title'].'"/>';
		      $repl_arr['custom_imagethumburl:'.$i]	=	substr($ctemp['values']['image'],0, strrpos($ctemp['values']['image'],".")).
																												$cfg_client["thumbext"].
																												strtolower(substr($ctemp['values']['image'],strrpos($ctemp['values']['image'],".")));
				} else {
		      $repl_arr['custom_image:'.$i]					=	'';
		     	$repl_arr['custom_imagethumb:'.$i]			=	'';
		      $repl_arr['custom_imagethumburl:'.$i]	=	'';
				}
				$repl_arr['custom_imagelinkurl:'.$i]			=	$ctemp['values']['link'];
	      $repl_arr['custom_imageurl:'.$i]					=	$ctemp['values']['image'];
	      $repl_arr['custom:'.$i]					=	$ctemp['values']['image'];
				$repl_arr['custom_imagedesc:'.$i]				=	htmlentities($ctemp['values']['description'],ENT_COMPAT,'UTF-8');;
				$repl_arr['custom_imagetitle:'.$i]				=	htmlentities($ctemp['values']['title'],ENT_COMPAT,'UTF-8');;

			} else if($artsys_obj->settings['article_custom'.$i.'_type']=='link') {

				$ctemp = array();
				$ctemp['value']=$item_obj->getDataByKey('custom'.$i);
				$ctemp['value_arr']=explode("\n",$ctemp['value']);
				$ctemp['values']['link']=trim($ctemp['value_arr'][0]);//url
				$ctemp['values']['title']=trim($ctemp['value_arr'][1]);
				$ctemp['value_arr'][0]='';
				$ctemp['value_arr'][1]='';

				$ctemp['values']['description']=trim(implode("\n",$ctemp['value_arr']));		

				if (!empty($ctemp['values']['link'])) {
		      $repl_arr['custom_link:'.$i]					=	'<a href="'.$ctemp['values']['link'].'">'.
		      																						(!empty($ctemp['values']['title'])?$ctemp['values']['title']:$ctemp['values']['link']).
		      																						'</a>';
				} else {
		      $repl_arr['custom_link:'.$i]					=	'';
				}
	      $repl_arr['custom_linkurl:'.$i]				=	$ctemp['values']['link'];
	      $repl_arr['custom:'.$i]								=	$ctemp['values']['link'];
				$repl_arr['custom_linkdesc:'.$i]				=	htmlentities($ctemp['values']['description'],ENT_COMPAT,'UTF-8');;
				$repl_arr['custom_linktitle:'.$i]			=	htmlentities($ctemp['values']['title'],ENT_COMPAT,'UTF-8');;


				if (strpos( $repl_arr['custom:'.$i],'cms://idcatside=')!==false)
		      $repl_arr['custom_linkidcatside:'.$i]	=	(int) str_replace('cms://idcatside=','',$repl_arr['custom:'.$i]);
				else
					$repl_arr['custom_linkidcatside:'.$i] = '';
					
				if (strpos( $repl_arr['custom:'.$i],'cms://idcat=')!==false)
		      $repl_arr['custom_linkidcat:'.$i]	=	(int) str_replace('cms://idcat=','',$repl_arr['custom:'.$i]);
				else
					$repl_arr['custom_linkidcat:'.$i] = '';
	
				if (!empty($repl_arr['custom_linkidcat:'.$i]) && strpos($tpl_main,$i.':idcatside_si')!==false) {

					$arr=as_get_idcatside_by_cat($repl_arr['custom_linkidcat:'.$i],1);
					$repl_arr['custom_linkidcat:'.$i.':idcatside_si1']=$arr[0];
					$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si1']=$arr[1];

					$arr=as_get_idcatside_by_cat($repl_arr['custom_linkidcat:'.$i],2);
					$repl_arr['custom_linkidcat:'.$i.':idcatside_si2']=$arr[0];
					$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si2']=$arr[1];

					$arr=as_get_idcatside_by_cat($repl_arr['custom_linkidcat:'.$i],3);
					$repl_arr['custom_linkidcat:'.$i.':idcatside_si3']=$arr[0];
					$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si3']=$arr[1];

				}
	
				if (!empty($repl_arr['custom_linkidcat:'.$i]) && strpos($tpl_main,$i.':idcat_si')!==false) {

					$arr=as_get_idcatsub_by_cat($repl_arr['custom_linkidcat:'.$i],1);
					$repl_arr['custom_linkidcat:'.$i.':idcat_si1']=$arr[0];
					$repl_arr['custom_linkidcat:'.$i.':idcat_name_si1']=$arr[1];

					$arr=as_get_idcatsub_by_cat($repl_arr['custom_linkidcat:'.$i],2);
					$repl_arr['custom_linkidcat:'.$i.':idcat_si2']=$arr[0];
					$repl_arr['custom_linkidcat:'.$i.':idcat_name_si2']=$arr[1];

					$arr=as_get_idcatsub_by_cat($repl_arr['custom_linkidcat:'.$i],3);
					$repl_arr['custom_linkidcat:'.$i.':idcat_si3']=$arr[0];
					$repl_arr['custom_linkidcat:'.$i.':idcat_name_si3']=$arr[1];

				}
				
			} else if($artsys_obj->settings['article_custom'.$i.'_type']=='file') {

				$ctemp = array();
				$ctemp['value']=$item_obj->getDataByKey('custom'.$i);
				$ctemp['value_arr']=explode("\n",$ctemp['value']);
				$ctemp['values']['file']=trim($ctemp['value_arr'][0]);//url
				$ctemp['values']['title']=trim($ctemp['value_arr'][1]);
				$ctemp['value_arr'][0]='';
				$ctemp['value_arr'][1]='';

				$ctemp['values']['description']=trim(implode("\n",$ctemp['value_arr']));		

				if (!empty($ctemp['values']['file'])) {
					$file=$cfg_client['path'].$ctemp['values']['file'];		
					$filesize='';
	        if (is_file($file)) {
	            $filesize = filesize($file);
	            if ($filesize > 1048576) $filesize = sprintf( "%01.".$cfg_arr['filesize_decplaces']."f", $filesize/1048576).' '.$cfg_arr['filesize_str_mb'];
	            else $filesize = ($filesize > 1024) ? sprintf( "%01.".$cfg_arr['filesize_decplaces']."f", $filesize/1024).' '.$cfg_arr['filesize_str_kb']: $filesize.' '.$cfg_arr['filesize_str_b'];
	        } else $filesize = '';
					$repl_arr['custom_filepath:'.$i]			= str_replace(basename($ctemp['values']['file']),'',$ctemp['values']['file']);
					$repl_arr['custom_filename:'.$i]			= basename(substr($ctemp['values']['file'],0,strrpos($ctemp['values']['file'],'.')));
					$repl_arr['custom_fileext:'.$i]				= substr($ctemp['values']['file'],strrpos($ctemp['values']['file'],'.')+1);
					$repl_arr['custom_filesize:'.$i]			= $filesize;
		      $repl_arr['custom_file:'.$i]					=	'<a href="'.$ctemp['values']['file'].'">'.
		      																						(!empty($ctemp['values']['title'])?$ctemp['values']['title']:$ctemp['values']['file']).
		      																						'</a>';
				} else {
					$repl_arr['custom_filepath:'.$i]			= '';
					$repl_arr['custom_filename:'.$v]			= '';
					$repl_arr['custom_fileext:'.$v]				= '';
					$repl_arr['custom_filesize:'.$v]			= '';
		      $repl_arr['custom_file:'.$i]					=	'';
				}
				$repl_arr['custom_fileurl:'.$i]				=	$ctemp['values']['file'];
				$repl_arr['custom_filedesc:'.$i]			=	htmlentities($ctemp['values']['description'],ENT_COMPAT,'UTF-8');;
				$repl_arr['custom_filetitle:'.$i]			=	htmlentities($ctemp['values']['title'],ENT_COMPAT,'UTF-8');;

			} else {
				$repl_arr['custom'.$i]	=	$item_obj->getDataByKey('custom'.$i);
				$repl_arr['custom:'.$i]	=	$item_obj->getDataByKey('custom'.$i);	
			}
			$artsys_obj->settings['article_custom'.$i.'_label']=trim(str_replace('[readonly]','',$artsys_obj->settings['article_custom'.$i.'_label']));
	    $repl_arr['custom'.$i.'_label']	=	htmlentities($artsys_obj->settings['article_custom'.$i.'_label'],ENT_COMPAT,'UTF-8');
	    $repl_arr['custom_label:'.$i]	=	htmlentities($artsys_obj->settings['article_custom'.$i.'_label'],ENT_COMPAT,'UTF-8');


			// alias transfer
			if (trim($artsys_obj->settings['article_custom'.$i.'_alias'])!='') {
			
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias'])]=$repl_arr['custom:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_label']=$repl_arr['custom_label:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_data']=$repl_arr['custom_data:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_html_selectboxoptions']=$repl_arr['custom_html_selectboxoptions:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_file']=$repl_arr['custom_file:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_fileurl']=$repl_arr['custom_fileurl:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_filedesc']=$repl_arr['custom_filedesc:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_filetitle']=$repl_arr['custom_filetitle:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_filename']=$repl_arr['custom_filename:'.$v]			= '';
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_filepath']=$repl_arr['custom_filepath:'.$v]			= '';
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_fileext']=$repl_arr['custom_fileext:'.$v]				= '';
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_filesize']=$repl_arr['custom_filesize:'.$v]			= '';
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_link']=$repl_arr['custom_link:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkurl']=$repl_arr['custom_linkurl:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkdesc']=$repl_arr['custom_linkdesc:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linktitle']=$repl_arr['custom_linktitle:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat']=$repl_arr['custom_linkidcat:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcatside_si1']=$repl_arr['custom_linkidcat:'.$i.':idcatside_si1'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcatside_si2']=$repl_arr['custom_linkidcat:'.$i.':idcatside_si2'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcatside_si3']=$repl_arr['custom_linkidcat:'.$i.':idcatside_si3'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcatside_name_si1']=$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si1'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcatside_name_si2']=$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si2'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcatside_name_si3']=$repl_arr['custom_linkidcat:'.$i.':idcatside_name_si3'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcat_si1']=$repl_arr['custom_linkidcat:'.$i.':idcat_si1'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcat_si2']=$repl_arr['custom_linkidcat:'.$i.':idcat_si2'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcat_si3']=$repl_arr['custom_linkidcat:'.$i.':idcat_si3'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcat_name_si1']=$repl_arr['custom_linkidcat:'.$i.':idcat_name_si1'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcat_name_si2']=$repl_arr['custom_linkidcat:'.$i.':idcat_name_si2'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcat:idcat_name_si3']=$repl_arr['custom_linkidcat:'.$i.':idcat_name_si3'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_linkidcatside']=$repl_arr['custom_linkidcatside:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_image']=$repl_arr['custom_image:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_imageurl']=$repl_arr['custom_imageurl:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_imagethumb']=$repl_arr['custom_imagethumb:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_imagethumburl']=$repl_arr['custom_imagethumburl:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_imagelinkurl']=$repl_arr['custom_imagelinkurl:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_imagedesc']=$repl_arr['custom_imagedesc:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_imagetitle']=$repl_arr['custom_imagetitle:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).'_data']=$repl_arr['custom_data:'.$i];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':date']=$repl_arr['custom:'.$i.':date'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':timestamp']=$repl_arr['custom:'.$i.':timestamp'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':time']=$repl_arr['custom:'.$i.':time'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':day']=$repl_arr['custom:'.$i.':day'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':month']=$repl_arr['custom:'.$i.':month'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':day2']=$repl_arr['custom:'.$i.':day2'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':month2']=$repl_arr['custom:'.$i.':month2'];
				$repl_arr[trim($artsys_obj->settings['article_custom'.$i.'_alias']).':year']=$repl_arr['custom:'.$i.':year'];
			}
		}
		
		// tpl_main_tmp only used for base element recognition
		$tpl_main_tmp=str_replace('if_','',$tpl_main);
		$tpl_main_tmp=str_replace('if_not_','',$tpl_main_tmp);
		
		//Image
		if (strpos($tpl_main_tmp,'{image')!==false) {
			preg_match_all('#\{image(.*):(.*)\}#sU',$tpl_main_tmp,$_AS['temp']['matchesarray']);
			$_AS['temp']['matchesarray'][2]=array_unique($_AS['temp']['matchesarray'][2]);
			if (is_array($_AS['temp']['matchesarray'][2]))
				foreach ($_AS['temp']['matchesarray'][2] as $v){
						$ekt=$v;
						$ek=$v-1;
						if (!empty($art_images['value_txt'][$ek])) {
				      $repl_arr['image:'.$v]				=	'<img src="'.$art_images['value_txt'][$ek].'" alt="'.$art_images['title'][$ek].'"/>';
				     	$repl_arr['imagethumb:'.$v]		=	'<img src="'.
													        													substr($art_images['value_txt'][$ek],0, strrpos($art_images['value_txt'][$ek],".")).
																														$cfg_client["thumbext"].
																														strtolower(substr($art_images['value_txt'][$ek],strrpos($art_images['value_txt'][$ek],"."))).
																														'" alt="'.$art_images['title'][$ek].'"/>';
				      $repl_arr['imagethumburl:'.$v]	=	substr($art_images['value_txt'][$ek],0, strrpos($art_images['value_txt'][$ek],".")).
																														$cfg_client["thumbext"].
																														strtolower(substr($art_images['value_txt'][$ek],strrpos($art_images['value_txt'][$ek],".")));
						} else {
				      $repl_arr['image:'.$v]					=	'';
				     	$repl_arr['imagethumb:'.$v]			=	'';
				      $repl_arr['imagethumburl:'.$v]	=	'';
						}
						$repl_arr['imagelinkurl:'.$v]			=	$art_images['value_uni'][$ek];
			      $repl_arr['imageurl:'.$v]					=	$art_images['value_txt'][$ek];
						$repl_arr['imagedesc:'.$v]				=	htmlentities($art_images['description'][$ek],ENT_COMPAT,'UTF-8');;
						$repl_arr['imagetitle:'.$v]				=	htmlentities($art_images['title'][$ek],ENT_COMPAT,'UTF-8');;
			  }
			if (strpos($tpl_main_tmp,'{images}')!==false) {		 
		    $repl_arr['images']='';   
		    $repl_sub_arr=array();
				if (is_array($art_images['sort_index']))
					foreach ($art_images['sort_index'] as $ek => $ev){
						if (!empty($art_images['value_txt'][$ek])) {
				      $repl_sub_arr['image']					=	'<img src="'.$art_images['value_txt'][$ek].'" alt="'.$art_images['title'][$ek].'"/>';
				     	$repl_sub_arr['imagethumb']			=	'<img src="'.
													        													substr($art_images['value_txt'][$ek],0, strrpos($art_images['value_txt'][$ek],".")).
																														$cfg_client["thumbext"].
																														strtolower(substr($art_images['value_txt'][$ek],strrpos($art_images['value_txt'][$ek],"."))).
																														'" alt="'.$art_images['title'][$ek].'"/>';
				      $repl_sub_arr['imagethumburl']	=	substr($art_images['value_txt'][$ek],0, strrpos($art_images['value_txt'][$ek],".")).
																														$cfg_client["thumbext"].
																														strtolower(substr($art_images['value_txt'][$ek],strrpos($art_images['value_txt'][$ek],".")));
						} else {
				      $repl_sub_arr['image']					=	'';
				     	$repl_sub_arr['imagethumb']			=	'';
				      $repl_sub_arr['imagethumburl']	=	'';
						}
			      $repl_sub_arr['imagelinkurl']			=	$art_images['value_uni'][$ek];
			      $repl_sub_arr['imageurl']					=	$art_images['value_txt'][$ek];
						$repl_sub_arr['imagedesc']				=	htmlentities($art_images['description'][$ek],ENT_COMPAT,'UTF-8');
						$repl_sub_arr['imagetitle']				=	htmlentities($art_images['title'][$ek],ENT_COMPAT,'UTF-8');
	
						$repl_sub_t_arr										=	array_filter($repl_sub_arr);
						if (!empty($repl_sub_t_arr)) {
													
							$repl_arr['images'] .= $tpl_images;
					    foreach ($repl_sub_arr as $k => $v) {
	
								// if-statement
								if(strpos($repl_arr['images'],'{if_'.$k.'}')!==false)
									if (empty($v))
									  $repl_arr['images'] = preg_replace('#\{if_'.$k.'\}(.*)\{/if_'.$k.'\}#sU','',$repl_arr['images']);
									else
									  $repl_arr['images'] = str_replace(array('{if_'.$k.'}','{/if_'.$k.'}'), array('',''), $repl_arr['images']);
				
								// if-not-statement
								if(strpos($repl_arr['images'],'{if_not_'.$k.'}')!==false)
									if (empty($v))
								  	$repl_arr['images'] = str_replace(array('{if_not_'.$k.'}','{/if_not_'.$k.'}'), array('',''), $repl_arr['images']);
									else
									 	$repl_arr['images'] = preg_replace('#\{if_not_'.$k.'\}(.*)\{/if_not_'.$k.'\}#sU','',$repl_arr['images']);
	
								$repl_arr['images']			=	str_replace('{'.$k.'}',$v,$repl_arr['images']);
							}	
						}			
					}
			} else
				$repl_arr['images']							= '';
	  }
	
		//file
		if (strpos($tpl_main_tmp,'{file')!==false) {
			preg_match_all('#\{file(.*):(.*)\}#sU',$tpl_main_tmp,$_AS['temp']['matchesarray']);
			$_AS['temp']['matchesarray'][2]=array_unique($_AS['temp']['matchesarray'][2]);
			if (is_array($_AS['temp']['matchesarray'][2]))
				foreach ($_AS['temp']['matchesarray'][2] as $v){
						$ekt=$v;
						$ek=$v-1;
						if (!empty($art_files['value_txt'][$ek])) {
							$file=$cfg_client['path'].$art_files['value_txt'][$ek];		
							$filesize='';
	            if (is_file($file)) {
	                $filesize = filesize($file);
	                if ($filesize > 1048576) $filesize = sprintf( "%01.".$cfg_arr['filesize_decplaces']."f", $filesize/1048576).' '.$cfg_arr['filesize_str_mb'];
	                else $filesize = ($filesize > 1024) ? sprintf( "%01.".$cfg_arr['filesize_decplaces']."f", $filesize/1024).' '.$cfg_arr['filesize_str_kb']: $filesize.' '.$cfg_arr['filesize_str_b'];
	            } else $filesize = '';
							$repl_arr['filepath:'.$v]			= str_replace(basename($art_files['value_txt'][$ek]),'',$art_files['value_txt'][$ek]);
							$repl_arr['filename:'.$v]			= basename(substr($art_files['value_txt'][$ek],0,strrpos($art_files['value_txt'][$ek],'.')));
							$repl_arr['fileext:'.$v]				= substr($art_files['value_txt'][$ek],strrpos($art_files['value_txt'][$ek],'.')+1);
							$repl_arr['filesize:'.$v]			= $filesize;
				      $repl_arr['file:'.$v]					=	'<a href="'.$art_files['value_txt'][$ek].'">'.
				      																						(!empty($art_files['title'][$ek])?$art_files['title'][$ek]:$art_files['value_txt'][$ek]).
				      																						'</a>';
						} else {
							$repl_arr['filepath:'.$v]			= '';
							$repl_arr['filename:'.$v]			= '';
							$repl_arr['fileext:'.$v]				= '';
							$repl_arr['filesize:'.$v]			= '';
				      $repl_arr['file:'.$v]					=	'';
						}
						$repl_arr['fileurl:'.$v]				=	$art_files['value_txt'][$ek];
						$repl_arr['filedesc:'.$v]				=	htmlentities($art_files['description'][$ek],ENT_COMPAT,'UTF-8');;
						$repl_arr['filetitle:'.$v]			=	htmlentities($art_files['title'][$ek],ENT_COMPAT,'UTF-8');;
			  }
			if (strpos($tpl_main_tmp,'{files}')!==false) {		 
		    $repl_arr['files']='';   
		    $repl_sub_arr=array();
				if (is_array($art_files['sort_index']))
					foreach ($art_files['sort_index'] as $ek => $ev){
						if (!empty($art_files['value_txt'][$ek])) {
							$file=$cfg_client['path'].$art_files['value_txt'][$ek];		
							$filesize='';
	            if (is_file($file)) {
	                $filesize = filesize($file);
	                if ($filesize > 1048576) $filesize = sprintf( "%01.".$cfg_arr['filesize_decplaces']."f", $filesize/1048576).' '.$cfg_arr['filesize_str_mb'];
	                else $filesize = ($filesize > 1024) ? sprintf( "%01.".$cfg_arr['filesize_decplaces']."f", $filesize/1024).' '.$cfg_arr['filesize_str_kb']: $filesize.' '.$cfg_arr['filesize_str_b'];
	            } else $filesize = '';

							$repl_sub_arr['filepath']			= str_replace(basename($art_files['value_txt'][$ek]),'',$art_files['value_txt'][$ek]);
							$repl_sub_arr['filename']			= basename(substr($art_files['value_txt'][$ek],0,strrpos($art_files['value_txt'][$ek],'.')));
							$repl_sub_arr['fileext']			= substr($art_files['value_txt'][$ek],strrpos($art_files['value_txt'][$ek],'.')+1);
							$repl_sub_arr['filesize']			= $filesize;
				      $repl_sub_arr['file']					=	'<a href="'.$art_files['value_txt'][$ek].'">'.
			     																								(!empty($art_files['title'][$ek])?$art_files['title'][$ek]:$art_files['value_txt'][$ek]).
				    																							'</a>';
						} else {
							$repl_sub_arr['filepath']			= '';
							$repl_sub_arr['filename']			= '';
							$repl_sub_arr['fileext']			= '';
							$repl_sub_arr['filesize']			= '';
				      $repl_sub_arr['file']					=	'';
						}
						$repl_sub_arr['fileurl']				=	$art_files['value_txt'][$ek];
						$repl_sub_arr['filedesc']				=	htmlentities($art_files['description'][$ek],ENT_COMPAT,'UTF-8');;
						$repl_sub_arr['filetitle']			=	htmlentities($art_files['title'][$ek],ENT_COMPAT,'UTF-8');;
	
						$repl_sub_t_arr									=	array_filter($repl_sub_arr);
						if (!empty($repl_sub_t_arr)) {
							
							$repl_arr['files'] .= $tpl_files;
					    foreach ($repl_sub_arr as $k => $v) {
	
								// if-statement
								if(strpos($repl_arr['files'],'{if_'.$k.'}')!==false)
									if (empty($v))
									  $repl_arr['files'] = preg_replace('#\{if_'.$k.'\}(.*)\{/if_'.$k.'\}#sU','',$repl_arr['files']);
									else
									  $repl_arr['files'] = str_replace(array('{if_'.$k.'}','{/if_'.$k.'}'), array('',''), $repl_arr['files']);
				
								// if-not-statement
								if(strpos($repl_arr['files'],'{if_not_'.$k.'}')!==false)
									if (empty($v))
								  	$repl_arr['files'] = str_replace(array('{if_not_'.$k.'}','{/if_not_'.$k.'}'), array('',''), $repl_arr['files']);
									else
									 	$repl_arr['files'] = preg_replace('#\{if_not_'.$k.'\}(.*)\{/if_not_'.$k.'\}#sU','',$repl_arr['files']);
	
								$repl_arr['files']		 =	str_replace('{'.$k.'}',$v,$repl_arr['files']);
							}	
						}			
					}
			} else
				$repl_arr['files']						 =	'';
	  }
	
		//link
		if (strpos($tpl_main_tmp,'{link')!==false) {
			preg_match_all('#\{link(.*):(.*)\}#sU',$tpl_main_tmp,$_AS['temp']['matchesarray']);
			$_AS['temp']['matchesarray'][2]=array_unique($_AS['temp']['matchesarray'][2]);
			if (is_array($_AS['temp']['matchesarray'][2]))
				foreach ($_AS['temp']['matchesarray'][2] as $v){
						$ekt=$v;
						$ek=$v-1;
						if (!empty($art_links['value_txt'][$ek])) {
				      $repl_arr['link:'.$v]					=	'<a href="'.$art_links['value_txt'][$ek].'">'.
				      																						(!empty($art_links['title'][$ek])?$art_links['title'][$ek]:$art_links['value_txt'][$ek]).
				      																						'</a>';
						} else {
				      $repl_arr['link:'.$v]					=	'';
						}
			      $repl_arr['linkurl:'.$v]				=	$art_links['value_txt'][$ek];
						$repl_arr['linkdesc:'.$v]				=	htmlentities($art_links['description'][$ek],ENT_COMPAT,'UTF-8');;
						$repl_arr['linktitle:'.$v]			=	htmlentities($art_links['title'][$ek],ENT_COMPAT,'UTF-8');;
			  }
			if (strpos($tpl_main_tmp,'{links}')!==false) {		 
		    $repl_arr['links']='';   
		    $repl_sub_arr=array();
				if (is_array($art_links['sort_index']))
					foreach ($art_links['sort_index'] as $ek => $ev){
						if (!empty($art_links['value_txt'][$ek])) {
				      $repl_sub_arr['link']						=	'<a href="'.$art_links['value_txt'][$ek].'">'.
		      																									(!empty($art_links['title'][$ek])?$art_links['title'][$ek]:$art_links['value_txt'][$ek]).
		      																									'</a>';
						} else {
				      $repl_sub_arr['link']						=	'';
						}
			      $repl_sub_arr['linkurl']					=	$art_links['value_txt'][$ek];
						$repl_sub_arr['linkdesc']					=	htmlentities($art_links['description'][$ek],ENT_COMPAT,'UTF-8');;
						$repl_sub_arr['linktitle']				=	htmlentities($art_links['title'][$ek],ENT_COMPAT,'UTF-8');;
	
						$repl_sub_t_arr									=	array_filter($repl_sub_arr);
						if (!empty($repl_sub_t_arr)) {
		
							$repl_arr['links'] .= $tpl_links;
					    foreach ($repl_sub_arr as $k => $v) {
	
								// if-statement
								if(strpos($repl_arr['links'],'{if_'.$k.'}')!==false)
									if (empty($v))
									  $repl_arr['links'] = preg_replace('#\{if_'.$k.'\}(.*)\{/if_'.$k.'\}#sU','',$repl_arr['links']);
									else
									  $repl_arr['links'] = str_replace(array('{if_'.$k.'}','{/if_'.$k.'}'), array('',''), $repl_arr['links']);
				
								// if-not-statement
								if(strpos($repl_arr['links'],'{if_not_'.$k.'}')!==false)
									if (empty($v))
								  	$repl_arr['links'] = str_replace(array('{if_not_'.$k.'}','{/if_not_'.$k.'}'), array('',''), $repl_arr['links']);
									else
									 	$repl_arr['links'] = preg_replace('#\{if_not_'.$k.'\}(.*)\{/if_not_'.$k.'\}#sU','',$repl_arr['links']);
	
								$repl_arr['links']		 =	str_replace('{'.$k.'}',$v,$repl_arr['links']);
							}
						}				
					}
			} else
				$repl_arr['links']						 =	'';
	  }

		//date
		if (strpos($tpl_main_tmp,'{date')!==false) {
			preg_match_all('#\{date(.*):(.*)\}#sU',$tpl_main_tmp,$_AS['temp']['matchesarray']);

			$_AS['temp']['matchesarray'][2]=array_unique($_AS['temp']['matchesarray'][2]);
			if (is_array($_AS['temp']['matchesarray'][2])){
				foreach ($_AS['temp']['matchesarray'][2] as $v){
						$ekt=$v;
						$ek=$v-1;
						$v = str_replace(':day','',$v);
						$v = str_replace(':month','',$v);
						$v = str_replace(':year','',$v);

						$repl_arr['date:'.$v]='';				
			      $repl_arr['date:'.$v.':day']='';	
			      $repl_arr['date:'.$v.':month']='';	
			      $repl_arr['date:'.$v.':day2']='';	
			      $repl_arr['date:'.$v.':month2']='';	
			      $repl_arr['date:'.$v.':year']='';
				    $repl_arr['datetime24:'.$v]	=	'';
				    $repl_arr['datetime12:'.$v]	=	'';

						if($art_dates['value_txt'][$ek]!='' && $art_dates['value_txt'][$ek]!='--'){
				      $repl_arr['date:'.$v]	=	@date($cfg_arr['date'], strtotime($art_dates['value_txt'][$ek]));
				      $repl_arr['date:'.$v.':day']	=	@date($cfg_arr['day'], strtotime($art_dates['value_txt'][$ek]));
				      $repl_arr['date:'.$v.':month']	=	@date($cfg_arr['month'], strtotime($art_dates['value_txt'][$ek]));
				      $repl_arr['date:'.$v.':day2']	=	utf8_encode(@strftime($cfg_arr['day'], strtotime($art_dates['value_txt'][$ek])));
				      $repl_arr['date:'.$v.':month2']	=	utf8_encode(@strftime($cfg_arr['month'], strtotime($art_dates['value_txt'][$ek])));
				      $repl_arr['date:'.$v.':year']	=	@date($cfg_arr['year'], strtotime($art_dates['value_txt'][$ek]));
					    if (strlen($art_dates['value_txt'][$ek])>10) {
						    $repl_arr['datetime24:'.$v]	=	strftime($cfg_arr['time24'], strtotime($art_dates['value_txt'][$ek]));
						    $repl_arr['datetime12:'.$v]	=	strftime($cfg_arr['time12'], strtotime($art_dates['value_txt'][$ek]));
							}
				    } 
				    
						$repl_arr['dateduration:'.$v]		=	htmlentities($art_dates['value_uni'][$ek],ENT_COMPAT,'UTF-8');;
						$repl_arr['datedesc:'.$v]				=	htmlentities($art_dates['description'][$ek],ENT_COMPAT,'UTF-8');;
						$repl_arr['datetitle:'.$v]			=	htmlentities($art_dates['title'][$ek],ENT_COMPAT,'UTF-8');;
				  }
				  for ($i=count($art_dates['value_txt']);$i>=0;$i--){
						$repl_arr['date:L']='';				
			      $repl_arr['date:L:day']='';	
			      $repl_arr['date:L:month']='';	
			      $repl_arr['date:L:day2']='';	
			      $repl_arr['date:L:month2']='';	
			      $repl_arr['date:L:year']='';
				    $repl_arr['datetime24:L']	=	'';
				    $repl_arr['datetime12:L']	=	'';
					    
						if($art_dates['value_txt'][$i]!='' && $art_dates['value_txt'][$i]!='--'){
				      $repl_arr['date:L']	=	@date($cfg_arr['date'], strtotime($art_dates['value_txt'][$i]));
				      $repl_arr['date:L:day']	=	@date($cfg_arr['day'], strtotime($art_dates['value_txt'][$i]));
				      $repl_arr['date:L:month']	=	@date($cfg_arr['month'], strtotime($art_dates['value_txt'][$i]));
				      $repl_arr['date:L:day2']	=	utf8_encode(@strftime($cfg_arr['day2'], strtotime($art_dates['value_txt'][$i])));
				      $repl_arr['date:L:month2']	=	utf8_encode(@strftime($cfg_arr['month2'], strtotime($art_dates['value_txt'][$i])));
				      $repl_arr['date:L:year']	=	@date($cfg_arr['year'], strtotime($art_dates['value_txt'][$i]));
					    if (strlen($art_dates['value_txt'][$i])>10) {
						    $repl_arr['datetime24:L']	=	strftime($cfg_arr['time24'], strtotime($art_dates['value_txt'][$i]));
						    $repl_arr['datetime12:L']	=	strftime($cfg_arr['time12'], strtotime($art_dates['value_txt'][$i]));
							}
				    } 
				    
						$repl_arr['dateduration:L']		=	htmlentities($art_dates['value_uni'][$i],ENT_COMPAT,'UTF-8');;
						$repl_arr['datedesc:L']				=	htmlentities($art_dates['description'][$i],ENT_COMPAT,'UTF-8');;
						$repl_arr['datetitle:L']			=	htmlentities($art_dates['title'][$i],ENT_COMPAT,'UTF-8');;
						if($art_dates['value_txt'][$i]!='')
							break;
						
				  }				  
				}
			if (strpos($tpl_main_tmp,'{dates}')!==false) {		 
		    $repl_arr['dates']='';   
		    $repl_sub_arr=array();
				if (is_array($art_dates['sort_index']))
					foreach ($art_dates['sort_index'] as $ek => $ev){

						$repl_sub_arr['date'] = '';				
			      $repl_sub_arr['date:day'] = '';	
			      $repl_sub_arr['date:month'] = '';	
			      $repl_sub_arr['date:day2'] = '';	
			      $repl_sub_arr['date:month2'] = '';	
			      $repl_sub_arr['date:year'] = '';
				    $repl_sub_arr['datetime24']	=	'';
				    $repl_sub_arr['datetime12']	=	'';
					    
						if($art_dates['value_txt'][$ek]!='' && $art_dates['value_txt'][$ek]!='--'){
				      $repl_sub_arr['date']	=	@date($cfg_arr['date'], strtotime($art_dates['value_txt'][$ek]));
				      $repl_sub_arr['date:day']	=	@date($cfg_arr['day'], strtotime($art_dates['value_txt'][$ek]));
				      $repl_sub_arr['date:month']	=	@date($cfg_arr['month'], strtotime($art_dates['value_txt'][$ek]));
				      $repl_sub_arr['date:day2']	=	utf8_encode(@strftime($cfg_arr['day'], strtotime($art_dates['value_txt'][$ek])));
				      $repl_sub_arr['date:month2']	=	utf8_encode(@strftime($cfg_arr['month'], strtotime($art_dates['value_txt'][$ek])));
				      $repl_sub_arr['date:year']	=	@date($cfg_arr['year'], strtotime($art_dates['value_txt'][$ek]));
				      $repl_sub_arr['date:year2']	=	utf8_encode(@strftime($cfg_arr['year2'], strtotime($art_dates['value_txt'][$ek])));
					    if (strlen($art_dates['value_txt'][$ek])>10) {
						    $repl_sub_arr['datetime24']	=	strftime($cfg_arr['time24'], strtotime($art_dates['value_txt'][$ek]));
						    $repl_sub_arr['datetime12']	=	strftime($cfg_arr['time12'], strtotime($art_dates['value_txt'][$ek]));
							}
				    } 
						
						$repl_sub_arr['datedesc']			=	htmlentities($art_dates['description'][$ek],ENT_COMPAT,'UTF-8');
						$repl_sub_arr['dateduration']	=	htmlentities($art_dates['value_uni'][$ek],ENT_COMPAT,'UTF-8');
						$repl_sub_arr['datetitle']		=	htmlentities($art_dates['title'][$ek],ENT_COMPAT,'UTF-8');;
	
						$repl_sub_t_arr									=	array_filter($repl_sub_arr);
						if (!empty($repl_sub_t_arr)) {
		
							$repl_arr['dates'] .= $tpl_dates;
					    foreach ($repl_sub_arr as $k => $v) {
	
								// if-statement
								if(strpos($repl_arr['dates'],'{if_'.$k.'}')!==false)
									if (empty($v))
									  $repl_arr['dates'] = preg_replace('#\{if_'.$k.'\}(.*)\{/if_'.$k.'\}#sU','',$repl_arr['dates']);
									else
									  $repl_arr['dates'] = str_replace(array('{if_'.$k.'}','{/if_'.$k.'}'), array('',''), $repl_arr['dates']);
				
								// if-not-statement
								if(strpos($repl_arr['dates'],'{if_not_'.$k.'}')!==false)
									if (empty($v))
								  	$repl_arr['dates'] = str_replace(array('{if_not_'.$k.'}','{/if_not_'.$k.'}'), array('',''), $repl_arr['dates']);
									else
									 	$repl_arr['dates'] = preg_replace('#\{if_not_'.$k.'\}(.*)\{/if_not_'.$k.'\}#sU','',$repl_arr['dates']);
	
								$repl_arr['dates']		 =	str_replace('{'.$k.'}',$v,$repl_arr['dates']);
							}
						}				
					}
			} else
				$repl_arr['dates']						 =	'';
	  }

		$repl_arr['category']	= '';
		if (strpos($item_obj->getDataByKey('idcategory'),'|')!==false) {
			$cat_str_arr=array();
			$repl_arr['categoryid']='';
			foreach(array_filter(explode('|',$item_obj->getDataByKey('idcategory'))) as $v)
				$cat_str_arr[]=$cat_arr[$v];
			$repl_arr['category']=implode(', ',$cat_str_arr);
			if (empty($repl_arr['categoryid']))
				$repl_arr['categoryid']=$v;
		} elseif ($item_obj->getDataByKey('idcategory')!='') {					
      $repl_arr['category']= $cat_arr[$item_obj->getDataByKey('idcategory')];
      $repl_arr['categoryid']= $item_obj->getDataByKey('idcategory');
		}


		$repl_arr['today_timestamp'] = time();
		$repl_arr['idlang'] = $lang;
		$repl_arr['idarticle'] = $item_obj->getDataByKey('idarticle');
		// additional sf-page-stuff
		if (is_array($as_externalvars2elements) && count($as_externalvars2elements)>0)
			foreach ($as_externalvars2elements as $kkk => $vvv)
				$repl_arr[$kkk]=$vvv;

		return $repl_arr;

	}
}


if(! function_exists(as_element_ifstatements)){
  /**
  * 
  *
  * @param		
  * @return		
  * @access		
  */
	function as_element_ifstatements($tpl='',$elarray,$elkey,$elvalue) {
	
			$_AS['temp']=array();

			if(strpos($tpl,'{if_')===false || empty($tpl))
				return $tpl;
			
			// global if-value-statement
			if(strpos($tpl,'{if_'.$elkey.'=')!==false) {
				preg_match_all('/\{if_'.$elkey.'=(.*?)\}/',$tpl,$_AS['temp']['temp_results']);
				foreach ($_AS['temp']['temp_results'][0] as $ek => $ev) {
					$_AS['temp']['compval']=$_AS['temp']['temp_results'][1][$ek];
					$_AS['temp']['compelement']=$_AS['temp']['temp_results'][1][$ek];
					if (array_key_exists(trim($_AS['temp']['compval'],'[]'),$elarray)) {
						$_AS['temp']['compval']=$elarray[trim($_AS['temp']['compval'],'[]')];
						$_AS['temp']['compelement']=str_replace(array('[',']'),array('\[','\]'),$_AS['temp']['temp_results'][1][$ek]);							
					}
						
					if ($elvalue!=$_AS['temp']['compval'] || (trim($elvalue)=='' && trim($_AS['temp']['compval'])=='')) {
					  $tpl = preg_replace('#\{if_'.$elkey.'='.$_AS['temp']['compelement'].'\}(.*)\{/if_'.$elkey.'='.$_AS['temp']['compelement'].'\}#sU','',$tpl);
					} else {
					  $tpl = str_replace(array('{if_'.$elkey.'='.$_AS['temp']['temp_results'][1][$ek].'}','{/if_'.$elkey.'='.$_AS['temp']['temp_results'][1][$ek].'}'), array('',''), $tpl);
					}
				}
			}		
	
			// global if-value-statement
			if(strpos($tpl,'{if_not_'.$elkey.'=')!==false) {
				preg_match_all('/\{if_not_'.$elkey.'=(.*?)\}/',$tpl,$_AS['temp']['temp_results']);
				foreach ($_AS['temp']['temp_results'][0] as $ek => $ev) {
					$_AS['temp']['compval']=$_AS['temp']['temp_results'][1][$ek];
					$_AS['temp']['compelement']=$_AS['temp']['temp_results'][1][$ek];
					if (array_key_exists(trim($_AS['temp']['compval'],'[]'),$elarray)) {
						$_AS['temp']['compval']=$elarray[trim($_AS['temp']['compval'],'[]')];
						$_AS['temp']['compelement']=str_replace(array('[',']'),array('\[','\]'),$_AS['temp']['temp_results'][1][$ek]);							
					}
			
					if ($elvalue!=$_AS['temp']['compval'] || (trim($elvalue)=='' && trim($_AS['temp']['compval'])=='')) {
					  $tpl = str_replace(array('{if_not_'.$elkey.'='.$_AS['temp']['temp_results'][1][$ek].'}','{/if_not_'.$elkey.'='.$_AS['temp']['temp_results'][1][$ek].'}'), array('',''), $tpl);
					} else {
					  $tpl = preg_replace('#\{if_not_'.$elkey.'='.$_AS['temp']['compelement'].'\}(.*)\{/if_not_'.$elkey.'='.$_AS['temp']['compelement'].'\}#sU','',$tpl);
					}
				}
			}

			// global if-value-statement
			if(strpos($tpl,'{if_'.$elkey.'>')!==false) {
				preg_match_all('/\{if_'.$elkey.'>(.*?)\}/',$tpl,$_AS['temp']['temp_results']);
				foreach ($_AS['temp']['temp_results'][0] as $ek => $ev) {
					$_AS['temp']['compval']=$_AS['temp']['temp_results'][1][$ek];
					$_AS['temp']['compelement']=$_AS['temp']['temp_results'][1][$ek];
				
					if (array_key_exists(trim($_AS['temp']['compval'],'[]'),$elarray)) {
						$_AS['temp']['compval']=$elarray[trim($_AS['temp']['compval'],'[]')];
						$_AS['temp']['compelement']=str_replace(array('[',']'),array('\[','\]'),$_AS['temp']['temp_results'][1][$ek]);				
						
					}				
					if ($elvalue<=$_AS['temp']['compval'] || (trim($elvalue)=='' && trim($_AS['temp']['compval'])=='')) {
					  $tpl = preg_replace('#\{if_'.$elkey.'>'.$_AS['temp']['compelement'].'\}(.*)\{/if_'.$elkey.'>'.$_AS['temp']['compelement'].'\}#sU','',$tpl);
					} else {
					  $tpl = str_replace(array('{if_'.$elkey.'>'.$_AS['temp']['temp_results'][1][$ek].'}','{/if_'.$elkey.'>'.$_AS['temp']['temp_results'][1][$ek].'}'), array('',''), $tpl);
					}
				}
			}		
	
			// global if-value-statement
			if(strpos($tpl,'{if_not_'.$elkey.'>')!==false) {
				preg_match_all('/\{if_not_'.$elkey.'>(.*?)\}/',$tpl,$_AS['temp']['temp_results']);
				foreach ($_AS['temp']['temp_results'][0] as $ek => $ev) {
					$_AS['temp']['compval']=$_AS['temp']['temp_results'][1][$ek];
					$_AS['temp']['compelement']=$_AS['temp']['temp_results'][1][$ek];
					if (array_key_exists(trim($_AS['temp']['compval'],'[]'),$elarray)) {
						$_AS['temp']['compval']=$elarray[trim($_AS['temp']['compval'],'[]')];
						$_AS['temp']['compelement']=str_replace(array('[',']'),array('\[','\]'),$_AS['temp']['temp_results'][1][$ek]);							
					}
					if ($elvalue<=$_AS['temp']['compval'] || (trim($elvalue)=='' && trim($_AS['temp']['compval'])=='')) {
					  $tpl = str_replace(array('{if_not_'.$elkey.'>'.$_AS['temp']['temp_results'][1][$ek].'}','{/if_not_'.$elkey.'>'.$_AS['temp']['temp_results'][1][$ek].'}'), array('',''), $tpl);
					} else {
					  $tpl = preg_replace('#\{if_not_'.$elkey.'>'.$_AS['temp']['compelement'].'\}(.*)\{/if_not_'.$elkey.'>'.$_AS['temp']['compelement'].'\}#sU','',$tpl);
					}
				}
			}		
		
			// global if-value-statement
			if(strpos($tpl,'{if_'.$elkey.'<')!==false) {
				preg_match_all('/\{if_'.$elkey.'<(.*?)\}/',$tpl,$_AS['temp']['temp_results']);
				foreach ($_AS['temp']['temp_results'][0] as $ek => $ev) {
					$_AS['temp']['compval']=$_AS['temp']['temp_results'][1][$ek];
					$_AS['temp']['compelement']=$_AS['temp']['temp_results'][1][$ek];
					if (array_key_exists(trim($_AS['temp']['compval'],'[]'),$elarray)) {
						$_AS['temp']['compval']=$elarray[trim($_AS['temp']['compval'],'[]')];
						$_AS['temp']['compelement']=str_replace(array('[',']'),array('\[','\]'),$_AS['temp']['temp_results'][1][$ek]);		
			
					}
					if ($elvalue>=$_AS['temp']['compval'] || (trim($elvalue)=='' && trim($_AS['temp']['compval'])=='')) {
					  $tpl = preg_replace('#\{if_'.$elkey.'<'.$_AS['temp']['compelement'].'\}(.*)\{/if_'.$elkey.'<'.$_AS['temp']['compelement'].'\}#sU','',$tpl);
					} else {
					  $tpl = str_replace(array('{if_'.$elkey.'<'.$_AS['temp']['temp_results'][1][$ek].'}','{/if_'.$elkey.'<'.$_AS['temp']['temp_results'][1][$ek].'}'), array('',''), $tpl);
					}
				}
			}		
	
			// global if-value-statement
			if(strpos($tpl,'{if_not_'.$elkey.'<')!==false) {
				preg_match_all('/\{if_not_'.$elkey.'<(.*?)\}/',$tpl,$_AS['temp']['temp_results']);
				foreach ($_AS['temp']['temp_results'][0] as $ek => $ev) {
					$_AS['temp']['compval']=$_AS['temp']['temp_results'][1][$ek];
					$_AS['temp']['compelement']=$_AS['temp']['temp_results'][1][$ek];
					if (array_key_exists(trim($_AS['temp']['compval'],'[]'),$elarray)) {
						$_AS['temp']['compval']=$elarray[trim($_AS['temp']['compval'],'[]')];
						$_AS['temp']['compelement']=str_replace(array('[',']'),array('\[','\]'),$_AS['temp']['temp_results'][1][$ek]);							
					}
					if ($elvalue>=$_AS['temp']['compval'] || (trim($elvalue)=='' && trim($_AS['temp']['compval'])=='')) {
					  $tpl = str_replace(array('{if_not_'.$elkey.'<'.$_AS['temp']['temp_results'][1][$ek].'}','{/if_not_'.$elkey.'<'.$_AS['temp']['temp_results'][1][$ek].'}'), array('',''), $tpl);
					} else {
					  $tpl = preg_replace('#\{if_not_'.$elkey.'<'.$_AS['temp']['compelement'].'\}(.*)\{/if_not_'.$elkey.'<'.$_AS['temp']['compelement'].'\}#sU','',$tpl);
					}
				}
			}		

			// global if-statement
			if(strpos($tpl,'{if_'.$elkey.'}')!==false)
				if (empty($elvalue))
				  $tpl = preg_replace('#\{if_'.$elkey.'\}(.*)\{/if_'.$elkey.'\}#sU','',$tpl);
				else
				  $tpl = str_replace(array('{if_'.$elkey.'}','{/if_'.$elkey.'}'), array('',''), $tpl);

			// global if-not-statement
			if(strpos($tpl,'{if_not_'.$elkey.'}')!==false)
				if (empty($elvalue))
			  	$tpl = str_replace(array('{if_not_'.$elkey.'}','{/if_not_'.$elkey.'}'), array('',''), $tpl);
				else
				 	$tpl = preg_replace('#\{if_not_'.$elkey.'\}(.*)\{/if_not_'.$elkey.'\}#sU','',$tpl);
				 	
			return $tpl;
	
	
	}
}

if(! function_exists(as_element_sfifstatements)){
  /**
  * 
  *
  * @param		
  * @return		
  * @access		
  */
	function as_element_sfifstatements($tpl='') {

			if(strpos($tpl,'{if_')===false || empty($tpl))
				return $tpl;
				
			global $view,$sess;
	
				return $tpl;
			// global if-backend
			if(strpos($tpl,'{if_backend}')!==false)
				if ($sess->name == 'sefrengo' && ($view == 'preview' || $view == 'edit')) {
				  $tpl = str_replace(array('{if_backend}','{/if_backend}'), array('',''), $tpl);
				} else {
					$tpl = preg_replace('#\{if_backend\}(.*)\{/if_backend\}#sU','',$tpl);
				}
			// global if-backend
			if(strpos($tpl,'{if_backend_edit}')!==false)
				if ($sess->name == 'sefrengo' && ($view != 'preview' && $view == 'edit')) {
				  $tpl = str_replace(array('{if_backend_edit}','{/if_backend_edit}'), array('',''), $tpl);
				} else {
					$tpl = preg_replace('#\{if_backend_edit\}(.*)\{/if_backend_edit\}#sU','',$tpl);
				}
			// global if-backend
			if(strpos($tpl,'{if_backend_preview}')!==false)
				if ($sess->name == 'sefrengo' && ($view == 'preview' && $view != 'edit')) {
				  $tpl = str_replace(array('{if_backend_preview}','{/if_backend_preview}'), array('',''), $tpl);
				} else {
					$tpl = preg_replace('#\{if_backend_preview\}(.*)\{/if_backend_preview\}#sU','',$tpl);
				}
			// global if-frontend
			if(strpos($tpl,'{if_frontend}')!==false)
				if (($sess->name != 'sefrengo')) {
				  $tpl = str_replace(array('{if_frontend}','{/if_frontend}'), array('',''), $tpl);
				} else {
					$tpl = preg_replace('#\{if_frontend\}(.*)\{/if_frontend\}#sU','',$tpl);
				}
				
			return $tpl;
	
	}
}



?>
