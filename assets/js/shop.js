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

    // to.setAttribute("data-aos-easing", "ease-in-back");
    // to.setAttribute("data-aos-delay", "300");
    // to.setAttribute("data-aos-offset", "0");
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
                                console.log(data);
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
                                console.log(data);
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
        $(".grid-product-img-info").css("height", $(".grid-product-card-img-top").css("height"));
        $(".list-product-img-info").css("width", $(".list-product-card-img-top").width() + 30 + "px");
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

    $('.mdi-plus-circle').click(function () {
        $(this).prev().val(parseInt($(this).prev().val()) + 1);
    });
    $('.mdi-minus-circle').click(function () {
        if (parseInt($(this).next().val()) > 0)
            $(this).next().val(parseInt($(this).next().val()) - 1);
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
        if ($(this).attr('class').includes("ri-heart-line")) {
            $(this).removeClass("ri-heart-line");
            $(this).addClass("ri-heart-fill");
            $(this).css("color", "#FA1616");

        } else {
            $(this).addClass("ri-heart-line");
            $(this).removeClass("ri-heart-fill");
            $(this).css("color", "#FFF");
        }
    });


});