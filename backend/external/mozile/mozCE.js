/* ***** BEGIN LICENSE BLOCK *****
 * Licensed under Version: MPL 1.1/GPL 2.0/LGPL 2.1
 * Full Terms at http://mozile.mozdev.org/license.html
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * The Original Code is Playsophy code (www.playsophy.com).
 *
 * The Initial Developer of the Original Code is Playsophy
 * Portions created by the Initial Developer are Copyright (C) 2002-2003
 * the Initial Developer. All Rights Reserved.
 *
 * Contributor(s):
 *
 * ***** END LICENSE BLOCK ***** */

/* 
 * mozCE V0.52
 * 
 * Mozilla Inline text editing that relies on eDOM, extensions to the standard w3c DOM.
 *
 * This file implements contenteditable/user modify in Mozilla by leverging
 * Mozilla's proprietary Selection object as well as eDOM, a set of browser independent
 * extensions to the w3c DOM for building editors. 
 *
 * POST05:
 * - refactor userModify code as part of "EditableElement" 
 * - IE's "ContentEditable" means that an element is editable whenever its "ContentEditable"
 * setting is true. However, we may change this so that you have to set editing on for a
 * document as a whole before its individual editable sections become editable. This would
 * allow a user to browse an editable document and explicitly choose to edit it or not.
 * - see if can move to using DOM events and away from Window.getSelection() if possible 
 * (effects how generic it can be!)
 * - selection model: word, line etc. Write custom handlers of clicks and use new Range
 * expansion methods
 */

/****************************************************************************************
 *
 * MozUserModify and ContentEditable: allow precise designation of editing scope. This
 * file implements user-modify/contentEditable. The following utilities let the implementation
 * determine scope.
 *
 * - http://www.w3.org/TR/1999/WD-css3-userint-19990916#user-modify
 *
 * POST04
 * - rename to be "mozSelection.js"
 * - remove need to spec ContentEditable as equivalent to mozUserModify: do mapping in
 * style sheet: *[contentEditable="true"] 
 * - to change as part of "editableElement": may also move Selection methods into EditableElement
 * - support for tracking whether changes were made to elements or not ie/ does a user
 * need to save? Should MozCE warn a user to save before exiting the browser? Some of
 * this may go into eDOM itself in enhancements to document or to all elements ie/ changed?
 *
 ****************************************************************************************/

/**
 * Start of "EditableElement": this will move into eDOM once it is fleshed out.
 *
 * POST04: set user-input and user-select properly as a side effect of setting user-modify. 
 * Need to chase to explicit parent of the editable area and check if true
 * Also for contentEditable - make sure set moz user modify and other properties!
 */
Element.prototype.__defineGetter__(
	"mozUserModify",
	function()
	{
		var mozUserModify = document.defaultView.getComputedStyle(this, null).MozUserModify;
		return mozUserModify;
	}
);

/**
 * Does MozUserModify set this element modifiable
 */
Element.prototype.__defineGetter__(
		"mozUserModifiable",
		function()
		{
			// first check user modify!
			var mozUserModify = this.mozUserModify;
			if(mozUserModify == "read-write")
			{
				return true;
			}

			return false;
		}
);

/**
 * mozUserModify and contentEditable both count
 */
Element.prototype.__defineGetter__(
	"userModify",
	function()
	{
		var mozUserModify = this.mozUserModify;
		// special case: allow MS attribute to set modify level
		if(this.isContentEditable)
			return("read-write");
		return mozUserModify;
	}
);

/**
 * If either contentEditable is true or userModify is not read-only then return true. This makes
 * it easy to support a single approach to user modification of elements in a page using either
 * the W3c or Microsoft approaches.
 * 
 * POST04:
 * - consider not supporting contentEditable here
 */
Element.prototype.__defineGetter__(
		"userModifiable",
		function()
		{
			// first check user modify!
			var userModify = this.userModify;
			if(userModify == "read-write")
			{
				return true;
			}

			return false;
		}
);

/*
 * UserModifiableContext means a parent element that is explicitly set to userModifiable. Note that this accounts for
 * different degrees of userModify. If say "writetext" is inside a "write" then context will stop at the writetext
 * element. That is the context for that level of usermodify. 
 */ 
Element.prototype.__defineGetter__(
	"userModifiableContext",
	function()
	{
		// Moz route (userModify) 
		if(this.mozUserModifiable)
		{
			var context = this;
			contextUserModify = this.mozUserModify;
			while(context.parentNode)
			{
				var contextParentUserModify = context.parentNode.mozUserModify;
				if(contextParentUserModify != contextUserModify)
					break;
				context = context.parentNode;
				contextUserModify = contextParentUserModify;
			}
			return context;
		}

		// try IE route
		return this.contentEditableContext;
	}
);

/***************************************************************************************************************
 * New Selection methods to support styling the current selection. Ideally there would be
 * a new object called EditableSelection that specializes Selection and is accessible from
 * Window.
 *
 * POST05:
 * - move away from marked CSSR once edom supports it!
 * - move alot of the content here (the XHTML specific stuff) to eDOMXHTML leaving these methods as just Selection
 * wrappers for Range methods.
 * - redo as document.getEditableSelection() and a new object, EditableSelection.
 ***************************************************************************************************************/

/**
 * POST05
 * - May redefine SelectedInsertionPoint as a specialization of InsertionPoint. It can
 * track changes in Selection.
 * - maintain the insertion point - make it current!
 * - TURN INTO INTERNAL FIELD FOR SELECTION ie/ 
 */
Selection.prototype.insertionPoint = function(collapse)
{
	if(!this.isCollapsed)
	{
		this.ip = null;

		if(collapse) 
			this.collapseToStart();
		else
			this.collapseToEnd();
	}

	var selectedip = null;

	var umc = this.anchorNode.parentElement.userModifiableContext;

	if(umc)
		selectedip = documentCreateInsertionPoint(umc, this.anchorNode, this.anchorOffset);

	// if no current ip or if selected ip differs from current ip then reset current ip
	if(!this.ip || !selectedip || !selectedip.equivalent(this.ip))
	{
		this.ip = selectedip;
	}

	return this.ip;
}

Selection.MOVE_FORWARD_ONE = 0;
Selection.MOVE_BACK_ONE = 1;
Selection.MOVE_UP_ONE = 2;
Selection.MOVE_DOWN_ONE = 3;
Selection.MOVE_START_TOP = 4;
Selection.MOVE_END_TOP = 5;
Selection.MOVE_START_LINE = 6;
Selection.MOVE_END_LINE = 7;

Selection.prototype.moveInsertionPoint = function(moveOption)
{
	var ip = this.insertionPoint(true);

	if(!ip)
		return false;

	switch(moveOption)
	{
		case Selection.MOVE_FORWARD_ONE:
			ip.forwardOne();
			break;

		case Selection.MOVE_BACK_ONE:
			ip.backOne();
			break;

		case Selection.MOVE_UP_ONE:
			ip.upOne();
			break;

		case Selection.MOVE_DOWN_ONE:
			ip.downOne();
			break;

		case Selection.MOVE_TO_LINE_START:
			ip.toLineStart();
			break;

		case Selection.MOVE_TO_LINE_END:
			ip.toLineEnd();
			break;

		case Selection.MOVE_TO_TOP_START:
			ip.toTopStart();
			break;

		case Selection.MOVE_TO_TOP_END:
			ip.toTopEnd();
			break;

		default: // no op for now - may become exception
			return false;
	}

	this.collapse(ip.ipNode, ip.ipOffset);
	
	return true;		
}

Selection.prototype.insertCharacter = function(charCode)
{
	var cssr = this.getEditableRange(false);
	if(!cssr)
		return false;

	// if there's a selection then delete it
	if(!cssr.collapsed)
		cssr.extractContentsByCSS();

	// seems to mess up the current position!
	var ip = documentCreateInsertionPoint(cssr.top, cssr.startContainer, cssr.startOffset);
			
	ip.insertCharacter(charCode);
	
	this.collapse(ip.ipNode, ip.ipOffset);

	return true;
}

/**
 * "Delete" for selected XHTML represents three behaviors:
 * - if range isn't collapsed then delete contents of the range - treat table contents properly (see code for behavior)
 * - if range is collapsed
 *   - if at start of line then merge line with previous line if there is one and this is appropriate
 *   - otherwise delete character or element before the selected point in the line
 *
 * Note: this is an XHTML compliant deletion. It is driven solely by CSS settings. This works for XHTML selections but
 * it is unlikely to work for semantically rich and restrictive XML. Deletion of an XML document would have to pay 
 * attention to that document's semantics.
 */
Selection.prototype.deleteSelection = function()
{
	// delete in place ...
	if(this.isCollapsed)
	{
		var ip = this.insertionPoint(true);

		if(!ip)
			return false;

		var result = ip.deletePreviousInLine();

		if(!result)
		{
			var line = ip.line;
			ip = line.deleteStructure();
		}

		this.collapse(ip.ipNode, ip.ipOffset);
		return true;
	}

	// delete selection
	var cssr = this.getEditableRange(false);

	if(!cssr)
		return false;

	cssr.extractContentsByCSS();

	this.removeAllRanges();
	this.addRange(cssr.cloneRange());

	return true;
}

/**
 * Splits XHTML container of contained lines; applies a contained line if in a bounded
 * line; if inlineBreak, uses "BR"s; also use "BRs" if in a line formed from a BR.
 * 
 * POST05: this method will turn a new line, if any, into a paragraph element
 */
Selection.prototype.splitXHTMLLine = function(inlineBreak)
{
	var cssr = this.getEditableRange(false);
	if(!cssr)
		return false;

	if(!cssr.collapsed)
	{ // POST04: delete text when write over it!	
		cssr.collapse(true);
	}

	this.removeAllRanges();
	ip = documentCreateInsertionPoint(cssr.top, cssr.startContainer, cssr.startOffset);

	if(inlineBreak)
	{
		ip.insertNode(documentCreateXHTMLElement("br"));
		// if originally at end of line then BR may lead to an empty line that Mozilla
		// can't select within. It needs to be set to a token line!
		var line = ip.line;
		if(line.emptyLine)
			ip.set(line.setToTokenLine());
	}
	else
		ip.splitXHTMLLine(); 

	ip.toTextReference();

	cssr.selectInsertionPoint(ip);
	this.removeAllRanges();
	this.addRange(cssr);
		
	return true;
}

/**
 * POST05: change so defaultValue doesn't have to be passed in; think about toggling whole line if selection collapsed
 */
Selection.prototype.toggleTextStyle = function(styleName, styleValue, defaultValue)
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	if(cssr.hasStyle(styleName, styleValue))
		cssr.styleText(styleName, defaultValue);
	else
		cssr.styleText(styleName, styleValue);

	this.selectEditableRange(cssr);
}

/**
 * POST05: think about toggling whole line if selection collapsed
 */
Selection.prototype.styleText = function(styleName, styleValue)
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	cssr.styleText(styleName, styleValue);

	this.selectEditableRange(cssr);
}

Selection.prototype.linkText = function(href)
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	cssr.linkText(href);

	this.selectEditableRange(cssr);
}

Selection.prototype.clearTextLinks = function()
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	cssr.clearTextLinks();

	this.selectEditableRange(cssr);
}

/**
 * This will only style contained lines
 */
Selection.prototype.styleLines = function(styleName, styleValue)
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	var lines = cssr.lines;	

	for(var i=0; i<lines.length; i++)
	{
		// turn bounded line into contained line or put in container for top line
		if((lines[i].lineType == CSSLine.BOUNDED_LINE) || lines[i].topLine)
		{
			// special case: empty bounded line - don't try to style this!
			if(lines[i].emptyLine)
				continue;
			lines[i] = lines[i].setContainer(documentCreateXHTMLElement(defaultContainerName), false);
		}

		lines[i].setStyle(styleName, styleValue);
	}

	this.selectEditableRange(cssr);
}

/**
 * POST05: a/c for "BR" means don't apply container directly. Promote line and nix the BR. 
 * Promotion means moving a line outside of its parent (table el => make div and promote 
 * outside of it)
 */
Selection.prototype.changeLinesContainer = function(containerName)
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	var lines = cssr.lines;
	for(var i=0; i<lines.length; i++)
	{ 
		// keep container if it is a contained line but not a block:
		// - it is top
		// - it is a table cell
		// - it is a list item
		var keep = ((lines[i].lineType == CSSLine.CONTAINED_LINE) && (lines[i].containedLineType != ContainedLine.BLOCK));
		lines[i].setContainer(documentCreateXHTMLElement(containerName), !keep);
	}

	this.selectEditableRange(cssr);
}

Selection.prototype.removeLinesContainer = function()
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	var lines = cssr.lines;
	for(var i=0; i<lines.length; i++)
	{
		if((lines[i].lineType == CSSLine.CONTAINED_LINE) && !lines[i].topLine) // as long as contained line and container isn't top then remove it
			lines[i].removeContainer();
	}

	this.selectEditableRange(cssr);
}

Selection.prototype.indentLines = function()
{	
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	indentLines(cssr);	

	this.selectEditableRange(cssr);
}

Selection.prototype.outdentLines = function()
{	
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	outdentLines(cssr);	

	this.selectEditableRange(cssr);
}

Selection.prototype.toggleListLines = function(requestedList, alternateList)
{	
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return;

	listLinesToggle(cssr, requestedList, alternateList);

	this.selectEditableRange(cssr);
}

Selection.prototype.insertNode = function(node)
{
	var cssr = this.getEditableRange(true);

	if(!cssr)
		return false;

	var ip = cssr.firstInsertionPoint;

	ip.insertNode(node);

	cssr.selectInsertionPoint(ip);

	cssr.__clearTextBoundaries(); // POST05: don't want to have to use this

	this.selectEditableRange(cssr);

	return true;
}

/**
 * POST05: paste more than text
 */
Selection.prototype.paste = function()
{
	var cssr = this.getEditableRange(false);

	if(!cssr) // not an editable area
		return false;

	var clipboard = mozilla.getClipboard();

	// only get text for now: POST04: need XHTML validator first so that correct
	// HTML comes first.
	var text = clipboard.getData(MozClipboard.TEXT_FLAVOR);
	if(text)
		return window.getSelection().insertNode(document.createTextNode(text));

	return true;
}

Selection.prototype.copy = function()
{
	var cssr = this.getEditableRange(false);

	if(!cssr || cssr.collapsed) // not an editable area or nothing selected
		return false;

	// data to save - render as text (temporary thing - move to html later)
	var text = cssr.toString();

	var clipboard = mozilla.getClipboard();

	// clipboard.setData(deletedFragment.saveXML(), "text/html"); // go back to this once, paste supports html paste!
	clipboard.setData(text, MozClipboard.TEXT_FLAVOR);

	return true;
}

Selection.prototype.cut = function()
{
	var cssr = this.getEditableRange(false);

	if(!cssr || cssr.collapsed) // not an editable area or nothing selected
		return false;

	var clipboard = mozilla.getClipboard();

	// data to save - render as text (temporary thing)
	var text = cssr.toString();

	var deletedFragment = cssr.extractContentsByCSS();

	// clipboard.setData(deletedFragment.saveXML(), MozClipboard.HTML_FLAVOR); // go back to this once, paste supports html paste!
	clipboard.setData(text, MozClipboard.TEXT_FLAVOR);

	this.removeAllRanges();
	this.addRange(cssr);

	return true;
}

/*
 * Shorthand way to get CSS Range for the current selection. This range will be marked
 * ie/ it can easily be restored.
 *
 * POST05: 
 * - consider not calculating textpointers here (createCSSTextRange) but only within the
 *   editing functions in eDOM where the context can be given more precisely.
 * - allow text selection to only begin and end on word boundaries (part of CSSTextRange 
 * selection methods)
 * - account for empty editable area (maybe in isContentEditable); account for selection
 * type ie/ element or object or text.
 */
Selection.prototype.getEditableRange = function(mark)
{	
	try 
	{
		var selr = window.getSelection().getRangeAt(0);
		var commonAncestor = selr.commonAncestorContainer;

		if(!commonAncestor.parentElement.userModifiable)
			return null;

		var cec = commonAncestor.parentElement.userModifiableContext;

		var cssr = __createCSSRange(selr.cloneRange(), cec, mark); 

		return cssr;
	}
	catch(e)
	{
		return null;
	}
}

/*
 * Restore the range
 */
Selection.prototype.selectEditableRange = function(cssr)
{
	cssr.__restoreTextBoundaries(); // POST04: required cause of line manip that effects range but makes rest more complex
	var rng = document.createRange();
	this.removeAllRanges();
	this.addRange(cssr.cloneRange());	
}