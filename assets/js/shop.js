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


window.onresize = function () {
    var w = window.innerWidth;
    if (w >= 992) {
        $('body').removeClass('sidebar-open');
        $('#navbarSupportedContent').removeClass('show');
    }
}

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
                        html += '<div class="row ' + temp + ' col-12 mb-1 "><div class="col-6 p-0 p-sm-3 m-0 text-left"><span>' + option.name + '</span></div><div class="col-6 p-0 p-sm-3 m-0 qty text-right"><i class="mdi mdi-minus-circle"></i><input data-object="' + encode(JSON.stringify(option)) + '" type="number" class="count product-modal-option" data-value="' + option.name + '" name="qty" value="0"><i class="mdi mdi-plus-circle"></i></div></div>';
                    } else {
                        html += '<div class="row ' + temp + ' col-12 mb-1"><div class="col-4 p-0 p-sm-3 m-0 text-left"><span>' + option.name + '</span></div><div class="col-4 p-0 p-sm-3 m-0 text-center"><span class="badge price-tag">' + option.price + '</span></div><div class="col-4 p-0 p-sm-3 m-0 qty text-right"><i class="mdi mdi-minus-circle"></i><input data-object="' + encode(JSON.stringify(option)) + '" type="number" class="count product-modal-option" data-value="' + option.name + '" name="qty" value="0"><i class="mdi mdi-plus-circle"></i></div></div>';
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

$(document).ready(function () {
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
    $('#close-card-success').click(function () {
        $("#payment_form").css('display', 'none');
    });
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
                                // console.log(data);
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
                                // console.log(data);
                            }
                        });
                        break;
                }
            });
            $('#postalCode').keyup(function () {
                postalGeocoding($(this).val());
            });

        }
        if (window.location.href.includes("auth")) {
            if (window.location.hash == "#register")
                navigateFromTo("login", "register");
        }
    }

    $("a[href='#login']").click(function () {
        navigateFromTo("register", "login");
    });
    $("a[href='#register']").click(function () {
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
    setInterval(function () {
        listToArray($(".grid-product-card-img-top")).forEach(function (elem) {
            if (elem.nextElementSibling.className == 'grid-product-img-info') {
                elem.nextElementSibling.style.height = $(elem).css("height");

            }
        });
        // $(".list-product-img-info").css("width", $(".list-product-card-img-top").width() + 30 + "px");
        $(".modal-header").css("height", $(".product-img").css("height"));
    }, 100);

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
    // AJAX ADD FAVOURITE
    $(".grid-product-fav").click(function () {
        //redirect to loginpage if not logged in
        if ($(this).attr('class').includes("ri-heart-line")) {
            // $.post("post/addFavorite", {
            //     idd: $(this).attr("data-id")
            // }, function (data, status) {
            //     console.log(data);
            //     data = JSON.parse(data);
            //     if (data.result == true) { //check added or remove and decide
            $(this).removeClass("ri-heart-line");
            $(this).addClass("ri-heart-fill");
            $(this).css("color", "#FA1616");

            //     } else {
            //         //error
            //     }
            // });


        } else {
            $(this).addClass("ri-heart-line");
            $(this).removeClass("ri-heart-fill");
            $(this).css("color", "#FFF");
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
        var content = JSON.parse(dataElem.attr("data-content"));
        var modal = $(this);
        modal.find('#product-modal-name').html(content.name);
        modal.find('#product-modal-description').html(content.description);
        modal.find('#product-modal-price').html(money(content.price));
        if (content.displayImage != "") {
            modal.find('#product-modal-img').attr('src', content.displayImage);
        } modal.find('#product-modal-total-price').html(money(content.price));
        modal.find('input[name="product-modal-total"]').val(content.price);
        modal.find(('input[name="product-details"]')).val(JSON.stringify(content));
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

            $('.mdi-plus-circle').click(function () {
                $(this).prev().val(parseInt($(this).prev().val()) + 1).change();
            });
            $('.mdi-minus-circle').click(function () {
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


    $('#order-now').click(function () {
        console.log("ORDER NOW")
    });

    $('.mdi-plus-circle').click(function () {
        $(this).prev().val(parseInt($(this).prev().val()) + 1).change();
    });
    $('.mdi-minus-circle').click(function () {
        if (parseInt($(this).next().val()) > 0)
            $(this).next().val(parseInt($(this).next().val()) - 1).change();
    });


    $('.cart-order').click(function () {
        var productDetails = JSON.parse($('input[name="product-details"]').val());
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
                rt = btoa(rt);
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
                    console.log(data);
                    var lang = getCookie('lingo');
                    data = JSON.parse(data);
                    if (data.result == true) {
                        //refresh all content in cart
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
                        // console.log(data);
                    }
                });
                break;
            case "order-now":
                console.log((JSON.stringify(obj)));
                setCookie('order', '' + JSON.stringify(obj) + '', 20);
                window.location.href = 'checkout';
                break;

        }

    });

    var url = window.location.href.split("/")
    var page = url[url.length - 1];
    if (page == 'checkout') {
        var data = getCookie('order');
        // setCookie('order', null, -20);
    }


});