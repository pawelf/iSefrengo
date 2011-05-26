<!-- Anfang filelist.tpl -->
<div id="main">
<div class="forms">
		{SUB_NAV_RIGHT}{QNAV}
</div>
		<h5>{AREA_TITLE}</h5>
<!-- BEGIN RULESERROR -->
  <p class="errormsg">{CONTENT}</p>
<!-- END RULESERROR -->
<!-- BEGIN ERROR -->
  <p class="errormsg">{ERR_MSG} {CSS_WARN}</p>
<!-- END ERROR -->
<!-- BEGIN OK -->
<p class="ok">{OKMESSAGE}</p>
<!-- END OK -->
<h3>{FILENAME}{DESCRIPTION}<span>{ACTIONS}</span></h3>
 <fieldset>
<ul class="pages">		
<!-- BEGIN ENTRY -->

{ROWEDIT}
<li class="pg">
{ENTRY_SHOWDETAIL}

{ENTRY_ICON} {ENTRY_NAME} {ENTRY_DELETE}
{ENTRY_DESCRIPTION}{ENTRY_SPECIAL} {ENTRY_SCAN} 
{ENTRY_DOWNLOAD} {ENTRY_NEW} {ENTRY_DUPLICATE} {ENTRY_IMEXPORT} 
{ENTRY_EDIT} {ENTRY_DELBUT}
<ul class="actions">
<li class="detail"><a href="">Ansicht</a></li>
<li class="dir"><a href="">abgleichen</a></li>
<li class="mfolder"><a href="{LINK_NEWCAT}" title="{NAME_NEWCAT}">erstellen</a></li>
</ul>
</li>
				{ROWEDITEND}

<!-- END ENTRY -->

<!-- BEGIN DETAIL -->
				{DETAILROWEDIT}
2

					<td class="entry nowrap" {DETAIL_STYLE}>{DETAIL_ICON} {DETAIL_NAME}{DETAIL_DELETE}</td>
					<td class="entry">{DETAIL_DESCRIPTION}{DETAIL_EDITSCRIPT}</td>
					<td class="entry buttons">{DETAIL_DOWNLOAD}{DETAIL_DUPLICATE}{DETAIL_EXIMPORT}{DETAIL_MOVE}{DETAIL_EDIT}{DETAIL_DELBUT}</td>
				{DETAILROWEDITEND}
<!-- END DETAIL -->
<!-- BEGIN DETAILFM -->
3
					<td class="entry"{DETAILFM_STYLE}></td>
					<td class="entry"{DETAILFM_STYLE} colspan="2">
<!-- END DETAILFM -->
<!-- BEGIN DETAILFM1 -->
				<div class="{DETAILFM1BLOCKEDIT}">
					{DETAILFM1ROWEDIT}
					<div class="filedisplay">{DETAILFM1ACTIVE}{DETAILFM1_NAMESTART}<img src="{DETAILFM1_PICTSRC}" width="{DETAILFM1_PICTWIDTH}" height="{DETAILFM1_PICTHEIGHT}" alt="" />{DETAILFM1_NAMEEND}</div>
					<div class="filedetails">{DETAILFM1_DESCRIPTION}</div>{DETAILFM1_EDITSCRIPT}
					<div class="fileedit"><strong>{DETAILFM1_NAME}</strong>{DETAILFM1_AKTIONEN}{DETAILFM1_FILESIZE}</div>
					{DETAILFM1ROWEDITEND}
				</div>
<!-- END DETAILFM1 -->
<!-- BEGIN DETAILFM2 -->
					{DETAILFM2_FAKE}</td>
				</tr>
<!-- END DETAILFM2 -->
<!-- BEGIN NODETAIL -->
				<tr>
					<td class="entry" colspan="2">{CONTENT}<td>
				</tr>
<!-- END NODETAIL -->

<!-- BEGIN PASTENTRY -->
{ROWEDIT}
<li class="pg">
 <label>{ENTRY_SHOWDETAIL} {ENTRY_ICON} {ENTRY_NAME} {ENTRY_DELETE}</label>
 {ENTRY_DESCRIPTION}
 {ENTRY_SCAN} {ENTRY_DOWNLOAD} {ENTRY_NEW} {ENTRY_DUPLICATE} {ENTRY_IMEXPORT} {ENTRY_EDIT} {ENTRY_DELBUT}
  <ul class="actions">
<li class="dir"><a href="{LINK_DIR}" title="{NAME_DIR}">abgleichen</a></li>
<li class="mfolder"><a href="{LINK_FOLDER}" title="{NAME_FOLDER}">erstellen</a></li>
<li class="edit"><a href="{LINK_EDIT}" title="{NAME_EDIT}">bearbeiten</a></li>
<li class="delete"><a href="{LINK_DELETE}" title="{NAME_DELETE}" onclick="return delete_confirm()">löschen</a></li>
</ul>
</li>
{ROWEDITEND}

<!-- END PASTENTRY -->
<!-- BEGIN FILEIMPORT -->
1
				<tr>
					<td class="content7 nowrap" align="right">
						{FILEIMPORT_TEXT}
					</td>
					<td class="content7 nowrap" align="center">
				<form name="fileuploads" action="{FILEIMPORT_ACTION}" method="post" enctype="multipart/form-data">
		  			<input type="hidden" name="area" value="{FILEIMPORT_TYPE}" />
		  			<input type="hidden" name="action" value="{FILEIMPORT_FUNC}" />
		  			<input type="hidden" name="path" value="{FILEIMPORT_DIR}" />
		  			<input type="hidden" name="idclient" value="{FILEIMPORT_CLIENT}" />
						<input class="uplinput" name="{FILEIMPORT_NAME}" type="file" size="16" />
					</td>
					<td class="content7 buttons">
						<input type="image" src="{FILEIMPORT_PICT}" alt="{FILEIMPORT_HINT}" title="{FILEIMPORT_HINT}" />
				</form>
					</td>
					{FILEIMPORTSCRIPT_CALL}

				</tr>
<!-- END FILEIMPORT -->
<!-- BEGIN FILEIMPORTBULK -->
</ul><p>
				<form name="fileuploads" action="{FILEIMPORTTRIPLE_ACTION}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="action" value="{FILEIMPORTTRIPLE_FUNC}" />
					<input type="hidden" name="idclient" value="{FILEIMPORTTRIPLE_CLIENT}" />
<label>{FILEIMPORTTRIPLE_TEXT}</label>

						<input class="uplinput" name="{FILEIMPORTTRIPLE_NAME}" type="file" size="13" />

						<label for="iddirectory">{FILEIMPORTTRIPLE_TO}</label>
						<select class="upldirsel" name="iddirectory" id="iddirectory">{FILEIMPORTTRIPLE_DIRECTORY}</select>

						<input type="image" src="{FILEIMPORTTRIPLE_PICT}" alt="{FILEIMPORTTRIPLE_HINT}" title="{FILEIMPORTTRIPLE_HINT}" />

					{FILEIMPORTSCRIPT_CALL}
				</form>
</p>
<!-- END FILEIMPORTBULK -->


</div>
<div id="overDiv" style="position:absolute; visibility:hidden;"></div>
<div id="popmenu" name="popmenu" onmouseover="clearhidemenu();highlightmenu(event,'on')" onmouseout="highlightmenu(event,'off');dynamichide(event)"></div>
<script type="text/javascript" src="tpl/standard/js/popupmenu.js"></script>
{JSTEXT}
<div class="footer">{FOOTER_LICENSE}</div>
</body>
</html>
