/* jqKeyboard | v1.0.1 | https://github.com/hAWKdv/jqKeyboard#readme | MIT */
var jqKeyboard=jqKeyboard||{};!function(t,e){"use strict";var a='input[type="text"], textarea, input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="email"], input[type="password"], input[type="search"], input[type="month"], inpu[type="url"], input[type="time"], input[type="tel"], input[type="week"], input[type="number"]',n="normal",i="shift-b",s="special",o="jqk-btn",c="jqk-lang-btn",l="selected",r="clicked",d="minimize-btn",u="jqk-toggle-btn",h="btn-row",g="jqk-hide",p="dark",f="jq-keyboard",v="jqk-lang-cont",m="-lang",C=0,L=3,b={},$={},S={},k={},y={};S={insertCharacter:function(t,e,a){return t.slice(0,e.start)+a+t.slice(e.end)},backspaceStrManipulation:function(t,e,a){return 0===e.start&&0===e.end?t:t.slice(0,e.start-a)+t.slice(e.end)},getSelectedLangClass:function(){return"."+y.selectedLanguage+m},setCaretPosition:function(t,e){var a;null!==t&&(t.createTextRange?(a=t.createTextRange(),a.move("character",e),a.select()):t.selectionStart?(t.focus(),t.setSelectionRange(e,e)):t.focus())}};var b={$$createBase:function(){var t,a,n=e("body");this.$base=e("<div>").attr("id",f),this.$langCont=e("<div>").attr("id",v),this.$minBtn=e("<div>").addClass(d).prop("title","Minimize"),this.$toggleBtn=e("<div>").attr("id",u),y.options&&"dark"===y.options.icon&&this.$toggleBtn.addClass(p),this.$langCont.append(this.$minBtn),this.$base.append(this.$langCont),n.append(this.$toggleBtn),this.createLayout(),y.options&&y.options.containment?(this.containment=e(y.options.containment),this.containment.append(this.$base)):(n.append(this.$base),t=e(window).outerWidth()-this.$base.outerWidth(),a=e(window).outerHeight()-this.$base.outerHeight(),this.containment=[C,C,t,a],this.maintainContainment())},maintainContainment:function(){var t;e(window).resize(function(){clearTimeout(t),t=setTimeout(function(){var t=e(window).outerWidth()-b.$base.outerWidth(),a=e(window).outerHeight()-b.$base.outerHeight(),n=[C,C,t,a];b.$base.draggable("option","containment",n)},100)})},createLayout:function(){var e,a,n,i=t.layouts.length;for(n=0;i>n&&L>n;n+=1)a=t.layouts[n],e=this.createButtons(a,n),this.createLangSwitchBtn(a.lang,n),this.$base.append(e)},createButtons:function(t,a){var n,i,s,o,c,l=e("<div>").addClass(t.lang+m);for(a>0&&l.addClass(g),o=0;o<t.layout.length;o+=1){for(n=e("<div>").addClass(h),s=t.layout[o].split(" "),c=0;c<s.length;c+=1)i=this.buildButtonFromString(s[c]),n.append(i);l.append(n)}return l},buildButtonFromString:function(t){var a=e("<button>").addClass(o);return 1===t.length?a.addClass(n).data("val",t).html(t):3===t.length?a.addClass(i).data("val",t[0]).data("shift",t[2]).data("normal",t[0]).html(t[0]):-1!==t.indexOf("<<")&&-1!==t.indexOf(">>")&&(a=this.createSpecialBtn(a,t)),a},createSpecialBtn:function(t,e){var a=e.replace("<<","").replace(">>","");switch(a){case"space":t.data("val"," ");break;case"tab":t.data("val","	");break;case"enter":t.data("val","\n")}return t.addClass(s+" "+a).html("&nbsp;"),t},createLangSwitchBtn:function(t,a){var n=e("<button>").addClass(c).data("lang",t).html(t.toUpperCase());0===a&&(n.addClass(l),y.selectedLanguage=t),this.$langCont.append(n)}},$={SHIFT_CLASS:"."+s+".shift",CPSLCK_CLASS:"."+s+".capslock",areLangEventsLoaded:{},loadLanguageSwitcher:function(){e("."+c).on("click",function(){var t=e(this),a=t.data("lang"),n="."+a+m,i=S.getSelectedLangClass();$._resetCaretOfActiveElem(),i!==n&&(e(i).addClass(g),e(n).removeClass(g),e("."+c+"."+l).removeClass(l),t.addClass(l),y.selectedLanguage=a,$.areLangEventsLoaded[y.selectedLanguage]||($.loadCapsLockEvent(),$.loadShiftEvent(),$.areLangEventsLoaded[y.selectedLanguage]=!0))})},loadCapsLockEvent:function(){var t=S.getSelectedLangClass();this._onLocalButtonClick($.CPSLCK_CLASS,function(){var a,n;$._resetCaretOfActiveElem(),y.shift[y.selectedLanguage]||(a=e(this),n=a.closest(t),y.capsLock[y.selectedLanguage]?(a.removeClass(l),y.capsLock[y.selectedLanguage]=!1):(a.addClass(l),y.capsLock[y.selectedLanguage]=!0),$._traverseLetterButtons(n,y.capsLock[y.selectedLanguage]))})},loadShiftEvent:function(){var t=S.getSelectedLangClass();this._onLocalButtonClick($.SHIFT_CLASS,function(){var a,n=e(t),i=n.find($.SHIFT_CLASS),s=n.find($.CPSLCK_CLASS);return $._resetCaretOfActiveElem(),y.shift[y.selectedLanguage]?void $._unshift():(y.capsLock[y.selectedLanguage]&&(s.removeClass(l),y.capsLock[y.selectedLanguage]=!1),a=e(this).closest(t),$._traverseInputButtons(a,!0,"shift"),y.shift[y.selectedLanguage]=!0,void i.addClass(l))})},loadBackspaceEvent:function(){e("."+s+".backspace").on("click",function(){$._onActiveElemTextManipulation(function(t,e){var a;return a=t.start===t.end?1:0,{updatedContent:S.backspaceStrManipulation(e,t,a),caretOffset:-a}})})},loadInputButtonEvent:function(){b.$base.find("."+n).add("."+i).add("."+s+".space").add("."+s+".tab").add("."+s+".enter").on("click",function(){var t=e(this).data("val");$._onActiveElemTextManipulation(function(e,a){return{updatedContent:S.insertCharacter(a,e,t),caretOffset:1}}),y.shift[y.selectedLanguage]&&$._unshift()})},activeElementListener:function(){var t;t=y.options&&y.options.allowed?y.options.allowed.join(", "):a,e(t).focus(function(){$.$activeElement=e(this)})},_onActiveElemTextManipulation:function(t){var e,a,n,i;$.$activeElement&&(a=$.$activeElement.val()||"",e=$.$activeElement[0],i={start:e.selectionStart,end:e.selectionEnd},n=t(i,a),$.$activeElement.val(n.updatedContent),S.setCaretPosition(e,i.start+n.caretOffset))},_resetCaretOfActiveElem:function(){this.$activeElement&&S.setCaretPosition(this.$activeElement[0],this.$activeElement[0].selectionStart)},_unshift:function(){var t=S.getSelectedLangClass(),a=e(S.getSelectedLangClass()).find($.SHIFT_CLASS),n=a.closest(t);this._traverseInputButtons(n,!1,"normal"),y.shift[y.selectedLanguage]=!1,a.removeClass(l)},_onLocalButtonClick:function(t,e){b.$base.find(S.getSelectedLangClass()).find(t).on("click",e)},_traverseLetterButtons:function(t,a){t.find("."+n).each(function(){var t=e(this),n=t.data("val");n=a?n.toUpperCase():n.toLowerCase(),t.html(n).data("val",n)})},_traverseInputButtons:function(t,a,n){this._traverseLetterButtons(t,a),t.find("."+i).each(function(){var t=e(this),a=t.data(n);t.html(a).data("val",a)})},$$loadEvents:function(){this.activeElementListener(),this.loadLanguageSwitcher(),this.loadInputButtonEvent(),this.loadBackspaceEvent(),this.loadCapsLockEvent(),this.loadShiftEvent(),this.areLangEventsLoaded[y.selectedLanguage]=!0}},k={attachDragToBase:function(){b.$base.draggable({containment:b.containment,cursor:"move",stop:function(){e(this).css({width:"auto",height:"auto"})}})},attachOnClickBtnEvent:function(){e("."+o).on("mousedown",function(){var t=e(this);t.addClass(r),setTimeout(function(){t.removeClass(r)},500)}).on("mouseup",function(){e(this).removeClass(r)})},minimizeKeyboard:function(){b.$minBtn.on("click",function(){b.$base.removeClass("show"),b.$toggleBtn.fadeIn()})},maximizeKeyboard:function(){b.$toggleBtn.on("click",function(){b.$base.addClass("show"),e(this).hide()})},$$load:function(){this.attachDragToBase(),this.attachOnClickBtnEvent(),this.minimizeKeyboard(),this.maximizeKeyboard()}},y={isReadyToRun:function(){return t.layouts?this.isRunning?(console.error("jqKeyboard: The library is already used/running in the current context/page."),!1):!0:(console.error("jqKeyboard: The keyboard layout configuration file hasn't been loaded."),!1)},init:function(t){y.isReadyToRun()&&(y.options=t,y.isRunning=!0,y.selectedLanguage=null,y.shift={},y.capsLock={},b.$$createBase(),$.$$loadEvents(),k.$$load())}};t.init=y.init}(jqKeyboard,jQuery);
