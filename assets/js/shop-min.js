window.onscroll=function(){scrollFunction()};var element=document.getElementById("body");function navigateFromTo(t,e){var a=document.getElementById(t),i=document.getElementById(e);null==a&&null==a||(a.style.display="none"),null==i&&null==i||(i.style.display="block"),"#payment"==e&&$(".creditcardform").card({debug:!0,container:".card-wrapper",formatting:!0,formSelectors:{numberInput:'input[name="number"]',expiryInput:'input[name="expiry"]',cvcInput:'input[name="cvc"]',nameInput:'input[name="name"]'},cardSelectors:{cardContainer:".jp-card-container",card:".jp-card",numberDisplay:".jp-card-number",expiryDisplay:".jp-card-expiry",cvcDisplay:".jp-card-cvc",nameDisplay:".jp-card-name"},classes:{valid:"jp-card-valid",invalid:"jp-card-invalid"},masks:{cardNumber:!1}})}function scrollTo(t){try{document.getElementById(t).scrollIntoView()}catch(t){}}function getCategoryChildren(t,e){var a="";return t.forEach((function(t){if(e==t.category.id){var i=""==t.category.name?"m-0 ml-3 mr-4 pl-2 pr-5 p-0":"";switch(t.type){case"single":""==t.price?a+='<div class="row '+i+' col-12 mb-1 " style="margin-top:2px;"><div class="col-6 p-0 p-sm-3 m-0 text-left"><span>'+t.name+'</span></div><div class="col-6 p-0 p-sm-3 m-0 qty text-right"><input data-object="'+encode(JSON.stringify(t))+'" class="form-check-input product-modal-option" data-value="'+t.name+'" type="checkbox" id="gridCheck"></div></div>':a+='<div class="row '+i+' col-12 mb-1 "><div class="col-4 p-0 p-sm-3 m-0 text-left"><span>'+t.name+'</span></div><div class="col-4 p-0 p-sm-3 m-0 text-center"><span class="badge price-tag">'+t.price+'</span></div><div class="col-4 p-0 p-sm-3 m-0 qty text-right"><input data-object="'+encode(JSON.stringify(t))+'" class="form-check-input product-modal-option" data-value="'+t.name+'" type="checkbox" id="gridCheck"></div></div>';break;case"multiple":""==t.price?a+='<div class="row '+i+' col-12 mb-1 "><div class="col-6 p-0 p-sm-3 m-0 text-left"><span>'+t.name+'</span></div><div class="col-6 p-0 p-sm-3 m-0 qty text-right"><i class="mdi mdi-minus-circle minus"></i><input data-object="'+encode(JSON.stringify(t))+'" type="number" class="count product-modal-option" data-value="'+t.name+'" name="qty" value="0"><i class="mdi mdi-plus-circle plus"></i></div></div>':a+='<div class="row '+i+' col-12 mb-1"><div class="col-4 p-0 p-sm-3 m-0 text-left"><span>'+t.name+'</span></div><div class="col-4 p-0 p-sm-3 m-0 text-center"><span class="badge price-tag">'+t.price+'</span></div><div class="col-4 p-0 p-sm-3 m-0 qty text-right"><i class="mdi mdi-minus-circle minus"></i><input data-object="'+encode(JSON.stringify(t))+'" type="number" class="count product-modal-option" data-value="'+t.name+'" name="qty" value="0"><i class="mdi mdi-plus-circle plus"></i></div></div>';break}}})),a}function isCreditCard(t){return!!/^(?:(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/.test(t)}function isCardValid(t){if(null!=t){for(var e=t.split(""),a=0,i=0;i<t.length;i++){var n=int.parse(e[i]);if(i%2==0||0==i){var r=2*n;r>9&&(r-=9),a+=r}else a+=n}return a%10==0}return!1}$(".owl-carousel").owlCarousel({items:3,loop:!0,nav:!1,dot:!0,autoplay:!0,slideTransition:"linear",autoplayHoverPause:!0,responsive:{0:{items:1},600:{items:2},1e3:{items:3}}}),AOS.init({offset:120,delay:0,duration:1200,easing:"ease",once:!0,mirror:!1,anchorPlacement:"top-bottom",disable:"mobile"}),$(document).ready((function(){screen.width<=990?$(".contact-md").css("display","block"):$(".contact-md").css("display","none")}),100),$("img").on("dragstart",(function(t){t.preventDefault()})),$("body").on("contextmenu","img",(function(t){return!1})),$("#navbarSupportedContent").on("hidden.bs.collapse",(function(){$("body").removeClass("sidebar-open")})),$("#navbarSupportedContent").on("shown.bs.collapse",(function(){$("body").addClass("sidebar-open")}));var cart=document.getElementById("cart-fab"),menu=document.getElementById("js-sticky-widget"),body=document.getElementsByTagName("body")[0];function scrollFunction(t,e){document.body.scrollTop>(e??350)||document.documentElement.scrollTop>(e??350)?t.style.display="block":t.style.display="none"}function money(t){return Intl.NumberFormat("en-US",{style:"currency",currency:getCookie("currency"),minimumFractionDigit:4}).format(t)}window.onscroll=function(){null!=cart&&scrollFunction(cart)},window.onresize=function(){window.innerWidth>=992&&($("body").removeClass("sidebar-open"),$("#navbarSupportedContent").removeClass("show")),listToArray($(".grid-product-card-img-top")).forEach((function(t){"grid-product-img-info"==t.nextElementSibling.className&&(t.nextElementSibling.style.height=$(t).css("height"),t.nextElementSibling.style.width=$(t).css("width"))})),$(".modal-header").css("height",$(".product-img").css("height"))},$(document).ready((function(){var t=window.location.href.split("/"),e=t[t.length-1],a=window.location.hash;function i(t){switch(parseInt(t)){case 5:return{0:"Your order has been delivered",trn:"order-delivered"};case 1:return{0:"Your order has been received",trn:"order-received"};case 3:return{0:"Order has been shipped",trn:"order-shipped"};case 4:return{0:"Your order is on the way",trn:"order-onway"};case 2:return{0:"Order is ready",trn:"order-ready"}}}function n(t){return(t=parseInt(t))<10?"0"+t:t}$("#add_address").click((function(){var t=$("#contact_form");"none"==t.css("display")&&(t.css("display","block"),$(this).addClass("active"))})),listToArray($(".grid-product-card-img-top")).forEach((function(t){"grid-product-img-info"==t.nextElementSibling.className&&(t.nextElementSibling.style.height=$(t).css("height"),t.nextElementSibling.style.width=$(t).css("width"))})),$(".select-shop").click((function(){setCookie("YnJhbmNo",$(this).attr("data-id"),1),location.reload()})),$("#add_card").click((function(){var t=$("#payment_form");"none"==t.css("display")&&(t.css("display","block"),$(this).addClass("active"))})),$("#ratingModal").on("show.bs.modal",(function(t){$("#rating-id").attr("data-id",t.relatedTarget.getAttribute("data-id"))})),$("#rate-order").click((function(){$.post("post/addRatings",{id:$("#rating-id").attr("data-id"),ratings:$('input[name="rating"]:checked').val(),comment:$('input[name="comment"]').val()},(function(t,e){var a=getCookie("lingo");1==(t=JSON.parse(t)).result?webToast.Success({status:dictionary.successful[a],message:dictionary["order-rated"][a],delay:5e3}):webToast.Info({status:"",message:dictionary["already-rated"][a],delay:5e3}),$("#ratingModal").modal("hide")}))})),$(".order-again").click((function(){var t=[],e=$(this).attr("data-id").replace('"[',"[").replace(']"',"]");JSON.parse(e).forEach((function(e){var a=[];e.productOptions.forEach((function(t){a.push({name:t.name,value:t.amount})}));var i={pId:e.productId,total:e.amount,note:e.additionalNote.substring(0,120),options:a};t.push(i)})),setCookie("order",""+base64en(JSON.stringify(t)),20),window.location.href="checkout"})),$(".delete-order").click((function(){var t=$(this),e=getCookie("lingo");mcxDialog.confirm(dictionary["are-you-sure"][e],{cancelBtnText:dictionary.cancel[e],sureBtnText:dictionary.proceed[e],sureBtnClick:function(){$.post("post/deleteOrder",{id:t.attr("data-id")},(function(e,a){var i=getCookie("lingo");1==(e=JSON.parse(e)).result?t.parent().parent().parent().css("display","none"):webToast.Danger({status:"",message:dictionary.failed[i],delay:5e3})}))}})})),$("#close-card-success").click((function(){$("#payment_form").css("display","none")})),$("#postalCode").keyup((function(){postalGeocoding($(this).val())}));try{var r=getCookie("lingo"),o=$('input[name="track-id"]');listToArray(o).forEach((function(t){var e=setInterval((function(){t=$(t),$.post("post/updateDelivery",{id:t.val()},(function(a,o){a=(a=a.stripSlashes().stripSlashes().split('"[').join("[").split('["').join("[")).split(']"').join("]").split('"{').join("{").split('}"').join("}");try{a=JSON.parse(a);var s='<li class="row justify-content-between" id="start">'+$("#start").html()+"</li>",c=t.next(),d=["January","February","March","April","May","June","July","August","September","October","November","December"];a.status.forEach((t=>{var e=new Date(1e3*t.time),a=t.status;s+='<li class="row justify-content-between"><h5 trn="'+i(a).trn+'">'+dictionary[i(a).trn][r]+'</h5><p class="float-right">'+d[e.getMonth()]+" "+e.getDate()+", "+n(e.getHours())+":"+n(e.getMinutes())+"</p></li>"})),c.html(s),t.attr("data-id")<a.status.length&&playSound("assets/audio/beep.mp3"),4==a.status.length&&clearInterval(e),t.attr("data-id",a.status.length)}catch(t){}}))}),1e4)}))}catch(t){}function s(t,e){$.post("post/updateCartQuantity",{id:t,val:e},(function(t,e){1==(t=JSON.parse(t.toString())).result&&u()}))}function c(t){mcxDialog.confirm(dictionary["are-you-sure"][r],{cancelBtnText:dictionary.cancel[r],sureBtnText:dictionary.proceed[r],sureBtnClick:function(){return $.post("post/deleteCartItem",{id:t.attr("data-id")},(function(t,e){var a=getCookie("lingo");1==(t=JSON.parse(t)).result?u():webToast.Danger({status:dictionary["error-occured"][a],message:dictionary[t.error.trn][a],delay:5e3})}))}})}""!=window.location.hash&&(window.location.href.includes("profile")&&(navigateFromTo("#fav",window.location.hash),$(".de-nav-link[href='#fav']").removeClass("active"),$(".de-nav-link[href='"+window.location.hash+"']").addClass("active"),$("#confirmationModal").on("show.bs.modal",(function(t){$("#confirm-btn").attr("data",t.relatedTarget.getAttribute("data-id")),$("#confirm-btn").attr("page",t.relatedTarget.getAttribute("data-page"))})),$("#confirm-btn").click((function(){switch($(this).attr("page")){case"payment":$.post("post/deleteMOP",{id:$(this).attr("data")},(function(t,e){1==(t=JSON.parse(t)).result&&(window.history.replaceState&&window.history.replaceState(null,null,window.location.href),location.reload())}));break;case"info":$.post("post/deleteAddress",{id:$(this).attr("data")},(function(t,e){1==(t=JSON.parse(t)).result&&(window.history.replaceState&&window.history.replaceState(null,null,window.location.href),location.reload())}));break}}))),window.location.href.includes("auth")&&("#register"==window.location.hash?navigateFromTo($("#current").val(),"register"):"#forgot-password"==window.location.hash&&navigateFromTo($("#current").val(),"forgot-password"))),$("a[href='#login']").click((function(){void 0!==$(".alert-danger")&&$(".alert-danger").css("display","none"),navigateFromTo($("#current").val(),"login"),$("#current").val("login")})),$("a[href='#register']").click((function(){void 0!==$(".alert-danger")&&$(".alert-danger").css("display","none"),navigateFromTo($("#current").val(),"register"),$("#current").val("register")})),$("a[href='#forgot-password']").click((function(){void 0!==$(".alert-danger")&&$(".alert-danger").css("display","none"),navigateFromTo($("#current").val(),"forgot-password"),$("#current").val("forgot-password")})),$(".list-product-card").click((function(){})),$(".de-nav-link").click((function(){var t=""==window.location.hash?"#fav":window.location.hash,e=$(this).attr("href");window.location.hash=e,navigateFromTo(t,e)})),$(".modal-option-header").click((function(){$(this).find("i").attr("class").includes("mdi-chevron-down")?($(this).find("i").removeClass("mdi-chevron-down"),$(this).find("i").addClass("mdi-chevron-right")):($(this).find("i").removeClass("mdi-chevron-right"),$(this).find("i").addClass("mdi-chevron-down"))})),$("#logout").click((function(){window.location.href="logout"})),$(".list-product-fav").click((function(){$(this).attr("class").includes("ri-heart-line")?($(this).removeClass("ri-heart-line"),$(this).addClass("ri-heart-fill"),$(this).css("color","#FA1616")):($(this).addClass("ri-heart-line"),$(this).removeClass("ri-heart-fill"),$(this).css("color","#000"))})),$("#productModal").on("show.bs.modal",(function(t){var e,a=$(t.relatedTarget);"BUTTON"==a.prop("tagName")?e=a.parent().parent().parent().find('input[type="hidden"]'):"H4"==a.prop("tagName")&&(e=a.next());var i=JSON.parse(base64de(e.attr("data-content"))),n=$(this);n.find("#product-modal-name").html(i.name),n.find("#product-modal-description").html(i.description),n.find("#product-modal-price").html(money(i.price)),""!=i.displayImage?n.find("#product-modal-img").attr("src",i.displayImage):n.find("#product-modal-img").attr("src",$("#product-modal-img").attr("data-placeholder")),n.find("#product-modal-total-price").html(money(i.price)),n.find('input[name="product-modal-total"]').val(i.price),n.find('input[name="product-details"]').val(encode(JSON.stringify(i)));try{n.find("#product-modal-ratings").html(""==i.ratings?0:i.ratings)}catch(t){}try{n.find("#product-modal-orderCount").html(parseInt("null"==i.orderCount||null==i.orderCount?0:i.orderCount))}catch(t){}var r=[];$("#option-display").html("");try{i.productOptions.forEach((function(t){var e={};e.id=t.category.id,e.name=t.category.name,e.html=getCategoryChildren(i.productOptions,t.category.id),r.push(e)}));var o=[],s="";r.forEach((function(t){o.includes(t.id)||(o.push(t.id),""==t.name?s+=t.html:s+='<div class="accordion mt-2 mb-2" id="accordion'+t.name+'"><div><div class="modal-option-header row col-12 pl-3 pb-2 pt-2" data-toggle="collapse" data-target="#collapse'+t.name+'" aria-expanded="true" aria-controls="collapse'+t.name+'"><span class="text-left col-8">'+t.name+'</span><i class="mdi mdi-chevron-right text-right text-muted col-4"></i></div><div id="collapse'+t.name+'" class="collapse pl-4 pt-1" data-parent="#accordion'+t.name+'">'+t.html+"</div></div></div>")})),$("#option-display").html(s),$(".plus").click((function(){$(this).prev().val(parseInt($(this).prev().val())+1).change()})),$(".minus").click((function(){parseInt($(this).next().val())>0&&$(this).next().val(parseInt($(this).next().val())-1).change()})),$(".product-modal-option").change((function(){var t=JSON.parse(decode($(this).attr("data-object"))),e=$("#product-modal-total-price"),a=$('input[name="product-modal-total"]');if(""!=t.price){var i=parseInt(a.val());if(isNaN($(this).val()))$(this).is(":checked")?i+=parseInt(t.price):i-=parseInt(t.price);else{if(null==t.amount)i+=parseInt(t.price)*parseInt($(this).val());else{var n=parseInt($(this).val())-parseInt(t.amount);i+=parseInt(t.price)*n}t.amount=parseInt($(this).val()),$(this).attr("data-object",encode(JSON.stringify(t)))}a.val(i),e.html(money(a.val()))}}))}catch(t){}})),$('[name="place-order"]').click((function(t){var e=getCookie("lingo");spinner("checkout").show(),webToast.loading({status:dictionary.loading[e],message:dictionary["please-wait"][e],delay:1e5})})),$(".grid-product-fav").click((function(){""==$(this).attr("data-id")&&(location.href="auth");var t=$(this);$(this).attr("class").includes("ri-heart-line")?$.post("post/addFavorite",{id:$(this).attr("data-id")},(function(e,a){1==(e=JSON.parse(e)).result&&(t.removeClass("ri-heart-line"),t.addClass("ri-heart-fill"),t.css("color","#FA1616"))})):$.post("post/removeFavorite",{id:$(this).attr("data-id")},(function(i,n){1==(i=JSON.parse(i)).result&&(t.addClass("ri-heart-line"),t.removeClass("ri-heart-fill"),"profile"!=e&&"#fav"!=a||t.parent().parent().css("display","none"))}))}));var d=$("#deliveryInfo");try{new Date(Date.now()+6e4*base64de(d.attr("data-delivery-time")))}catch(t){new Date(Date.now()+36e5)}$('[data-toggle="datepicker"]').datepicker({format:"yyyy/mm/dd",startDate:Date.now(),yearSuffix:"年",endDate:new Date(Date.now()+12096e5)});try{var l=JSON.parse(base64de($("data#operationalTime").attr("data-value")))}catch(t){}if($('[data-toggle="datepicker"]').change((function(){$("#delivery-time-display").val();var t=new Date;t=new Date(t.getFullYear(),t.getMonth(),t.getDate());var e=(new Date($(this).val()).getTime()-t.getTime())/864e5;e>6&&(e%7==0?e=0:e-=7);var a=l[e];try{var i=a.open.split(":"),n=parseInt(i[0]),r=parseInt(i[1])+30;r>=60&&(r-=60,n++),a.open=n+":"+r,isNaN(n)&&(a.open="")}catch(t){}$('[data-toggle="timepicker"]').timepicker({step:15,show2400:!0,minTime:a.open,maxTime:a.close,disableTimeRanges:[a.breakStart,a.breakEnd]})})),2==$('input[name="delivery_option"]:checked').val()&&deliveryTimeToast.clear(),$('input[name="delivery_option"]').change((function(){1==$(this).val()?($("#takeout-time").css("display","none"),$(".take-out-info").css("display","none"),$(".delivery-info").css("display","block"),deliveryTimeToast.show($("#delivery-time-display").html())):($(".take-out-info").css("display","block"),$(".delivery-info").css("display","none"),$("#takeout-time").css("display","block"),deliveryTimeToast.clear())})),null!=$("#card-saved").val()&&($("#use-new-info").is(":checked")?$("#new-checkout-address").css("display","block"):$("#new-checkout-address").css("display","none")),$("#use-new-card").is(":checked")?$("#new-checkout-payment").css("display","block"):$("#new-checkout-payment").css("display","none"),"card"==$('input[name="payment_option"]:checked').val()?($("#saved-cards").css("display","block"),$("#saved-cards").children().length<1&&$("#new-checkout-payment").css("display","block")):$("#saved-cards").css("display","none"),$('input[name="checkout-address"]').change((function(){"block"==$("#new-checkout-address").css("display")&&($("#new-checkout-address").css("display","none"),$('input[name="fname"]').removeAttr("required"),$('input[name="lname"]').removeAttr("required"),$('input[name="phone"]').removeAttr("required"),$('input[name="email"]').removeAttr("required"),$('input[name="zip"]').removeAttr("required"),$('input[name="city"]').removeAttr("required"),$('input[name="address"]').removeAttr("required"),$('input[name="street"]').removeAttr("required")),"use-new-address"==$(this).attr("data-id")&&($("#new-checkout-address").css("display","block"),$('input[name="fname"]').attr("required","true"),$('input[name="lname"]').attr("required","true"),$('input[name="phone"]').attr("required","true"),$('input[name="email"]').attr("required","true"),$('input[name="zip"]').attr("required","true"),$('input[name="address"]').attr("required","true"),$('input[name="city"]').attr("required","true"),$('input[name="street"]').attr("required","true"))})),"checkout"==e)$(".creditcardform").card({debug:!0,container:".card-wrapper",formatting:!0,formSelectors:{numberInput:'input[name="number"]',expiryInput:'input[name="expiry"]',cvcInput:'input[name="cvc"]',nameInput:'input[name="name"]'},cardSelectors:{cardContainer:".jp-card-container",card:".jp-card",numberDisplay:".jp-card-number",expiryDisplay:".jp-card-expiry",cvcDisplay:".jp-card-cvc",nameDisplay:".jp-card-name"},classes:{valid:"jp-card-valid",invalid:"jp-card-invalid"},masks:{cardNumber:!1}});try{}catch(t){}try{var p=[];listToArray($(".cat-pill")).forEach((t=>{var e=$(t).attr("data-id"),a=$(".grid-product-card-wrap"),i=[];listToArray(a).forEach((function(t){try{JSON.parse($(t).attr("data-categories")).includes(e)&&i.push(t)}catch(t){}}));var n={};n.pill=$(t),n.belong=i,p.push(n)})),p.forEach((function(t){t.belong.length<1&&t.pill.css("display","none")}))}catch(t){}function u(){$.post("get/cartItems",{id:$("#cart").attr("data-id")},(function(t,e){if(1==(t=JSON.parse(t)).result){var a=0,i=$("#cart-total"),n=$("#cart-items"),r=$("#tax");t=JSON.parse(t.data),n.html("");var o="";t.forEach((function(t){var e="";t.productOptions.forEach((function(t){var a="boolean"==typeof t.amount?t.amount?1:0:t.amount;e+=unicodeToChar(t.name)+"<strong> X"+a+"</strong>・"}));var i=t.quantity??0;o+='<div data-id="'+t.id+'"><div class="pt-3 pb-3"><div class="row col-12"><i class="mdi mdi-delete delete-btn delete-btn-danger" data-page="delete-cart-item" data-id="'+t.datid+'" style="margin-top:-8px; margin-right:-8px"></i><div class="col-lg-1 col-md-1 col-sm-1 text-left pr-3"><h5 class="span-circle" style="background-color:#05C776;">x'+i+'</h5></div><div class="col-lg-8 col-md-8 col-sm-5 text-left pl-4 mt-1"><h4 class="order-sub-title font-weight-bold">'+t.productDetails+'</h4><div style="font-size:14px"><span class="text-muted">'+e+'</span><br><span class="text-muted"><span>Note</span>:"'+t.additionalNote+'" </span></div></div><div class="col-lg-3 col-md-3 col-sm-6 text-lg-center text-sm-right"><span class="order-sub-title font-weight-bold ml-2">'+money(parseInt(t.amount)*parseInt(t.quantity))+'</span><div class="qty text-right"><i class="mdi mdi-minus-circle" data-id="'+t.datid+'"></i><input type="number" class="count" name="qty" value="'+i+'"><i class="mdi mdi-plus-circle" data-id="'+t.datid+'"></i></div></div></div></div><div class="row-hr"></div></div>',a+=parseInt(t.amount)*parseInt(t.quantity)})),void 0!==r&&r.html(money(Math.round(.08*a))),n.html(o),i.html(money(a)),$(".mdi-delete").click((function(){switch($(this).attr("data-page")){case"delete-cart-item":c($(this));break}})),$(".mdi-plus-circle").click((function(){$(this).prev().val(parseInt($(this).prev().val())+1).change(),null!=$(this).attr("data-id")&&s($(this).attr("data-id"),$(this).prev().val())})),$(".mdi-minus-circle").click((function(){parseInt($(this).next().val())>0&&$(this).next().val(parseInt($(this).next().val())-1).change(),null!=$(this).attr("data-id")&&s($(this).attr("data-id"),$(this).next().val())}))}}))}$(".category-pill").click((function(){var t=$(this);if(void 0!==t.attr("href")){var e=$(this).attr("href");scrollTo(e.substring(1,e.length))}var a=$(this).attr("data-id"),i=$(".grid-product-card-wrap");if(listToArray(i).forEach((function(t){$(t).css("display","block")})),void 0!==a){var n=[];listToArray(i).forEach((function(t){try{JSON.parse($(t).attr("data-categories")).includes(a)&&n.push(t)}catch(t){}})),n.length<1&&t.css("display","none"),listToArray(i).forEach((function(t){n.includes(t)||$(t).css("display","none")}))}})),$('input[name="payment_option"]').change((function(){$(this).is(":checked")&&("block"==$("#saved-cards").css("display")&&($("#saved-cards").css("display","none"),$("#new-checkout-payment").css("display","none")),"card"==$(this).val()&&(null==$("#card-saved").val()&&$("#new-checkout-payment").css("display","block"),$("#saved-cards").css("display","block"),$("#use-new-card").is(":checked")&&$("#new-checkout-payment").css("display","block")))})),$("#show-reservation").click((function(){"none"==$(this).next().css("display")?($(this).next().css("display","flex"),deliveryTimeToast.clear()):($(this).next().css("display","none"),deliveryTimeToast.show($("#delivery-time-display").html()))})),$('input[name="checkout-payment"]').change((function(){"block"==$("#new-checkout-payment").css("display")&&($("#new-checkout-payment").css("display","none"),$('input[name="number"]').removeAttr("required"),$('input[name="expiry"]').removeAttr("required"),$('input[name="name"]').removeAttr("required"),$('input[name="cvc"]').removeAttr("required")),"use-new-payment"==$(this).attr("data-id")&&($("#new-checkout-payment").css("display","block"),$('input[name="number"]').attr("required","true"),$('input[name="expiry"]').attr("required","true"),$('input[name="name"]').attr("required","true"),$('input[name="cvc"]').attr("required","true"))})),$(".mdi-delete").click((function(){switch($(this).attr("data-page")){case"delete-cart-item":c($(this));break}})),$(".mdi-plus-circle").click((function(){$(this).prev().val(parseInt($(this).prev().val())+1).change(),null!=$(this).attr("data-id")&&s($(this).attr("data-id"),$(this).prev().val())})),$(".mdi-minus-circle").click((function(){parseInt($(this).next().val())>0&&$(this).next().val(parseInt($(this).next().val())-1).change(),null!=$(this).attr("data-id")&&s($(this).attr("data-id"),$(this).next().val())})),$("#cart-checkout").click((function(){setCookie("order","ZnJvbS1jYXJ0",20),window.location.href="checkout"})),$(".cart-order").click((function(){var t=JSON.parse(decode($('input[name="product-details"]').val())),e=$('input[name="session"]').val(),a=listToArray($(".product-modal-option")).map((function(t){var e={};return e.name=$(t).attr("data-value"),e.value=isNaN($(t).val())?$(t).is(":checked"):$(t).val(),e})),i=$('textarea[name="product-modal-note"]').val(),n=$('input[name="product-modal-total"]').val();function r(t,e=0){for(var a=t,i=0;i<e;i++)a=base64en(a);return a}var o=Math.floor(20*Math.random())+1,s={id:r(o,1),data:r(JSON.stringify({pId:{id:t.id,name:t.name},sId:e,total:n,note:i,options:a}),o)};switch($(this).attr("data-page")){case"add-to-cart":$.post("post/addToCart",s,(function(t,e){var a=getCookie("lingo");1==(t=JSON.parse(t)).result?(u(),webToast.Success({status:dictionary.successful[a],message:dictionary["cart-added"][a],delay:2e3})):webToast.Danger({status:dictionary["error-occured"][a],message:dictionary[t.error.trn][a],delay:5e3})}));break;case"order-now":s={pId:t.id,total:n,note:i.substring(0,120),options:a};setCookie("order",""+base64en(JSON.stringify(s)),20),window.location.href="checkout";break}}))}));