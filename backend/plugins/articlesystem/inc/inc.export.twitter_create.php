<?PHP

		$_AS['TMP']['publish']=array();
		$_AS['TMP']['publish']['description']=$_AS['TMP']['output']; 
		$_AS['TMP']['publish']['description']=strip_tags($_AS['TMP']['publish']['description']);

		$_AS['TMP']['publish']['link_man']=$_AS['item']->getDataByKey($_AS['artsys_obj']->getSetting('spfnc_twitter_url_man'));
		$_AS['TMP']['value_arr']=explode("\n",$_AS['TMP']['publish']['link_man']);
		if ($_AS['artsys_obj']->getSetting('spfnc_twitter_url_man')=='' ||
				$_AS['TMP']['publish']['link_man']=='' ||
				trim($_AS['TMP']['value_arr'][0])=='' ) {
			$_AS['TMP']['publish']['link']=$_AS['artsys_obj']->getSetting('spfnc_twitter_url'); 
			$_AS['TMP']['publish']['link']=str_replace('{idlang}',$lang,$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=str_replace('{idarticle}',$id,$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=str_replace('{idcategory}',$_AS['item']->getDataByKey('idcategory'),$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=str_replace('{baseurl}',$cfg_client['htmlpath'],$_AS['TMP']['publish']['link']);
			$_AS['TMP']['publish']['link']=$_AS['TMP']['publish']['link'];
		}	else if ($_AS['artsys_obj']->getSetting('article_'.$_AS['artsys_obj']->getSetting('spfnc_twitter_url_man').'_type')=='link') {
				$_AS['TMP']['publish']['link_man']=trim($_AS['TMP']['value_arr'][0]);
				$_AS['TMP']['publish']['name']=trim($_AS['TMP']['value_arr'][1]);
				$_AS['TMP']['value_arr'][0]='';
				$_AS['TMP']['value_arr'][1]='';
				$_AS['TMP']['publish']['caption']=trim(implode("\n",$_AS['TMP']['value_arr']));		
				$_AS['TMP']['publish']['link']=$_AS['TMP']['publish']['link_man'];
				if (strpos($_AS['TMP']['publish']['link'],'cms://')!==false)
					$_AS['TMP']['publish']['link']=str_replace('cms://',$cfg_client['htmlpath'].'index.php?',	$_AS['TMP']['publish']['link']).'&lang='.$lang;
				$_AS['TMP']['publish']['link']=trim($_AS['TMP']['publish']['link']);
		} else 
				$_AS['TMP']['publish']['link']=trim($_AS['TMP']['publish']['link_man']);

		include_once $_AS['basedir'] . 'inc/class.snoopy.php';

		$_AS['TMP']['snoopy'] = new Snoopy;
		$_AS['TMP']['snoopy']->fetch("http://is.gd/api.php?longurl=".urlencode($_AS['TMP']['publish']['link']));
		$_AS['TMP']['link_snoopyresult_arr']=explode("\n",$_AS['TMP']['snoopy']->results);
		$_AS['TMP']['link_isgd']=trim($_AS['TMP']['link_snoopyresult_arr'][0]);
		if (strpos($_AS['TMP']['link_isgd'],'is.gd')!==false)		
			$_AS['TMP']['publish']['link']=$_AS['TMP']['link_isgd'];

		$_AS['TMP']['publish']['description']=str_replace('{url}',$_AS['TMP']['publish']['link'],$_AS['TMP']['publish']['description']);
	
		?>
		
		<script type="text/javascript">
		
			var data<?PHP echo $id; ?> = "<?PHP echo addslashes($_AS['TMP']['publish']['description']); ?>";
		
		</script>
		
		<?PHP
		
		echo '<div id="post'.$id.'" class="fullwidthmsg">
					<input style="float:right;" type="button" value="'.$_AS['artsys_obj']->lang->get('spfnc_publish').'" onclick="document.getElementById(\'post'.$id.'\').className=\'fullwidthmsg\';publishTweet('.$id.');return false"/>'."\n";
		echo '<div style="width:465px;font-size:11px;padding-left:3px;">'.$_AS['item']->getDataByKey('title',true).'<small class="shorturl"><a href="'.$_AS['TMP']['link_isgd'].'" target="_blank">'.str_replace('http://','',$_AS['TMP']['link_isgd']).'</a></small></div>';
		echo '<iframe src="export_twitter_publish.php?db='.$_AS['db'].
					'&amp;lang='.$lang.
					'&amp;client='.$client.
					'&amp;idarticle='.$id.
					'" width="80%" height="90" name="articleupdate'.$id.
					'" style="padding:0;border:0;overflow:hidden;frameborder="no"></iframe>
					</div>';

?>
