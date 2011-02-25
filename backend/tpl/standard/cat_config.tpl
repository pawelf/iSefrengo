<!-- Anfang cat_config.tpl -->
<div id="main" class="siteconf">
<h3>{AREA_TITLE}</h3>
<!-- BEGIN ERRORMESSAGE -->
<p class="errormsg">{ERRORMESSAGE}</p>
<!-- END ERRORMESSAGE -->
<form name="editform" method="post" action="{FORM_ACTION}">
<input type="hidden" name="action" value="save" />
<input type="hidden" name="idtplconf" value="{IDTPLCONF}" />
<input type=hidden name="idcat" value="{IDCAT}" />
<input type=hidden name="parent" value="{PARENT}" />

<fieldset>
  <legend>{CON_CONCONFIG}</legend>
  <p><label>{CON_TITLE_DESC}</label>
    <input type="text" name="title" value="{SIDE_TITLE}" size="30" maxlength="255" />
  </p>
  <p>
<!-- BEGIN URL_REWRITE -->
  <label>{CAT_REWRITE_TITEL}</label>
  <input type="checkbox" name="rewrite_use_automatic" value="1" id="rewrite_use_automatic" {REWRITE_USE_AUTOMATIC_CHECKED}  onclick="if(document.editform.rewrite_use_automatic.checked==true){document.editform.rewrite_alias.disabled=true;document.editform.rewrite_alias.style.backgroundColor='#cccccc'}else{document.editform.rewrite_alias.disabled=false;document.editform.rewrite_alias.style.backgroundColor='#ffffff'}" />
  <label for="rewrite_use_automatic">{CAT_REWRITE_AUTO}</label>
  <input class="w800" type="text" name="rewrite_alias" value="{REWRITE_URL}"  {REWRITE_URL_DISABLED} size="90" maxlength="255" />	
  {REWRITE_ERROR}
  <label>{CAT_REWRITE_URL}:</label><a href="{REWRITE_CURRENT_URL}">{REWRITE_CURRENT_URL}</a>
  </p>
<!-- END URL_REWRITE -->
  <p><label>{CON_CATCONFIG_LANG}</label>
  <textarea class="w800" name="description" rows="3" cols="52">{CON_CATCONFIG_DESC}</textarea>
 </p>
  <!-- BEGIN USER_RIGHTS -->
  <p><label>{SIDE_RIGHTS}</label>
     {BACKENDRIGHTS}{FRONTENDRIGHTS}</p><!-- END USER_RIGHTS --> 
   {BUTTONS_ORDNERANGABEN}
 </fieldset>
 <fieldset>
  {TPL_CONF}
  {BUTTONS_MODULANGABEN}
 </fieldset>
</div>
<div class="footer">{FOOTER_LICENSE}</div>
</body>
</html>
