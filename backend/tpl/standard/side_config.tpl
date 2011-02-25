<!-- Anfang side_config.tpl -->
<script type="text/javascript">
<!--
function timemanagement() {
  document.editform.online[2].selected = true;
}
//-->
</script>
<link rel="stylesheet" type="text/css" href="tpl/{SKIN}/css/date.css" />
<div id="main" class="siteconf">
<h3>{AREA_TITLE}</h3>
<!-- BEGIN ERRORMESSAGE -->
<p class="errormsg">{ERRORMESSAGE}</p>
<!-- END ERRORMESSAGE -->
<form name="editform" method="post" action="{FORM_ACTION}">
<input type="hidden" name="action" value="save" />
<input type="hidden" name="idtplconf" value="{IDTPLCONF}" />
<input type="hidden" name="lastmodified" value="{LASTMODIFIED}" />
<input type="hidden" name="author" value="{AUTHOR}" />
<input type="hidden" name="created" value="{CREATED}" />
<input type="hidden" name="idcatside" value="{IDCATSIDE}" />


<fieldset>
  <legend>{CON_SIDECONFIG}</legend>
  <p><label>{SIDE_TITLE_DESC}</label>
    <input type="text" name="title" value="{SIDE_TITLE}" size="30" maxlength="255" />
    {SELECT_LOCK_SIDE}</p>
<!-- BEGIN URL_REWRITE -->
  <label>{SIDE_REWRITE_TITEL}</label>
  <input type="checkbox" name="rewrite_use_automatic" value="1" id="rewrite_use_automatic" {REWRITE_USE_AUTOMATIC_CHECKED}  onclick="if(document.editform.rewrite_use_automatic.checked==true){document.editform.rewrite_url.disabled=true;document.editform.rewrite_url.style.backgroundColor='#cccccc'}else{document.editform.rewrite_url.disabled=false;document.editform.rewrite_url.style.backgroundColor='#ffffff'}" />
  <label for="rewrite_use_automatic">{SIDE_REWRITE_AUTO}</label>
  <input class="w800" type="text" name="rewrite_url" value="{REWRITE_URL}"  {REWRITE_URL_DISABLED} size="90" maxlength="255" />
  {REWRITE_ERROR}
  <label>{SIDE_REWRITE_URL}:</label><a href="{REWRITE_CURRENT_URL}">{REWRITE_CURRENT_URL}</a><!-- END URL_REWRITE -->
<!-- BEGIN USER_RIGHTS -->
<p><label>{SIDE_RIGHTS}</label>
<ul class="rights">
<li>{BACKENDRIGHTS}</li>
<li>{FRONTENDRIGHTS}</li>
</ul>
</p><!-- END USER_RIGHTS -->
<!-- BEGIN TIMER_BLOCK -->
   <label>{VISBILITY_DESC}</label>
   <fieldset>
     <legend>{LANG_SIDE_IS}:</legend>
<!-- BEGIN VISIBILITY_BLOCK --><input type="radio" name="online" value="{VISIBILITY_ZAHL}" id="a{VISIBILITY_ZAHL}" {VISIBILITY_SELECT} />
     <label for="a{VISIBILITY_ZAHL}">{VISIBILITY_NAME}</label>
<!-- END VISIBILITY_BLOCK -->
     <label>{LANG_ONLINE}:</label>
     <input type="date" name="{STARTDATE_NAME}" value="{STARTDATE_VALUE}" size="10" maxlength="10"  onchange="document.editform.online[2].checked=true;" />
     {LANG_ZEIT}
	   <input type="datetime" name="{STARTTIME_NAME}" value="{STARTTIME_VALUE}" size="5" maxlength="5"  onchange="document.editform.online[2].checked=true;" />
     <label>{LANG_OFFLINE}:</label>
     <input type="date" name="{ENDDATE_NAME}" value="{ENDDATE_VALUE}" size="10" maxlength="10"  onchange="document.editform.online[2].checked=true;" />
     {LANG_ZEIT}
	   <input type="datetime" name="{ENDTIME_NAME}" value="{ENDTIME_VALUE}" size="5" maxlength="5"  onchange="document.editform.online[2].checked=true;" />
   </fieldset>
<!-- END TIMER_BLOCK -->
<!-- BEGIN CLONE_AND_NOTICE -->
   <label>{LANG_MOVE_SIDE}:</label>{SELECT_SIDEMOVE}<br>
   <label>{LANG_NOTICES}:</label>
   <textarea name="summary" rows="10" cols="20" class="w800">{SUMMARY}</textarea><br>
<!-- END CLONE_AND_NOTICE -->
<!-- BEGIN NOTICE -->
   <label>{LANG_NOTICES}:</label>
   <textarea name="summary" rows="20" cols="10" style="width:638px">{SUMMARY}</textarea>
   {HIDDEN_CLONES}
<!-- END NOTICE -->
   {BUTTONS_SEITENANGABEN}
 </fieldset>
 <fieldset>
 <!-- BEGIN META -->
   <legend>{LANG_CON_METACONFIG}</legend>
   <p>
     <label>{LANG_META_DESC}</label>
     <textarea class="w800" name="meta_description" rows="2" cols="50">{META_DESC}</textarea>
   </p>
   <p>
     <label>{LANG_META_KEYWORDS}</label>
     <input class="w800" type="text" name="meta_keywords" value="{META_KEYWORDS}" />
   </p>     
   <p>       
     <label>{LANG_META_AUTHOR}</label>
     <input type="text" name="meta_author" style="width:318px" value="{META_AUTHOR}" />
   </p>
   <p>
     <label>{LANG_META_ROBOTS}</label>
    <select name="meta_robots" size="1" style="width:318px">;
<!-- BEGIN META_ROBOTS --><option value="{META_ROBOTS_VALUE}" {META_ROBOTS_SELECT}>{META_ROBOTS_NAME}</option>
<!-- END META_ROBOTS -->
    </select>
   </p>
   <p>
     <label>{LANG_META_REDIRECT}</label>
     <input type="checkbox" name="meta_redirect" value="1" {META_REDIRECT} />
     <input type="text" name="meta_redirect_url" value="{META_REDIRECT_URL}" size="50" maxlength="255" />
  </p>
<!-- END META -->
<!-- END RIGHTS -->
<!-- BEGIN HIDDEN_FIELDS -->{HIDDEN_FIELDS}<!-- END HIDDEN_FIELDS -->
  {BUTTONS_METAANGABEN}
 </fieldset>
 <fieldset>
  {TPL_CONF}
  {BUTTONS_MODULANGABEN}
 </fieldset>
</div>

<div class="footer">{FOOTER_LICENSE}</div>
<script type="text/javascript" src="tpl/{SKIN}/js/dateinput.min.js"></script>
<script type="text/javascript" src="tpl/{SKIN}/js/adds.dateinput.js"></script>
<script>
var i = document.createElement("input");
  i.setAttribute("type", "date");
  if (i.type == "text") {
    $(':date').dateinput({
	lang: '{BACKEND_LANG}',
	format: 'dd.mm.yyyy'
});
  }


</script>
</body>
</html>
