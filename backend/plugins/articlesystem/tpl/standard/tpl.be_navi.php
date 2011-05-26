<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

$_AS['tpl']['be_navi'] = '
<style type="text/css">
.grey {color:grey}
#main .tab {
	color:#144282;
	font-size:11px !important;
	text-decoration:none;
	margin:0;padding:2px 5px 2px 5px;
	border-top:1px solid white;
	border-left:1px solid white;
	border-right:1px solid white;
}
#main .tab:hover {
	color:#144282;
	font-size:11px !important;
	text-decoration:none;
	margin:0;padding:2px 5px 2px 5px;
	border-top:1px solid white;
	border-left:1px solid white;
	border-right:1px solid white;
}
#main{
padding:0 10px 0 10px;
}

*html #main{
padding:0 0 0 0;
}
*+html #main{
padding:0 0 0 0;
}

img.disabled {
	opacity:0.4;
	-moz-opacity:0.4;
	filter:alpha(opacity=40);
}

img.enabled {
	opacity:1;
	-moz-opacity:1;
	filter:alpha(opacity=100);
}


.entryuser table td{
	border:none;
	margin:0;
	padding:0;
	font-size:10px;
}

td.entryuser select {
	font:10px verdana,helvetica,arial,geneva,sans-serif;
	border:none;
	float:left;
	margin:2px 5px 2px 0;
	border:1px solid #D6D6D6;
}
.thinbuttons{
	margin:0;;
	margin-bottom:1px;
	padding-top:0;
	background-position: 0 -32px ;padding-bottom:0;
	margin-left:10px;
}

td.head{
padding-top:5px !important;
font-size:11px !important;

}
td.head td {
font-size:11px !important;
white-space:nowrap;
}

/* die Buttons unten */
input.sf_smallbuttonAction,
.fileblockactive #rightsmenucoat input.sf_buttonAction{
	background:url(tpl/{sf_skin}/img/bg_button.gif) #F4F7FB repeat-x;
	background-position: 0 -32px ;
	border:1px solid #8E8E8E;
	color:#000000;
	cursor:pointer;
	font:bold 10px verdana,helvetica,arial,geneva,sans-serif;
	margin:0;
	margin-bottom:1px;
	padding:0 10px 0 10px;
	width:auto;
}

.search_input{
	height:12px !important;
	padding:0 !important;
}

*html .search_input{
	height:17px !important;
	padding:0 !important;
	margin-bottom:3px;
}

*+html .search_input{
	height:13px !important;
	margin-bottom:1px;
}

input.sf_smallbuttonActionOver,
.fileblockactive #rightsmenucoat input.sf_buttonActionCancelOver{
	background:url(tpl/{sf_skin}/img/bg_button.gif) #F4F7FB repeat-x;
	border:1px solid #99CC01;
	background-position: 0 -2px ;
	color:#000000;
	cursor:pointer;
	font:bold 10px verdana,helvetica,arial,geneva,sans-serif;
	margin:0;
	margin-bottom:1px;
	
	padding:0 10px 0 10px;
	width:auto;
}
*html input.sf_smallbuttonAction {
	margin-bottom:3px;

}
*html input.sf_smallbuttonActionOver {
	margin-bottom:3px;
}
*html td.entryuser select {
	margin:2px 5px 2px 0;
}


*+html td.entryuser select {
	margin:1px 5px -2px 0 !important;
}


td.entryuser p.zahl{
	display:block !important;
	float:none !important;
	text-align:right;
	margin:4px 0;

}
*html td.entryuser p.zahl{
	margin-top:1px !important;
	margin-bottom:1px !important;
}
*+html td.entryuser p.zahl{
	margin-top:4px !important;
	margin-bottom:3px !important;
}
*+html td.entryuser{
	padding-bottom:2px;
}
td.entryuser img{
	margin-top:2px;
}
.uber{
	background:#fff;
	font:bold 12px verdana,helvetica,arial,geneva,sans-serif;
	vertical-align:middle;
}
.uber{
	border:1px solid #D6D6D6;
	font-size:10px;
	padding:2px 5px;
	text-align:left;
	white-space:nowrap;
}

.uber{
	border:1px solid #D6D6D6;
	padding:2px 5px;
	vertical-align:top;
}
.notxtdeco a {
text-decoration:none;

}
</style>
<div id="main" style="">
  <div class="forms" >
  {links}
  </div>
  <h5>{area} - {subarea}{action}</h5>
';



$_AS['tpl']['navi_link'] = '
<a class="action tab" href="{url}" {css}>{area}</a>
';

?>
