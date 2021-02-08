window.onscroll = function () { scrollFunction() };
var element = document.getElementById("body");
function scrollFunction() {
    if (document.body.scrollTop > 400 || document.documentElement.scrollTop > 400) {
        $(".navbar").addClass("fixed-top");
        element.classList.add("header-small");
        $("body").addClass("body-top-padding");

    } else {
        $(".navbar").removeClass("fixed-top");
        element.classList.remove("header-small");
        $("body").removeClass("body-top-padding");
    }
}

$('.owl-carousel').owlCarousel({
    items: 3,
    loop: true,
    nav: false,
    dot: true,
    autoplay: true,
    slideTransition: 'linear',
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 3
        }
    }
});

AOS.init({
    offset: 120,
    delay: 0,
    duration: 1200,
    easing: 'ease',
    once: true,
    mirror: false,
    anchorPlacement: 'top-bottom',
    disable: "mobile"
});
// SCROLLSPY
$(document).ready(function () {
    if (screen.width <= 990) {
        $('.contact-md').css('display', 'block');
    } else {
        $('.contact-md').css('display', 'none');
    }
}, 100);

$('img').on('dragstart', function (event) { event.preventDefault(); });
$("body").on("contextmenu", "img", function (e) {
    return false;
});



//SIDEBAR-OPEN
$('#navbarSupportedContent').on('hidden.bs.collapse', function () {
    $("body").removeClass("sidebar-open");
})

$('#navbarSupportedContent').on('shown.bs.collapse', function () {
    $("body").addClass("sidebar-open");
})


function navigateFromTo(oldDiv, newDiv) {

    var from = document.getElementById(oldDiv);
    var to = document.getElementById(newDiv);
    if (from != undefined || from != null) {
        from.style.display = "none";
    }
    if (to != undefined || to != null) {
        to.style.display = "block";
    }

    if (newDiv == "#payment") {
        $('.creditcardform').card({
            debug: true,
            container: '.card-wrapper',
            formatting: true,
            formSelectors: {
                numberInput: 'input[name="number"]',
                expiryInput: 'input[name="expiry"]',
                cvcInput: 'input[name="cvc"]',
                nameInput: 'input[name="name"]'
            }, cardSelectors: {
                cardContainer: '.jp-card-container',
                card: '.jp-card',
                numberDisplay: '.jp-card-number',
                expiryDisplay: '.jp-card-expiry',
                cvcDisplay: '.jp-card-cvc',
                nameDisplay: '.jp-card-name'
            }, classes: {
                valid: 'jp-card-valid',
                invalid: 'jp-card-invalid'
            }, masks: {
                cardNumber: false,
            },
        });
    }
}

function scrollTo(element) {
    try {
        document.getElementById(element).scrollIntoView();
    } catch (e) {
    }// var left = ele.offsetLeft;
    // var top = ele.offsetTop;
    // console.log(left, top);
    // window.scrollTo(left, top);
}

function getCategoryChildren(options, category) {
    var html = "";
    options.forEach(function (option) {
        if (category == option.category.id) {
            var temp = option.category.name == "" ? 'm-0 ml-3 mr-4 pl-2 pr-5 p-0' : '';
            switch (option.type) {
                case "single":

                    if (option.price == "") {
                        html += '<div class="row ' + temp + ' col-12 mb-1 " style="margin-top:2px;"><div class="col-6 p-0 p-sm-3 m-0 text-left"><span>' + option.name + '</span></div><div class="col-6 p-0 p-sm-3 m-0 qty text-right"><input data-object="' + encode(JSON.stringify(option)) + '" class="form-check-input product-modal-option" data-value="' + option.name + '" type="checkbox" id="gridCheck"></div></div>';
                    } else {
                        html += '<div class="row ' + temp + ' col-12 mb-1 "><div class="col-4 p-0 p-sm-3 m-0 text-left"><span>' + option.name + '</span></div><div class="col-4 p-0 p-sm-3 m-0 text-center"><span class="badge price-tag">' + option.price + '</span></div><div class="col-4 p-0 p-sm-3 m-0 qty text-right"><input data-object="' + encode(JSON.stringify(option)) + '" class="form-check-input product-modal-option" data-value="' + option.name + '" type="checkbox" id="gridCheck"></div></div>';
                    }

                    break;
                case "multiple":
                    if (option.price == "") {
                        html += '<div class="row ' + temp + ' col-12 mb-1 "><div class="col-6 p-0 p-sm-3 m-0 text-left"><span>' + option.name + '</span></div><div class="col-6 p-0 p-sm-3 m-0 qty text-right"><i class="mdi mdi-minus-circle minus"></i><input data-object="' + encode(JSON.stringify(option)) + '" type="number" class="count product-modal-option" data-value="' + option.name + '" name="qty" value="0"><i class="mdi mdi-plus-circle plus"></i></div></div>';
                    } else {
                        html += '<div class="row ' + temp + ' col-12 mb-1"><div class="col-4 p-0 p-sm-3 m-0 text-left"><span>' + option.name + '</span></div><div class="col-4 p-0 p-sm-3 m-0 text-center"><span class="badge price-tag">' + option.price + '</span></div><div class="col-4 p-0 p-sm-3 m-0 qty text-right"><i class="mdi mdi-minus-circle minus"></i><input data-object="' + encode(JSON.stringify(option)) + '" type="number" class="count product-modal-option" data-value="' + option.name + '" name="qty" value="0"><i class="mdi mdi-plus-circle plus"></i></div></div>';
                    }
                    break;
            }
        }
    });
    return html;
}



function isCreditCard(str) {
    var regexp = /^(?:(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/;
    if (regexp.test(str)) {
        return true;
    }
    else {
        return false;
    }
}

function isCardValid(cardNumber) {
    if (cardNumber != null) {
        var number = cardNumber.split("");
        var sum = 0;
        for (var i = 0; i < cardNumber.length; i++) {
            var indv = int.parse(number[i]);
            if (i % 2 == 0 || i == 0) {
                var doubled = indv * 2;
                if (doubled > 9) {
                    doubled = doubled - 9;
                }
                sum += doubled;
            } else {
                sum += indv;
            }
        }
        return (sum % 10 == 0);
    } else
        return false;

}
var cart = document.getElementById("cart-fab");
window.onscroll = function () { if (cart != undefined) scrollFunction(cart) };

function scrollFunction(e) {
    if (document.body.scrollTop > 350 || document.documentElement.scrollTop > 350) {
        e.style.display = "block";
    } else {
        e.style.display = "none";
    }
}
function money(amount) {
    var money = Intl.NumberFormat('en-US', { style: "currency", currency: getCookie('currency'), minimumFractionDigit: 4 });
    return money.format(amount);
}

window.onresize = function () {
    var w = window.innerWidth;
    if (w >= 992) {
        $('body').removeClass('sidebar-open');
        $('#navbarSupportedContent').removeClass('show');
    }

    listToArray($(".grid-product-card-img-top")).forEach(function (elem) {
        if (elem.nextElementSibling.className == 'grid-product-img-info') {
            elem.nextElementSibling.style.height = $(elem).css("height");
            elem.nextElementSibling.style.width = $(elem).css("width");

        }
    });
    // $(".list-product-img-info").css("width", $(".list-product-card-img-top").width() + 30 + "px");
    $(".modal-header").css("height", $(".product-img").css("height"));

}
// function loadCss() {
//     var cssLink = document.createElement('link');
//     cssLink.rel = 'stylesheet';
//     cssLink.href = 'assets/css/shop.css';
//     var head = document.getElementsByTagName('head')[0];
//     head.append(cssLink);
// };

$(document).ready(function () {

    var url = window.location.href.split("/")
    var page = url[url.length - 1];
    var tag = window.location.hash;

    $("#add_address").click(function () {
        var contactForm = $("#contact_form");
        if (contactForm.css('display') == 'none') {
            contactForm.css('display', 'block');
            $(this).addClass('active');
        }/* else {
            contactForm.css('display', 'none');
            $(this).removeClass('active');
        }*/
    });

    listToArray($(".grid-product-card-img-top")).forEach(function (elem) {
        if (elem.nextElementSibling.className == 'grid-product-img-info') {
            elem.nextElementSibling.style.height = $(elem).css("height");
            elem.nextElementSibling.style.width = $(elem).css("width");

        }
    });

    $('.select-shop').click(function () {
        setCookie("YnJhbmNo", $(this).attr('data-id'), 1);
        location.reload();
    });

    $("#add_card").click(function () {
        var paymentForm = $("#payment_form");
        if (paymentForm.css('display') == 'none') {
            paymentForm.css('display', 'block');
            $(this).addClass('active');
        } /*else {
            paymentForm.css('display', 'none');
            $(this).removeClass('active');
        }*/
    });

    $('#ratingModal').on('show.bs.modal', function (e) {
        $('#rating-id').attr("data-id", e.relatedTarget.getAttribute('data-id'));
    });
    $('#rate-order').click(function () {
        $.post("post/addRatings", {
            id: $('#rating-id').attr('data-id'),
            ratings: $('input[name="rating"]:checked').val(),
            comment: $('input[name="comment"]').val(),
        }, function (data, status) {
            var lang = getCookie('lingo');
            // console.log(data);
            data = JSON.parse(data);
            if (data.result == true) {
                webToast.Success({
                    status: dictionary['successful'][lang],
                    message: dictionary['order-rated'][lang],
                    delay: 5000
                });

            } else {
                webToast.Info({
                    status: "",
                    message: dictionary['already-rated'][lang],
                    delay: 5000
                });
            }
            $('#ratingModal').modal('hide');
        });
    });

    $('.order-again').click(function () {
        var cart = [];
        var data = $(this).attr('data-id').replace('"[', "[").replace(']"', "]");
        JSON.parse(data).forEach(function (item) {
            var options = [];
            item.productOptions.forEach(function (option) {
                options.push({
                    name: option.name,
                    value: option.amount
                });
            });

            var obj = {
                pId: item.productId,
                total: item.amount,
                note: item.additionalNote.substring(0, 120),
                options: options,
            };
            cart.push(obj);
        });
        setCookie('order', '' + base64en(JSON.stringify(cart)) + '', 20);
        window.location.href = 'checkout';
    });

    $('.delete-order').click(function () {
        var btn = $(this);
        var lang = getCookie('lingo');
        mcxDialog.confirm(dictionary['are-you-sure'][lang], {
            // titleText: "",
            cancelBtnText: dictionary['cancel'][lang],
            sureBtnText: dictionary['proceed'][lang],
            sureBtnClick: function () {
                $.post('post/deleteOrder', {
                    id: btn.attr('data-id'),
                }, function (data, status) {
                    // console.log(data);
                    var lang = getCookie('lingo');
                    data = JSON.parse(data);
                    if (data.result == true) {
                        btn.parent().parent().parent().css('display', 'none');
                    } else {
                        webToast.Danger({
                            status: "",
                            message: dictionary['failed'][lang],
                            delay: 5000
                        });
                    }
                });
            }
        });
    });

    $('#close-card-success').click(function () {
        $("#payment_form").css('display', 'none');
    });

    $('#postalCode').keyup(function () {
        postalGeocoding($(this).val());
    });

    function showDeliveryInfo(id) {
        switch (parseInt(id)) {
            case 5:
                return { 0: "Your order has been delivered", trn: 'order-delivered' };
            case 1:
                return { 0: "Your order has been received", trn: 'order-received' };
            case 3:
                return { 0: "Order has been shipped", trn: 'order-shipped' };
            case 4:
                return { 0: "Your order is on the way", trn: 'order-onway' };
            case 2:
                return { 0: "Order is ready", trn: 'order-ready' };
        }
    }

    try {
        setInterval(function () {
            var track = $('input[name="track-id"]');
            $.post('post/updateDelivery', {
                id: track.val(),
            }, function (data, status) {
                data = data.stripSlashes().stripSlashes().split('"[').join('[').split('["').join('[');
                data = (data.split(']"').join(']').split('"{').join('{').split('}"').join('}'))
                try {
                    data = (JSON.parse(data));
                    var html = '<li class="row justify-content-between" id="start">' + $('#start').html() + '</li>';
                    var timeline = $('.timeline');
                    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    data.status.forEach((element) => {
                        var d = new Date(element.time * 1000);
                        // var cD = new Date();
                        var id = element.status;
                        //same year getFullYear()
                        html += '<li class="row justify-content-between"><h5 trn="' + showDeliveryInfo(id).trn + '">' + showDeliveryInfo(id)[0] + '</h5><p class="float-right">' + months[d.getMonth()] + " " + d.getDate() + ", " + d.getDate() + ":" + d.getMinutes() + '</p></li>'
                    });

                    timeline.html(html);
                } catch (e) {

                }
            });
        }, 10000)
    } catch (e) {

    }

    if (window.location.hash != "") {
        if (window.location.href.includes("profile")) {
            navigateFromTo("#fav", window.location.hash);
            $(".de-nav-link[href='#fav']").removeClass("active");
            $(".de-nav-link[href='" + window.location.hash + "']").addClass("active");

            $('#confirmationModal').on('show.bs.modal', function (e) {
                $('#confirm-btn').attr("data", e.relatedTarget.getAttribute('data-id'));
                $('#confirm-btn').attr("page", e.relatedTarget.getAttribute('data-page'));
            });

            $('#confirm-btn').click(function () {
                switch ($(this).attr("page")) {
                    case "payment":
                        $.post("post/deleteMOP", { id: $(this).attr("data") }, function (data, status) {
                            data = JSON.parse(data);
                            if (data.result == true) {
                                if (window.history.replaceState) {
                                    window.history.replaceState(null, null, window.location.href);
                                }
                                location.reload();
                            } else {
                                // //console.log(data);
                            }
                        });
                        break;
                    case "info":
                        $.post("post/deleteAddress", { id: $(this).attr("data") }, function (data, status) {
                            data = JSON.parse(data);
                            if (data.result == true) {
                                if (window.history.replaceState) {
                                    window.history.replaceState(null, null, window.location.href);
                                }
                                location.reload();
                            } else {
                                // //console.log(data);
                            }
                        });
                        break;
                }
            });

        }
        if (window.location.href.includes("auth")) {
            if (window.location.hash == "#register")
                navigateFromTo("login", "register");
        }
    }

    $("a[href='#login']").click(function () {
        if ($('.alert-danger') !== undefined)
            $('.alert-danger').css("display", "none");
        navigateFromTo("register", "login");
    });
    $("a[href='#register']").click(function () {
        if ($('.alert-danger') !== undefined)
            $('.alert-danger').css("display", "none");
        navigateFromTo("login", "register");
    });

    $('.list-product-card').click(function () {
        // var details = $(this).parent().find('div.product-list-details');

        // if (details.css('display') == "none") {
        //     details.css('display', 'flex');
        //     $(this).css('display', 'none');
        // }
        // else {
        //     details.css('display', 'none');
        //     $(this).css('display', 'flex');
        // }

    });
    // setInterval(function () {
    //    }, 100);

    $('.de-nav-link').click(function () {
        var oldId = window.location.hash == "" ? "#fav" : window.location.hash;
        var newId = $(this).attr("href");
        window.location.hash = newId;
        navigateFromTo(oldId, newId);
    });

    $('.modal-option-header').click(function () {
        if ($(this).find("i").attr('class').includes("mdi-chevron-down")) {
            $(this).find("i").removeClass("mdi-chevron-down");
            $(this).find("i").addClass("mdi-chevron-right");
        } else {
            $(this).find("i").removeClass("mdi-chevron-right");
            $(this).find("i").addClass("mdi-chevron-down");
        }
    });

    $("#logout").click(function () {
        window.location.href = "logout";
    });

    $(".list-product-fav").click(function () {
        if ($(this).attr('class').includes("ri-heart-line")) {
            $(this).removeClass("ri-heart-line");
            $(this).addClass("ri-heart-fill");
            $(this).css("color", "#FA1616");

        } else {
            $(this).addClass("ri-heart-line");
            $(this).removeClass("ri-heart-fill");
            $(this).css("color", "#000");
        }

    });

    $('#productModal').on('show.bs.modal', function (e) {
        var invoker = $(e.relatedTarget);
        var dataElem;
        if (invoker.prop("tagName") == "BUTTON") {
            dataElem = invoker.parent().parent().parent().find('input[type="hidden"]');
        } else if (invoker.prop('tagName') == "H4") {
            dataElem = invoker.next();
        }
        var content = JSON.parse(base64de(dataElem.attr("data-content")));
        var modal = $(this);
        modal.find('#product-modal-name').html(content.name);
        modal.find('#product-modal-description').html(content.description);
        modal.find('#product-modal-price').html(money(content.price));
        if (content.displayImage != "") {
            modal.find('#product-modal-img').attr('src', content.displayImage);
        } else {
            modal.find('#product-modal-img').attr('src', $('#product-modal-img').attr('data-placeholder'));
        }
        modal.find('#product-modal-total-price').html(money(content.price));
        modal.find('input[name="product-modal-total"]').val(content.price);
        modal.find(('input[name="product-details"]')).val(encode(JSON.stringify(content)));
        try {
            modal.find('#product-modal-ratings').html(parseInt(content.ratings == "" ? 0 : content.ratings).toFixed(1));
        } catch (e) {

        }
        try {
            modal.find('#product-modal-orderCount').html(parseInt((content.orderCount == "null" || content.orderCount == null) ? 0 : content.orderCount));
        } catch (e) {

        }
        var categories = [];
        $('#option-display').html("");
        try {
            content.productOptions.forEach(function (option) {
                var category = {};
                category.id = option.category.id;
                category.name = option.category.name;
                category.html = getCategoryChildren(content.productOptions, option.category.id);
                categories.push(category);
            });
            var uniqueCategoriesId = [];
            var html = "";
            categories.forEach(function (category) {
                if (!uniqueCategoriesId.includes(category.id)) {
                    uniqueCategoriesId.push(category.id);
                    if (category.name == "") {
                        html += category.html;
                    } else {
                        html += '<div class="accordion mt-2 mb-2" id="accordion' + category.name + '"><div><div class="modal-option-header row col-12 pl-3 pb-2 pt-2" data-toggle="collapse" data-target="#collapse' + category.name + '" aria-expanded="true" aria-controls="collapse' + category.name + '"><span class="text-left col-8">' + category.name + '</span><i class="mdi mdi-chevron-right text-right text-muted col-4"></i></div><div id="collapse' + category.name + '" class="collapse pl-4 pt-1" data-parent="#accordion' + category.name + '">' + category.html + '</div></div></div>';
                    }
                }

            });
            $('#option-display').html(html);

            $('.plus').click(function () {
                $(this).prev().val(parseInt($(this).prev().val()) + 1).change();
            });
            $('.minus').click(function () {
                if (parseInt($(this).next().val()) > 0)
                    $(this).next().val(parseInt($(this).next().val()) - 1).change();
            });

            $('.product-modal-option').change(function () {
                var obj = JSON.parse(decode($(this).attr('data-object')));
                var totalDisplay = $('#product-modal-total-price');
                var total = $('input[name="product-modal-total"]');
                if (obj.price != "") {
                    var np = parseInt(total.val());
                    if (!isNaN($(this).val())) {
                        if (obj.amount == undefined) {
                            np += parseInt(obj.price) * parseInt($(this).val());
                        } else {
                            var diff = parseInt($(this).val()) - parseInt(obj.amount);
                            np += parseInt(obj.price) * (diff);
                        }
                        obj.amount = parseInt($(this).val());
                        $(this).attr('data-object', encode(JSON.stringify(obj)));


                    }
                    else if ($(this).is(':checked')) {
                        np += parseInt(obj.price);
                    } else {
                        np -= parseInt(obj.price);
                    }
                    total.val(np);
                    totalDisplay.html(money(total.val()));
                }
            });

        } catch (e) {

        }

    });

    $('[name="place-order"]').click(function (e) {
        var lang = getCookie('lingo');
        spinner('checkout').show();
        webToast.loading({
            status: dictionary['loading'][lang],
            message: dictionary['please-wait'][lang],
            delay: 100000
        });
    });
    // AJAX ADD FAVOURITE
    $(".grid-product-fav").click(function () {
        if ($(this).attr("data-id") == "") {
            location.href = "auth";
        }
        var icon = $(this);
        if ($(this).attr('class').includes("ri-heart-line")) {
            $.post("post/addFavorite", {
                id: $(this).attr("data-id"),
            }, function (data, status) {
                // console.log(data);
                data = JSON.parse(data);
                if (data.result == true) { //check added or remove and decide
                    icon.removeClass("ri-heart-line");
                    icon.addClass("ri-heart-fill");
                    icon.css("color", "#FA1616");
                } else {
                    //error
                }
            });
        } else {
            $.post("post/removeFavorite", {
                id: $(this).attr("data-id"),
            }, function (data, status) {
                // console.log(data);
                data = JSON.parse(data);
                if (data.result == true) { //check added or remove and decide
                    icon.addClass("ri-heart-line");
                    icon.removeClass("ri-heart-fill");

                    if (page == "profile" || tag == "#fav")
                        icon.parent().parent().css('display', 'none');
                } else {
                    //error
                }
            });
        }
    });

    function updateCartAmount(id, val) {
        $.post("post/updateCartQuantity", { id: id, val: val }, function (data, status) {
            data = JSON.parse(data.toString());
            // //console.log(data);
            if (data.result == true) {
                getCartItem();
            } else {
                //
            }
        });
    }
    function deleteItem(elem) {
        mcxDialog.confirm(dictionary['are-you-sure'][lang], {
            // titleText: "",
            cancelBtnText: dictionary['cancel'][lang],
            sureBtnText: dictionary['proceed'][lang],
            sureBtnClick: function () {
                return $.post("post/deleteCartItem", { id: elem.attr('data-id') }, function (data, status) {
                    //console.log(data);
                    var lang = getCookie('lingo');
                    data = JSON.parse(data);
                    if (data.result == true) {
                        getCartItem();

                    } else {
                        webToast.Danger({
                            status: dictionary['error-occured'][lang],
                            message: dictionary[data.error.trn][lang],
                            delay: 5000
                        });
                        // //console.log(data);
                    }
                });
            }
        });
    }
    var deliveryInfo = $('#deliveryInfo');

    try {
        var date = new Date(Date.now() + 60000 * base64de(deliveryInfo.attr('data-delivery-time')));
    } catch (e) {
        var date = new Date(Date.now() + 3600000);
    }

    $('[data-toggle="datepicker"]').datepicker({
        format: 'yyyy/mm/dd',
        startDate: Date.now(),
        yearSuffix: '年',
        endDate: new Date(Date.now() + 1209600000)
    });

    try {
        var operationTimes = JSON.parse(base64de($('data#operationalTime').attr('data-value')));
    } catch (e) {

    }
    $('[data-toggle="datepicker"]').change(function () {
        var deliveryTime = ($('#delivery-time-display').val())
        var today = new Date();
        today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        var dateSelected = new Date($(this).val());
        var daySelected = ((dateSelected.getTime() - today.getTime()) / 86400000);
        if (daySelected > 6) {
            if (daySelected % 7 == 0)
                daySelected = 0;
            else
                daySelected = daySelected - 7;
        }
        var times = (operationTimes[daySelected]);
        try {
            var open = times.open.split(":");
            var hr = parseInt(open[0]);
            var min = parseInt(open[1]) + 30;
            if (min >= 60) { min = min - 60; hr++; }
            times.open = hr + ":" + min;
            if (isNaN(hr)) { times.open = "" }
        } catch (e) {

        }
        $('[data-toggle="timepicker"]').timepicker({
            step: 15,
            show2400: true,
            minTime: times.open,
            maxTime: times.close,
            disableTimeRanges: [times.breakStart, times.breakEnd],
        });
    });


    if ($('input[name="delivery_option"]:checked').val() == 2) {
        deliveryTimeToast.clear();

    }
    $('input[name="delivery_option"]').change(function () {
        if ($(this).val() == 1) {
            $('#takeout-time').css('display', 'none');
            $(".take-out-info").css('display', 'none');
            $('.delivery-info').css('display', 'block');
            deliveryTimeToast.show($('#delivery-time-display').html())
        } else {
            $(".take-out-info").css('display', 'block');
            $('.delivery-info').css('display', 'none');
            $('#takeout-time').css('display', 'block');
            deliveryTimeToast.clear();

        }
    });

    if ($('#card-saved').val() != undefined) {
        if ($('#use-new-info').is(':checked')) {
            $('#new-checkout-address').css('display', 'block');
        } else {
            $('#new-checkout-address').css('display', 'none');
        }
    }



    if ($('input[name="payment_option"]:checked').val() == "card") {
        $('#saved-cards').css('display', 'block');

    } else {
        $('#saved-cards').css('display', 'none');
    }

    if ($('#use-new-card').is(':checked')) {
        $('#new-checkout-payment').css('display', 'block');
    } else {
        $('#new-checkout-payment').css('display', 'none');
    }

    // if ($('input[name="checkout-payment"]:checked').attr('data-id') == "use-new-payment") {
    //     $("#new-checkout-payment").css('display', 'block');
    // }
    $('input[name="checkout-address"]').change(function () {
        if ($('#new-checkout-address').css('display') == 'block') {
            $('#new-checkout-address').css('display', 'none');
            $('input[name="fname"]').removeAttr('required');
            $('input[name="lname"]').removeAttr('required');
            $('input[name="phone"]').removeAttr('required');
            $('input[name="email"]').removeAttr('required');
            $('input[name="zip"]').removeAttr('required');
            $('input[name="city"]').removeAttr('required');
            $('input[name="address"]').removeAttr('required');
            $('input[name="street"]').removeAttr('required');
        }
        if ($(this).attr('data-id') == "use-new-address") {
            $('#new-checkout-address').css('display', 'block');
            $('input[name="fname"]').attr('required', 'true');
            $('input[name="lname"]').attr('required', 'true');
            $('input[name="phone"]').attr('required', 'true');
            $('input[name="email"]').attr('required', 'true');
            $('input[name="zip"]').attr('required', 'true');
            $('input[name="address"]').attr('required', 'true');
            $('input[name="city"]').attr('required', 'true');
            $('input[name="street"]').attr('required', 'true');

        }

    });


    if (page == 'checkout') {
        var card = $('.creditcardform').card({
            debug: true,
            container: '.card-wrapper',
            formatting: true,
            formSelectors: {
                numberInput: 'input[name="number"]',
                expiryInput: 'input[name="expiry"]',
                cvcInput: 'input[name="cvc"]',
                nameInput: 'input[name="name"]'
            }, cardSelectors: {
                cardContainer: '.jp-card-container',
                card: '.jp-card',
                numberDisplay: '.jp-card-number',
                expiryDisplay: '.jp-card-expiry',
                cvcDisplay: '.jp-card-cvc',
                nameDisplay: '.jp-card-name'
            }, classes: {
                valid: 'jp-card-valid',
                invalid: 'jp-card-invalid'
            }, masks: {
                cardNumber: false,
            },
        });
    }

    $('.category-pill').click(function () {
        if ($(this).attr('href') != undefined) {
            var tag = $(this).attr('href');
            scrollTo(tag.substring(1, tag.length));
        }
        var id = $(this).attr('data-id');
        var products = $('.grid-product-card-wrap');

        listToArray(products).forEach(function (product) {
            $(product).css('display', 'block');

        });
        if (id !== undefined) {
            var belongs = [];
            listToArray(products).forEach(function (product) {
                try {
                    var categories = JSON.parse($(product).attr('data-categories'));
                    if (categories.includes(id)) {
                        belongs.push(product);
                    }
                } catch (E) {

                }
            });

            listToArray(products).forEach(function (product) {
                if (!belongs.includes(product)) {
                    $(product).css('display', 'none');
                }
            });
        }
    });

    $('input[name="payment_option"]').change(function () {
        if ($(this).is(':checked')) {
            if ($('#saved-cards').css('display') == 'block') {
                $('#saved-cards').css('display', 'none');
                $('#new-checkout-payment').css('display', 'none');

            }
            if ($(this).val() == "card") {
                if ($('#card-saved').val() == undefined)
                    $('#new-checkout-payment').css('display', 'block');
                $('#saved-cards').css('display', 'block');
                if ($('#use-new-card').is(':checked')) {
                    $('#new-checkout-payment').css('display', 'block');
                }
            }
        }
    });

    $('#show-reservation').click(function () {
        if ($(this).next().css('display') == 'none') {
            $(this).next().css('display', 'flex');
            deliveryTimeToast.clear();
        } else {
            $(this).next().css('display', 'none');
            deliveryTimeToast.show($('#delivery-time-display').html())
        }
    });


    $('input[name="checkout-payment"]').change(function () {
        // if ($(this).is(':checked')) {
        if ($('#new-checkout-payment').css('display') == 'block') {
            $('#new-checkout-payment').css('display', 'none');
            $('input[name="number"]').removeAttr('required');
            $('input[name="expiry"]').removeAttr('required');
            $('input[name="name"]').removeAttr('required');
            $('input[name="cvc"]').removeAttr('required');
        }
        if ($(this).attr('data-id') == "use-new-payment") {
            $('#new-checkout-payment').css('display', 'block');
            $('input[name="number"]').attr('required', 'true');
            $('input[name="expiry"]').attr('required', 'true');
            $('input[name="name"]').attr('required', 'true');
            $('input[name="cvc"]').attr('required', 'true');
        }
        // }
    });


    function getCartItem() {
        $.post("get/cartItems", { id: $('#cart').attr('data-id') }, function (data, status) {
            //  console.log(data);
            data = JSON.parse(data);
            if (data.result == true) {
                var total = 0;
                var totalDisplay = $('#cart-total');
                var cartItems = $('#cart-items');
                var tax = $('#tax');
                data = JSON.parse(data.data);
                // //console.log(data);
                cartItems.html("");
                var html = "";
                data.forEach(function (item) {
                    var options = "";
                    item.productOptions.forEach(function (option) {
                        var quantity = (typeof option.amount === "boolean") ? option.amount ? 1 : 0 : option.amount;
                        options += unicodeToChar(option.name) + "<strong> X" + quantity + "</strong>・";
                    });
                    var quantity = (item.quantity) ?? 0;
                    // html +='<style>.delete-btn{position:absolute;font-size:24px;right:0;top:0;margin-right:10px;margin-top:10px;cursor:pointer;color:#000;z-index:10}.delete-btn:hover{color:#666666}.delete-btn:active{font-size:22px}.delete-btn-danger{color:#ec7575}.delete-btn-danger:hover{color:rgb(175,10,10)}</style>';
                    html += '<div data-id="' + item.id + '"><div class="pt-3 pb-3"><div class="row col-12"><i class="mdi mdi-delete delete-btn delete-btn-danger" data-page="delete-cart-item" data-id="' + item.datid + '" style="margin-top:-8px; margin-right:-8px"></i><div class="col-lg-1 col-md-1 col-sm-1 text-left pr-3"><h5 class="span-circle" style="background-color:#05C776;">x' + quantity + '</h5></div><div class="col-lg-8 col-md-8 col-sm-5 text-left pl-4 mt-1"><h4 class="order-sub-title font-weight-bold">' + item.productDetails + '</h4><div style="font-size:14px"><span class="text-muted">' + options + '</span><br><span class="text-muted"><span>Note</span>:"' + item.additionalNote + '" </span></div></div><div class="col-lg-3 col-md-3 col-sm-6 text-lg-center text-sm-right"><span class="order-sub-title font-weight-bold ml-2">' + money(parseInt(item.amount) * parseInt(item.quantity)) + '</span><div class="qty text-right"><i class="mdi mdi-minus-circle" data-id="' + item.datid + '"></i><input type="number" class="count" name="qty" value="' + quantity + '"><i class="mdi mdi-plus-circle" data-id="' + item.datid + '"></i></div></div></div></div><div class="row-hr"></div></div>';
                    total += parseInt(item.amount) * parseInt(item.quantity);
                    // JSON.parse(`["\\u${unicodeText}"]`)
                    //String.fromCharCode(parseInt(unicode,16))
                });
                if (tax !== undefined) {
                    tax.html(money(Math.round(0.08 * total)));
                }
                cartItems.html(html);
                totalDisplay.html(money(total));



                $('.mdi-delete').click(function () {
                    switch ($(this).attr('data-page')) {
                        case 'delete-cart-item':
                            deleteItem($(this));
                            break;
                    }
                });

                $('.mdi-plus-circle').click(function () {
                    $(this).prev().val(parseInt($(this).prev().val()) + 1).change();
                    if ($(this).attr('data-id') != undefined) {
                        updateCartAmount($(this).attr('data-id'), $(this).prev().val());
                    }
                });
                $('.mdi-minus-circle').click(function () {
                    if (parseInt($(this).next().val()) > 0)
                        $(this).next().val(parseInt($(this).next().val()) - 1).change();
                    if ($(this).attr('data-id') != undefined) {
                        updateCartAmount($(this).attr('data-id'), $(this).next().val());
                    }
                });

            } else {

                // //console.log(data);
            }
        });

    }

    $('.mdi-delete').click(function () {
        switch ($(this).attr('data-page')) {
            case 'delete-cart-item':
                deleteItem($(this));
                break;
        }
    });

    $('.mdi-plus-circle').click(function () {
        $(this).prev().val(parseInt($(this).prev().val()) + 1).change();
        if ($(this).attr('data-id') != undefined) {
            updateCartAmount($(this).attr('data-id'), $(this).prev().val());
        }
    });
    $('.mdi-minus-circle').click(function () {
        if (parseInt($(this).next().val()) > 0)
            $(this).next().val(parseInt($(this).next().val()) - 1).change();
        if ($(this).attr('data-id') != undefined) {
            updateCartAmount($(this).attr('data-id'), $(this).next().val());
        }
    });
    try {
        // var conn = new WebSocket('ws://localhost:800/echo');
        // conn.onmessage = function (e) { console.log(e.data); };
        // conn.onopen = function (e) { conn.send('Hello Me!'); };
    } catch (e) {
        console.log(e);
    }
    $('#cart-checkout').click(function () {
        setCookie('order', ('ZnJvbS1jYXJ0'), 20);
        window.location.href = 'checkout';

    });

    $('.cart-order').click(function () {
        var productDetails = JSON.parse(decode($('input[name="product-details"]').val()));
        var sId = $('input[name="session"]').val();
        var options = listToArray($('.product-modal-option')).map(function (option) {
            var obj = {}
            obj.name = $(option).attr('data-value')
            obj.value = isNaN($(option).val()) ? ($(option).is(':checked')) : $(option).val();
            return obj;
        });
        var note = $('textarea[name="product-modal-note"]').val();
        var total = $('input[name="product-modal-total"]').val();
        function sencode(data, i = 0) {
            var rt = data;
            for (var j = 0; j < i; j++) {
                rt = base64en(rt);
            }
            return rt;
        }
        var iteration = Math.floor(Math.random() * 20) + 1;
        var obj = {
            id: sencode(iteration, 1), data: sencode(JSON.stringify({
                pId: { id: productDetails.id, name: productDetails.name },
                sId: sId,
                total: total,
                note: note,
                options: options,
            }), iteration)
        };
        switch ($(this).attr('data-page')) {
            case "add-to-cart":
                $.post("post/addToCart", obj, function (data, status) {
                    // console.log(data);
                    var lang = getCookie('lingo');
                    data = JSON.parse(data);
                    if (data.result == true) {
                        getCartItem();
                        webToast.Success({
                            status: dictionary['successful'][lang],
                            message: dictionary['cart-added'][lang],
                            delay: 2000
                        });

                    } else {
                        webToast.Danger({
                            status: dictionary['error-occured'][lang],
                            message: dictionary[data.error.trn][lang],
                            delay: 5000
                        });
                        // //console.log(data);
                    }
                });
                break;
            case "order-now":
                var obj = {
                    pId: productDetails.id,
                    total: total,
                    note: note.substring(0, 120),
                    options: options,
                };
                setCookie('order', '' + base64en(JSON.stringify(obj)) + '', 20);
                window.location.href = 'checkout';
                break;

        }

    });

});