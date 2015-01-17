(function(c){c.fn.autoSuggest=function(m,D){function F(a){var c=0;for(k in a)a.hasOwnProperty(k)&&c++;return c}function K(){var b=a.extraParams;return c.isFunction(b)?b():b}var a=c.extend({asHtmlID:!1,startText:"Enter Name Here",usePlaceholder:!1,emptyText:"No Results Found",preFill:{},limitText:"No More Selections Are Allowed",selectedItemProp:"value",selectedValuesProp:"value",searchObjProps:"value",queryParam:"q",retrieveLimit:!1,extraParams:"",matchCase:!1,minChars:1,keyDelay:400,resultsHighlight:!0,
neverSubmit:!1,selectionLimit:!1,showResultList:!0,showResultListWhenNoMatch:!1,canGenerateNewSelections:!0,start:function(){},selectionClick:function(a){},selectionAdded:function(a){},selectionRemoved:function(a){a.remove()},formatList:!1,beforeRetrieve:function(a){return a},retrieveComplete:function(a){return a},resultClick:function(a){},resultsComplete:function(){}},D),r,y=null;"function"==typeof m?r=m:"string"==typeof m?r=function(b,J){var r="";a.retrieveLimit&&(r="&limit="+encodeURIComponent(a.retrieveLimit));
y=c.getJSON(m+"?"+a.queryParam+"="+encodeURIComponent(b)+r+K(),function(c){c=a.retrieveComplete.call(this,c);J(c,b)})}:"object"==typeof m&&0<F(m)&&(r=function(a,c){c(m,a)});if(r)return this.each(function(b){function m(){var c=h.val().replace(/[\\]+|[\/]+/g,"");c!=z&&(z=c,c.length>=a.minChars?(f.addClass("loading"),G(c)):(f.removeClass("loading"),g.hide()))}function G(c){a.beforeRetrieve&&(c=a.beforeRetrieve.call(this,c));A();r(c,D)}function D(b,e){a.matchCase||(e=e.toLowerCase());e=e.replace("(",
"\\(","g").replace(")","\\)","g");var B=0;g.html(v.html("")).hide();for(var n=F(b),m=0;m<n;m++){var p=m;H++;var d=!1;if("value"==a.searchObjProps)var s=b[p].value;else for(var s="",r=a.searchObjProps.split(","),q=0;q<r.length;q++)var t=c.trim(r[q]),s=s+b[p][t]+" ";s&&(a.matchCase||(s=s.toLowerCase()),-1!=s.search(e)&&-1==l.val().search(","+b[p][a.selectedValuesProp]+",")&&(d=!0));if(d&&(d=c('<li class="as-result-item" id="as-result-item-'+p+'"></li>').click(function(){var b=c(this).data("data"),e=
b.num;if(0>=c("#as-selection-"+e,f).length&&!C){var L=b.attributes;h.val("").focus();z="";w(L,e);a.resultClick.call(this,b);g.hide()}C=!1}).mousedown(function(){u=!1}).mouseover(function(){c("li",v).removeClass("active");c(this).addClass("active")}).data("data",{attributes:b[p],num:H}),p=c.extend({},b[p]),s=a.matchCase?new RegExp("(?![^&;]+;)(?!<[^<>]*)("+e+")(?![^<>]*>)(?![^&;]+;)","g"):new RegExp("(?![^&;]+;)(?!<[^<>]*)("+e+")(?![^<>]*>)(?![^&;]+;)","gi"),a.resultsHighlight&&0<e.length&&(p[a.selectedItemProp]=
p[a.selectedItemProp].replace(s,"<em>$1</em>")),d=a.formatList?a.formatList.call(this,p,d):d.html(p[a.selectedItemProp]),v.append(d),delete p,B++,a.retrieveLimit&&a.retrieveLimit==B))break}f.removeClass("loading");0>=B&&v.html('<li class="as-message">'+a.emptyText+"</li>");v.css("width",f.outerWidth());(0<B||!a.showResultListWhenNoMatch)&&g.show();a.resultsComplete.call(this)}function w(b,e){l.val((l.val()||",")+b[a.selectedValuesProp]+",");var d=c('<li class="as-selection-item" id="as-selection-'+
e+'" data-value="'+b[a.selectedValuesProp]+'"></li>').click(function(){a.selectionClick.call(this,c(this));f.children().removeClass("selected");c(this).addClass("selected")}).mousedown(function(){u=!1}),g=c('<a class="as-close">&times;</a>').click(function(){l.val(l.val().replace(","+b[a.selectedValuesProp]+",",","));a.selectionRemoved.call(this,d);u=!0;h.focus();return!1});q.before(d.html(b[a.selectedItemProp]).prepend(g));a.selectionAdded.call(this,q.prev(),b[a.selectedValuesProp]);return q.prev()}
function I(a){if(0<c(":visible",g).length){var b=c("li",g),d="down"==a?b.eq(0):b.filter(":last"),f=c("li.active:first",g);0<f.length&&(d="down"==a?f.next():f.prev());b.removeClass("active");d.addClass("active")}}function A(){y&&(y.abort(),y=null)}if(a.asHtmlID)d=b=a.asHtmlID;else{b=b+""+Math.floor(100*Math.random());var d="as-input-"+b}a.start.call(this,{add:function(a){w(a,"u"+c("li",f).length).addClass("blur")},remove:function(a){l.val(l.val().replace(","+a+",",","));f.find('li[data-value = "'+
a+'"]').remove()}});var h=c(this);h.attr("autocomplete","off").addClass("as-input").attr("id",d);a.usePlaceholder?h.attr("placeholder",a.startText):h.val(a.startText);var u=!1;h.wrap('<ul class="as-selections" id="as-selections-'+b+'"></ul>').wrap('<li class="as-original" id="as-original-'+b+'"></li>');var f=c("#as-selections-"+b),q=c("#as-original-"+b),g=c('<div class="as-results" id="as-results-'+b+'"></div>').hide(),v=c('<ul class="as-list"></ul>'),l=c('<input type="hidden" class="as-values" name="as_values_'+
b+'" id="as-values-'+b+'" />'),n="";if("string"==typeof a.preFill){d=a.preFill.split(",");for(b=0;b<d.length;b++){var t={};t[a.selectedValuesProp]=d[b];""!=d[b]&&w(t,"000"+b)}n=a.preFill}else{n="";d=0;for(k in a.preFill)a.preFill.hasOwnProperty(k)&&d++;if(0<d)for(b=0;b<d;b++)t=a.preFill[b][a.selectedValuesProp],void 0==t&&(t=""),n=n+t+",",""!=t&&w(a.preFill[b],"000"+b)}""!=n&&(h.val(""),","!=n.substring(n.length-1)&&(n+=","),l.val(","+n),c("li.as-selection-item",f).addClass("blur").removeClass("selected"));
h.after(l);f.click(function(){u=!0;h.focus()}).mousedown(function(){u=!1}).after(g);var x=null,E=null,z="",C=!1;h.focus(function(){a.usePlaceholder||c(this).val()!=a.startText||""!=l.val()?u&&(c("li.as-selection-item",f).removeClass("blur"),""!=c(this).val()&&(v.css("width",f.outerWidth()),g.show())):c(this).val("");x&&clearInterval(x);x=setInterval(function(){a.showResultList&&(a.selectionLimit&&c("li.as-selection-item",f).length>=a.selectionLimit?(v.html('<li class="as-message">'+a.limitText+"</li>"),
g.show()):m())},a.keyDelay);u=!0;0==a.minChars&&G(c(this).val());return!0}).blur(function(){!a.usePlaceholder&&""==c(this).val()&&""==l.val()&&""==n&&0<a.minChars?c(this).val(a.startText):u&&(c("li.as-selection-item",f).addClass("blur").removeClass("selected"),g.hide());x&&clearInterval(x)}).keydown(function(b){first_focus=!1;switch(b.keyCode){case 38:b.preventDefault();I("up");break;case 40:b.preventDefault();I("down");break;case 8:if(""==h.val()){var e=l.val().split(","),e=e[e.length-2];f.children().not(q.prev()).removeClass("selected");
q.prev().hasClass("selected")?(l.val(l.val().replace(","+e+",",",")),a.selectionRemoved.call(this,q.prev())):(a.selectionClick.call(this,q.prev()),q.prev().addClass("selected"))}1==h.val().length&&(g.hide(),z="",A());0<c(":visible",g).length&&(E&&clearTimeout(E),E=setTimeout(function(){m()},a.keyDelay));break;case 9:case 188:if(a.canGenerateNewSelections){C=!0;var e=h.val().replace(/(,)/g,""),d=c("li.active:first",g);if(""!==e&&0>l.val().search(","+e+",")&&e.length>=a.minChars&&0===d.length){b.preventDefault();
b={};b[a.selectedItemProp]=e;b[a.selectedValuesProp]=e;e=c("li",f).length;w(b,"00"+(e+1));h.val("");A();break}}case 13:C=!1;d=c("li.active:first",g);0<d.length&&(d.click(),g.hide());(a.neverSubmit||0<d.length)&&b.preventDefault();break;case 27:case 16:case 20:A(),g.hide()}});var H=0})}})(jQuery);

$(function(){
$("input[type=text]").each(function(){var $this=$(this);$this.autoSuggest($this.attr("data-autocompleteurl"), {minChars: 3,
        matchCase: false,
        startText: "Item name",
        usePlaceholder: 0,
        selectedItemProp: "name", //name of object property
        selectedValuesProp: "value", //name of object property
        searchObjProps: "name", //comma separated list of object property names
        keyDelay: 100,});});
});
/*
$(function(){
var asurl = "php/autocomplete_nowep.php";
if (document.location.pathname == "/whitelist.php") { asurl = "php/autocomplete.php" };
//if ( == "/whitelist.php") { asurl = "php/autocomplete.php" };

$("input[type=text]").autoSuggest( asurl ,
        {minChars: 3,
        matchCase: false,
        startText: "Item name",
        selectedItemProp: "name", //name of object property
        selectedValuesProp: "value", //name of object property
        searchObjProps: "name", //comma separated list of object property names
        keyDelay: 100,});
});
*/