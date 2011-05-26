<?PHP

		$_AS['TMP']['publish']=array();
		$_AS['TMP']['publish']['name']=$_AS['item']->getDataByKey($_AS['artsys_obj']->getSetting('spfnc_facebook_url_name'),$txttransform); 
		$_AS['TMP']['publish']['name']=strip_tags($_AS['TMP']['publish']['name']);
		
		$_AS['TMP']['publish']['caption']=$_AS['item']->getDataByKey($_AS['artsys_obj']->getSetting('spfnc_facebook_url_caption'),$txttransform); 
		$_AS['TMP']['publish']['caption']=strip_tags($_AS['TMP']['publish']['caption']);
		
		$_AS['TMP']['publish']['description']=$_AS['TMP']['output']; 
		$_AS['TMP']['publish']['description']=strip_tags($_AS['TMP']['publish']['description']);
		
		$_AS['TMP']['publish']['link_man']=$_AS['item']->getDataByKey($_AS['artsys_obj']->getSetting('spfnc_facebook_url_man'));
		$_AS['TMP']['value_arr']=explode("\n",$_AS['TMP']['publish']['link_man']);
		if ($_AS['artsys_obj']->getSetting('spfnc_facebook_url_man')=='' ||
				$_AS['TMP']['publish']['link_man']=='' ||
				trim($_AS['TMP']['value_arr'][0])=='' ) {
			$_AS['TMP']['publish']['link']=$_AS['artsys_obj']->getSetting('spfnc_facebook_url'); 
			$_AS['TMP']['publish']['link']=str_replace('{idlang}',$lang,$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=str_replace('{idarticle}',$id,$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=str_replace('{idcategory}',$_AS['item']->getDataByKey('idcategory'),$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=str_replace('{baseurl}',$cfg_client['htmlpath'],$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=$_AS['TMP']['publish']['link'];
		}	else if ($_AS['artsys_obj']->getSetting('article_'.$_AS['artsys_obj']->getSetting('spfnc_facebook_url_man').'_type')=='link') {
				$_AS['TMP']['publish']['link_man']=trim($_AS['TMP']['value_arr'][0]);
				$_AS['TMP']['publish']['name']=trim($_AS['TMP']['value_arr'][1]);
				$_AS['TMP']['value_arr'][0]='';
				$_AS['TMP']['value_arr'][1]='';
				$_AS['TMP']['publish']['caption']=trim(implode("\n",$_AS['TMP']['value_arr']));		
				$_AS['TMP']['publish']['link']=$_AS['TMP']['publish']['link_man'];
				if (strpos($_AS['TMP']['publish']['link'],'cms://')!==false)
					$_AS['TMP']['publish']['link']=str_replace('cms://',$cfg_client['htmlpath'].'index.php?',	$_AS['TMP']['publish']['link']).'&lang='.$lang;
				$_AS['TMP']['publish']['link']=urlencode(urldecode(trim($_AS['TMP']['publish']['link'])));
		} else 
				$_AS['TMP']['publish']['link']=urlencode(urldecode(trim($_AS['TMP']['publish']['link_man'])));

		$_AS['TMP']['media_elmtype']=$_AS['artsys_obj']->getSetting('article_'.$_AS['artsys_obj']->getSetting('spfnc_facebook_media').'_type');
		if($_AS['TMP']['media_elmtype']=='text')
			$_AS['TMP']['publish']['media_raw']=$_AS['item']->getDataByKey($_AS['artsys_obj']->getSetting('spfnc_facebook_media'));
		else {
			$_AS['TMP']['media_raw']=$_AS['item']->getDataByKey($_AS['artsys_obj']->getSetting('spfnc_facebook_media'));
			$_AS['TMP']['media_raw_arr']=explode("\n",$_AS['TMP']['media_raw']);
			$_AS['TMP']['publish']['media_raw']=$cfg_client['htmlpath'].trim($_AS['TMP']['media_raw_arr'][0]);
		}
		
		$_AS['TMP']['media']['ext']=substr(trim($_AS['TMP']['publish']['media_raw']), strrpos(trim($_AS['TMP']['publish']['media_raw']),".")+1);
		
		if (in_array($_AS['TMP']['media']['ext'],array('jpeg','jpg','png','gif','JPEG','JPG','PNG','GIF')))
			$_AS['TMP']['publish']['mediatype']='image';
		else if (in_array($_AS['TMP']['media_raw_arr']['ext'],array('mp3','MP3')))
			$_AS['TMP']['publish']['mediatype']='mp3';
		else if (in_array($_AS['TMP']['media_raw_arr']['ext'],array('swf','SWF')))
			$_AS['TMP']['publish']['mediatype']='flash';
		else 
			$_AS['TMP']['publish']['mediatype']='';

		if (!empty($_AS['TMP']['publish']['mediatype']))	
			$_AS['TMP']['publish']['media']=urlencode(urldecode($_AS['TMP']['publish']['media_raw']));
		else
			$_AS['TMP']['publish']['media']='';
			
		if (empty($_AS['TMP']['publish']['name']))
			$_AS['TMP']['publish']['name']=htmlentities($_AS['TMP']['publish']['link'],ENT_COMPAT,'UTF-8');

		$_AS['TMP']['publish']['name']=json_encode($_AS['TMP']['publish']['name']);
		$_AS['TMP']['publish']['caption']=json_encode($_AS['TMP']['publish']['caption']);
		$_AS['TMP']['publish']['description']=json_encode($_AS['TMP']['publish']['description']);

		?>
		
		<script type="text/javascript">
		
			var name<?PHP echo $id; ?> = <?PHP echo $_AS['TMP']['publish']['name']; ?>;
			var caption<?PHP echo $id; ?> = <?PHP echo $_AS['TMP']['publish']['caption']; ?>;
			var description<?PHP echo $id; ?> = <?PHP echo $_AS['TMP']['publish']['description']; ?>;
			var link<?PHP echo $id; ?> = '<?PHP echo $_AS['TMP']['publish']['link']; ?>';
			var mediatype<?PHP echo $id; ?> = '<?PHP echo $_AS['TMP']['publish']['mediatype']; ?>';
			var media<?PHP echo $id; ?> = '<?PHP echo $_AS['TMP']['publish']['media']; ?>';
		
		</script>
		
		<?PHP
		
		echo '<div id="post'.$id.'" class="fullwidthmsg">
					<input style="float:right;" type="button" value="'.$_AS['artsys_obj']->lang->get('spfnc_publish').'" onclick="document.getElementById(\'post'.$id.'\').className=\'fullwidthmsg\';streamPublish(name'.$id.', link'.$id.', caption'.$id.', description'.$id.', mediatype'.$id.', media'.$id.','.$id.');return false"/>'."\n";
		echo '<div style="width:465px;font-size:11px;">'.$_AS['item']->getDataByKey('title',true).'</div>';
		echo '<iframe src="export_facebook_update.php?db='.$_AS['db'].
					'&amp;lang='.$lang.
					'&amp;client='.$client.
					'&amp;idarticle='.$id.
					'" width="99%" height="100" name="articleupdate'.$id.
					'" style="display:none;"></iframe>'."\n";
		echo '</div>';

?>