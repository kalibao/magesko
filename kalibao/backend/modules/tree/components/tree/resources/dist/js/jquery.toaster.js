(function(){if(typeof Array.prototype.indexOf!=='function'){Array.prototype.indexOf=function(a,b){for(var i=(b||0),j=this.length;i<j;i+=1){if((a===undefined)||(a===null)){if(this[i]===a){return i}}else if(this[i]===a){return i}}return-1}}})();(function($,g){var h={gettoaster:function(){var a=$('#'+k.toaster.id);if(a.length<1){a=$(k.toaster.template).attr('id',k.toaster.id).css(k.toaster.css).addClass(k.toaster['class']);if((k.stylesheet)&&(!$("link[href="+k.stylesheet+"]").length)){$('head').appendTo('<link rel="stylesheet" href="'+k.stylesheet+'">')}$(k.toaster.container).append(a)}return a},notify:function(a,b,c){var d=this.gettoaster();var e=$(k.toast.template.replace('%priority%',c)).hide().css(k.toast.css).addClass(k.toast['class']);$('.title',e).css(k.toast.csst).html(a);$('.message',e).css(k.toast.cssm).html(b);if((k.debug)&&(window.console)){console.log(toast)}d.append(k.toast.display(e));if(k.donotdismiss.indexOf(c)===-1){var f=(typeof k.timeout==='number')?k.timeout:((typeof k.timeout==='object')&&(c in k.timeout))?k.timeout[c]:1500;setTimeout(function(){k.toast.remove(e,function(){e.remove()})},f)}}};var j={'toaster':{'id':'toaster','container':'body','template':'<div></div>','class':'toaster','css':{'position':'fixed','top':'10px','right':'10px','width':'300px','zIndex':50000}},'toast':{'template':'<div class="alert alert-%priority% alert-dismissible" role="alert">'+'<button type="button" class="close" data-dismiss="alert">'+'<span aria-hidden="true">&times;</span>'+'<span class="sr-only">Close</span>'+'</button>'+'<span class="title"></span>: <span class="message"></span>'+'</div>','defaults':{'title':'Notice','priority':'success'},'css':{},'cssm':{},'csst':{'fontWeight':'bold'},'fade':'slow','display':function(a){return a.fadeIn(k.toast.fade)},'remove':function(a,b){return a.animate({opacity:'0',padding:'0px',margin:'0px',height:'0px'},{duration:k.toast.fade,complete:b})}},'debug':false,'timeout':1500,'stylesheet':null,'donotdismiss':[]};var k={};$.extend(k,j);$.toaster=function(a){if(typeof a==='object'){if('settings'in a){k=$.extend(true,k,a.settings)}}else{var b=Array.prototype.slice.call(arguments,0);var c=['message','title','priority'];a={};for(var i=0,l=b.length;i<l;i+=1){a[c[i]]=b[i]}}var d=(('title'in a)&&(typeof a.title==='string'))?a.title:k.toast.defaults.title;var e=('message'in a)?a.message:null;var f=(('priority'in a)&&(typeof a.priority==='string'))?a.priority:k.toast.defaults.priority;if(e!==null){h.notify(d,e,f)}};$.toaster.reset=function(){k={};$.extend(k,j)}})(jQuery);