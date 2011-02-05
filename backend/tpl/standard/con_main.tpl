<!-- Anfang con_main.tpl -->
<div id="main">
<div class="forms" id="formpadd">
<!-- BEGIN FORM_SELECT_ACTIONS -->
  <form name="actionform" method="post" action="{FORM_URL_ACTIONS}">
    <input type="hidden" name="area" value="con" />
    <select name="change_show_tree" size="1" onchange="actionform.submit()">
      <option value="">{LANG_SELECT_ACTIONS}</option><!-- BEGIN SELECT_ACTIONS -->
      <option value="{ACTIONS_VALUE}" {ACTIONS_SELECTED}>{ACTIONS_ENTRY}</option><!-- END SELECT_ACTIONS -->
    </select>
  </form><!-- END FORM_SELECT_ACTIONS --><!-- BEGIN FORM_SELECT_VIEW -->
  <form name="treeform" method="post" action="{FORM_URL_VIEW}">
    <input type="hidden" name="area" value="con" />
    <select name="change_show_tree" size="1" onchange="treeform.submit()">
      <option value="">{LANG_SELECT_VIEW}</option><!-- BEGIN SELECT_FOLDERLIST -->
      <option value="{FOLDERLIST_VALUE}" {FOLDERLIST_SELECTED}>{FOLDERLIST_ENTRY}</option><!-- END SELECT_FOLDERLIST -->
    </select>
  </form><!-- END FORM_SELECT_VIEW --><!-- BEGIN FORM_CHANGE_TO -->
  <form name="changetoform" method="post" action="{FORM_URL_CHANGE_TO}">
    <input type="hidden" name="area" value="con" />
    <select name="sort" size="1" onchange="changetoform.submit()">
      <option value="">{LANG_CHANGE_TO}</option><!-- BEGIN SELECT_CHANGE_TO -->
      <option value="{CHANGE_TO_VALUE}" {CHANGE_TO_SELECTED}>{CHANGE_TO_ENTRY}</option><!-- END SELECT_CHANGE_TO -->
    </select>
  </form><!-- END FORM_CHANGE_TO -->
</div>

<h5>{AREA}</h5>
 <script type="text/javascript" src="tpl/standard/js/popupmenu.js"></script>
    <div id="overDiv" style="position:absolute; visibility:hidden;"></div>
<!-- BEGIN ERRORMESSAGE -->
<p class="errormsg">{ERRORMESSAGE} </p>
<!-- END ERRORMESSAGE -->

  <h3>{LANG_STRUCTURE_AND_SIDE}{BUTTON_EXPAND}{BUTTON_MINIMIZE}<span>{LANG_ACTIONS}</span></h3>
<!-- BEGIN TREE -->
  <ul class="folder">
    <li>{EMPTY_ROW}
    <a href="{LINK_CAT_EXPAND}" class="{CLASS_CAT_EXPAND}" title="{TITLE_CAT_EXPAND}"></a>
    <a href="{LINK_CAT_CONFIG}" title="{TITLE_CAT_CONFIG}">{CAT_NAME}</a>
      <ul class="actions"><!-- BEGIN FOLDER -->
        <li class="file"><a href="{LINK_NEWSIDE}" title="{NAME_NEWSIDE}">{NAME_NEWSIDE}</a></li>
        <li class="mfolder"><a href="{LINK_NEWCAT}" title="{NAME_NEWCAT}">{NAME_NEWCAT}</a></li>
        <li class="clone"><a href="{LINK_COPYCAT}" title="{NAME_COPYCAT}">{NAME_COPYCAT}</a></li>
        <li class="{CLASS_LOCK}"><a href="{LINK_LOCK}" title="{NAME_LOCK}">{NAME_LOCK}</a></li>
        <li class="view"><a href="{LINK_PUBLISH}" title="{NAME_PUBLISH}">{NAME_PUBLISH}</a></li>
        <li class="delete"><a href="{LINK_DELETE}" title="{NAME_DELETE}">{NAME_DELETE}</a></li>
        <li class="previews"><a href="{LINK_PREVIEW}" title="{NAME_PREVIEW}">{NAME_PREVIEW}</a></li><!-- END FOLDER --><!-- BEGIN QUICKFOLDER -->
        {CAT_ACTIONS}<!-- END QUICKFOLDER -->
      </ul>
      <ul class="pages"><!-- BEGIN SIDES -->
        <li class="pg"><a href="{LINK_SIDECONFIG}" title="{NAME_SIDECONFIG}">&#8803;</a>
        <a href="{LINK_SIDENAME}" title="{TITLE_SIDENAME}">{NAME_SIDENAME}</a>{SIDEANCHOR}
          <ul class="actions"><!-- BEGIN Seite -->
            <li class="home"><a href="{LINK_STARTPAGE}" title="{NAME_STARTPAGE}">{NAME_STARTPAGE}</a></li>
            <li class="edit"><a href="{LINK_EDIT}" title="{NAME_EDIT}">{NAME_EDIT}</a></li>
            <li class="clone"><a href="{LINK_COPY}" title="{NAME_COPY}">{NAME_COPY}</a></li>
            <li class="{CLASS_LOCK}"><a href="{LINK_LOCK}" title="{NAME_LOCK}">{NAME_LOCK}</a></li>
            <li class="view"><a href="{LINK_PUBLISH}" title="{NAME_PUBLISH}">{NAME_PUBLISH}</a></li>
            <li class="delete"><a href="{LINK_DELETE}" title="{NAME_DELETE}" onclick="return delete_confirm()">{NAME_DELETE}</a></li>
            <li class="previews"><a href="{LINK_PREVIEW}" title="{NAME_PREVIEW}">{NAME_PREVIEW}</a></li><!-- END Seite --><!-- BEGIN QUICK -->
            {SIDE_ACTIONS}<!-- END QUICK -->
          </ul>
        </li><!-- END SIDES -->  
      </ul>
    </li>
  </ul><!-- END TREE --><!-- BEGIN EMPTY -->{EMPTY_ROW}{LANG_NOCATS}
</div>
<div class="footer">{FOOTER_LICENSE}</div>
</body>
</html>
