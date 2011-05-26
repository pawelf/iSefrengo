<?php


$_AS=array();

//config mode
$mip_form['0']['desc'] = 'Konfigurationsmodus';
$mip_form['0']['cat'] = 'option';
$mip_form['0']['size'] = '1';
$mip_form['0']['option_desc'][] = 'Normal';
$mip_form['0']['option_val'][] =  '';
#$mip_form['0']['option_desc'][] = 'Erweitert';
#$mip_form['0']['option_val'][] =  'advanced';
$mip_form['0']['option_desc'][] = 'Ausgeblendet';
$mip_form['0']['option_val'][] =  'hidden';
$mip_form['0']['cms_var'] = 'MOD_VAR[0]';
$mip_form['0']['cms_val'] = $cms_mod['value']['0'];
$mip_form['0']['flag'] = 'reload';

//config mode
$mip_form['1000000']['desc'] = 'Zu nutzende Datenbank';
$mip_form['1000000']['cat'] = 'option';
$mip_form['1000000']['size'] = '1';

$_AS['temp']['sql'] = "SHOW TABLES";

$db->query($_AS['temp']['sql']);
$db->next_record();

$_AS['db_tables']=array();
while($db->next_record()){
	if (strpos($db->f('0'),'articlesystem')!==false) {
		$AS_configtemp['tname'] = explode('_',str_replace($cfg_cms['db_table_prefix'],'',$db->f('0')));
		$_AS['db_tables'][$AS_configtemp['tname'][1]] = $AS_configtemp['tname'][1];
	}
}
foreach($_AS['db_tables'] as $v) {
	$_AS['temp']['sql'] = "SELECT value FROM  ".$cms_db['values']." WHERE group_name='lang' AND key1='nav_".$v."' AND idclient='$client'";
	$db->query($_AS['temp']['sql']);
	$db->next_record();
	
	$mip_form['1000000']['option_desc'][] = strtoupper($v).' ('.htmlentities(stripslashes($db->f('value')),ENT_COMPAT,'UTF-8').')';
	$mip_form['1000000']['option_val'][] =  $v;
}

unset($_AS['temp']['sql']);

$mip_form['1000000']['cms_var'] = 'MOD_VAR[1000000]';
$mip_form['1000000']['cms_val'] = $cms_mod['value']['1000000'];
$mip_form['1000000']['cms_val_default'] = 'articlesystem';
$mip_form['1000000']['flag'] = 'reload';

if (empty($cms_mod['value']['1000000']))
	$_AS['db']='articlesystem';
else
	$_AS['db']=$cms_mod['value']['1000000'];

// Datumformat
$mip_form['10']['cat'] = 'txt';
$mip_form['10']['type'] = '';
$mip_form['10']['rows'] = '1';
$mip_form['10']['desc'] = '<small>Tag: {day}, Monat: {month}, Jahr: {year}<br/><strong>{startdate} {enddate} {range_date_from} {range_date_to}</small></strong>';
$mip_form['10']['cms_var'] = 'MOD_VAR[10]';
$mip_form['10']['cms_val'] = $cms_mod['value']['10'];
$mip_form['10']['cms_val_default'] = '{day}.{month}.{year}';

$mip_form['10010']['cat'] = 'txt';
$mip_form['10010']['type'] = '';
$mip_form['10010']['rows'] = '1';
$mip_form['10010']['desc'] = 'Hauptausgabe - Tag<strong><small><br/>{range_date_from:day} {range_date_to:day}</small></strong>';
$mip_form['10010']['cms_var'] = 'MOD_VAR[10010]';
$mip_form['10010']['cms_val'] = $cms_mod['value']['10010'];
$mip_form['10010']['cms_val_default'] = 'd';

$mip_form['10011']['cat'] = 'txt';
$mip_form['10011']['type'] = '';
$mip_form['10011']['rows'] = '1';
$mip_form['10011']['desc'] = 'Hauptausgabe - Monat<strong><small><br/>{range_date_from:month} {range_date_to:month}</small></strong>';
$mip_form['10011']['cms_var'] = 'MOD_VAR[10011]';
$mip_form['10011']['cms_val'] = $cms_mod['value']['10011'];
$mip_form['10011']['cms_val_default'] = 'm';

$mip_form['10012']['cat'] = 'txt';
$mip_form['10012']['type'] = '';
$mip_form['10012']['rows'] = '1';
$mip_form['10012']['desc'] = 'Hauptausgabe - Jahr<strong><small><br/>{range_date_from:year} {range_date_to:year}</small></strong>';
$mip_form['10012']['cms_var'] = 'MOD_VAR[10012]';
$mip_form['10012']['cms_val'] = $cms_mod['value']['10012'];
$mip_form['10012']['cms_val_default'] = 'Y';

$mip_form['10110']['cat'] = 'txt';
$mip_form['10110']['type'] = '';
$mip_form['10110']['rows'] = '1';
$mip_form['10110']['desc'] = 'Liste - Tag<strong><small><br/>{startdate:day}  {enddate:day} {custom:<em>1-35</em>:day}</small></strong>';
$mip_form['10110']['cms_var'] = 'MOD_VAR[10110]';
$mip_form['10110']['cms_val'] = $cms_mod['value']['10110'];
$mip_form['10110']['cms_val_default'] = 'd';

$mip_form['10111']['cat'] = 'txt';
$mip_form['10111']['type'] = '';
$mip_form['10111']['rows'] = '1';
$mip_form['10111']['desc'] = 'Liste - Monat<strong><small><br/>{startdate:month}  {enddate:month} {custom:<em>1-35</em>:month}</small></strong>';
$mip_form['10111']['cms_var'] = 'MOD_VAR[10111]';
$mip_form['10111']['cms_val'] = $cms_mod['value']['10111'];
$mip_form['10111']['cms_val_default'] = 'm';

$mip_form['10112']['cat'] = 'txt';
$mip_form['10112']['type'] = '';
$mip_form['10112']['rows'] = '1';
$mip_form['10112']['desc'] = 'Liste - Jahr<strong><small><br/>{startdate:year}  {enddate:year}  {custom:<em>1-35</em>:year}</small></strong>';
$mip_form['10112']['cms_var'] = 'MOD_VAR[10112]';
$mip_form['10112']['cms_val'] = $cms_mod['value']['10112'];
$mip_form['10112']['cms_val_default'] = 'Y';

$mip_form['10210']['cat'] = 'txt';
$mip_form['10210']['type'] = '';
$mip_form['10210']['rows'] = '1';
$mip_form['10210']['desc'] = 'Detailansicht - Tag<strong><small><br/>{startdate:day}  {enddate:day} {custom:<em>1-35</em>:day}</small></strong>';
$mip_form['10210']['cms_var'] = 'MOD_VAR[10210]';
$mip_form['10210']['cms_val'] = $cms_mod['value']['10210'];
$mip_form['10210']['cms_val_default'] = 'd';

$mip_form['10211']['cat'] = 'txt';
$mip_form['10211']['type'] = '';
$mip_form['10211']['rows'] = '1';
$mip_form['10211']['desc'] = 'Detailansicht - Monat<strong><small><br/>{startdate:month}  {enddate:month} {custom:<em>1-35</em>:month}</small></strong>';
$mip_form['10211']['cms_var'] = 'MOD_VAR[10211]';
$mip_form['10211']['cms_val'] = $cms_mod['value']['10211'];
$mip_form['10211']['cms_val_default'] = 'm';

$mip_form['10212']['cat'] = 'txt';
$mip_form['10212']['type'] = '';
$mip_form['10212']['rows'] = '1';
$mip_form['10212']['desc'] = 'Detailansicht - Jahr<strong><small><br/>{startdate:year}  {enddate:year} {custom:<em>1-35</em>:year}</small></strong>';
$mip_form['10212']['cms_var'] = 'MOD_VAR[10212]';
$mip_form['10212']['cms_val'] = $cms_mod['value']['10212'];
$mip_form['10212']['cms_val_default'] = 'Y';



$mip_form['11100']['cat'] = 'txt';
$mip_form['11100']['type'] = '';
$mip_form['11100']['rows'] = '1';
$mip_form['11100']['desc'] = '<strong>Locale-Einstellung <small>(PHP-Funktion setlocale())</small></strong>';
$mip_form['11100']['cms_var'] = 'MOD_VAR[11100]';
$mip_form['11100']['cms_val'] = $cms_mod['value']['11100'];
$mip_form['11100']['cms_val_default'] = "LC_TIME,de_DE@euro,de_DE,de,ge";

$mip_form['11110']['cat'] = 'txt';
$mip_form['11110']['type'] = '';
$mip_form['11110']['rows'] = '1';
$mip_form['11110']['desc'] = 'Liste - Tag<strong><small><br/>{startdate:day2}  {enddate:day2} {custom:<em>1-35</em>:day2}</small></strong>';
$mip_form['11110']['cms_var'] = 'MOD_VAR[11110]';
$mip_form['11110']['cms_val'] = $cms_mod['value']['11110'];
$mip_form['11110']['cms_val_default'] = '%A';

$mip_form['11111']['cat'] = 'txt';
$mip_form['11111']['type'] = '';
$mip_form['11111']['rows'] = '1';
$mip_form['11111']['desc'] = 'Liste - Monat<strong><small><br/>{startdate:month2}  {enddate:month2} {custom:<em>1-35</em>:month2}</small></strong>';
$mip_form['11111']['cms_var'] = 'MOD_VAR[11111]';
$mip_form['11111']['cms_val'] = $cms_mod['value']['11111'];
$mip_form['11111']['cms_val_default'] = '%B';

$mip_form['11210']['cat'] = 'txt';
$mip_form['11210']['type'] = '';
$mip_form['11210']['rows'] = '1';
$mip_form['11210']['desc'] = 'Detailansicht - Tag<strong><small><br/>{startdate:day2}  {enddate:day2} {custom:<em>1-35</em>:day2}</small></strong>';
$mip_form['11210']['cms_var'] = 'MOD_VAR[11210]';
$mip_form['11210']['cms_val'] = $cms_mod['value']['11210'];
$mip_form['11210']['cms_val_default'] = '%A';

$mip_form['11211']['cat'] = 'txt';
$mip_form['11211']['type'] = '';
$mip_form['11211']['rows'] = '1';
$mip_form['11211']['desc'] = 'Detailansicht - Monat<strong><small><br/>{startdate:month2}  {enddate:month2} {custom:<em>1-35</em>:month2}</small></strong>';
$mip_form['11211']['cms_var'] = 'MOD_VAR[11211]';
$mip_form['11211']['cms_val'] = $cms_mod['value']['11211'];
$mip_form['11211']['cms_val_default'] = '%B';

// Zeitformat
$mip_form['11']['cat'] = 'txt';
$mip_form['11']['type'] = '';
$mip_form['11']['rows'] = '1';
$mip_form['11']['desc'] = '<small>Stunde: {hour}, Minute: {minute}<br/><strong>{starttime24} {endtime24} {starttime12} {endtime12}<br/> {range_time_from} {range_time_to}</small></strong><br/>
';
$mip_form['11']['cms_var'] = 'MOD_VAR[11]';
$mip_form['11']['cms_val'] = $cms_mod['value']['11'];
$mip_form['11']['cms_val_default'] = '{hour}:{minute} Uhr';



// Seitenschaltung richtung
$mip_form['2']['cat'] = 'option';
$mip_form['2']['type'] = '';
$mip_form['2']['rows'] = '1';
$mip_form['2']['desc'] = 'Seitenzahlenrichtung';
$mip_form['2']['cms_var'] = 'MOD_VAR[2]';
$mip_form['2']['cms_val'] = $cms_mod['value']['2'];
$mip_form['2']['cms_val_default'] = '0';
$mip_form['2']['option_desc'][]= 'Neueste Artikel - Erste Seite';
$mip_form['2']['option_val'][]= '0';
$mip_form['2']['option_desc'][]= 'Neueste Artikel - Letze Seite';
$mip_form['2']['option_val'][]= '1';



// Seitenschaltung in der Listenansicht
$mip_form['1']['cat'] = 'option';
$mip_form['1']['type'] = '';
$mip_form['1']['tab'] = '0';
$mip_form['1']['desc'] = '<strong>Anzuzeigender Zeitabschnitt</strong>';
$mip_form['1']['cms_var'] = 'MOD_VAR[1]';
$mip_form['1']['cms_val'] = $cms_mod['value']['1'];
$mip_form['1']['cms_val_default'] = '1';
$mip_form['1']['option_desc'][]= '1 Monat';
$mip_form['1']['option_val'][]= '1';
$mip_form['1']['option_desc'][]= '2 Monate';
$mip_form['1']['option_val'][]= '2';
$mip_form['1']['option_desc'][]= '3 Monate';
$mip_form['1']['option_val'][]= '3';
$mip_form['1']['option_desc'][]= '6 Monate';
$mip_form['1']['option_val'][]= '6';
$mip_form['1']['option_desc'][]= '1 Jahr';
$mip_form['1']['option_val'][]= '12';
$mip_form['1']['option_desc'][]= '2 Jahre';
$mip_form['1']['option_val'][]= '24';
$mip_form['1']['option_desc'][]= 'deaktiviert (alle Artikel anzeigen)';
$mip_form['1']['option_val'][]= '-1';
$mip_form['1']['flag'] = 'reload';

// Seitenschaltung nach Anzahl
$mip_form['3']['cat'] = 'option';
$mip_form['3']['type'] = '';$mip_form['3']['rows'] = '1';
$mip_form['3']['tab'] = '0';
$mip_form['3']['desc'] = 'Artikel-Gültigkeit';
$mip_form['3']['cms_var'] = 'MOD_VAR[3]';
$mip_form['3']['cms_val'] = $cms_mod['value']['3'];
$mip_form['3']['cms_val_default'] = '1';
$mip_form['3']['option_desc'][]= 'Tag wird berücksichtigt';
$mip_form['3']['option_val'][]= '0';
$mip_form['3']['option_desc'][]= 'Tag und Uhrzeit werden berücksichtigt';
$mip_form['3']['option_val'][]= '1';


// Artikel aus dieser Kategorie anzeigen
$mip_form['8']['cat'] = 'option';
$mip_form['8']['type'] = '';
$mip_form['8']['rows'] = '1';
$mip_form['8']['desc'] = '<strong>Artikel aus Kategorie</strong> <small><br/>und Startkategorie für <small>{category_select}</small>';
$mip_form['8']['cms_var'] = 'MOD_VAR[8]';
$mip_form['8']['cms_val'] = $cms_mod['value']['8'];
$mip_form['8']['cms_val_default'] = '0';
$mip_form['8']['option_desc'][] = 'Alle';
$mip_form['8']['option_val'][] = '0';


//AdoDB initialtisieren
$_AS['temp']['sql'] = "SELECT
            A.idlang, A.name
        FROM
            ".$cfg_cms['db_table_prefix']."lang A
        LEFT JOIN
            ".$cfg_cms['db_table_prefix']."clients_lang B USING(idlang)
        WHERE
            B.idclient='".$client."'
        ORDER BY
            idlang";

$db->query($_AS['temp']['sql']);

while ($db->next_record()) {
    $_AS['temp']['lang'][$db->f(0)] = $db->f(1);
}

unset($_AS['temp']['sql']);

$_AS['temp']['sql'] = "SELECT idcategory, name, idlang FROM ".$cfg_cms['db_table_prefix']."plug_".$_AS['db']."_category WHERE idclient='".$client."' ORDER BY idlang,hash ASC"; // AND idlang='".$idlang."'
$db->query($_AS['temp']['sql']);

$_AS['temp']['catinfo']='';

while ($db->next_record()) {
		$_AS['temp']['catinfo'] .= '<tr><td><small>'.
																	$_AS['temp']['lang'][$db->f(2)].
																	'</small></td><td><small><strong>'.
																	$db->f(1).
																	'</strong></small></td><td><small>Id'.
																	'</small></td><td align="right"><small><strong>'.
																	$db->f(0).
																	'</strong></small></td></tr>';
    $mip_form['8']['option_desc'][] = '('.$_AS['temp']['lang'][$db->f(2)].') '.$db->f(1);
    $mip_form['8']['option_val'][] = $db->f(0);

}

if (count($mip_form['8']['option_desc'])<2)
		$mip_form['8']['cat'] = 'hidden';

unset($_AS['temp']['sql']);
// Template Listenansicht - Body
$mip_form['5']['desc'] = '<strong>Hauptausgabe</strong>';
$mip_form['5']['cat'] = 'txtarea';
$mip_form['5']['rows'] = '18';
$mip_form['5']['type'] = 'long';
$mip_form['5']['cms_var'] = 'MOD_VAR[5]';
$mip_form['5']['cms_val'] = $cms_mod['value']['5'];
$mip_form['5']['cms_val_default'] = '{search_form}
<br/>
{if_listview}
{range}
{/if_listview}
<br/>
<br/>
<table border="0" width="50%" cellpadding="4" cellspacing="0">
{if_listview}
		<td valign="top" width="20%">{startdate_sortlink}Datum{/startdate_sortlink}</td>
		<td valign="top">{title_sortlink}{title_label}{/title_sortlink}</td>
{/if_listview}
{content}
</table>
<br/>
{page_nav_adv}
';
// legend template single entry
$mip_form['90005']['cat'] = 'desc';
$mip_form['90005']['type'] = '';
$mip_form['90005']['desc'] = '<div id="legend_MOD_VAR1" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{content}<br/>
{title_label} {teaser_label} {text_label} {category_label} {custom_label:<em>1-35</em>} {custom_selected:<em>1-35</em>}<br/>
{range} {range_time24_from} {range_time24_to} {range_time12_from} {range_time12_to}<br/>
{range_date_from} {range_date_from:day} {range_date_from:month} {range_date_from:year}<br/>{range_date_to} {range_date_to:day} {range_date_to:month} {range_date_to:year}<br/>
{container_id} {mod_key}<br/>
<strong>Interaktion</strong><br/>
'.(($cms_mod['value']['74'] == 'calendar')?'{calendar} {calendar:nohead} {calendar_month} {calendar_prev_link} {calendar_next_link} {calendar:prev} {calendar:next} {calendar_month:prev} {calendar_month:next} {calendar:prev:nohead} {calendar:next:nohead}<br/>':'').' {page_nav_adv} {page_nav} {page_nav_first} {page_nav_prev} {page_nav_numbers} {page_nav_next} {page_nav_last}<br/>{pages_current} {pages_total} {link_rangeforward} {link_rangebackward}<br/>
<strong style="color:#333">{search_form} {article_form} {set_article_form} {category_form} {set_category_form} {category_links} <br/>
{year_form} {yearrange_form} {month_form} {customfilter_form:<em>1-35</em>} {customfilter_combinedform:<em>1</em>:<em>2</em>:<em>&nbsp;...&nbsp;</em>:<em>35</em>} {savesettings_form}</strong><br/>
{startdate_sortlink} {/startdate_sortlink}<br/>{enddate_sortlink} {/enddate_sortlink}<br/>{title_sortlink} {/title_sortlink}<br/>{teaser_sortlink} {/teaser_sortlink}<br/>{text_sortlink} {/text_sortlink}<br/>{custom_sortlink:<em>1-35</em>} {/custom_sortlink:<em>1-35</em>}<br/>
<strong>Inhaltslogik/-manipulation</strong><br/>
{if_backend} {/if_backend} {if_backend_edit} {/if_backend_edit} {if_backend_preview} {/if_backend_preview}
<br/>{if_frontend} {/if_frontend} {if_page_numbers} {/if_page_numbers}<br/>
{if_custom_selected:<em>1-35</em>} {/if_custom_selected:<em>1-35</em>}<br/>
{if_listview} {/if_listview} {if_detailview} {/if_detailview}<br/>
{if_range_date_from} {/if_range_date_from} {if_not_range_date_from} {/if_not_range_date_from}<br/>
{if_range_date_to} {/if_range_date_to} {if_not_range_date_to} {/if_not_range_date_to}<br/>
{if_idlang=...} {/if_idlang=...} {if_not_idlang=...} {/if_not_idlang=...}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR1\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// Template Listenansicht - Zeile
$mip_form['6']['desc'] = '<strong>Liste - Zeile <small>{content}</small></strong>';
$mip_form['6']['cat'] = 'txtarea';
$mip_form['6']['rows'] = '12';
$mip_form['6']['type'] = 'long';
$mip_form['6']['cms_var'] = 'MOD_VAR[6]';
$mip_form['6']['cms_val'] = $cms_mod['value']['6'];
$mip_form['6']['cms_val_default'] = '	<tr>
		<td valign="top" width="20%">{startdate} {starttime}</td>
		<td valign="top">
			{if_text}
			<a href="{url}">{title}</a><br/>
			<small>{chop}{text}{/chop}</small>
			{/if_text}
			{if_not_text}
			{title}
			{/if_not_text}
		</td>
	</tr>
';
// legend template single entry
$mip_form['90006']['cat'] = 'desc';
$mip_form['90006']['type'] = '';
$mip_form['90006']['desc'] = '<div id="legend_MOD_VAR2" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{title} {teaser} {text} {category} {categoryid} {images} {files} {links} {category} {dates}<br/>
{image:x} {imageurl:x} {imagelinkurl:x} {imagetitle:x} {imagedesc:x} {imagethumb:x} {imagethumburl:x}<br/>
{file:x} {fileurl:x} {filetitle:x} {filedesc:x} {filename:x} {fileext:x} {filesize:x}<br/>
{link:x} {linkurl:x} {linktitle:x} {linkdesc:x}<br/>
{date:x} {datetitle:x} {datedesc:x} {dateduration:x} {datetime24:x} {datetime12:x} {date:x:day} {date:x:month} {date:x:day2} {date:x:month2} {date:x:year}<br/>
{custom:<em>1-35</em>} <span style="color:#555;">{custom_data:<em>1-35</em>}</span> {custom_label:<em>1-35</em>} {custom:<em>1-35</em>:date} {custom:<em>1-35</em>:time}<br/>{custom:<em>1-35</em>:day} {custom:<em>1-35</em>:month} {custom:<em>1-35</em>:year} {custom:<em>1-35</em>:timestamp}<br/>
{custom_<em>"image"-Elemente</em>:<em>1-35</em>} {custom_<em>"file"-Elemente</em>:<em>1-35</em>} {custom_<em>"link"-Elemente</em>:<em>1-35</em>}<br/>
Spezielle "Custom-Link"-Elemente: {custom_linkidcat:<em>1-35</em>} {custom_linkidcat:<em>1-35</em>:idcatside_si<em>1-3</em>} {custom_linkidcat:<em>1-35</em>:idcatside_name_si<em>1-3</em>} {custom_linkidcatside:<em>1-35</em>}<br/>
{custom_linkidcat:<em>1-35</em>:idcat_si<em>1-3</em>} {custom_linkidcat:<em>1-35</em>:idcat_name_si<em>1-3</em>}<br/>
Alternativ für alle frei definierbaren Felder: {<em>Alias</em>} <span style="color:#555;">{<em>Alias</em>_data}</span> {<em>Alias</em>_label} {<em>Alias</em>:date} {<em>Alias</em>:time}<br/>{<em>Alias</em>:day} {<em>Alias</em>:month} {<em>Alias</em>:year} {<em>Alias</em>:timestamp}<br/>
{<em>Alias</em>_<em>"image"-Elemente</em>:<em>1-35</em>} {<em>Alias</em>_<em>"file"-Elemente</em>:<em>1-35</em>} {<em>Alias</em>_<em>"link"-Elemente</em>:<em>1-35</em>} <br/>
{<em>Alias</em>_linkidcat} {<em>Alias</em>_linkidcat:idcatside_si<em>1-3</em>} {<em>Alias</em>_linkidcat:idcatside_name_si<em>1-3</em>} {<em>Alias</em>_linkidcatside}<br/>
{<em>Alias</em>_linkidcat:idcat_si<em>1-3</em>} {<em>Alias</em>_linkidcat:idcat_name_si<em>1-3</em>}<br/>
{startdate} {startdate:day} {startdate:month} {startdate:year}<br/>
{enddate} {enddate:day} {enddate:month} {enddate:year}<br/>
{starttime24} {starttime12} {endtime24} {endtime12}<br/>
{items_count:all} (or {items_count}) {items_count:page} {items_count:oddeven} <br/>
{idarticle} {today_timestmap} {idlang} {container_id} {mod_key} {comments_count}<br/>
<strong>Interaktion</strong><br/>{url} <em>(Detailansicht)</em><br/>
<strong>Inhaltslogik/-manipulation</strong><br/>
{if_backend} {/if_backend} {if_backend_edit} {/if_backend_edit} {if_backend_preview} {/if_backend_preview}<br/>{if_frontend} {/if_frontend}<br/>
<strong>{if_</strong><em>Element:x</em><strong>} {/if_</strong><em>Element:x</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>} {/if_not_</strong><em>Element:x</em><strong>}</strong><br/>
<strong>{if_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>} {/if_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>} {/if_not_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>}</strong><br/>
<strong>{if_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>} {/if_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>} {/if_not_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>}</strong><br/>
<strong>{if_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>} {/if_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>} {/if_not_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>}</strong><br/>
Alternativ kann auch der Wert eines anderen Elements für Vergleiche genutzt werden!<br/>Anstelle <em>Value</em> wird das Element in eckigen Klammern notiert -> [<em>Element:y</em>].<br/>
{hide_on_last_item} {/hide_on_last_item} {chop} ... {/chop}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR2\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['17']['desc'] = '<strong>Liste - Kopf <small>{content}</small></strong> <small>(Wird am Anfang der Listung und bei sich wechselnden Kategorien innerhalb der Liste ausgegeben.)';
$mip_form['17']['cat'] = 'txtarea';
$mip_form['17']['rows'] = '8';
$mip_form['17']['type'] = 'long';
$mip_form['17']['cms_var'] = 'MOD_VAR[17]';
$mip_form['17']['cms_val'] = $cms_mod['value']['17'];
$mip_form['17']['cms_val_default'] = '	<tr>
{if_category}
		<td colspan="2">
			<small>{category}</small>
		</td>
{/if_category}
{if_not_category}
		<td colspan="2">
			<small>Ohne Kategorie</small>
		</td>
{/if_not_category}
	</tr>
';
// legend template single entry
$mip_form['90017']['cat'] = 'desc';
$mip_form['90017']['type'] = '';
$mip_form['90017']['desc'] = '<div id="legend_MOD_VAR19" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{category}<br/>
<strong>Inhaltslogik/-manipulation</strong><br/>
{if_category} ... {/if_category} {if_not_category} ... {/if_not_category}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR19\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['9']['desc'] = '<strong>Liste - Zeile wenn keine Artikel vorhanden <small>{content}</small><strong>';
$mip_form['9']['cat'] = 'txtarea';
$mip_form['9']['rows'] = '5';
$mip_form['9']['type'] = 'long';
$mip_form['9']['cms_var'] = 'MOD_VAR[9]';
$mip_form['9']['cms_val'] = $cms_mod['value']['9'];
$mip_form['9']['cms_val_default'] = '	<tr>
		<td valign="top"colspan="2"> 
			Keinen Eintrag gefunden.
		</td>
	</tr>
';

// Template Detailansicht
$mip_form['7']['desc'] = '<strong>Detailansicht</strong>';
$mip_form['7']['cat'] = 'txtarea';
$mip_form['7']['rows'] = '18';
$mip_form['7']['type'] = 'long';
$mip_form['7']['cms_var'] = 'MOD_VAR[7]';
$mip_form['7']['cms_val'] = $cms_mod['value']['7'];
$mip_form['7']['cms_val_default'] = '	<tr>
		<td valign="top"> 
			<small>{startdate}</small>
			<h2>{title}</h2>
			<p>{text}</p>
			<br/>
			<a href="{url_back}">Zur&uuml;ck</a>
		</td>
	</tr>
';
//

$mip_form['70']['cat'] = 'option';
$mip_form['70']['type'] = '';
$mip_form['70']['rows'] = '1';
$mip_form['70']['desc'] = '<strong>Ausgabe</strong>';
$mip_form['70']['cms_var'] = 'MOD_VAR[70]';
$mip_form['70']['cms_val'] = $cms_mod['value']['70'];
$mip_form['70']['cms_val_default'] = 'true';
$mip_form['70']['option_desc'][]= 'Detailansicht innerhalb Hauptausgabe-Template';
$mip_form['70']['option_val'][]= 'true';
$mip_form['70']['option_desc'][]= 'separate Ausgabe';
$mip_form['70']['option_val'][]= 'false';
$mip_form['70']['flag'] = 'reload';


$mip_form['72']['cat'] = 'option';
$mip_form['72']['type'] = '';
$mip_form['72']['rows'] = '1';
$mip_form['72']['desc'] = '<strong>Ausgabemodus</strong>';
$mip_form['72']['cms_var'] = 'MOD_VAR[72]';
$mip_form['72']['cms_val'] = $cms_mod['value']['72'];
$mip_form['72']['cms_val_default'] = 'false';
$mip_form['72']['option_desc'][]= 'Listen- oder Detailansicht';
$mip_form['72']['option_val'][]= 'listordetail';
$mip_form['72']['option_desc'][]= 'Listenansicht';
$mip_form['72']['option_val'][]= 'list';
$mip_form['72']['option_desc'][]= 'Detailansicht';
$mip_form['72']['option_val'][]= 'detail';
$mip_form['72']['flag'] = 'reload';
if ($cms_mod['value'][70]=='false')
	$mip_form['72']['cat'] = 'option';
else
	$mip_form['72']['cat'] = 'hidden';

if ($cms_mod['value'][70]=='true')
	$mip_form['72']['cms_val']= 'listordetail';




// Template Detailansicht
$mip_form['71']['desc'] = 'Seperate Ausgabe auf Seite <small>(idcatside oder 0 eingeben)<br/>(0 = automatisch - gemäß Kategorie-Routing oder aktuelle Seite)</small>';
if ($cms_mod['value'][70]=='false')
	$mip_form['71']['cat'] = 'txt';
else
	$mip_form['71']['cat'] = 'hidden';
$mip_form['71']['cms_var'] = 'MOD_VAR[71]';
$mip_form['71']['cms_val'] = $cms_mod['value']['71'];
$mip_form['71']['cms_val_default'] = '0';
//

$mip_form['73']['cat'] = 'option';
$mip_form['73']['type'] = '';
$mip_form['73']['rows'] = '1';
$mip_form['73']['desc'] = 'Artikel-Archiv ausgeben?';
$mip_form['73']['cms_var'] = 'MOD_VAR[73]';
$mip_form['73']['cms_val'] = $cms_mod['value']['73'];
$mip_form['73']['cms_val_default'] = 'false';
$mip_form['73']['option_desc'][]= 'Ja';
$mip_form['73']['option_val'][]= 'true';
$mip_form['73']['option_desc'][]= 'Nein';
$mip_form['73']['option_val'][]= 'false';


$mip_form['74']['cat'] = 'option';
$mip_form['74']['type'] = '';
$mip_form['74']['rows'] = '1';
$mip_form['74']['desc'] = '<strong>Ausgabe-Funktionlität</strong>';
$mip_form['74']['cms_var'] = 'MOD_VAR[74]';
$mip_form['74']['cms_val'] = $cms_mod['value']['74'];
$mip_form['74']['cms_val_default'] = 'true';
$mip_form['74']['option_desc'][]= 'Allgemein (News)';
$mip_form['74']['option_val'][]= '0';
$mip_form['74']['option_desc'][]= 'Kalender';
$mip_form['74']['option_val'][]= 'calendar';
if ($cms_mod['value']['70']=='true' || empty($cms_mod['value']['70'])){
	$mip_form['74']['option_desc'][]= 'Teaser';
	$mip_form['74']['option_val'][]= 'teaser';
}
$mip_form['74']['flag'] = 'reload';


$mip_form['749901']['cat'] = 'hidden';
$mip_form['749901']['type'] = '';
$mip_form['749901']['desc'] = '<small>Im <strong>Teaser-Modus</strong> wird die Listenansicht deaktiviert.<br/>
Über die Artikel-Auswahl ({article_select} {set_article_select}) und/oder <br/>
über eine Freifeld-Werteingabe (Link) lassen sich Artikel auf bestimmten<br/>
Seiten oder auf allen Seiten eines Ordners/Ordnerstrangs anzeigen.';

$mip_form['74001']['cat'] = 'option';
$mip_form['74001']['type'] = '';
$mip_form['74001']['rows'] = '1';
$mip_form['74001']['desc'] = 'Genutztes Freifeld für die idcat- oder idcatside-Werteingabe';
$mip_form['74001']['cms_var'] = 'MOD_VAR[74001]';
$mip_form['74001']['cms_val'] = $cms_mod['value']['74001'];
$mip_form['74001']['cms_val_default'] = 'true';
$mip_form['74001']['option_desc'][]= 'keins';
$mip_form['74001']['option_val'][]= '0';
for ($i=1;$i<36;$i++) {
$mip_form['74001']['option_desc'][]= 'custom'.$i.'&nbsp;&nbsp;';
$mip_form['74001']['option_val'][]= 'custom'.$i;
}

$mip_form['74101']['cat'] = 'option';
$mip_form['74101']['type'] = '';
$mip_form['74101']['rows'] = '1';
$mip_form['74101']['desc'] = 'Wo soll der Artikel angezeigt werden <small>(Wert des Freifelds)</small>';
$mip_form['74101']['cms_var'] = 'MOD_VAR[74101]';
$mip_form['74101']['cms_val'] = $cms_mod['value']['74101'];
$mip_form['74101']['cms_val_default'] = 'true';
$mip_form['74101']['option_desc'][]= 'Bestimmte Seite (idcatside)';
$mip_form['74101']['option_val'][]= 'idcatside';
$mip_form['74101']['option_desc'][]= 'Seiten eines bestimmten Ordners (idcat)';
$mip_form['74101']['option_val'][]= 'idcat';
$mip_form['74101']['option_desc'][]= 'Seiten eines bestimmten Ordners, rekursiv (idcat)';
$mip_form['74101']['option_val'][]= 'idcat_r';

$mip_form['74102']['cat'] = 'option';
$mip_form['74102']['type'] = '';
$mip_form['74102']['rows'] = '1';
$mip_form['74102']['desc'] = 'Bei Mehrfachzuordnungen Artikel zufällig ausgeben';
$mip_form['74102']['cms_var'] = 'MOD_VAR[74102]';
$mip_form['74102']['cms_val'] = $cms_mod['value']['74102'];
$mip_form['74102']['cms_val_default'] = 'false';
$mip_form['74102']['option_desc'][]= 'Ja';
$mip_form['74102']['option_val'][]= 'true';
$mip_form['74102']['option_desc'][]= 'Nein';
$mip_form['74102']['option_val'][]= 'false';

$mip_form['74103']['cat'] = 'option';
$mip_form['74103']['type'] = '';
$mip_form['74103']['rows'] = '1';
$mip_form['74103']['desc'] = 'Freifeldtyp "Link" wird für die Werteingabe genutzt. <br/><small>Wert liegt in der Form <em>cms://idcatside=ID</em> bzw. <em>cms://idcat=ID</em> vor? </small>';
$mip_form['74103']['cms_var'] = 'MOD_VAR[74103]';
$mip_form['74103']['cms_val'] = $cms_mod['value']['74103'];
$mip_form['74103']['cms_val_default'] = 'true';
$mip_form['74103']['option_desc'][]= 'Ja';
$mip_form['74103']['option_val'][]= 'true';
$mip_form['74103']['option_desc'][]= 'Nein';
$mip_form['74103']['option_val'][]= 'false';


$mip_form['74201']['cat'] = 'option';
$mip_form['74201']['type'] = '';
$mip_form['74201']['rows'] = '1';
$mip_form['74201']['desc'] = 'Genutztes Freifeld für Event-Begin <small><br/>(Freifeld muss vom Typ <em>Datum</em> oder <em>Datum+Zeit</em> sein)</small>';
$mip_form['74201']['cms_var'] = 'MOD_VAR[74201]';
$mip_form['74201']['cms_val'] = $cms_mod['value']['74201'];
$mip_form['74201']['cms_val_default'] = 'true';
$mip_form['74201']['option_desc'][]= 'keins';
$mip_form['74201']['option_val'][]= '';
for ($i=1;$i<36;$i++) {
$mip_form['74201']['option_desc'][]= 'custom'.$i.'&nbsp;&nbsp;';
$mip_form['74201']['option_val'][]= 'custom'.$i;
}

$mip_form['74202']['cat'] = 'option';
$mip_form['74202']['type'] = '';
$mip_form['74202']['rows'] = '1';
$mip_form['74202']['desc'] = 'Genutztes Freifeld für Event-Ende  <small><br/>(Freifeld muss vom Typ <em>Datum</em> oder <em>Datum+Zeit</em> sein)<br/><br/>Hinweis: Beide Freifelder müssen vom gleichen Typ sein!</small>';
$mip_form['74202']['cms_var'] = 'MOD_VAR[74202]';
$mip_form['74202']['cms_val'] = $cms_mod['value']['74202'];
$mip_form['74202']['cms_val_default'] = 'true';
$mip_form['74202']['option_desc'][]= 'keins';
$mip_form['74202']['option_val'][]= '';
for ($i=1;$i<36;$i++) {
$mip_form['74202']['option_desc'][]= 'custom'.$i.'&nbsp;&nbsp;';
$mip_form['74202']['option_val'][]= 'custom'.$i;
}

$mip_form['74204']['cat'] = 'option';
$mip_form['74204']['type'] = '';
$mip_form['74204']['rows'] = '1';
$mip_form['74204']['desc'] = 'Nur das Start-Datum eines Events wird als Termin berücksichtigt';
$mip_form['74204']['cms_var'] = 'MOD_VAR[74204]';
$mip_form['74204']['cms_val'] = $cms_mod['value']['74204'];
$mip_form['74204']['cms_val_default'] = 'true';
$mip_form['74204']['option_desc'][]= 'Ja';
$mip_form['74204']['option_val'][]= 'true';
$mip_form['74204']['option_desc'][]= 'Nein (performancelastiger)';
$mip_form['74204']['option_val'][]= 'false';

$mip_form['74205']['cat'] = 'option';
$mip_form['74205']['type'] = '';
$mip_form['74205']['rows'] = '1';
$mip_form['74205']['desc'] = 'Monatsschaltung (Monat vor/zurück) beeinflusst Artikelliste?';
$mip_form['74205']['cms_var'] = 'MOD_VAR[74205]';
$mip_form['74205']['cms_val'] = $cms_mod['value']['74205'];
$mip_form['74205']['cms_val_default'] = 'false';
$mip_form['74205']['option_desc'][]= 'Nein';
$mip_form['74205']['option_val'][]= 'false';
$mip_form['74205']['option_desc'][]= 'Ja';
$mip_form['74205']['option_val'][]= 'true';

//
$mip_form['74206']['cat'] = 'txt';
$mip_form['74206']['type'] = '';
$mip_form['74206']['desc'] = 'Startmonat';
$mip_form['74206']['cms_var'] = 'MOD_VAR[74206]';
$mip_form['74206']['cms_val'] = $cms_mod['value']['74206'];
$mip_form['74206']['cms_val_default'] = '';
//
$mip_form['74207']['cat'] = 'txt';
$mip_form['74207']['type'] = '';
$mip_form['74207']['desc'] = 'Startjahr';
$mip_form['74207']['cms_var'] = 'MOD_VAR[74207]';
$mip_form['74207']['cms_val'] = $cms_mod['value']['74207'];
$mip_form['74207']['cms_val_default'] = '';

//
$mip_form['74208']['cat'] = 'txt';
$mip_form['74208']['type'] = '';
$mip_form['74208']['desc'] = 'Zielseite für alle Links des Kalenders <small>(idcatside, 0 = aktuelle Seite)</small>';
$mip_form['74208']['cms_var'] = 'MOD_VAR[74208]';
$mip_form['74208']['cms_val'] = $cms_mod['value']['74208'];
$mip_form['74208']['cms_val_default'] = '';

#echo $cms_mod['value'][72].'---'.$cms_mod['value'][70];

if (($cms_mod['value'][72]=='listordetail' || empty($cms_mod['value'][72]) || $cms_mod['value'][72]=='false') && ($cms_mod['value'][70]=='true' ||  empty($cms_mod['value'][70]))) {
	$mip_form['74']['cat'] = 'option';
	$mip_form['749901']['cat'] = 'desc';
	$mip_form['74001']['cat'] = 'option';
	$mip_form['74101']['cat'] = 'option';
	$mip_form['74102']['cat'] = 'option';
	$mip_form['74103']['cat'] = 'option';
	
	if ($cms_mod['value'][74]=='teaser') {
		$mip_form['749901']['cat'] = 'desc';
		$mip_form['74001']['cat'] = 'option';
		$mip_form['74101']['cat'] = 'option';
		$mip_form['74102']['cat'] = 'option';
		$mip_form['74103']['cat'] = 'option';
	} else {
		$mip_form['74001']['cat'] = 'hidden';
		$mip_form['74101']['cat'] = 'hidden';
		$mip_form['74102']['cat'] = 'hidden';
		$mip_form['74103']['cat'] = 'hidden';
		$mip_form['749901']['cat'] = 'hidden';
	}		
	
} else {

	$mip_form['74001']['cat'] = 'hidden';
	$mip_form['74101']['cat'] = 'hidden';
	$mip_form['74102']['cat'] = 'hidden';
	$mip_form['74103']['cat'] = 'hidden';
	$mip_form['749901']['cat'] = 'hidden';
}	




// legend template single entry
$mip_form['90007']['cat'] = 'desc';
$mip_form['90007']['type'] = '';
$mip_form['90007']['desc'] = '<div id="legend_MOD_VAR3" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{title} {teaser} {text} {category} {categoryid} {images} {files} {links} {dates}<br/>
{image:x} {imageurl:x} {imagelinkurl:x} {imagetitle:x} {imagedesc:x} {imagethumb:x} {imagethumburl:x}<br/>
{file:x} {fileurl:x} {filetitle:x} {filedesc:x} {filename:x} {fileext:x} {filesize:x}<br/>
{link:x} {linkurl:x} {linktitle:x} {linkdesc:x}<br/>
{date:x} {datetitle:x} {datedesc:x} {dateduration:x} {datetime24:x} {datetime12:x} {date:x:day} {date:x:month} {date:x:day2} {date:x:month2} {date:x:year}<br/>
{custom:<em>1-35</em>} <span style="color:#555;">{custom_data:<em>1-35</em>}</span> {custom_label:<em>1-35</em>} {custom:<em>1-35</em>:date} {custom:<em>1-35</em>:time}<br/>{custom:<em>1-35</em>:day} {custom:<em>1-35</em>:month} {custom:<em>1-35</em>:year} {custom:<em>1-35</em>:timestamp}<br/>
{custom_<em>"image"-Elemente</em>:<em>1-35</em>} {custom_<em>"file"-Elemente</em>:<em>1-35</em>} {custom_<em>"link"-Elemente</em>:<em>1-35</em>}<br/>
Spezielle "Custom-Link"-Elemente: {custom_linkidcat:<em>1-35</em>} {custom_linkidcat:<em>1-35</em>:idcatside_si<em>1-3</em>} {custom_linkidcat:<em>1-35</em>:idcatside_name_si<em>1-3</em>} {custom_linkidcatside:<em>1-35</em>}<br/>
{custom_linkidcat:<em>1-35</em>:idcat_si<em>1-3</em>} {custom_linkidcat:<em>1-35</em>:idcat_name_si<em>1-3</em>}<br/>
Alternativ für alle frei definierbaren Felder: {<em>Alias</em>} <span style="color:#555;">{<em>Alias</em>_data}</span> {<em>Alias</em>_label} {<em>Alias</em>:date} {<em>Alias</em>:time}<br/>{<em>Alias</em>:day} {<em>Alias</em>:month} {<em>Alias</em>:year} {<em>Alias</em>:timestamp}<br/>
{<em>Alias</em>_<em>"image"-Elemente</em>:<em>1-35</em>} {<em>Alias</em>_<em>"file"-Elemente</em>:<em>1-35</em>} {<em>Alias</em>_<em>"link"-Elemente</em>:<em>1-35</em>} <br/>
{<em>Alias</em>_linkidcat} {<em>Alias</em>_linkidcat:idcatside_si<em>1-3</em>} {<em>Alias</em>_linkidcat:idcatside_name_si<em>1-3</em>} {<em>Alias</em>_linkidcatside}<br/>
{<em>Alias</em>_linkidcat:idcat_si<em>1-3</em>} {<em>Alias</em>_linkidcat:idcat_name_si<em>1-3</em>}<br/>
{startdate} {startdate:day} {startdate:month} {startdate:day2} {startdate:month2} {startdate:year}<br/>
{enddate} {enddate:day} {enddate:month} {enddate:day2} {enddate:month2} {enddate:year}<br/>
{starttime24} {starttime12} {endtime24} {endtime12}<br/>
{idarticle} {today_timestmap} {idlang} {container_id} {mod_key} {comments_count}<br/>
<strong>Interaktion</strong><br/>{url_back} <em>(Listenansicht)</em> {comments}<br/>
<strong>Inhaltslogik/-manipulation</strong><br/>
{if_backend} {/if_backend} {if_backend_edit} {/if_backend_edit} {if_backend_preview} {/if_backend_preview}<br/>{if_frontend} {/if_frontend}<br/>
<strong>{if_</strong><em>Element:x</em><strong>} {/if_</strong><em>Element:x</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>} {/if_not_</strong><em>Element:x</em><strong>}</strong><br/>
<strong>{if_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>} {/if_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>} {/if_not_</strong><em>Element:x</em><strong>=</strong><em>Value</em><strong>}</strong><br/>
<strong>{if_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>} {/if_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>} {/if_not_</strong><em>Element:x</em><strong>&gt;</strong><em>Value</em><strong>}</strong><br/>
<strong>{if_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>} {/if_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>}</strong> <strong>{if_not_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>} {/if_not_</strong><em>Element:x</em><strong>&lt;</strong><em>Value</em><strong>}</strong><br/>
Alternativ kann auch der Wert eines anderen Elements für Vergleiche genutzt werden!<br/>Anstelle <em>Value</em> wird das Element in eckigen Klammern notiert -> [<em>Element:y</em>].
{chop} ... {/chop}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR3\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';



// search fields

$mip_form['15']['cat'] = 'option';
$mip_form['15']['flag'] = 'multiple';
$mip_form['15']['size'] = '7';
$mip_form['15']['desc'] = '<strong>Suche</strong><br/>Datenfelder die durchsucht werden<small><br/>bei Verwendung von {search_ ... }</small>';
$mip_form['15']['cms_var'] = 'MOD_VAR[15]';
$mip_form['15']['cms_val'] = $cms_mod['value']['15'];
$mip_form['15']['cms_val_default'] = '';
$mip_form['15']['option_desc'][] = 'Standard (Titel, Aufmacher, Text)';
$mip_form['15']['option_val'][] = '';
$mip_form['15']['option_desc'][] = 'Titel';
$mip_form['15']['option_val'][] = 'title';
$mip_form['15']['option_desc'][] = 'Aufmacher';
$mip_form['15']['option_val'][] = 'teaser';
$mip_form['15']['option_desc'][] = 'Text';
$mip_form['15']['option_val'][] = 'text';
#$mip_form['15']['option_desc'][] = 'Bildunterschrift';
#$mip_form['15']['option_val'][] = 'picture1_caption';
#$mip_form['15']['option_desc'][] = 'Dateititel';
#$mip_form['15']['option_val'][] = 'file1_title';
#$mip_form['15']['option_desc'][] = 'Interner Link - Titel';
#$mip_form['15']['option_val'][] = 'link1_title';
#$mip_form['15']['option_desc'][] = 'Externer Link - Titel';
#$mip_form['15']['option_val'][] = 'link2_title';
for ($i=1;$i<36;$i++){
	$mip_form['15']['option_desc'][] = 'Freifeld '.$i;
	$mip_form['15']['option_val'][] = 'custom'.$i;
}

$mip_form['10015']['cat'] = 'txt';
$mip_form['10015']['type'] = 'long';
$mip_form['10015']['rows'] = '7';
$mip_form['10015']['desc'] = '<strong>Zusätzliche MySQL WHERE Clause für Artikelausgabe (Liste)</strong><small><br/><br/><strong>Beispiel: <em>title=\'%Neu%\'</em></strong>&nbsp;&nbsp;&nbsp;
Mögliche Datenfelder: startdate starttime enddate endtime created lastedit title teaser text custom1-35</small>';
$mip_form['10015']['cms_var'] = 'MOD_VAR[10015]';
$mip_form['10015']['cms_val'] = $cms_mod['value']['10015'];
$mip_form['10015']['cms_val_default'] = '';



// max number of search results
$mip_form['16']['cat'] = 'txt';
$mip_form['16']['type'] = '';
$mip_form['16']['rows'] = '1';
$mip_form['16']['desc'] = 'Maximale Anzahl an Suchergebnissen<small><br/>bei Verwendung von {search_ ... }</small>';
$mip_form['16']['cms_var'] = 'MOD_VAR[16]';
$mip_form['16']['cms_val'] = $cms_mod['value']['16'];
$mip_form['16']['cms_val_default'] = '50';

// legend template single entry
$mip_form['90013']['cat'] = 'desc';
$mip_form['90013']['type'] = '';
$mip_form['90013']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Element</strong> {url}</small></div>';


$mip_form['91003']['cat'] = 'desc';
$mip_form['91003']['type'] = '';
$mip_form['91003']['desc'] = '<strong>{chop} {/chop}</strong>';

$mip_form['910030']['cat'] = 'desc';
$mip_form['910030']['type'] = '';
$mip_form['910030']['desc'] = '<strong>Kalender <small>{calendar}</small></strong>';

//
$mip_form['1003']['cat'] = 'txt';
$mip_form['1003']['type'] = '';
$mip_form['1003']['desc'] = 'max. Zeichen';
$mip_form['1003']['cms_var'] = 'MOD_VAR[1003]';
$mip_form['1003']['cms_val'] = $cms_mod['value']['1003'];
$mip_form['1003']['cms_val_default'] = '200';

//
$mip_form['1004']['cat'] = 'chk';
$mip_form['1004']['type'] = '';
$mip_form['1004']['desc'] = 'in der Mitte kürzen';
$mip_form['1004']['option_var']['0'] = 'MOD_VAR[1004]';
$mip_form['1004']['option_val']['0'] = $cms_mod['value']['1004'];
$mip_form['1004']['option_desc']['0'] = 'ja';
$mip_form['1004']['option_val_select']['0'] = 'true';

// 
$mip_form['1005']['cat'] = 'txt';
$mip_form['1005']['type'] = '';
$mip_form['1005']['desc'] = 'Anhängsel';
$mip_form['1005']['cms_var'] = 'MOD_VAR[1005]';
$mip_form['1005']['cms_val'] = $cms_mod['value']['1005'];
$mip_form['1005']['cms_val_default'] = ' ... ';


$mip_form['90500']['cat'] = 'desc';
$mip_form['90500']['type'] = '';
$mip_form['90500']['desc'] = '<strong>{filesize} {filesize:x} {custom_filesize:x}</strong>';

$mip_form['500']['cat'] = 'txt';
$mip_form['500']['type'] = '';
$mip_form['500']['desc'] = 'Kürzel für Byte';
$mip_form['500']['cms_var'] = 'MOD_VAR[500]';
$mip_form['500']['cms_val'] = $cms_mod['value']['500'];
$mip_form['500']['cms_val_default'] = 'Byte';

$mip_form['501']['cat'] = 'txt';
$mip_form['501']['type'] = '';
$mip_form['501']['desc'] = 'Kürzel für Kilobyte';
$mip_form['501']['cms_var'] = 'MOD_VAR[501]';
$mip_form['501']['cms_val'] = $cms_mod['value']['501'];
$mip_form['501']['cms_val_default'] = 'KByte';

$mip_form['502']['cat'] = 'txt';
$mip_form['502']['type'] = '';
$mip_form['502']['desc'] = 'Kürzel für Megabyte';
$mip_form['502']['cms_var'] = 'MOD_VAR[502]';
$mip_form['502']['cms_val'] = $cms_mod['value']['502'];
$mip_form['502']['cms_val_default'] = 'MByte';

$mip_form['510']['cat'] = 'option';
$mip_form['510']['type'] = '';
$mip_form['510']['desc'] = 'Nachkommastellen';
$mip_form['510']['cms_var'] = 'MOD_VAR[510]';
$mip_form['510']['cms_val'] = $cms_mod['value']['510'];
$mip_form['510']['cms_val_default'] = '2';
$mip_form['510']['option_desc']['0'] = '0';
$mip_form['510']['option_val']['0'] = '0';
$mip_form['510']['option_desc']['1'] = '1';
$mip_form['510']['option_val']['1'] = '1';
$mip_form['510']['option_desc']['2'] = '2';
$mip_form['510']['option_val']['2'] = '2';
$mip_form['510']['tab'] = '0';



$mip_form['2900']['cat'] = 'desc';
$mip_form['2900']['type'] = '';
$mip_form['2900']['desc'] = '<strong>{customfilter_form:1-35}</strong>';


$mip_form['2000']['cat'] = 'option';
$mip_form['2000']['desc'] = 'Auswahlmöglichkeiten';
$mip_form['2000']['cms_var'] = 'MOD_VAR[2000]';
$mip_form['2000']['cms_val'] = $cms_mod['value']['2000'];
$mip_form['2000']['cms_val_default'] = '0';
$mip_form['2000']['option_desc']['0'] = 'unabhängig von der Auswahl anderer Filter';
$mip_form['2000']['option_val']['0'] = '0';
$mip_form['2000']['option_desc']['1'] = 'abhängig von der Auswahl anderer Filter';
$mip_form['2000']['option_val']['1'] = '1';


$mip_form['2010']['cat'] = 'option';
$mip_form['2010']['desc'] = 'Auswahlinteraktion';
$mip_form['2010']['cms_var'] = 'MOD_VAR[2010]';
$mip_form['2010']['cms_val'] = $cms_mod['value']['2010'];
$mip_form['2010']['cms_val_default'] = '0';
$mip_form['2010']['option_desc']['0'] = 'Filter verbunden';
$mip_form['2010']['option_val']['0'] = '0';
$mip_form['2010']['option_desc']['1'] = 'Filter separat';
$mip_form['2010']['option_val']['1'] = '1';


// Ausgabenreihenfolge
$mip_form['28']['cat'] = 'option';
$mip_form['28']['desc'] = 'Reihenfolge der Ausgabe';
$mip_form['28']['cms_var'] = 'MOD_VAR[28]';
$mip_form['28']['cms_val'] = $cms_mod['value']['28'];
$mip_form['28']['cms_val_default'] = 'SORT_DESC';
$mip_form['28']['option_desc']['0'] = 'vorw&#228;rts';
$mip_form['28']['option_val']['0'] = 'SORT_ASC';
$mip_form['28']['option_desc']['1'] = 'r&#252;ckw&#228;rts';
$mip_form['28']['option_val']['1'] = 'SORT_DESC';



// Navigation

$mip_form['90039']['cat'] = 'desc';
$mip_form['90039']['type'] = '';
$mip_form['90039']['desc'] = '<strong>Navigation <small>{page_nav}</small></strong>';

$mip_form['90040']['cat'] = 'desc';
$mip_form['90040']['type'] = '';
$mip_form['90040']['desc'] = '<strong>Datum- / Zeit-Formatierung</strong>';


// Navigation template vorwaerts aktiv
$mip_form['39']['cat'] = 'txt';
$mip_form['39']['desc'] = 'Trennzeichen zwischen den Links';
$mip_form['39']['cms_var'] = 'MOD_VAR[39]';
$mip_form['39']['cms_val'] = $cms_mod['value']['39'];
$mip_form['39']['cms_val_default'] = ' | ';

// Navigation Anzahl Navipunkte
$mip_form['40']['cat'] = 'txt';
$mip_form['40']['desc'] = 'Anzahl der Seiten-Links vor und nach der aktuellen Seite<br/><small><strong>Achtung: Gilt auch für {page_nav_adv}</strong></small>';
$mip_form['40']['cms_var'] = 'MOD_VAR[40]';
$mip_form['40']['cms_val'] = $cms_mod['value']['40'];
$mip_form['40']['cms_val_default'] = '3';

// Navigation text_prev
$mip_form['41']['cat'] = 'txt';
$mip_form['41']['desc'] = 'Symbol oder Text für vorherige Seite';
$mip_form['41']['cms_var'] = 'MOD_VAR[41]';
$mip_form['41']['cms_val'] = $cms_mod['value']['41'];
$mip_form['41']['cms_val_default'] = '&lsaquo;';

// Navigation text_next
$mip_form['42']['cat'] = 'txt';
$mip_form['42']['desc'] = 'Symbol oder Text für naechste Seite';
$mip_form['42']['cms_var'] = 'MOD_VAR[42]';
$mip_form['42']['cms_val'] = $cms_mod['value']['42'];
$mip_form['42']['cms_val_default'] = '&rsaquo;';

// Navigation text_first
$mip_form['43']['cat'] = 'txt';
$mip_form['43']['desc'] = 'Symbol oder Text für erste Seite';
$mip_form['43']['cms_var'] = 'MOD_VAR[43]';
$mip_form['43']['cms_val'] = $cms_mod['value']['43'];
$mip_form['43']['cms_val_default'] = '&laquo;';

// Navigation text_last
$mip_form['44']['cat'] = 'txt';
$mip_form['44']['desc'] = 'Symbol oder Text für letzte Seite';
$mip_form['44']['cms_var'] = 'MOD_VAR[44]';
$mip_form['44']['cms_val'] = $cms_mod['value']['44'];
$mip_form['44']['cms_val_default'] = '&raquo;';

// Navigation text_last
$mip_form['4010']['cat'] = 'txt';
$mip_form['4010']['desc'] = 'Optionale Attribute Links';
$mip_form['4010']['cms_var'] = 'MOD_VAR[4010]';
$mip_form['4010']['cms_val'] = $cms_mod['value']['4010'];
$mip_form['4010']['cms_val_default'] = '';

// Navigation text_last
$mip_form['4011']['cat'] = 'txt';
$mip_form['4011']['desc'] = 'Optionale Attribute aktiver Link';
$mip_form['4011']['cms_var'] = 'MOD_VAR[4011]';
$mip_form['4011']['cms_val'] = $cms_mod['value']['4011'];
$mip_form['4011']['cms_val_default'] = 'style="font-weight:bold;"';


// Anzahl der Eintraege
$mip_form['48']['cat'] = 'txt';
$mip_form['48']['desc'] = '<strong>Seitenschaltung</strong> - Anzahl Einträge pro Seite <small>(0 = alle)</small>';
$mip_form['48']['cms_var'] = 'MOD_VAR[48]';
$mip_form['48']['cms_val'] = $cms_mod['value']['48'];
$mip_form['48']['cms_val_default'] = '10';


$mip_form['300']['cat'] = 'txtarea';
$mip_form['300']['type'] = '';
$mip_form['300']['rows'] = '6';
$mip_form['300']['desc'] = '<strong>Kategorie-Routing</strong><br/><small>Bestimmt anhand der Ordner- o. Seiten-ID die darzustellende Artikelkategorie.<br />Beispiele:<br />
<strong>idcat:13 > 1 </strong><i><br/>(Ist idcat 13 aktiv, wird die Artikelkategorie mit der id 1 angezeigt)</i><br />
<strong>idcatside:34 > 2 </strong><i><br/>(Ist idcatside 34 aktiv, wird die Artikelkategorie mit der id 2 angezeigt)</i><br/>
<strong>idcatside:27 > 1,2 </strong><i><br/>(Ist idcatside 27 aktiv, werden die Artikelkategorien mit der id 1 und 2 angezeigt)</i></small>';
$mip_form['300']['cms_var'] = 'MOD_VAR[300]';
$mip_form['300']['cms_val'] = $cms_mod['value']['300'];

$mip_form['301']['cat'] = 'desc';
$mip_form['301']['type'] = '';
$mip_form['301']['desc'] = '<div id="legend_MOD_VAR30" style="display:none;text-align:right;"><small><table align="right" cellspacing="5" cellpadding="0" border="0">'.$_AS['temp']['catinfo'].'</table></small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR30\').innerHTML"><small style="cursor: pointer;">Verfügbare Kategorien anzeigen</small></div>';

if (count($mip_form['8']['option_desc'])<2) {
	$mip_form['300']['cat'] = 'hidden';
	$mip_form['301']['cat'] = 'hidden';
}

$mip_form['400']['cat'] = 'txtarea';
$mip_form['400']['type'] = '';
$mip_form['400']['rows'] = '7';
$mip_form['400']['desc'] = '<strong>Sortierung der Liste</strong><small><br/><br/><strong><em>DATENFELD</strong> (s.u.) > <strong>SORTIERUNG</strong> (ASC = aufsteigend, DESC = Absteigend)</em>oder<br/><em>RAND()</em><br/>
<br/>startdate starttime <br/>
enddate endtime<br/>
created lastedit<br/>
title teaser text<br/>
custom1-35</small>';
$mip_form['400']['cms_var'] = 'MOD_VAR[400]';
$mip_form['400']['cms_val'] = $cms_mod['value']['400'];
$mip_form['400']['cms_val_default'] = 'startdate > DESC
starttime > DESC 
enddate > DESC
endtime >DESC
created > DESC
title > ASC';


$mip_form['700']['desc'] = '<strong>Bilder <small>{images}</small></strong>';
$mip_form['700']['cat'] = 'txtarea';
$mip_form['700']['rows'] = '4';
$mip_form['700']['type'] = 'long';
$mip_form['700']['cms_var'] = 'MOD_VAR[700]';
$mip_form['700']['cms_val'] = $cms_mod['value']['700'];
$mip_form['700']['cms_val_default'] = '<img src="{imageurl}" alt="{imagetitle}"/>
{if_imagedesc}<br/><small>{imagedesc}</small>{/if_imagedesc}
<br/>';

$mip_form['720']['desc'] = '<strong>Dateien <small>{files}</small></strong>';
$mip_form['720']['cat'] = 'txtarea';
$mip_form['720']['rows'] = '4';
$mip_form['720']['type'] = 'long';
$mip_form['720']['cms_var'] = 'MOD_VAR[720]';
$mip_form['720']['cms_val'] = $cms_mod['value']['720'];
$mip_form['720']['cms_val_default'] = '<a href="{fileurl}" title="{filetitle}">
	{filetitle}{if_not_filetitle}{fileurl}{/if_not_filetitle}
</a>
{if_filedesc}<br/><small>{filedesc}</small>{/if_filedesc}
<br/>';

$mip_form['740']['desc'] = '<strong>Links <small>{links}</small></strong>';
$mip_form['740']['cat'] = 'txtarea';
$mip_form['740']['rows'] = '4';
$mip_form['740']['type'] = 'long';
$mip_form['740']['cms_var'] = 'MOD_VAR[740]';
$mip_form['740']['cms_val'] = $cms_mod['value']['740'];
$mip_form['740']['cms_val_default'] = '<a href="{linkurl}" title="{linktitle}">
	{linktitle}{if_not_linktitle}{linkurl}{/if_not_linktitle}
</a>
{if_linkdesc}<br/><small>{linkdesc}</small>{/if_linkdesc}
<br/>';

$mip_form['750']['desc'] = '<strong>Termine <small>{dates}</small></strong>';
$mip_form['750']['cat'] = 'txtarea';
$mip_form['750']['rows'] = '4';
$mip_form['750']['type'] = 'long';
$mip_form['750']['cms_var'] = 'MOD_VAR[750]';
$mip_form['750']['cms_val'] = $cms_mod['value']['750'];
$mip_form['750']['cms_val_default'] = '{date} - {datetime24} - {datetitle}
<br/>';

$mip_form['760']['desc'] = '<strong>Kategorie-Links <small>{category_links}</small></strong>';
$mip_form['760']['cat'] = 'txtarea';
$mip_form['760']['rows'] = '3';
$mip_form['760']['type'] = 'long';
$mip_form['760']['cms_var'] = 'MOD_VAR[760]';
$mip_form['760']['cms_val'] = $cms_mod['value']['760'];
$mip_form['760']['cms_val_default'] = '<a href="{url}" title="{name}">{name}</a>
<br/>';

$mip_form['770']['desc'] = 'Kategorie-Links "Einstellungen speichern" <small>{category_links}</small></strong>';
$mip_form['770']['cat'] = 'txtarea';
$mip_form['770']['rows'] = '3';
$mip_form['770']['type'] = 'long';
$mip_form['770']['cms_var'] = 'MOD_VAR[770]';
$mip_form['770']['cms_val'] = $cms_mod['value']['770'];
$mip_form['770']['cms_val_default'] = '{save}<br/>{reset}';

// legend template single entry
$mip_form['90770']['cat'] = 'desc';
$mip_form['90770']['type'] = '';
$mip_form['90770']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {save} {reset}</small></div>';


// Navigation text_last
$mip_form['771']['cat'] = 'txt';
$mip_form['771']['desc'] = 'Beschriftung Speichern-Button <small>{save}</small>';
$mip_form['771']['cms_var'] = 'MOD_VAR[771]';
$mip_form['771']['cms_val'] = $cms_mod['value']['771'];
$mip_form['771']['cms_val_default'] = 'Speichern';

// Navigation text_last
$mip_form['772']['cat'] = 'txt';
$mip_form['772']['desc'] = 'Beschriftung Einstellungen-zurücksetzen-Button <small>{reset}</small>';
$mip_form['772']['cms_var'] = 'MOD_VAR[772]';
$mip_form['772']['cms_val'] = $cms_mod['value']['772'];
$mip_form['772']['cms_val_default'] = 'Zurücksetzen';


$mip_form['773']['cat'] = 'option';
$mip_form['773']['type'] = '';
$mip_form['773']['rows'] = '1';
$mip_form['773']['desc'] = 'Ausgabe erst aktivieren, wenn Einstellungen gespeichert wurden?';
$mip_form['773']['cms_var'] = 'MOD_VAR[773]';
$mip_form['773']['cms_val'] = $cms_mod['value']['773'];
$mip_form['773']['cms_val_default'] = 'false';
$mip_form['773']['option_desc'][]= 'Ja';
$mip_form['773']['option_val'][]= 'true';
$mip_form['773']['option_desc'][]= 'Nein';
$mip_form['773']['option_val'][]= 'false';

$mip_form['780']['cat'] = 'txt';
$mip_form['780']['type'] = '';
$mip_form['780']['rows'] = '1';
$mip_form['780']['desc'] = '<strong>Sortierungs-Links <small>AUFSTEIGEND {<em>Element</em>_sortlink<em>(:1-35)</em>}</small></strong><br/>
<small>Optionale Attribute</small>';
$mip_form['780']['cms_var'] = 'MOD_VAR[780]';
$mip_form['780']['cms_val'] = $cms_mod['value']['780'];
$mip_form['780']['cms_val_default'] = 'class="as_sortlink_asc" title="Sortierung aufsteigend"';

$mip_form['781']['cat'] = 'txt';
$mip_form['781']['type'] = '';
$mip_form['781']['rows'] = '1';
$mip_form['781']['desc'] = '<strong>Sortierungs-Links <small>ABSTEIGEND {<em>Element</em>_sortlink<em>(:1-35)</em>}</small></strong><br/>
<small>Optionale Attribute</small>';
$mip_form['781']['cms_var'] = 'MOD_VAR[781]';
$mip_form['781']['cms_val'] = $cms_mod['value']['781'];
$mip_form['781']['cms_val_default'] = 'class="as_sortlink_desc" title="Sortierung absteigend"';


// legend template image
$mip_form['90008']['cat'] = 'desc';
$mip_form['90008']['type'] = '';
$mip_form['90008']['desc'] = '<div id="legend_MOD_VAR20" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{image} {imageurl} {imagetitle} {imagedesc} {imagethumb} {imagethumburl}<br/>
<strong>Inhaltslogik/-manipulation</strong><br/>{if_<em>Element</em>} ... {/if_<em>Element</em>} {if_not_<em>Element</em>} ... {/if_not_<em>Element</em>}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR20\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// legend template files
$mip_form['90009']['cat'] = 'desc';
$mip_form['90009']['type'] = '';
$mip_form['90009']['desc'] = '<div id="legend_MOD_VAR21" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{file} {fileurl} {filetitle} {filedesc} {filename} {fileext} {filesize}<br/>
<strong>Inhaltslogik/-manipulation</strong><br/>{if_<em>Element</em>} ... {/if_<em>Element</em>} {if_not_<em>Element</em>} ... {/if_not_<em>Element</em>}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR21\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// legend template link
$mip_form['90010']['cat'] = 'desc';
$mip_form['90010']['type'] = '';
$mip_form['90010']['desc'] = '<div id="legend_MOD_VAR22" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{link} {linkurl} {linktitle} {linkdesc}<br/>
<strong>Inhaltslogik/-manipulation</strong><br/>{if_<em>Element</em>} ... {/if_<em>Element</em>} {if_not_<em>Element</em>} ... {/if_not_<em>Element</em>}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR22\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// legend template link
$mip_form['90011']['cat'] = 'desc';
$mip_form['90011']['type'] = '';
$mip_form['90011']['desc'] = '<div id="legend_MOD_VAR23" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{url} {url_addon} {name}<br/>
<strong>Inhaltslogik/-manipulation</strong><br/>{if_<em>Element</em>} ... {/if_<em>Element</em>} {if_not_<em>Element</em>} ... {/if_not_<em>Element</em>}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR23\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// legend template link
$mip_form['90014']['cat'] = 'desc';
$mip_form['90014']['type'] = '';
$mip_form['90014']['desc'] = '<div id="legend_MOD_VAR24" style="display:none;text-align:right;"><small>
Die Konfigurationsmöglichkeiten aller Datumsangaben entspricht denen der <a href="http://de.php.net/manual/de/function.date.php" target="_blank" style="color:black">PHP-Funktion date()</a>. </small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR24\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// legend template link
$mip_form['90015']['cat'] = 'desc';
$mip_form['90015']['type'] = '';
$mip_form['90015']['desc'] = '<div id="legend_MOD_VAR25" style="display:none;text-align:right;"><small>
Die Konfigurationsmöglichkeiten der Zeitangaben entspricht denen der <a href="http://de.php.net/manual/de/function.strftime.php" target="_blank" style="color:black">PHP-Funktion strftime()</a>. </small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR25\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';

// legend template date
$mip_form['90016']['cat'] = 'desc';
$mip_form['90016']['type'] = '';
$mip_form['90016']['desc'] = '<div id="legend_MOD_VAR26" style="display:none;text-align:right;"><small><strong>Inhaltselemente</strong><br/>
{datetitle} {datedesc} {dateduration}<br/>
{date} {date:day} {date:month} {date:day2} {date:month2} {date:year}<br/>
{datetime24} {datetime12}<br/><br/>
<strong>Inhaltslogik/-manipulation</strong><br/>{if_<em>Element</em>} ... {/if_<em>Element</em>} {if_not_<em>Element</em>} ... {/if_not_<em>Element</em>}</small></div>
<div style="text-align:right;line-height:130%" onclick="this.innerHTML=document.getElementById(\'legend_MOD_VAR26\').innerHTML"><small style="cursor: pointer;">Hilfe anzeigen<br /></small></div>';


// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['18']['desc'] = '<strong>Suche <small>{search_form}</small></strong>';
$mip_form['18']['cat'] = 'txtarea';
$mip_form['18']['rows'] = '4';
$mip_form['18']['type'] = 'long';
$mip_form['18']['cms_var'] = 'MOD_VAR[18]';
$mip_form['18']['cms_val'] = $cms_mod['value']['18'];
$mip_form['18']['cms_val_default'] = '{search_label}{search_input}{search_submit}';

// legend template single entry
$mip_form['90018']['cat'] = 'desc';
$mip_form['90018']['type'] = '';
$mip_form['90018']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Inhaltselemente</strong><br/> {search_input} {search_label} {search_submit}</small></div>';



$mip_form['100']['cat'] = 'txt';
$mip_form['100']['type'] = '';
$mip_form['100']['desc'] = 'Beschriftung<small> {search_submit}</small>';
$mip_form['100']['cms_var'] = 'MOD_VAR[100]';
$mip_form['100']['cms_val'] = $cms_mod['value']['100'];
$mip_form['100']['cms_val_default'] = 'suchen';
// 
$mip_form['101']['cat'] = 'txt';
$mip_form['101']['type'] = '';
$mip_form['101']['desc'] = 'Beschriftung<small> {search_label}</small>';
$mip_form['101']['cms_var'] = 'MOD_VAR[101]';
$mip_form['101']['cms_val'] = $cms_mod['value']['101'];
$mip_form['101']['cms_val_default'] = 'Suchbegriff eingeben';
// 
$mip_form['103']['cat'] = 'txt';
$mip_form['103']['type'] = '';
$mip_form['103']['desc'] = 'Optionale Attribute<small> {search_input}</small>';
$mip_form['103']['cms_var'] = 'MOD_VAR[103]';
$mip_form['103']['cms_val'] = $cms_mod['value']['103'];
$mip_form['103']['cms_val_default'] = '';
// 
$mip_form['104']['cat'] = 'txt';
$mip_form['104']['type'] = '';
$mip_form['104']['desc'] = 'Optionale Attribute<small> {search_label}</small>';
$mip_form['104']['cms_var'] = 'MOD_VAR[104]';
$mip_form['104']['cms_val'] = $cms_mod['value']['104'];
$mip_form['104']['cms_val_default'] = '';
// 
$mip_form['107']['cat'] = 'txt';
$mip_form['107']['type'] = '';
$mip_form['107']['desc'] = 'Optionale Attribute<small> {search_submit}</small>';
$mip_form['107']['cms_var'] = 'MOD_VAR[107]';
$mip_form['107']['cms_val'] = $cms_mod['value']['107'];
$mip_form['107']['cms_val_default'] = '';

$mip_form['108']['cat'] = 'txt';
$mip_form['108']['type'] = '';
$mip_form['108']['desc'] = 'Zielseite <small>(idcatside, 0 = aktuelle Seite)</small>';
$mip_form['108']['cms_var'] = 'MOD_VAR[108]';
$mip_form['108']['cms_val'] = $cms_mod['value']['108'];
$mip_form['108']['cms_val_default'] = '0';





// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['19']['desc'] = '<strong>Kategorieauswahl <small>{category_form} {set_category_form}</small></strong>';
$mip_form['19']['cat'] = 'txtarea';
$mip_form['19']['rows'] = '3';
$mip_form['19']['type'] = 'long';
$mip_form['19']['cms_var'] = 'MOD_VAR[19]';
$mip_form['19']['cms_val'] = $cms_mod['value']['19'];
$mip_form['19']['cms_val_default'] = '{category_label}{category_select}{category_submit}';

// legend template single entry
$mip_form['90019']['cat'] = 'desc';
$mip_form['90019']['type'] = '';
$mip_form['90019']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {category_select} {category_label} {category_submit}</small></div>';

$mip_form['102019']['cat'] = 'txt';
$mip_form['102019']['type'] = '';
$mip_form['102019']['rows'] = '1';
$mip_form['102019']['desc'] = 'Beschriftung alle anzeigen<br/><small>{category_select} & {category_links} erster Selectbox-Eintrag</small>';
$mip_form['102019']['cms_var'] = 'MOD_VAR[102019]';
$mip_form['102019']['cms_val'] = $cms_mod['value']['102019'];
$mip_form['102019']['cms_val_default'] = 'Alle anzeigen';

$mip_form['105019']['cat'] = 'txt';
$mip_form['105019']['type'] = '';
$mip_form['105019']['desc'] = 'Beschriftung<small> {category_submit}</small>';
$mip_form['105019']['cms_var'] = 'MOD_VAR[105019]';
$mip_form['105019']['cms_val'] = $cms_mod['value']['105019'];
$mip_form['105019']['cms_val_default'] = 'Auswählen';

$mip_form['101019']['cat'] = 'txt';
$mip_form['101019']['type'] = '';
$mip_form['101019']['desc'] = 'Beschriftung<small> {category_label}</small>';
$mip_form['101019']['cms_var'] = 'MOD_VAR[101019]';
$mip_form['101019']['cms_val'] = $cms_mod['value']['101019'];
$mip_form['101019']['cms_val_default'] = 'Kategorie auswählen';
// 
$mip_form['103019']['cat'] = 'txt';
$mip_form['103019']['type'] = '';
$mip_form['103019']['desc'] = 'Optionale Attribute<small> {category_select}';
$mip_form['103019']['cms_var'] = 'MOD_VAR[103019]';
$mip_form['103019']['cms_val'] = $cms_mod['value']['103019'];
$mip_form['103019']['cms_val_default'] = 'onchange="document.{form_name}.submit();"';
// 
$mip_form['104019']['cat'] = 'txt';
$mip_form['104019']['type'] = '';
$mip_form['104019']['desc'] = 'Optionale Attribute<small> {category_label}</small>';
$mip_form['104019']['cms_var'] = 'MOD_VAR[104019]';
$mip_form['104019']['cms_val'] = $cms_mod['value']['104019'];
$mip_form['104019']['cms_val_default'] = '';
// 
$mip_form['107019']['cat'] = 'txt';
$mip_form['107019']['type'] = '';
$mip_form['107019']['desc'] = 'Optionale Attribute<small> {category_submit}</small>';
$mip_form['107019']['cms_var'] = 'MOD_VAR[107019]';
$mip_form['107019']['cms_val'] = $cms_mod['value']['107019'];
$mip_form['107019']['cms_val_default'] = '';

$mip_form['108019']['cat'] = 'txt';
$mip_form['108019']['type'] = '';
$mip_form['108019']['desc'] = 'Zielseite <small>(idcatside, 0 = aktuelle Seite)</small>';
$mip_form['108019']['cms_var'] = 'MOD_VAR[108019]';
$mip_form['108019']['cms_val'] = $cms_mod['value']['108019'];
$mip_form['108019']['cms_val_default'] = '0';


// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['20']['desc'] = '<strong>Monatsauswahl <small>{month_form}</small></strong>';
$mip_form['20']['cat'] = 'txtarea';
$mip_form['20']['rows'] = '3';
$mip_form['20']['type'] = 'long';
$mip_form['20']['cms_var'] = 'MOD_VAR[20]';
$mip_form['20']['cms_val'] = $cms_mod['value']['20'];
$mip_form['20']['cms_val_default'] = '{month_label}{month_select}{month_submit}';

// legend template single entry
$mip_form['90020']['cat'] = 'desc';
$mip_form['90020']['type'] = '';
$mip_form['90020']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {month_select} {month_label} {month_submit}</small></div>';

$mip_form['105020']['cat'] = 'txt';
$mip_form['105020']['type'] = '';
$mip_form['105020']['desc'] = 'Beschriftung<small> {month_submit}</small>';
$mip_form['105020']['cms_var'] = 'MOD_VAR[105020]';
$mip_form['105020']['cms_val'] = $cms_mod['value']['105020'];
$mip_form['105020']['cms_val_default'] = 'auswählen';

$mip_form['101020']['cat'] = 'txt';
$mip_form['101020']['type'] = '';
$mip_form['101020']['desc'] = 'Beschriftung<small> {month_label}</small>';
$mip_form['101020']['cms_var'] = 'MOD_VAR[101020]';
$mip_form['101020']['cms_val'] = $cms_mod['value']['101020'];
$mip_form['101020']['cms_val_default'] = 'Monat auswählen';
// 
$mip_form['103020']['cat'] = 'txt';
$mip_form['103020']['type'] = '';
$mip_form['103020']['desc'] = 'Optionale Attribute<small> {month_select}</small>';
$mip_form['103020']['cms_var'] = 'MOD_VAR[103020]';
$mip_form['103020']['cms_val'] = $cms_mod['value']['103020'];
$mip_form['103020']['cms_val_default'] = 'onchange="document.{form_name}.submit();"';
// 
$mip_form['104020']['cat'] = 'txt';
$mip_form['104020']['type'] = '';
$mip_form['104020']['desc'] = 'Optionale Attribute<small> {month_label}</small>';
$mip_form['104020']['cms_var'] = 'MOD_VAR[104020]';
$mip_form['104020']['cms_val'] = $cms_mod['value']['104020'];
$mip_form['104020']['cms_val_default'] = '';
// 
$mip_form['107020']['cat'] = 'txt';
$mip_form['107020']['type'] = '';
$mip_form['107020']['desc'] = 'Optionale Attribute<small> {month_submit}</small>';
$mip_form['107020']['cms_var'] = 'MOD_VAR[107020]';
$mip_form['107020']['cms_val'] = $cms_mod['value']['107020'];
$mip_form['107020']['cms_val_default'] = '';

$mip_form['199020']['cat'] = 'desc';
$mip_form['199020']['type'] = '';
$mip_form['199020']['desc'] = '<small>(Für JS-Events steht innerhalb der optionalen Attribute das Element {form_name} zur Verfügung)</small>';

$mip_form['108020']['cat'] = 'txt';
$mip_form['108020']['type'] = '';
$mip_form['108020']['desc'] = 'Zielseite <small>(idcatside, 0 = aktuelle Seite)</small>';
$mip_form['108020']['cms_var'] = 'MOD_VAR[108020]';
$mip_form['108020']['cms_val'] = $cms_mod['value']['108020'];
$mip_form['108020']['cms_val_default'] = '0';


// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['22']['desc'] = '<strong>Jahresauswahl <small>{year_form}</small></strong>';
$mip_form['22']['cat'] = 'txtarea';
$mip_form['22']['rows'] = '3';
$mip_form['22']['type'] = 'long';
$mip_form['22']['cms_var'] = 'MOD_VAR[22]';
$mip_form['22']['cms_val'] = $cms_mod['value']['22'];
$mip_form['22']['cms_val_default'] = '{year_label}{year_select}{year_submit}';

// legend template single entry
$mip_form['90022']['cat'] = 'desc';
$mip_form['90022']['type'] = '';
$mip_form['90022']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {year_select} {year_label} {year_submit}</small></div>';

$mip_form['105022']['cat'] = 'txt';
$mip_form['105022']['type'] = '';
$mip_form['105022']['desc'] = 'Beschriftung<small> {year_submit}</small>';
$mip_form['105022']['cms_var'] = 'MOD_VAR[105022]';
$mip_form['105022']['cms_val'] = $cms_mod['value']['105022'];
$mip_form['105022']['cms_val_default'] = 'auswählen';

$mip_form['101022']['cat'] = 'txt';
$mip_form['101022']['type'] = '';
$mip_form['101022']['desc'] = 'Beschriftung<small> {year_label}</small>';
$mip_form['101022']['cms_var'] = 'MOD_VAR[101022]';
$mip_form['101022']['cms_val'] = $cms_mod['value']['101022'];
$mip_form['101022']['cms_val_default'] = 'Jahr auswählen';
// 
$mip_form['103022']['cat'] = 'txt';
$mip_form['103022']['type'] = '';
$mip_form['103022']['desc'] = 'Optionale Attribute<small> {year_select}</small>';
$mip_form['103022']['cms_var'] = 'MOD_VAR[103022]';
$mip_form['103022']['cms_val'] = $cms_mod['value']['103022'];
$mip_form['103022']['cms_val_default'] = 'onchange="document.{form_name}.submit();"';
// 
$mip_form['104022']['cat'] = 'txt';
$mip_form['104022']['type'] = '';
$mip_form['104022']['desc'] = 'Optionale Attribute<small> {year_label}</small>';
$mip_form['104022']['cms_var'] = 'MOD_VAR[104022]';
$mip_form['104022']['cms_val'] = $cms_mod['value']['104022'];
$mip_form['104022']['cms_val_default'] = '';
// 
$mip_form['107022']['cat'] = 'txt';
$mip_form['107022']['type'] = '';
$mip_form['107022']['desc'] = 'Optionale Attribute<small> {year_submit}</small>';
$mip_form['107022']['cms_var'] = 'MOD_VAR[107022]';
$mip_form['107022']['cms_val'] = $cms_mod['value']['107022'];
$mip_form['107022']['cms_val_default'] = '';

$mip_form['199022']['cat'] = 'desc';
$mip_form['199022']['type'] = '';
$mip_form['199022']['desc'] = '<small>(Für JS-Events steht innerhalb der optionalen Attribute das Element {form_name} zur Verfügung)</small>';

$mip_form['108022']['cat'] = 'txt';
$mip_form['108022']['type'] = '';
$mip_form['108022']['desc'] = 'Zielseite <small>(idcatside, 0 = aktuelle Seite)</small>';
$mip_form['108022']['cms_var'] = 'MOD_VAR[108022]';
$mip_form['108022']['cms_val'] = $cms_mod['value']['108022'];
$mip_form['108022']['cms_val_default'] = '0';



// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['23']['desc'] = '<strong>Freifeldfilterauswahl <small>{customfilter_form:<em>1-35</em>}</small></strong>';
$mip_form['23']['cat'] = 'txtarea';
$mip_form['23']['rows'] = '3';
$mip_form['23']['type'] = 'long';
$mip_form['23']['cms_var'] = 'MOD_VAR[23]';
$mip_form['23']['cms_val'] = $cms_mod['value']['23'];
$mip_form['23']['cms_val_default'] = '{custom_label}{custom_select}{custom_submit}';


// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['99023']['desc'] = '<strong>Freifeldfilterauswahl </strong>(kombiniert) <strong><small>{customfilter_combinedform:<em>1</em>:<em>2</em>:<em>&nbsp;...&nbsp;</em>:<em>35</em>}</small></strong>';
$mip_form['99023']['cat'] = 'txtarea';
$mip_form['99023']['rows'] = '3';
$mip_form['99023']['type'] = 'long';
$mip_form['99023']['cms_var'] = 'MOD_VAR[99023]';
$mip_form['99023']['cms_val'] = $cms_mod['value']['99023'];
$mip_form['99023']['cms_val_default'] = '{custom_selects}{custom_submit}';


// legend template single entry
$mip_form['90023']['cat'] = 'desc';
$mip_form['90023']['type'] = '';
$mip_form['90023']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {custom_select} {custom_label} {custom_submit}</small></div>';

// legend template single entry
$mip_form['99923']['cat'] = 'desc';
$mip_form['99923']['type'] = '';
$mip_form['99923']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {custom_select} {custom_label} {custom_submit}</small></div>';


$mip_form['105019']['cat'] = 'txt';
$mip_form['105019']['type'] = '';
$mip_form['105019']['rows'] = '1';
$mip_form['105019']['desc'] = 'Beschriftung erster Selectbox-Eintrag <small>{custom_select}</small>';
$mip_form['105019']['cms_var'] = 'MOD_VAR[105019]';
$mip_form['105019']['cms_val'] = $cms_mod['value']['105019'];
$mip_form['105019']['cms_val_default'] = 'Auswählen';

$mip_form['105023']['cat'] = 'txt';
$mip_form['105023']['type'] = '';
$mip_form['105023']['desc'] = 'Beschriftung<small> {custom_submit}</small>';
$mip_form['105023']['cms_var'] = 'MOD_VAR[105023]';
$mip_form['105023']['cms_val'] = $cms_mod['value']['105023'];
$mip_form['105023']['cms_val_default'] = 'auswählen';

$mip_form['101023']['cat'] = 'txt';
$mip_form['101023']['type'] = '';
$mip_form['101023']['desc'] = 'Beschriftung<small> {custom_label}&nbsp;&nbsp;&nbsp;({label} = Freifeldtitel)</small>';
$mip_form['101023']['cms_var'] = 'MOD_VAR[101023]';
$mip_form['101023']['cms_val'] = $cms_mod['value']['101023'];
$mip_form['101023']['cms_val_default'] = '{label} auswählen';
// 
$mip_form['103023']['cat'] = 'txt';
$mip_form['103023']['type'] = '';
$mip_form['103023']['desc'] = 'Optionale Attribute<small> {custom_select}</small>';
$mip_form['103023']['cms_var'] = 'MOD_VAR[103023]';
$mip_form['103023']['cms_val'] = $cms_mod['value']['103023'];
$mip_form['103023']['cms_val_default'] = 'onchange="document.{form_name}.submit();"';
// 
$mip_form['193023']['cat'] = 'txt';
$mip_form['193023']['type'] = '';
$mip_form['193023']['desc'] = 'Optionale Attribute<small> {custom_select} - Freifeldfilterauswahl (kombiniert)</small>';
$mip_form['193023']['cms_var'] = 'MOD_VAR[193023]';
$mip_form['193023']['cms_val'] = $cms_mod['value']['193023'];
$mip_form['193023']['cms_val_default'] = 'multiple="multiple" size="5"';

$mip_form['104023']['cat'] = 'txt';
$mip_form['104023']['type'] = '';
$mip_form['104023']['desc'] = 'Optionale Attribute<small> {custom_label}</small>';
$mip_form['104023']['cms_var'] = 'MOD_VAR[104023]';
$mip_form['104023']['cms_val'] = $cms_mod['value']['104023'];
$mip_form['104023']['cms_val_default'] = '';
// 
$mip_form['107023']['cat'] = 'txt';
$mip_form['107023']['type'] = '';
$mip_form['107023']['desc'] = 'Optionale Attribute<small> {custom_submit}</small>';
$mip_form['107023']['cms_var'] = 'MOD_VAR[107023]';
$mip_form['107023']['cms_val'] = $cms_mod['value']['107023'];
$mip_form['107023']['cms_val_default'] = '';

$mip_form['199023']['cat'] = 'desc';
$mip_form['199023']['type'] = '';
$mip_form['199023']['desc'] = '<small>(Für JS-Events steht innerhalb der optionalen Attribute das Element {form_name} zur Verfügung)</small>';

$mip_form['108023']['cat'] = 'txt';
$mip_form['108023']['type'] = '';
$mip_form['108023']['desc'] = 'Zielseite <small>(idcatside, 0 = aktuelle Seite)</small>';
$mip_form['108023']['cms_var'] = 'MOD_VAR[108023]';
$mip_form['108023']['cms_val'] = $cms_mod['value']['108023'];
$mip_form['108023']['cms_val_default'] = '0';


// {set_article_form}
$mip_form['24']['desc'] = '<strong>Artikelauswahl <small>{article_form} {set_article_form}</small></strong>';
$mip_form['24']['cat'] = 'txtarea';
$mip_form['24']['rows'] = '3';
$mip_form['24']['type'] = 'long';
$mip_form['24']['cms_var'] = 'MOD_VAR[24]';
$mip_form['24']['cms_val'] = $cms_mod['value']['24'];
$mip_form['24']['cms_val_default'] = '{article_label}{article_select}{article_submit}';

// legend template single entry
$mip_form['90024']['cat'] = 'desc';
$mip_form['90024']['type'] = '';
$mip_form['90024']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {article_select} {article_label} {article_submit}</small></div>';

$mip_form['105024']['cat'] = 'txt';
$mip_form['105024']['type'] = '';
$mip_form['105024']['desc'] = 'Beschriftung<small> {article_submit}</small>';
$mip_form['105024']['cms_var'] = 'MOD_VAR[105024]';
$mip_form['105024']['cms_val'] = $cms_mod['value']['105024'];
$mip_form['105024']['cms_val_default'] = 'Auswählen';

$mip_form['101024']['cat'] = 'txt';
$mip_form['101024']['type'] = '';
$mip_form['101024']['desc'] = 'Beschriftung<small> {article_label}</small>';
$mip_form['101024']['cms_var'] = 'MOD_VAR[101024]';
$mip_form['101024']['cms_val'] = $cms_mod['value']['101024'];
$mip_form['101024']['cms_val_default'] = 'Artikel auswählen';
// 
$mip_form['103024']['cat'] = 'txt';
$mip_form['103024']['type'] = '';
$mip_form['103024']['desc'] = 'Optionale Attribute<small> {article_select}';
$mip_form['103024']['cms_var'] = 'MOD_VAR[103024]';
$mip_form['103024']['cms_val'] = $cms_mod['value']['103024'];
$mip_form['103024']['cms_val_default'] = 'onchange="document.{form_name}.submit();"';
// 
$mip_form['104024']['cat'] = 'txt';
$mip_form['104024']['type'] = '';
$mip_form['104024']['desc'] = 'Optionale Attribute<small> {article_label}</small>';
$mip_form['104024']['cms_var'] = 'MOD_VAR[104024]';
$mip_form['104024']['cms_val'] = $cms_mod['value']['104024'];
$mip_form['104024']['cms_val_default'] = '';
// 
$mip_form['107024']['cat'] = 'txt';
$mip_form['107024']['type'] = '';
$mip_form['107024']['desc'] = 'Optionale Attribute<small> {article_submit}</small>';
$mip_form['107024']['cms_var'] = 'MOD_VAR[107024]';
$mip_form['107024']['cms_val'] = $cms_mod['value']['107024'];
$mip_form['107024']['cms_val_default'] = '';

$mip_form['110024']['cat'] = 'txt';
$mip_form['110024']['type'] = '';
$mip_form['110024']['desc'] = 'Max. Zeichenlänge der Artikeltitel in der Auswahl <small>(Anzahl eingeben)</small>';
$mip_form['110024']['cms_var'] = 'MOD_VAR[110024]';
$mip_form['110024']['cms_val'] = $cms_mod['value']['110024'];
$mip_form['110024']['cms_val_default'] = '64';

$mip_form['120024']['cat'] = 'txt';
$mip_form['120024']['type'] = '';
$mip_form['120024']['desc'] = 'Max. Menge der zur Auswahl stehenden Artikel <small>(Anzahl eingeben)</small>';
$mip_form['120024']['cms_var'] = 'MOD_VAR[120024]';
$mip_form['120024']['cms_val'] = $cms_mod['value']['120024'];
$mip_form['120024']['cms_val_default'] = '32';

$mip_form['130024']['cat'] = 'option';
$mip_form['130024']['desc'] = 'Archivierte Artikel auswählen';
$mip_form['130024']['cms_var'] = 'MOD_VAR[130024]';
$mip_form['130024']['cms_val'] = $cms_mod['value']['130024'];
$mip_form['130024']['cms_val_default'] = '0';
$mip_form['130024']['option_desc']['0'] = 'Nein';
$mip_form['130024']['option_val']['0'] = '0';
$mip_form['130024']['option_desc']['1'] = 'Ja';
$mip_form['130024']['option_val']['1'] = '1';

$mip_form['140024']['cat'] = 'option';
$mip_form['140024']['desc'] = 'Offline-Artikel auswählen';
$mip_form['140024']['cms_var'] = 'MOD_VAR[140024]';
$mip_form['140024']['cms_val'] = $cms_mod['value']['140024'];
$mip_form['140024']['cms_val_default'] = '0';
$mip_form['140024']['option_desc']['0'] = 'Nein';
$mip_form['140024']['option_val']['0'] = '0';
$mip_form['140024']['option_desc']['1'] = 'Ja';
$mip_form['140024']['option_val']['1'] = '1';










// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['21']['desc'] = '<strong>Zeitabschnitt <small>{range}</small></strong>';
$mip_form['21']['cat'] = 'txtarea';
$mip_form['21']['rows'] = '3';
$mip_form['21']['type'] = 'long';
$mip_form['21']['cms_var'] = 'MOD_VAR[21]';
$mip_form['21']['cms_val'] = $cms_mod['value']['21'];
$mip_form['21']['cms_val_default'] = '{link_rangebackward} {range_date_from} - {range_date_to} {link_rangeforward}';


// legend template single entry
$mip_form['90021']['cat'] = 'desc';
$mip_form['90021']['type'] = '';
$mip_form['90021']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {range_time24_from} {range_time24_to} {range_time12_from} {range_time12_to}<br/>
{range_date_from} {range_date_from:day} {range_date_from:month} {range_date_from:year}<br/>{range_date_to} {range_date_to:day} {range_date_to:month} {range_date_to:year}<br/>
{link_rangebackward} {link_rangeforward}</small></div>';


// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['13']['desc'] = '<strong>Navigation Zeitabschnitt - Link "vor" <small>{link_rangeforward}</small></strong>';
$mip_form['13']['cat'] = 'txtarea';
$mip_form['13']['rows'] = '2';
$mip_form['13']['type'] = 'long';
$mip_form['13']['cms_var'] = 'MOD_VAR[13]';
$mip_form['13']['cms_val'] = $cms_mod['value']['13'];
$mip_form['13']['cms_val_default'] = '<a href="{url}">vor</a>';

// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['14']['desc'] = '<strong>Navigation Zeitabschnitt - Link "zurück" <small>{link_rangebackward}</small></strong>';
$mip_form['14']['cat'] = 'txtarea';
$mip_form['14']['rows'] = '2';
$mip_form['14']['type'] = 'long';
$mip_form['14']['cms_var'] = 'MOD_VAR[14]';
$mip_form['14']['cms_val'] = $cms_mod['value']['14'];
$mip_form['14']['cms_val_default'] = '<a href="{url}">zur&uuml;ck</a>';





// Artikel aus dieser Kategorie anzeigen
$mip_form['80']['cat'] = 'option';
$mip_form['80']['type'] = '';
$mip_form['80']['rows'] = '1';
$mip_form['80']['desc'] = 'Zeitliche Orientierung des Zeitabschnitts';
$mip_form['80']['cms_var'] = 'MOD_VAR[80]';
$mip_form['80']['cms_val'] = $cms_mod['value']['80'];
$mip_form['80']['cms_val_default'] = '1';
$mip_form['80']['option_desc'][] = 'am aktuellen Datum';
$mip_form['80']['option_val'][] = '0';
$mip_form['80']['option_desc'][] = 'am Monatsanfang des Zeitabschnitts';
$mip_form['80']['option_val'][] = '1';
if ($mip_form['1']['cms_val']=='-1')
	$mip_form['80']['cat'] = 'hidden';




// Jahressabschnittsauswahl
$mip_form['25']['desc'] = '<strong>Jahressabschnittsauswahl <small>{yearrange_form}</small></strong>';
$mip_form['25']['cat'] = 'txtarea';
$mip_form['25']['rows'] = '2';
$mip_form['25']['type'] = 'long';
$mip_form['25']['cms_var'] = 'MOD_VAR[25]';
$mip_form['25']['cms_val'] = $cms_mod['value']['25'];
$mip_form['25']['cms_val_default'] = '{yearrange_start_label}{yearrange_start_select}
{yearrange_end_label} {yearrange_end_select} 
{yearrange_submit}';

// legend template single entry
$mip_form['90025']['cat'] = 'desc';
$mip_form['90025']['type'] = '';
$mip_form['90025']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {yearrange_start_label} {yearrange_start_select} {yearrange_end_label} {yearrange_end_select} {yearrange_submit}</small></div>';

$mip_form['108025']['cat'] = 'txt';
$mip_form['108025']['type'] = '';
$mip_form['108025']['desc'] = 'Anzahl der Monate in den Auswahlmenüs';
$mip_form['108025']['cms_var'] = 'MOD_VAR[108025]';
$mip_form['108025']['cms_val'] = $cms_mod['value']['108025'];
$mip_form['108025']['cms_val_default'] = '13';

$mip_form['109025']['cat'] = 'txt';
$mip_form['109025']['type'] = '';
$mip_form['109025']['desc'] = 'Startmonat-Anpassung <small>(0 = aktueller Monat, +/-Werte möglich )</small>';
$mip_form['109025']['cms_var'] = 'MOD_VAR[109025]';
$mip_form['109025']['cms_val'] = $cms_mod['value']['109025'];
$mip_form['109025']['cms_val_default'] = '-6';


$mip_form['105025']['cat'] = 'txt';
$mip_form['105025']['type'] = '';
$mip_form['105025']['desc'] = 'Beschriftung<small> {yearrange_submit}</small>';
$mip_form['105025']['cms_var'] = 'MOD_VAR[105025]';
$mip_form['105025']['cms_val'] = $cms_mod['value']['105025'];
$mip_form['105025']['cms_val_default'] = 'Auswählen';

$mip_form['101025']['cat'] = 'txt';
$mip_form['101025']['type'] = '';
$mip_form['101025']['desc'] = 'Beschriftung<small> {yearrange_start_label}</small>';
$mip_form['101025']['cms_var'] = 'MOD_VAR[101025]';
$mip_form['101025']['cms_val'] = $cms_mod['value']['101025'];
$mip_form['101025']['cms_val_default'] = 'Anfangsmonat';
// 
$mip_form['103025']['cat'] = 'txt';
$mip_form['103025']['type'] = '';
$mip_form['103025']['desc'] = 'Optionale Attribute<small> {yearrange_start_select}';
$mip_form['103025']['cms_var'] = 'MOD_VAR[103025]';
$mip_form['103025']['cms_val'] = $cms_mod['value']['103025'];
$mip_form['103025']['cms_val_default'] = 'onchange="{checkyearrange}document.{form_name}.submit();"';
// 
$mip_form['104025']['cat'] = 'txt';
$mip_form['104025']['type'] = '';
$mip_form['104025']['desc'] = 'Optionale Attribute<small> {yearrange_start_label}</small>';
$mip_form['104025']['cms_var'] = 'MOD_VAR[104025]';
$mip_form['104025']['cms_val'] = $cms_mod['value']['104025'];
$mip_form['104025']['cms_val_default'] = '';
// 

$mip_form['101026']['cat'] = 'txt';
$mip_form['101026']['type'] = '';
$mip_form['101026']['desc'] = 'Beschriftung<small> {yearrange_end_label}</small>';
$mip_form['101026']['cms_var'] = 'MOD_VAR[101026]';
$mip_form['101026']['cms_val'] = $cms_mod['value']['101026'];
$mip_form['101026']['cms_val_default'] = 'Endmonat';
// 
$mip_form['103026']['cat'] = 'txt';
$mip_form['103026']['type'] = '';
$mip_form['103026']['desc'] = 'Optionale Attribute<small> {yearrange_end_select}';
$mip_form['103026']['cms_var'] = 'MOD_VAR[103026]';
$mip_form['103026']['cms_val'] = $cms_mod['value']['103026'];
$mip_form['103026']['cms_val_default'] = 'onchange="{checkyearrange}document.{form_name}.submit();"';
// 
$mip_form['104026']['cat'] = 'txt';
$mip_form['104026']['type'] = '';
$mip_form['104026']['desc'] = 'Optionale Attribute<small> {yearrange_end_label}</small>';
$mip_form['104026']['cms_var'] = 'MOD_VAR[104026]';
$mip_form['104026']['cms_val'] = $cms_mod['value']['104026'];
$mip_form['104026']['cms_val_default'] = '';
// 
$mip_form['107025']['cat'] = 'txt';
$mip_form['107025']['type'] = '';
$mip_form['107025']['desc'] = 'Optionale Attribute<small> {yearrange_submit}</small>';
$mip_form['107025']['cms_var'] = 'MOD_VAR[107025]';
$mip_form['107025']['cms_val'] = $cms_mod['value']['107025'];
$mip_form['107025']['cms_val_default'] = 'onchange="{checkyearrange}"';



// Template Listenansicht - Zeile - Keinen Artikel gefunden

// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['30']['desc'] = '<strong>Kalender <small>{calendar}</small></strong>';
$mip_form['30']['cat'] = 'txtarea';
$mip_form['30']['rows'] = '12';
$mip_form['30']['type'] = 'long';
$mip_form['30']['cms_var'] = 'MOD_VAR[30]';
$mip_form['30']['cms_val'] = $cms_mod['value']['30'];
$mip_form['30']['cms_val_default'] = '<table border="0">
{head}
	<tr>
		<td align="center">{dayname_1}</td>
		<td align="center">{dayname_2}</td>
		<td align="center">{dayname_3}</td>
		<td align="center">{dayname_4}</td>
		<td align="center">{dayname_5}</td>
		<td align="center">{dayname_6}</td>
		<td align="center">{dayname_7}</td>
	</tr>
	{weeks}
</table>';


$mip_form['27']['desc'] = '<strong><small>{head}</small></strong>';
$mip_form['27']['cat'] = 'txtarea';
$mip_form['27']['rows'] = '6';
$mip_form['27']['type'] = 'long';
$mip_form['27']['cms_var'] = 'MOD_VAR[27]';
$mip_form['27']['cms_val'] = $cms_mod['value']['27'];
$mip_form['27']['cms_val_default'] = '
	<tr>
		<td align="center">{month_prev}</td>
		<td align="center"colspan="5">{month}</td> 
		<td align="center">{month_next}</td>
	</tr>
';

// legend template single entry
$mip_form['90030']['cat'] = 'desc';
$mip_form['90030']['type'] = '';
$mip_form['90030']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {head} {dayname_<em>1-7</em>} {weeks}</small></div>';
// legend template single entry
$mip_form['90027']['cat'] = 'desc';
$mip_form['90027']['type'] = '';
$mip_form['90027']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {month_next} {month} {month_prev}</small></div>';

//
$mip_form['31']['desc'] = 'Wochenzeile-Template';
$mip_form['31']['cat'] = 'txt';
$mip_form['31']['rows'] = '1';
$mip_form['31']['type'] = 'long';
$mip_form['31']['cms_var'] = 'MOD_VAR[31]';
$mip_form['31']['cms_val'] = $cms_mod['value']['31'];
$mip_form['31']['cms_val_default'] = '<tr>{week}</tr>';
//
$mip_form['26']['desc'] = '<span style="float:right;"><small><strong>Elemente</strong> {number} {month} {month_name}</small></span>Tag-Element {day} ';
$mip_form['26']['cat'] = 'txt';
$mip_form['26']['rows'] = '1';
$mip_form['26']['type'] = 'long';
$mip_form['26']['cms_var'] = 'MOD_VAR[26]';
$mip_form['26']['cms_val'] = $cms_mod['value']['26'];
$mip_form['26']['cms_val_default'] = '{number}';

// Artikel aus dieser Kategorie anzeigen
$mip_form['3000']['cat'] = 'option';
$mip_form['3000']['type'] = '';
$mip_form['3000']['rows'] = '1';
$mip_form['3000']['desc'] = 'Ausgabemodus';
$mip_form['3000']['cms_var'] = 'MOD_VAR[3000]';
$mip_form['3000']['cms_val'] = $cms_mod['value']['3000'];
$mip_form['3000']['cms_val_default'] = '0';
$mip_form['3000']['option_desc'][] = 'Tabelle ("leere Tage" ausgegeben)';
$mip_form['3000']['option_val'][] = '0';
$mip_form['3000']['option_desc'][] = 'Liste ("leere Tage" auslassen)';
$mip_form['3000']['option_val'][] = '1';


//
$mip_form['32']['desc'] = 'Tag-Template';
$mip_form['32']['cat'] = 'txt';
$mip_form['32']['rows'] = '1';
$mip_form['32']['type'] = 'long';
$mip_form['32']['cms_var'] = 'MOD_VAR[32]';
$mip_form['32']['cms_val'] = $cms_mod['value']['32'];
$mip_form['32']['cms_val_default'] = '<td align="center" valign="top" style="background:#ccc">{day}</td>';
//
$mip_form['33']['desc'] = 'Tag-Ausgewählt-Template';
$mip_form['33']['cat'] = 'txt';
$mip_form['33']['rows'] = '1';
$mip_form['33']['type'] = 'long';
$mip_form['33']['cms_var'] = 'MOD_VAR[33]';
$mip_form['33']['cms_val'] = $cms_mod['value']['33'];
$mip_form['33']['cms_val_default'] = '<td align="center" valign="top" style="background:#6f6">{day}</td>';
// 
$mip_form['34']['desc'] = 'Tag-Heute-Template';
$mip_form['34']['cat'] = 'txt';
$mip_form['34']['rows'] = '1';
$mip_form['34']['type'] = 'long';
$mip_form['34']['cms_var'] = 'MOD_VAR[34]';
$mip_form['34']['cms_val'] = $cms_mod['value']['34'];
$mip_form['34']['cms_val_default'] = '<td align="center" valign="top" style="background:#ccf">{day}</td>';
// 
$mip_form['35']['desc'] = 'Tag-Sonntag-Template';
$mip_form['35']['cat'] = 'txt';
$mip_form['35']['rows'] = '1';
$mip_form['35']['type'] = 'long';
$mip_form['35']['cms_var'] = 'MOD_VAR[35]';
$mip_form['35']['cms_val'] = $cms_mod['value']['35'];
$mip_form['35']['cms_val_default'] = '<td align="center" valign="top" style="background:#f66">{day}</td>';
// 
$mip_form['29']['desc'] = 'Event-Template';
$mip_form['29']['cat'] = 'txt';
$mip_form['29']['rows'] = '1';
$mip_form['29']['type'] = 'long';
$mip_form['29']['cms_var'] = 'MOD_VAR[29]';
$mip_form['29']['cms_val'] = $cms_mod['value']['29'];
$mip_form['29']['cms_val_default'] = '<td align="center" valign="top" style="border:1px solid">{day}</td>';

$mip_form['36']['desc'] = 'Link Monat <small>{month}</small>';
$mip_form['36']['cat'] = 'txt';
$mip_form['36']['rows'] = '1';
$mip_form['36']['type'] = 'long';
$mip_form['36']['cms_var'] = 'MOD_VAR[36]';
$mip_form['36']['cms_val'] = $cms_mod['value']['36'];
$mip_form['36']['cms_val_default'] = '<a href="{link}">{month}</a>';

$mip_form['37']['desc'] = 'Link Monat-Vor <small>{month_next}</small>';
$mip_form['37']['cat'] = 'txt';
$mip_form['37']['rows'] = '1';
$mip_form['37']['type'] = 'long';
$mip_form['37']['cms_var'] = 'MOD_VAR[37]';
$mip_form['37']['cms_val'] = $cms_mod['value']['37'];
$mip_form['37']['cms_val_default'] = '<a href="{link}">&gt;&gt;</a>';

$mip_form['38']['desc'] = 'Link Monat-Zurück <small>{month_prev}</small>';
$mip_form['38']['cat'] = 'txt';
$mip_form['38']['rows'] = '1';
$mip_form['38']['type'] = 'long';
$mip_form['38']['cms_var'] = 'MOD_VAR[38]';
$mip_form['38']['cms_val'] = $cms_mod['value']['38'];
$mip_form['38']['cms_val_default'] = '<a href="{link}">&lt;&lt;</a>';

$mip_form['30030']['desc'] = 'Wochenstart <small>(0 = So., 1 = Mo., 2 = Di. usw.)';
$mip_form['30030']['cat'] = 'txt';
$mip_form['30030']['rows'] = '1';
$mip_form['30030']['cms_var'] = 'MOD_VAR[30030]';
$mip_form['30030']['cms_val'] = $cms_mod['value']['30030'];
$mip_form['30030']['cms_val_default'] = '1';

$mip_form['30031']['desc'] = 'Tagesnamen <small>{dayname_<em>1-7</em>}</small> ';
$mip_form['30031']['cat'] = 'txtarea';
$mip_form['30031']['rows'] = '7';
$mip_form['30031']['cms_var'] = 'MOD_VAR[30031]';
$mip_form['30031']['cms_val'] = $cms_mod['value']['30031'];
$mip_form['30031']['cms_val_default']='So
Mo 
Di 
Mi 
Do 
Fr 
Sa';

$mip_form['30032']['desc'] = 'Monatsnamen';
$mip_form['30032']['cat'] = 'txtarea';
$mip_form['30032']['rows'] = '12';
$mip_form['30032']['cms_var'] = 'MOD_VAR[30032]';
$mip_form['30032']['cms_val'] = $cms_mod['value']['30032'];
$mip_form['30032']['cms_val_default']='Januar
Februar
März
April
Mai
Juni
Juli
August
September
Oktober
November
Dezember';

// <br>
$mip_form['99999']['cat'] = 'desc';
$mip_form['99999']['type'] = '';
$mip_form['99999']['desc'] = '';

$mip_form['999990']['cat'] = 'desc';
$mip_form['999990']['type'] = '';
$mip_form['999990']['desc'] = '';

$mip_form['999991']['cat'] = 'desc';
$mip_form['999991']['type'] = '';
$mip_form['999991']['desc'] = '';

$mip_form['999992']['cat'] = 'desc';
$mip_form['999992']['type'] = '';
$mip_form['999992']['desc'] = '';

$mip_form['400999']['cat'] = 'desc';
$mip_form['400999']['type'] = '';
$mip_form['400999']['desc'] = '';

// Navigation template vorwaerts aktiv
$mip_form['800']['cat'] = 'txt';
$mip_form['800']['desc'] = '<strong>Modulkennung</strong> <small><br/>(leer = automatisch, bei Nutzung des RSS-Moduls müssen Artikelsystem-Ausgabe-Modul und -RSS-Modul dieselbe<br/>Kennung nutzen.)</small>';
$mip_form['800']['cms_var'] = 'MOD_VAR[800]';
$mip_form['800']['cms_val'] = $cms_mod['value']['800'];
$mip_form['800']['cms_val_default'] = '';


// Comment-Plug
$mip_form['400000']['cat'] = 'desc';
$mip_form['400000']['desc'] = '<strong>Kommentare <small>{comments}</small></strong>';


$mip_form['400010']['desc'] = 'Forum erhällt Inhalte aus Projektsprache';
$mip_form['400010']['cat'] = 'option';
$mip_form['400010']['size'] = '1';
$_AS['temp']['sql'] = "SELECT 
			* 
		FROM 
			". $cms_db['lang'] ." L 
			LEFT JOIN ". $cms_db['clients_lang']." CL USING(idlang) 
		WHERE idclient = '$client'
		ORDER BY 
			L.name asc";

$db->query($_AS['temp']['sql']);
while( $db->next_record() ){
	$mip_form['400010']['option_desc'][] = $db->f('name');
	$mip_form['400010']['option_val'][] =  'cms_forum_as'.$client.'_lang'.$db->f('idlang');
}
$mip_form['400010']['cms_var'] = 'MOD_VAR[400010]';
$mip_form['400010']['cms_val'] = $cms_mod['value']['400010'];
$mip_form['400010']['cms_val_default'] = 'cms_as_client'.$client.'_lang'.$lang;


$mip_form['400011']['desc'] = 'Adminbenachtigung per Email bei neuem Eintrag';
$mip_form['400011']['cat'] = 'option';
$mip_form['400011']['size'] = '1';
$mip_form['400011']['option_desc'][] = 'Nein';
$mip_form['400011']['option_val'][] =  'false';
$mip_form['400011']['option_desc'][] = 'Ja';
$mip_form['400011']['option_val'][] =  'true';
$mip_form['400011']['cms_var'] = 'MOD_VAR[400011]';
$mip_form['400011']['cms_val'] = $cms_mod['value']['400011'];
$mip_form['400011']['cms_val_default'] = 'false';

$mip_form['400012']['cat'] = 'txt';
$mip_form['400012']['desc'] = 'Emailadresse Adminbenachtigung';
$mip_form['400012']['cms_var'] = 'MOD_VAR[400012]';
$mip_form['400012']['cms_val'] = $cms_mod['value']['400012'];
$mip_form['400012']['cms_val_default'] = 'me@localhost.de';
$mip_form['400012']['tab'] = '0';

$mip_form['400013']['desc'] = 'Wiedereintragszeit Sperre in Sekeunden<br />
  <small>Gibt an, wie lange ein Benutzer warten muß, bis er einen neuen Beitrag schreiben darf</small>';
$mip_form['400013']['cat'] = 'option';
$mip_form['400013']['size'] = '1';
$mip_form['400013']['option_desc'][] = '0';
$mip_form['400013']['option_val'][] =  '0';
$mip_form['400013']['option_desc'][] = '5';
$mip_form['400013']['option_val'][] =  '5';
$mip_form['400013']['option_desc'][] = '10';
$mip_form['400013']['option_val'][] =  '10';
$mip_form['400013']['option_desc'][] = '20';
$mip_form['400013']['option_val'][] =  '20';
$mip_form['400013']['option_desc'][] = '30';
$mip_form['400013']['option_val'][] =  '30';
$mip_form['400013']['option_desc'][] = '40';
$mip_form['400013']['option_val'][] =  '40';
$mip_form['400013']['option_desc'][] = '50';
$mip_form['400013']['option_val'][] =  '50';
$mip_form['400013']['option_desc'][] = '60';
$mip_form['400013']['option_val'][] =  '60';
$mip_form['400013']['option_desc'][] = '90';
$mip_form['400013']['option_val'][] =  '90';
$mip_form['400013']['option_desc'][] = '120';
$mip_form['400013']['option_val'][] =  '120';
$mip_form['400013']['option_desc'][] = '150';
$mip_form['400013']['option_val'][] =  '150';
$mip_form['400013']['cms_var'] = 'MOD_VAR[400013]';
$mip_form['400013']['cms_val'] = $cms_mod['value']['400013'];
$mip_form['400013']['cms_val_default'] = '5';

$mip_form['400014']['desc'] = "Gruppen, die Beiträge schreiben dürfen";
$mip_form['400014']['cat'] = 'app_group';
$mip_form['400014']['output_cat'] = 'option';
$mip_form['400014']['flag'] = 'multiple';
$mip_form['400014']['size'] = 5;
$mip_form['400014']['cms_var'] = "MOD_VAR[14]";
$mip_form['400014']['cms_val'] = $cms_mod['value']['400014'];

$mip_form['400015']['desc'] = 'Nicht eingeloggte Benutzer dürfen Beiträge verfassen';
$mip_form['400015']['cat'] = 'option';
$mip_form['400015']['size'] = '1';
$mip_form['400015']['option_desc'][] = 'Ja';
$mip_form['400015']['option_val'][] =  'true';
$mip_form['400015']['option_desc'][] = 'Nein';
$mip_form['400015']['option_val'][] =  'false';
$mip_form['400015']['cms_var'] = 'MOD_VAR[400015]';
$mip_form['400015']['cms_val'] = $cms_mod['value']['400015'];
$mip_form['400015']['cms_val_default'] = 'true';

$mip_form['400016']['desc'] = 'Threads per Seite in Threadlist';
$mip_form['400016']['cat'] = 'option';
$mip_form['400016']['size'] = '1';
$mip_form['400016']['option_desc'][] = '5';
$mip_form['400016']['option_val'][] =  '5';
$mip_form['400016']['option_desc'][] = '10';
$mip_form['400016']['option_val'][] =  '10';
$mip_form['400016']['option_desc'][] = '20';
$mip_form['400016']['option_val'][] =  '20';
$mip_form['400016']['option_desc'][] = '30';
$mip_form['400016']['option_val'][] =  '30';
$mip_form['400016']['option_desc'][] = '40';
$mip_form['400016']['option_val'][] =  '40';
$mip_form['400016']['option_desc'][] = '50';
$mip_form['400016']['option_val'][] =  '50';
$mip_form['400016']['option_desc'][] = '60';
$mip_form['400016']['option_val'][] =  '60';
$mip_form['400016']['option_desc'][] = '90';
$mip_form['400016']['option_val'][] =  '90';
$mip_form['400016']['option_desc'][] = '120';
$mip_form['400016']['option_val'][] =  '120';
$mip_form['400016']['option_desc'][] = '150';
$mip_form['400016']['option_val'][] =  '150';
$mip_form['400016']['cms_var'] = 'MOD_VAR[400016]';
$mip_form['400016']['cms_val'] = $cms_mod['value']['400016'];
$mip_form['400016']['cms_val_default'] = '20';

$mip_form['400017']['desc'] = 'Sprachstrings des Forums';
$mip_form['400017']['cat'] = 'option';
$mip_form['400017']['size'] = '1';
$mip_form['400017']['option_desc'][] = 'Deutsch';
$mip_form['400017']['option_val'][] =  'de';
$mip_form['400017']['option_desc'][] = 'English';
$mip_form['400017']['option_val'][] =  'en';
$mip_form['400017']['cms_var'] = 'MOD_VAR[400017]';
$mip_form['400017']['cms_val'] = $cms_mod['value']['400017'];
$mip_form['400017']['cms_val_default'] = 'true';

$mip_form['400018']['desc'] = 'Mailing deaktivieren (Debug)';
$mip_form['400018']['cat'] = 'option';
$mip_form['400018']['size'] = '1';
$mip_form['400018']['option_desc'][] = 'Ja';
$mip_form['400018']['option_val'][] =  'true';
$mip_form['400018']['option_desc'][] = 'Nein';
$mip_form['400018']['option_val'][] =  'false';
$mip_form['400018']['cms_var'] = 'MOD_VAR[400018]';
$mip_form['400018']['cms_val'] = $cms_mod['value']['400018'];
$mip_form['400018']['cms_val_default'] = 'false';

$mip_form['400019']['desc'] = 'Templateset Forum';
$mip_form['400019']['cat'] = 'txt';
$mip_form['400019']['cms_var'] = 'MOD_VAR[400019]';
$mip_form['400019']['cms_val'] = $cms_mod['value']['400019'];
$mip_form['400019']['cms_val_default'] = 'comments';

$mip_form['400020']['desc'] = 'Standardmässig ist das Forum für den Frontenduser sichtbar';
$mip_form['400020']['cat'] = 'option';
$mip_form['400020']['size'] = '1';
$mip_form['400020']['option_desc'][] = 'Nein';
$mip_form['400020']['option_val'][] =  'false';
$mip_form['400020']['option_desc'][] = 'Ja';
$mip_form['400020']['option_val'][] =  'true';
$mip_form['400020']['cms_var'] = 'MOD_VAR[400020]';
$mip_form['400020']['cms_val'] = $cms_mod['value']['400020'];
$mip_form['400020']['cms_val_default'] = 'true';

$mip_form['400021']['desc'] = 'Forumansicht';
$mip_form['400021']['cat'] = 'option';
$mip_form['400021']['size'] = '1';
$mip_form['400021']['option_desc'][] = 'Threadansicht';
$mip_form['400021']['option_val'][] =  'thread';
$mip_form['400021']['option_desc'][] = 'Kommentaransicht';
$mip_form['400021']['option_val'][] =  'comment';
#$mip_form['400021']['option_desc'][] = 'Die aktuellsten Kommentare';
#$mip_form['400021']['option_val'][] =  'latest';
$mip_form['400021']['cms_var'] = 'MOD_VAR[400021]';
$mip_form['400021']['cms_val'] = $cms_mod['value']['400021'];
$mip_form['400021']['cms_val_default'] = 'thread';

$mip_form['400022']['desc'] = 'Forum berücksichtigt Frontendrecht "Darf interaktive Inhalte bearbeiten"';
$mip_form['400022']['cat'] = 'option';
$mip_form['400022']['size'] = '1';
$mip_form['400022']['option_desc'][] = 'Nein';
$mip_form['400022']['option_val'][] =  'false';
$mip_form['400022']['option_desc'][] = 'Ja';
$mip_form['400022']['option_val'][] =  'true';
$mip_form['400022']['cms_var'] = 'MOD_VAR[400022]';
$mip_form['400022']['cms_val'] = $cms_mod['value']['400022'];
$mip_form['400022']['cms_val_default'] = 'false';
          	

$mip_form['400027']['desc'] = 'Wie viele Kommentare anzeigen bei Auswahl "Die aktuellsten Kommentare"';
$mip_form['400027']['cat'] = 'txt';
$mip_form['400027']['cms_var'] = 'MOD_VAR[400027]';
$mip_form['400027']['cms_val'] = $cms_mod['value']['400027'];
$mip_form['400027']['cms_val_default'] = '5';  


// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['21']['desc'] = '<strong>Zeitabschnitt <small>{range}</small></strong>';
$mip_form['21']['cat'] = 'txtarea';
$mip_form['21']['rows'] = '3';
$mip_form['21']['type'] = 'long';
$mip_form['21']['cms_var'] = 'MOD_VAR[21]';
$mip_form['21']['cms_val'] = $cms_mod['value']['21'];
$mip_form['21']['cms_val_default'] = '{link_rangebackward} {range_date_from} - {range_date_to} {link_rangeforward}';


// legend template single entry
$mip_form['90021']['cat'] = 'desc';
$mip_form['90021']['type'] = '';
$mip_form['90021']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {range_time24_from} {range_time24_to} {range_time12_from} {range_time12_to}<br/>
{range_date_from} {range_date_from:day} {range_date_from:month} {range_date_from:year}<br/>{range_date_to} {range_date_to:day} {range_date_to:month} {range_date_to:year}<br/>
{link_rangebackward} {link_rangeforward}</small></div>';


// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['13']['desc'] = '<strong>Navigation Zeitabschnitt - Link "vor" <small>{link_rangeforward}</small></strong>';
$mip_form['13']['cat'] = 'txtarea';
$mip_form['13']['rows'] = '2';
$mip_form['13']['type'] = 'long';
$mip_form['13']['cms_var'] = 'MOD_VAR[13]';
$mip_form['13']['cms_val'] = $cms_mod['value']['13'];
$mip_form['13']['cms_val_default'] = '<a href="{url}">vor</a>';

// Template Listenansicht - Zeile - Keinen Artikel gefunden
$mip_form['14']['desc'] = '<strong>Navigation Zeitabschnitt - Link "zurück" <small>{link_rangebackward}</small></strong>';
$mip_form['14']['cat'] = 'txtarea';
$mip_form['14']['rows'] = '2';
$mip_form['14']['type'] = 'long';
$mip_form['14']['cms_var'] = 'MOD_VAR[14]';
$mip_form['14']['cms_val'] = $cms_mod['value']['14'];
$mip_form['14']['cms_val_default'] = '<a href="{url}">zur&uuml;ck</a>';




// {page_nav_adv}
$mip_form['500000']['desc'] = '<strong>Seitennavigation (erweitert) <small>{page_nav_adv}</small></strong>';
$mip_form['500000']['cat'] = 'txtarea';
$mip_form['500000']['rows'] = '5';
$mip_form['500000']['type'] = 'long';
$mip_form['500000']['cms_var'] = 'MOD_VAR[500000]';
$mip_form['500000']['cms_val'] = $cms_mod['value']['500000'];
$mip_form['500000']['cms_val_default'] = '{first} {previous} {pages} {next} {last} ';

$mip_form['9500000']['cat'] = 'desc';
$mip_form['9500000']['type'] = '';
$mip_form['9500000']['desc'] = '<div style="text-align:right;line-height:130%"><small><strong>Elemente</strong> {first} {previous} {pages} {next} {last}</small></div>';

$mip_form['500010']['desc'] = 'Link "Erste Seite" <small><strong>{first}</strong></small>';
$mip_form['500010']['cat'] = 'txtarea';
$mip_form['500010']['rows'] = '2';
$mip_form['500010']['type'] = 'long';
$mip_form['500010']['cms_var'] = 'MOD_VAR[500010]';
$mip_form['500010']['cms_val'] = $cms_mod['value']['500010'];
$mip_form['500010']['cms_val_default'] = '<a href="{url}">&laquo;</a>';

$mip_form['500015']['desc'] = '<small>Link "Erste Seite (inaktiv)" <strong>{first}</strong></small>';
$mip_form['500015']['cat'] = 'txtarea';
$mip_form['500015']['rows'] = '2';
$mip_form['500015']['type'] = 'long';
$mip_form['500015']['cms_var'] = 'MOD_VAR[500015]';
$mip_form['500015']['cms_val'] = $cms_mod['value']['500015'];
$mip_form['500015']['cms_val_default'] = '';

$mip_form['500020']['desc'] = 'Link "Seite zurück" <small><strong>{previous}</strong></small>';
$mip_form['500020']['cat'] = 'txtarea';
$mip_form['500020']['rows'] = '2';
$mip_form['500020']['type'] = 'long';
$mip_form['500020']['cms_var'] = 'MOD_VAR[500020]';
$mip_form['500020']['cms_val'] = $cms_mod['value']['500020'];
$mip_form['500020']['cms_val_default'] = '<a href="{url}">&lsaquo;</a>';

$mip_form['500025']['desc'] = '<small>Link "Seite zurück (inaktiv)" <strong>{previous}</strong></small>';
$mip_form['500025']['cat'] = 'txtarea';
$mip_form['500025']['rows'] = '2';
$mip_form['500025']['type'] = 'long';
$mip_form['500025']['cms_var'] = 'MOD_VAR[500025]';
$mip_form['500025']['cms_val'] = $cms_mod['value']['500025'];
$mip_form['500025']['cms_val_default'] = '';

$mip_form['500030']['desc'] = 'Link "Seite" <small><strong>{pages}</strong></small>';
$mip_form['500030']['cat'] = 'txtarea';
$mip_form['500030']['rows'] = '2';
$mip_form['500030']['type'] = 'long';
$mip_form['500030']['cms_var'] = 'MOD_VAR[500030]';
$mip_form['500030']['cms_val'] = $cms_mod['value']['500030'];
$mip_form['500030']['cms_val_default'] = '<a href="{url}">{number}</a>';

$mip_form['500035']['desc'] = 'Link "Seite (aktiv)" <small><strong>{pages}</strong></small>';
$mip_form['500035']['cat'] = 'txtarea';
$mip_form['500035']['rows'] = '2';
$mip_form['500035']['type'] = 'long';
$mip_form['500035']['cms_var'] = 'MOD_VAR[500035]';
$mip_form['500035']['cms_val'] = $cms_mod['value']['500035'];
$mip_form['500035']['cms_val_default'] = '<a href="{url}">[{number}]</a>';

$mip_form['500040']['desc'] = 'Link "Seite vor" <small><strong>{next}</strong></small>';
$mip_form['500040']['cat'] = 'txtarea';
$mip_form['500040']['rows'] = '2';
$mip_form['500040']['type'] = 'long';
$mip_form['500040']['cms_var'] = 'MOD_VAR[500040]';
$mip_form['500040']['cms_val'] = $cms_mod['value']['500040'];
$mip_form['500040']['cms_val_default'] = '<a href="{url}">&rsaquo;</a>';

$mip_form['500045']['desc'] = '<small>Link "Seite vor (inaktiv)" <strong>{next}</strong></small>';
$mip_form['500045']['cat'] = 'txtarea';
$mip_form['500045']['rows'] = '2';
$mip_form['500045']['type'] = 'long';
$mip_form['500045']['cms_var'] = 'MOD_VAR[500045]';
$mip_form['500045']['cms_val'] = $cms_mod['value']['500045'];
$mip_form['500045']['cms_val_default'] = '';

$mip_form['500050']['desc'] = 'Link "Letze Seite" <small><strong>{last}</strong></small>';
$mip_form['500050']['cat'] = 'txtarea';
$mip_form['500050']['rows'] = '2';
$mip_form['500050']['type'] = 'long';
$mip_form['500050']['cms_var'] = 'MOD_VAR[500050]';
$mip_form['500050']['cms_val'] = $cms_mod['value']['500050'];
$mip_form['500050']['cms_val_default'] = '<a href="{url}">&raquo;</a>';

$mip_form['500055']['desc'] = '<small>Link "Letze Seite (inaktiv)" <strong>{last}</strong></small>';
$mip_form['500055']['cat'] = 'txtarea';
$mip_form['500055']['rows'] = '2';
$mip_form['500055']['type'] = 'long';
$mip_form['500055']['cms_var'] = 'MOD_VAR[500055]';
$mip_form['500055']['cms_val'] = $cms_mod['value']['500055'];
$mip_form['500055']['cms_val_default'] = '';

$mip_form['500300']['cat'] = 'txt';
$mip_form['500300']['desc'] = '<small>Trennzeichen zwischen den Seiten-Links</small>';
$mip_form['500300']['cms_var'] = 'MOD_VAR[500300]';
$mip_form['500300']['cms_val'] = $cms_mod['value']['500300'];
$mip_form['500300']['cms_val_default'] = '';












$mip_form['hide_in_list_output_mode'] = array(7);	
$mip_form['hide_in_detail_output_mode'] = array(1000000,71,74001,74101,300,301,8,15,10015,16,90039,90040,39,40,41,42,43,44,4010,4011,
																								8,1,80,3,48,2,400,2000,2010,2900,
																								5,90005,17,90017,6,90006,9,
																								18,90018,101,100,103,104,107,199020,108,
																								22,90022,105022,101022,103022,104022,107022,199022,108022,
																								20,90020,105020,101020,103020,104020,107020,199020,108020,
																								19,90019,102019,105019,101019,103019,104019,107019,199019,108019,
																								23,90023,99023,99923,105019,105023,101023,103023,193023,104023,107023,199023,108023,
																								24,90024,105024,101024,103024,104024,107024,110024,120024,130024,140024,
																								30,27,3000,26,90030,90027,31,32,33,34,35,29,36,37,38,30030,30031,30032,
																								25,108025,109025,90025,101025,105025,103025,104025,101026,101026,103026,104026,107025,
																								30000,30001,30002,
																								500000,500010,500020,500030,500040,500050,500015,500025,500035,500045,500055,500300,
																								760,770,90770,771,772,773,90011,21,90021,13,90013,14,780,781,
																								999990,749901);	
$mip_form['hide_comment-plug']	= array(400000,400010,400021,400027,400011,400012,400013,400014,400015,400020,4000,400022,400016,400017,400018,400019,400999);
												
if($cms_mod['value']['72'] == 'detail' && $cms_mod['value']['70'] == 'false'){
   foreach ($mip_form['hide_in_detail_output_mode']  AS $ke=>$va){
     $mip_form[$va]['cat'] = 'hidden';
   }
 }
if($cms_mod['value']['72'] == 'list' && $cms_mod['value']['70'] == 'false'){
   foreach ($mip_form['hide_in_list_output_mode']  AS $ke=>$va){
     $mip_form[$va]['cat'] = 'hidden';
   }
 }
if (!is_dir($cfg_cms['cms_path'].'plugins/comments/localapi/')) {
   foreach ($mip_form['hide_comment-plug']  AS $ke=>$va){
     $mip_form[$va]['cat'] = 'hidden';
   }
 }
if ($cms_mod['value']['70'] == 'true')
 $mip_form['999991']['cat'] = 'hidden';

	mip_formsp($mip_form['0']);//configmode
	
	$mip_form['hide_in_advanced_mode'] = array() ;
	$mip_form['hide_in_standard_mode'] = array_merge(array() , $mip_form['hide_in_advanced_mode'] );
 
//hidden config
if($cms_mod['value']['0'] == 'hidden'){
  foreach($cms_mod['value'] AS $ke=>$va){
    if($ke != '0'){
    ?>
      <input name="MOD_VAR[<?php echo $ke; ?>]" type="hidden" value="<?php echo htmlentities($va,ENT_COMPAT,'UTF-8');?>">
    <?php
     }
  }
}
//simple, advanced and all config (not hidden config)
else if($cms_mod['value']['0'] == '' || $cms_mod['value']['0'] == 'advanced' || $cms_mod['value']['0'] == 'all'){
	
	//if simple mode
	if($cms_mod['value']['0'] == ''){
	   foreach ($mip_form['hide_in_standard_mode']  AS $ke=>$va){

	     $mip_form[$va]['cat'] = 'hidden';
  		 $mip_form[$va]['cms_var'] = 'MOD_VAR[' . $va . ']';
			 $mip_form[$va]['cms_val'] = $cms_mod['value'][$va];		     
	     
	   }
	 }
	
	//if simple mode
	if($cms_mod['value']['0'] == 'advanced'){
	   foreach ($mip_form['hide_in_advanced_mode']  AS $ke=>$va){

	     $mip_form[$va]['cat'] = 'hidden';
  		 $mip_form[$va]['cms_var'] = 'MOD_VAR[' . $va . ']';
			 $mip_form[$va]['cms_val'] = $cms_mod['value'][$va];		  

	   }
	 }

	if($cms_mod['value']['74'] == 'teaser'){
		$mip_form[90017]['cat'] = 'hidden';
		$mip_form[90006]['cat'] = 'hidden';
		$mip_form[17]['cat'] = 'hidden';
		$mip_form[9]['cat'] = 'hidden';
		$mip_form[6]['cat'] = 'hidden';
	}

	if($cms_mod['value']['74'] != 'calendar'){
		$mip_form[999992]['cat'] = 'hidden';
		$mip_form[74201]['cat'] = 'hidden';
		$mip_form[74202]['cat'] = 'hidden';
		$mip_form[74208]['cat'] = 'hidden';
		$mip_form[74206]['cat'] = 'hidden';
		$mip_form[74207]['cat'] = 'hidden';
		$mip_form[74204]['cat'] = 'hidden';
		$mip_form[74205]['cat'] = 'hidden';
		foreach(array(	30,90030,31,32,27,3000,26,90027,33,34,35,29,36,37,38,30030,30031,30032,910030) as $v)
			$mip_form[$v]['cat'] = 'hidden';
		
	}

	if (count($_AS['db_tables'])>1) 
		mip_formsp($mip_form['1000000']);// DB select

	if($cms_mod['value']['74'] == 'teaser' || $cms_mod['value']['70'] == 'true')
		$mip_form['7']['desc'] = '<strong>Detailansicht <small>{content}</small></strong> ';
	 
		mip_forms_tabpane_beginp();
		mip_forms_tabitem_beginp('Ausgabeoptionen');	

		mip_formsp($mip_form['8']); //category
		if (count($mip_form['8']['option_desc'])>1)
			mip_formsp($mip_form['999990']); //br

		mip_formsp($mip_form['73']);
		mip_formsp($mip_form['99999']); //br detail
		mip_formsp($mip_form['70']); 
		mip_formsp($mip_form['71']); 
		mip_formsp($mip_form['72']);
		mip_formsp($mip_form['99999']); //br detai

		mip_formsp($mip_form['74']);
		mip_formsp($mip_form['74208']);
		mip_formsp($mip_form['74201']);
		mip_formsp($mip_form['74202']);
		mip_formsp($mip_form['74206']);
		mip_formsp($mip_form['74207']);
		mip_formsp($mip_form['999992']); //br detai



		mip_formsp($mip_form['74001']);
		mip_formsp($mip_form['74103']);
		mip_formsp($mip_form['74101']);
		mip_formsp($mip_form['74102']);

		mip_formsp($mip_form['99999']); //br
		mip_formsp($mip_form['999991']); //br detail
		
		mip_formsp($mip_form['1']); //Seitenschaltung nach month
		mip_formsp($mip_form['80']); //Seitenschaltung nach month
		mip_formsp($mip_form['3']); //Seitenschaltung nach anzahl
		mip_formsp($mip_form['999990']); //br

		mip_formsp($mip_form['48']);   // Anzahl der Eintraege
		mip_formsp($mip_form['2']); //Seitenschaltung_yn
		mip_formsp($mip_form['999990']); //br
		mip_formsp($mip_form['400']); //sort
		mip_formsp($mip_form['999990']); //br




		mip_forms_tabitem_endp();




		mip_forms_tabitem_beginp('Ausgabe-Templates');	
		mip_formsp($mip_form['5']); //tpl: list->body
		mip_formsp($mip_form['90005']);
		mip_formsp($mip_form['17']); //tpl: list->row
		mip_formsp($mip_form['90017']);
		mip_formsp($mip_form['6']); //tpl: list->row
		mip_formsp($mip_form['90006']);
		mip_formsp($mip_form['9']); //tpl: list->row->no_entry
		mip_formsp($mip_form['999990']); //br
		mip_formsp($mip_form['7']); //tpl: detail
		mip_formsp($mip_form['90007']);
		mip_forms_tabitem_endp();





		mip_forms_tabitem_beginp('Element-Templates 1');
		mip_formsp($mip_form['700']);
		mip_formsp($mip_form['90008']);
		
		mip_formsp($mip_form['720']);
		mip_formsp($mip_form['90009']);
		
		mip_formsp($mip_form['740']);
		mip_formsp($mip_form['90010']);

		mip_formsp($mip_form['750']);
		mip_formsp($mip_form['90016']);		
	
		mip_formsp($mip_form['500000']); //tpl: detail
		mip_formsp($mip_form['9500000']); //tpl: detail
		mip_formsp($mip_form['500010']); //tpl: detail
		mip_formsp($mip_form['500015']); //tpl: detail
		mip_formsp($mip_form['500020']); //tpl: detail
		mip_formsp($mip_form['500025']); //tpl: detail
		mip_formsp($mip_form['500030']); //tpl: detail
		mip_formsp($mip_form['500035']); //tpl: detail
		mip_formsp($mip_form['500300']); //tpl: detail
		mip_formsp($mip_form['500040']); //tpl: detail
		mip_formsp($mip_form['500045']); //tpl: detail
		mip_formsp($mip_form['500050']); //tpl: detail
		mip_formsp($mip_form['500055']); //tpl: detail
		mip_formsp($mip_form['999990']); //br



	
		mip_formsp($mip_form['21']); //tpl: detail
		mip_formsp($mip_form['90021']);		
		mip_formsp($mip_form['13']); //tpl: detail
		mip_formsp($mip_form['90013']);
		mip_formsp($mip_form['14']); //tpl: detail
		mip_formsp($mip_form['90013']);



		mip_formsp($mip_form['18']); //tpl: detail
		mip_formsp($mip_form['90018']);
		mip_formsp($mip_form['101']);
		mip_formsp($mip_form['100']); 
		mip_formsp($mip_form['103']); 
		mip_formsp($mip_form['104']); 
		mip_formsp($mip_form['107']); 
		mip_formsp($mip_form['199020']);
		mip_formsp($mip_form['108']);
		mip_formsp($mip_form['999990']); //br



		mip_formsp($mip_form['19']); //tpl: detail
		mip_formsp($mip_form['90019']);
		mip_formsp($mip_form['102019']); 
		mip_formsp($mip_form['105019']); 
		mip_formsp($mip_form['101019']); 
		mip_formsp($mip_form['103019']); 
		mip_formsp($mip_form['104019']); 
		mip_formsp($mip_form['107019']); 
		mip_formsp($mip_form['199020']); 
		mip_formsp($mip_form['108019']);
		mip_formsp($mip_form['999990']); //br		



		mip_formsp($mip_form['760']);
		mip_formsp($mip_form['90011']);
		mip_formsp($mip_form['770']);
		mip_formsp($mip_form['90770']);
		mip_formsp($mip_form['771']);
		mip_formsp($mip_form['772']);
		mip_formsp($mip_form['773']);
		mip_formsp($mip_form['999990']); //br			
		
		mip_formsp($mip_form['999990']); //br			
		mip_formsp($mip_form['780']); //date_format
		mip_formsp($mip_form['781']); //time_format		


		


		
		mip_forms_tabitem_endp();


		mip_forms_tabitem_beginp('Element-Templates 2');



		mip_formsp($mip_form['23']); //tpl: detail
		mip_formsp($mip_form['90023']);
		mip_formsp($mip_form['99023']);
		mip_formsp($mip_form['99923']);
		mip_formsp($mip_form['105019']); 		
		mip_formsp($mip_form['105023']); 
		mip_formsp($mip_form['101023']); 
		mip_formsp($mip_form['103023']); 
		mip_formsp($mip_form['193023']); 
		mip_formsp($mip_form['104023']); 
		mip_formsp($mip_form['107023']); 
		mip_formsp($mip_form['199023']); 
		mip_formsp($mip_form['108023']);
		mip_formsp($mip_form['999990']); //br		




		mip_formsp($mip_form['25']); //tpl: detail
		mip_formsp($mip_form['90025']);
		mip_formsp($mip_form['108025']);
		mip_formsp($mip_form['109025']);	
			
		mip_formsp($mip_form['105025']); 
		mip_formsp($mip_form['101025']); 
		mip_formsp($mip_form['101026']); 
		mip_formsp($mip_form['103025']); 
		mip_formsp($mip_form['104025']); 
		mip_formsp($mip_form['103026']); 
		mip_formsp($mip_form['104026']); 
		mip_formsp($mip_form['107025']); 
		mip_formsp($mip_form['999990']); //br		
		mip_formsp($mip_form['999990']); //br	
		
		mip_formsp($mip_form['22']); //tpl: detail
		mip_formsp($mip_form['90022']);
		
		mip_formsp($mip_form['105022']); 
		mip_formsp($mip_form['101022']); 
		mip_formsp($mip_form['103022']); 
		mip_formsp($mip_form['104022']); 
		mip_formsp($mip_form['107022']); 
		mip_formsp($mip_form['199022']); 
		mip_formsp($mip_form['108022']);
		mip_formsp($mip_form['999990']); //br		

								
		mip_formsp($mip_form['20']); //tpl: detail
		mip_formsp($mip_form['90020']);
		
		mip_formsp($mip_form['105020']); 
		mip_formsp($mip_form['101020']); 
		mip_formsp($mip_form['103020']); 
		mip_formsp($mip_form['104020']); 
		mip_formsp($mip_form['107020']); 
		mip_formsp($mip_form['199020']); 
		mip_formsp($mip_form['108020']);
		mip_formsp($mip_form['999990']); //br		
		

		mip_formsp($mip_form['24']); //tpl: detail
		mip_formsp($mip_form['90024']);
		 
		mip_formsp($mip_form['105024']); 
		mip_formsp($mip_form['101024']); 
		mip_formsp($mip_form['103024']); 
		mip_formsp($mip_form['104024']); 
		mip_formsp($mip_form['107024']); 
		mip_formsp($mip_form['110024']); 
		mip_formsp($mip_form['120024']); 
		mip_formsp($mip_form['130024']); 
		mip_formsp($mip_form['140024']); 
		mip_formsp($mip_form['999990']); //br			

		foreach(array(30,90030,27,90027,3000,31,26,32,33,34,35,29,36,37,38) as $v)
			mip_formsp($mip_form[$v]);
		mip_formsp($mip_form['999992']); //br detai			

		mip_forms_tabitem_endp();


		mip_forms_tabitem_beginp('Spezielle Einstellungen');	
		// suche
		mip_formsp($mip_form['15']); 
		mip_formsp($mip_form['16']); 

		// navi
		mip_formsp($mip_form['999990']); //br
    mip_formsp($mip_form['90039']);
    mip_formsp($mip_form['40']);   // Navianzahl
    mip_formsp($mip_form['39']);   // Trennzeichen
    mip_formsp($mip_form['41']);   // Trennzeichen
    mip_formsp($mip_form['42']);
    mip_formsp($mip_form['43']);
    mip_formsp($mip_form['44']);
    mip_formsp($mip_form['4010']);
    mip_formsp($mip_form['4011']);
		mip_formsp($mip_form['999990']); //br

		
    mip_formsp($mip_form['90040']);
		mip_formsp($mip_form['10']); //date_format
		mip_formsp($mip_form['10010']); //date_format
		mip_formsp($mip_form['10011']); //date_format
		mip_formsp($mip_form['10012']); //date_format
		mip_formsp($mip_form['10110']); //date_format
		mip_formsp($mip_form['10111']); //date_format
		mip_formsp($mip_form['10112']); //date_format
		mip_formsp($mip_form['10210']); //date_format
		mip_formsp($mip_form['10211']); //date_format
		mip_formsp($mip_form['10212']); //date_format
		mip_formsp($mip_form['90014']);
		mip_formsp($mip_form['11100']); //date_format
		mip_formsp($mip_form['11110']); //date_format
		mip_formsp($mip_form['11111']); //date_format
		mip_formsp($mip_form['11210']); //date_format
		mip_formsp($mip_form['11211']); //date_format
		mip_formsp($mip_form['11']); //time_format
		mip_formsp($mip_form['90015']);
		
		// comments
		mip_formsp($mip_form['400000']);// used lang
		mip_formsp($mip_form['400010']);// used lang
		mip_formsp($mip_form['400021']);// option view thread or comment
#		mip_formsp($mip_form['400027']);// txt Wie viele Kommentare anzeigen bei Auswahl "Die aktuellsten Kommentare"
	  mip_formsp($mip_form['400011']);// admin mail notify yes/no
		mip_formsp($mip_form['400012']);// admin mail notify emailadress
		mip_formsp($mip_form['400013']);// sperre wiedereintrag
		mip_formsp($mip_form['400014']);// groups who are allowed to write topics
		mip_formsp($mip_form['400015']);// allow anonymus postings
		mip_formsp($mip_form['400020']);// option default value modul is active
		mip_formsp($mip_form['400022']);// option modul regard perm "darf interaktive inhalte bearbeiten"
		mip_formsp($mip_form['400016']);// topics per page
		mip_formsp($mip_form['400017']);// langstrings
		mip_formsp($mip_form['400018']);// debug mail
		mip_formsp($mip_form['400019']);// used templateset
		mip_formsp($mip_form['400999']); //br



		mip_formsp($mip_form['910030']);
		mip_formsp($mip_form['74204']);
		mip_formsp($mip_form['74205']);
    mip_formsp($mip_form['30030']);    
    mip_formsp($mip_form['30031']);
    mip_formsp($mip_form['30032']);
		mip_formsp($mip_form['999992']);
			
    mip_formsp($mip_form['2900']);
    mip_formsp($mip_form['2010']);
    mip_formsp($mip_form['2000']);
    
		mip_formsp($mip_form['999990']); //br
		mip_formsp($mip_form['91003']);
		mip_formsp($mip_form['1003']); //chop
		mip_formsp($mip_form['1004']); //chop	
		mip_formsp($mip_form['1005']); //chop	
		mip_formsp($mip_form['99999']); //br

		mip_formsp($mip_form['90500']);
		mip_formsp($mip_form['500']); 
		mip_formsp($mip_form['501']); 
		mip_formsp($mip_form['502']);
		mip_formsp($mip_form['510']); 
		mip_formsp($mip_form['99999']); //br
		

		mip_formsp($mip_form['800']);
		mip_formsp($mip_form['99999']); //br
		
		mip_formsp($mip_form['300']);		
		mip_formsp($mip_form['301']);	
		if (count($mip_form['8']['option_desc'])>1)
			mip_formsp($mip_form['999990']); //br		
		mip_formsp($mip_form['10015']); 



		mip_forms_tabitem_endp();		
		
}


?>
