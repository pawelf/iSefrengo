<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['calendar']['head'] = '<table class="calendar">
<tr>
<td align="center" valign="top">{month_prev}</td>
<td align="center" valign="top" class="calendarHeader" colspan="5">{month}</td> 
<td align="center" valign="top">{month_next}</td>
</tr>
<tr>
<td align="center" valign="top" class="calendarHeader">{dayname_1}</td>
<td align="center" valign="top" class="calendarHeader">{dayname_2}</td>
<td align="center" valign="top" class="calendarHeader">{dayname_3}</td>
<td align="center" valign="top" class="calendarHeader">{dayname_4}</td>
<td align="center" valign="top" class="calendarHeader">{dayname_5}</td>
<td align="center" valign="top" class="calendarHeader">{dayname_6}</td>
<td align="center" valign="top" class="calendarHeader">{dayname_7}</td>
</tr>
';


$_AS['tpl']['calendar']['mprev']			= '<a href="{link}">&lt;&lt;</a>';
$_AS['tpl']['calendar']['month'] 			= '<a href="{link}">{month}</a>';
$_AS['tpl']['calendar']['mnext'] 			= '<a href="{link}">&gt;&gt;</a>';

$_AS['tpl']['calendar']['day'] 				= '<td align="center" valign="top" style="background:#aaa">{day}</td>';
$_AS['tpl']['calendar']['day_sel'] 		= '<td align="center" valign="top" style="background:#600">{day}</td>';
$_AS['tpl']['calendar']['day_today'] 	= '<td align="center" valign="top" style="background:#fff">{day}</td>';
$_AS['tpl']['calendar']['day_sun'] 		= '<td align="center" valign="top" style="background:#444">{day}</td>';

?>
