/*
 * INFORMATION
 * ---------------------------
 * Owner:     jquery.webspirited.com
 * Developer: Matthew Hailwood
 * ---------------------------
 *
 * CHANGELOG:
 * ---------------------------
 * 1.1
 * Fixed bug 01
 * 1.2
 * Added select option
 * * hidden select so tags may be submitted via normal form.
 * 1.3
 * Fixed bug 02
 * 1.4
 * Fixed bug 03
 * Fixed bug 04
 *
 * ---------------------------
 * Bug Fix Credits:
 * --
 * * Number: 01
 * * Bug:  Clicking autocomplete option does not add it to the array
 * * Name: Ed <tastypopsicle.com>
 * --
 * * Number: 02
 * * Bug: Unable to give select a name
 * * Name: Ed <tastypopsicle.com>
 * --
 * * Number 03
 * * Bug: reference to incorrect variable (tagArray vs tagsArray)
 * * Name: claudio <unknown>
 * --
 * * Number 04
 * * Bug: console.log() left in code
 * * Name: claudio <unknown>
 * --
 * * Number 06
 * * Feature: added fill method
 * * Name: Shawn Wildermuth <wildermuth.com>
 * --
 * * Number 07
 * * Feature: added maxLength and maxTags options
 * * Name: Jeff Shantz <jeffshantz.com>
 */(function(a){a.widget("ui.tagit",{options:{tagSource:[],triggerKeys:["enter","space","comma","tab"],initialTags:[],minLength:1,select:!1,allowNewTags:!0,caseSensitive:!1,highlightOnExistColor:"#0F0",emptySearch:!0,tagsChanged:function(a,b,c){}},_splitAt:/\ |,/g,_existingAtIndex:0,_pasteMetaKeyPressed:!1,_keys:{backspace:[8],enter:[13],space:[32],comma:[44,188],tab:[9]},_create:function(){var b=this;this.tagsArray=[];this.timer=null;this.element.addClass("tagit");this.element.children("li").each(function(){var c=a(this).attr("tagValue");b.options.initialTags.push(c?{label:a(this).text(),value:c}:a(this).text())});b._splitAt=null;a.inArray("space",b.options.triggerKeys)>0&&a.inArray("comma",b.options.triggerKeys)>0?b._splitAt=/\ |,/g:a.inArray("space",b.options.triggerKeys)>0?b._splitAt=/\ /g:a.inArray("comma",b.options.triggerKeys)>0&&(b._splitAt=/,/g);this.element.html('<li class="tagit-new"><input class="tagit-input" type="text" /></li>');this.input=this.element.find(".tagit-input");a(this.element).click(function(c){if(a(c.target).hasClass("tagit-close")){var d=a(c.target).parent();d.remove();var e=d.attr("tagValue");if(e)b._popTag(null,e);else{var f=d.text();b._popTag(f.substr(0,f.length-1))}}else{b.input.focus();b.options.emptySearch&&a(c.target).hasClass("tagit-input")&&b.input.val()==""&&b.input.autocomplete!=undefined&&b.input.autocomplete("search")}});var c=this.options.select;this.options.appendTo=this.element;this.options.source=this.options.tagSource;this.options.select=function(a,c){clearTimeout(b.timer);c.item.label===undefined?b._addTag(c.item.value):b._addTag(c.item.label,c.item.value);return!1};var d=this.input;this.options.focus=function(a,b){if(b.item.label!==undefined&&/^key/.test(a.originalEvent.originalEvent.type)){d.val(b.item.label);d.attr("tagValue",b.item.value);return!1}};this.input.autocomplete(this.options);this.options.select=c;this.input.keydown(function(c){var d=b.element.children(".tagit-choice:last");if(c.which==b._keys.backspace)return b._backspace(d);if(b._isInitKey(c.which)){c.preventDefault();!b.options.allowNewTags||b.options.maxTags!==undefined&&b.tagsArray.length==b.options.maxTags?b.input.val(""):b.options.allowNewTags&&a(this).val().length>=b.options.minLength&&b._addTag(a(this).val())}b.options.maxLength!==undefined&&b.input.val().length==b.options.maxLength&&c.preventDefault();d.hasClass("selected")&&d.removeClass("selected");_pasteMetaKeyPressed=c.metaKey;b.lastKey=c.which});this.input.keyup(function(b){_pasteMetaKeyPressed&&(b.which==91||b.which==86)&&a(this).blur();window.setTimeout(function(){_pasteMetaKeyPressed=b.metaKey},250)});this.input.blur(function(c){b.currentLabel=a(this).val();b.currentValue=a(this).attr("tagValue");b.options.allowNewTags&&(b.timer=setTimeout(function(){b._addTag(b.currentLabel,b.currentValue);b.currentValue="";b.currentLabel=""},400));a(this).val("").removeAttr("tagValue");return!1});String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g,"")};if(this.options.select){this.element.after('<select class="tagit-hiddenSelect" name="'+this.element.attr("name")+'" multiple="multiple"></select>');this.select=this.element.next(".tagit-hiddenSelect")}this._initialTags()},_popSelect:function(a,b){this.select.children('option[value="'+(b===undefined?a:b)+'"]').remove();this.select.change()},_addSelect:function(b,c){var d=a("<option>").attr({selected:"selected",value:c===undefined?b:c}).text(b);this.select.append(d);this.select.change()},_popTag:function(b,c){if(b===undefined){b=this.tagsArray.pop();if(typeof b=="object"){c=b.value;b=b.label}}else{var d;if(c===undefined){d=a.inArray(b,this.tagsArray);d=d==-1?this.tagsArray.length-1:d}else{d=this.tagsArray.length-1;for(var e in this.tagsArray)if(this.tagsArray[e].value==c){d=e;break}}this.tagsArray.splice(d,1)}this.options.select&&this._popSelect(b,c);this.options.tagsChanged&&this.options.tagsChanged(c||b,"popped",null)},_addTag:function(b,c){this.input.val("");if(this._splitAt&&b.search(this._splitAt)>0){var d=b.split(this._splitAt);for(var e=0;e<d.length;e++)this._addTag(d[e],c);return}b=b.replace(/,+$/,"");b=b.trim();if(b=="")return!1;if(this._exists(b,c)){this._highlightExisting();return!1}var f="";f=a('<li class="tagit-choice"'+(c!==undefined?' tagValue="'+c+'"':"")+">"+b+'<a class="tagit-close">x</a></li>');f.insertBefore(this.input.parent());this.input.val("");this.tagsArray.push(c===undefined?{label:b,value:b}:{label:b,value:c});this.options.select&&this._addSelect(b,c);this.options.tagsChanged&&this.options.tagsChanged(b,"added",f);return!0},_exists:function(a,b){if(this.tagsArray.length==0)return!1;if(b===undefined){this._existingAtIndex=0;for(var c in this.tagsArray){var d=typeof this.tagsArray[c]=="string"?this.tagsArray[c]:this.tagsArray[c].label;if(this._lowerIfCaseInsensitive(a)==this._lowerIfCaseInsensitive(d))return!0;this._existingAtIndex++}}else{this._existingAtIndex=0;for(var c in this.tagsArray){if(this._lowerIfCaseInsensitive(b)===this._lowerIfCaseInsensitive(this.tagsArray[c].value))return!0;this._existingAtIndex++}}this._existingAtIndex=-1;return!1},_highlightExisting:function(){if(this.options.highlightOnExistColor===undefined)return;var b=a(a(this.element).children(".tagit-choice")[this._existingAtIndex]);b.stop();var c=b.css("color");b.animate({color:this.options.highlightOnExistColor},100).animate({color:c},800)},_isInitKey:function(b){var c="";for(var d in this._keys)a.inArray(b,this._keys[d])!=-1&&(c=d);return a.inArray(c,this.options.triggerKeys)!=-1?!0:!1},_removeTag:function(){this._popTag();this.element.children(".tagit-choice:last").remove()},_backspace:function(a){if(this.input.val()=="")if(this.lastKey==this._keys.backspace){this._popTag();a.remove();this.lastKey=null}else{a.addClass("selected");this.lastKey=this._keys.backspace}return!0},_initialTags:function(){var b=this,c;this.options.tagsChanged&&(c=this.options.tagsChanged);this.options.tagsChanged=null;this.options.initialTags.length!=0&&a(this.options.initialTags).each(function(a,c){typeof c=="object"?b._addTag(c.label,c.value):b._addTag(c)});this.options.tagsChanged=c},_lowerIfCaseInsensitive:function(a){return a===undefined||typeof a!=typeof "a"?a:this.options.caseSensitive?a:a.toLowerCase()},tags:function(){return this.tagsArray},destroy:function(){a.Widget.prototype.destroy.apply(this,arguments);this.tagsArray=[]},reset:function(){this.element.find(".tagit-choice").remove();this.tagsArray=[];if(this.options.select){this.select.children().remove();this.select.change()}this._initialTags();this.options.tagsChanged&&this.options.tagsChanged(null,"reseted",null)},fill:function(a){this.element.find(".tagit-choice").remove();this.tagsArray=[];a!==undefined&&(this.options.initialTags=a);if(this.options.select){this.select.children().remove();this.select.change()}this._initialTags()},add:function(b,c){b=b.replace(/,+$/,"");if(this._splitAt&&b.search(this._splitAt)>0){var d=b.split(this._splitAt);for(var e=0;e<d.length;e++)this.add(d[e],c);return}b=b.trim();if(b==""||this._exists(b,c))return!1;var f="";f=a('<li class="tagit-choice"'+(c!==undefined?' tagValue="'+c+'"':"")+">"+b+'<a class="tagit-close">x</a></li>');f.insertBefore(this.input.parent());this.tagsArray.push(c===undefined?b:{label:b,value:c});this.options.select&&this._addSelect(b,c);this.options.tagsChanged&&this.options.tagsChanged(b,"added",f);return!0}})})(jQuery);