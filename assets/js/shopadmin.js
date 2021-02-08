
// var cart = document.getElementById("delivery-time-fab");
// window.onscroll = function () { if (cart != undefined) scrollFunction(cart) };

// function scrollFunction(e) {
//     if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
//         e.style.display = "block";
//     } else {
//         e.style.display = "none";
//     }
// }

function setColor(selector) {
    if (selector.attr("color") != undefined) {
        var color = tinycolor(selector.attr("color"));
        selector.css("background-color", selector.attr("color"));
        if (color.getBrightness() < 200) {
            selector.css("color", "white");
        } else {
            selector.css("color", "#212121")
        }
    }
    // console.log(sel)
}

function show(btn, div, display, hide = false) {
    $(btn).click(function () {
        var form = $(div);
        if (form.css('display') == 'none') {
            form.css('display', display);
            $(this).addClass('active');
        } else {
            if (hide) {
                form.css('display', 'none');
                $(this).removeClass('active');
            }
        }
    });
}
function hide(selector) {
    $(selector).css('display', 'none');
}
//  spinner.show(); hide()

function async(api, btn) {
    var lang = getCookie('lingo');
    switch (api) {
        case 'staff-level':
            $.post("post/updateStaffLevel",
                {
                    id: btn.attr("data-id"),
                    status: btn.attr('data')
                },
                function (data, status) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.result == true) {
                        webToast.Success({
                            status: dictionary['successful'][lang],
                            message: dictionary['staff-updated'][lang],
                            delay: 5000
                        });
                        // location.reload();
                    } else {
                        console.log(data);
                    }
                });
            break;
        case 'branch-status':
            $.post("post/updateBranchStatus",
                {
                    id: btn.attr("data-id"),
                    status: btn.attr('data')
                },
                function (data, status) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.result == true) {
                        webToast.Success({
                            status: dictionary['successful'][lang],
                            message: dictionary['branch-updated'][lang],
                            delay: 5000
                        });
                        // location.reload();
                    } else {
                        console.log(data);
                    }
                });
            break;
        case 'product-status':
            $.post("post/updateProductStatus",
                {
                    id: btn.attr("data-id"),
                    status: btn.attr('data')
                },
                function (data, status) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.result == true) {
                        webToast.Success({
                            status: dictionary['successful'][lang],
                            message: dictionary['product-updated'][lang],
                            delay: 5000
                        });
                        // location.reload();
                    } else {
                        console.log(data);
                    }
                });
            break;
        case 'order-status':
            $.post("post/updateOrderStatus",
                {
                    id: btn.attr("data-id"),
                    status: btn.attr('data')
                },
                function (data, status) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.result == true) {
                        webToast.Success({
                            status: dictionary['successful'][lang],
                            message: dictionary['order-updated'][lang],
                            delay: 5000
                        });
                        // location.reload();
                    } else {
                        console.log(data);
                    }
                });
            break;
        default:
            break;
    }
    console.log(api);
}

function playSound(url) {
    var audio = document.createElement('audio');
    audio.style.display = "none";
    audio.src = url;
    audio.autoplay = true;
    audio.onended = function () {
        audio.remove() //Remove when played.
    };
    document.body.appendChild(audio);
}

function getUpload(inputId, imgId, inputName, otherPreview) {
    $(inputId).change(function () {
        var file = $(this).get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(imgId).attr('src', e.target.result);
                if (otherPreview != undefined && otherPreview != null) {
                    $(otherPreview).attr('src', e.target.result);
                    // console.log($(otherPreview));
                    // console.log($(otherPreview).attr('src'));
                }
                try {
                    $('input[name="' + inputName + '"]').val(e.target.result);
                } catch (r) {

                }
            }
            reader.readAsDataURL(file);
        }
    });
}

function trim(x) {
    try {
        return x.replace(/^\s+|\s+$/gm, '');
    } catch (error) {
        return x;
    }
}

function delOption(nodeList, element) {
    var nodes = [];
    var index;
    for (i = 0; i < nodeList.length; i++) {
        var node = nodeList[i];
        try {
            if (node.tagName.toLowerCase() == "span") {
                nodes.push(nodeList[i]);
            }
        } catch (E) {
        }
    }

    for (i = 0; i < nodes.length; i++) {
        if (element == nodes[i]) {
            index = i;
        }
    }

    var display = $('#options-input-div');
    var storage = $('input[name="options"]');
    var former = JSON.parse(base64de(storage.val()));
    former.splice(index, 1);
    nodes.splice(index, 1);
    storage.val(base64en(JSON.stringify(former)));
    var temp = "";
    nodes.forEach(function (elem) {
        temp += elem.outerHTML;
    });
    display.html(temp);
}

function updateRevenueGraph(label, data) {
    $(function () {

        //Revenue Chart
        if ($("#revenue-chart").length) {
            var revenueChartCanvas = $("#revenue-chart").get(0).getContext("2d");

            var revenueChart = new Chart(revenueChartCanvas, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                        data: data,
                        backgroundColor: "rgba(255, 86, 48, 0.3)",
                    }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                zeroLineColor: "rgba(0, 0, 0, 0.09)",
                                color: "rgba(0, 0, 0, 0.09)"
                            },
                            ticks: {
                                fontColor: '#bababa',
                                min: 0,
                                stepSize: 5000,
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                fontColor: '#bababa',
                                beginAtZero: true
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            barPercentage: 0.4
                        }]
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }
    });
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


$(document).ready(function () {
    var lang = getCookie('lingo');

    show("#add-staff", "#add-staff-form", 'table-row', true);
    show("#add-branch", "#add-branch-form", 'table-row', true);
    show("#delivery-time-fab", "#timer", 'block', true);
    getUpload("#browse", "#browse-preview", "banner");
    getUpload("#browse1", "#browse-preview1", "logo");
    getUpload("#browse2", "#browse-preview2", "image-placeholder");
    getUpload("#product-image", "#browse-preview", "product-img", "#preview-small");
    //preview-small
    $('#save-average-time').click(function () {
        // spinner('timer').show();
    });

    listToArray($(".grid-product-card-img-top")).forEach(function (elem) {
        if (elem.nextElementSibling.className == 'grid-product-img-info') {
            elem.nextElementSibling.style.height = $(elem).css("height");
            elem.nextElementSibling.style.width = $(elem).css("width");

        }
    });

    try {
        updateRevenueGraph(weekLabels, weekData);
    } catch (e) {

    }

    $('.revenew-tab').click(function () {
        switch (parseInt($(this).attr('data-index'))) {
            case 0: //weekly
                updateRevenueGraph(weekLabels, weekData);
                break;
            case 1: //month
                updateRevenueGraph(monthLabels, monthData);
                break;
            case 2: //3month
                updateRevenueGraph(threeMonthLabels, threeMonthData);
                break;
            case 3: //year
                updateRevenueGraph(yearLabels, yearData);

                break;
            case 4: //all
                updateRevenueGraph(allLabels, allData);
                break;
            default:
                console.log("wahala");
        }

    });

    $(".rotate").click(function () {
        $(this).toggleClass("down");
    });

    $('#addCategoryModal').on('show.bs.modal', function (e) {
        $('#add-btn').attr("data", e.relatedTarget.getAttribute('data-id'));
        $('#add-btn').attr("page", e.relatedTarget.getAttribute('data-page'));
    });
    $('.edit-product').click(function () {
        spinner('products-main').show();
        var productId = $(this).parent().parent().attr('data-id');
        setCookie('editProductId', productId, 1);
        window.location.href = 'edit-product';
    });

    getCookie('lingo') == 'en' ? $('a[lang="en"]').addClass('text-light') : $('a[lang="jp"]').addClass('text-light');
    $('.lang').click(function () {

        if ($(this).attr('lang') == 'en') {
            setCookie("lingo", 'en', 365);
            $('a[lang="jp"]').removeClass('text-light')
            translator('en');
        } else {
            setCookie("lingo", 'jp', 365);
            $('a[lang="en"]').removeClass('text-light')
            translator('jp');


        }
        $(this).addClass('text-white');
    });

    $('#color-picker').spectrum({
        type: "text",
        togglePaletteOnly: "true",
        hideAfterPaletteSelect: "true",
        showInput: "true",
        showInitial: "true"
    });
    try {
        if ($('data#branchData') != undefined) {
            loadFormData(JSON.parse(base64de($('data#branchData').attr('data-details'))));
            if ($('data#branchData').attr('data-times') != "null") {
                var times = base64de($('data#branchData').attr('data-times')).replace('"[', '[').replace(']"', ']');///.replace(/(&quot\;)/g, "\""));
                times = JSON.parse(times);
                times.forEach(function (time) {
                    var open = $('input[data-day="open[' + time.day + ']"]');
                    open.val(time.open);
                    var close = $('input[data-day="close[' + time.day + ']"]');
                    close.val(time.close);
                    var breakStart = $('input[data-day="breakStart[' + time.day + ']"]');
                    breakStart.val(time.breakStart);
                    var breakEnd = $('input[data-day="breakEnd[' + time.day + ']"]');
                    breakEnd.val(time.breakEnd);
                });
            }
        }
    } catch (e) {
        // console.log(e)
    }

    $('.branch').click(function () {
        if ($('#selectedBranch').val() == $(this).attr('data-id')) {
            $('.branch').css('background-color', '#FFF');
            $('#selectedBranch').val('');
            $('input[name="branch-id"]').val($(this).attr('data-id'));
            if ($('#branchInfo').css('display') == 'block') {
                $('#branchInfo').css('display', "none");

            }
            // if ($('#operationalTimes').css('display') == 'block') {
            //     $('#operationalTimes').css('display', "none");

            // }
        } else {
            loadFormData(JSON.parse(base64de($(this).attr('data-details'))));
            if ($(this).attr('data-times') != "null") {
                var times = JSON.parse(base64de($(this).attr('data-times')));
                //replace(/(&quot\;)/g, "\"")
                times.forEach(function (time) {
                    var open = $('input[data-day="open[' + time.day + ']"]');
                    open.val(time.open);
                    var close = $('input[data-day="close[' + time.day + ']"]');
                    close.val(time.close);
                    var breakStart = $('input[data-day="breakStart[' + time.day + ']"]');
                    breakStart.val(time.breakStart);
                    var breakEnd = $('input[data-day="breakEnd[' + time.day + ']"]');
                    breakEnd.val(time.breakEnd);
                });
            } else {
                ['Sunday', "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"].forEach(function (day) {
                    var open = $('input[data-day="open[' + day + ']"]');
                    open.val("");
                    var close = $('input[data-day="close[' + day + ']"]');
                    close.val("");
                    var breakStart = $('input[data-day="breakStart[' + day + ']"]');
                    breakStart.val("");
                    var breakEnd = $('input[data-day="breakEnd[' + day + ']"]');
                    breakEnd.val("");
                });

            }
            $('.branch').css('background-color', '#FFF');
            $(this).css('background-color', '#C4C4F4');
            $('#selectedBranch').val($(this).attr('data-id'));
            $('input[name="branch-id"]').val($(this).attr('data-id'));
            if ($('#branchInfo').css('display') == 'none') {
                $('#branchInfo').css('display', "block");

            }
            // if ($('#operationalTimes').css('display') == 'none') {
            //     $('#operationalTimes').css('display', "block");

            // }
        }

    });

    try {
        setInterval(function () {
            var orders = $('input[name="order-count"]').val();
            var norder = $('input[name="noc"]');
            $.post('get/orderNotification', {
                id: orders
            }, function (data, status) {
                data = data.stripSlashes().stripSlashes().split('"[').join('[').split('["').join('[');
                data = (data.split(']"').join(']').split('"{').join('{').split('}"').join('}'))
                data = (JSON.parse(data));

                // console.log(norder.val(), data.count);

                if (data.result.length > 0) {
                    playSound('assets/audio/notification.mp3');
                    webToast.Info({
                        status: dictionary['notification'][lang] + "(" + data.result.length + ")",
                        message: "<a href='orders'>" + dictionary['new-order'][lang] + "</a>",
                        delay: 5000
                    });
                }

            });
        }, 15000)
    } catch (e) {

    }


    try {
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
            }
        })
    } catch (e) {

    }

    $('#delete-card').click(function () {
        mcxDialog.confirm(dictionary['are-you-sure'][lang], {
            // titleText: "",
            cancelBtnText: dictionary['cancel'][lang],
            sureBtnText: dictionary['proceed'][lang],
            sureBtnClick: function () {
                var id = ($(this).attr('data-id'));
                $.post("post/deleteSubscription", {
                    id: id
                }, function (data, status) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.result == true) {
                        webToast.Success({
                            status: dictionary['successful'][lang],
                            message: dictionary['settings-updated'][lang],
                            delay: 5000
                        });
                        location.reload();
                    } else {
                        // //console.log(data);
                    }
                });
            }
        });

    });

    $('#add-btn').click(function () {
        lang = getCookie('lingo');
        switch ($(this).attr("page")) {
            // case "card":
            //     var nos = $('input[name="number"]').val();
            //     var name = $('input[name="name"]').val();
            //     var exp = $('input[name="expiry"]').val();
            //     var cvv = $('input[name="cvc"]').val();

            //     break;
            case 'add-product-category':
            case 'add-option-category':
                var name = $('#category-name');
                var description = $('#category-description');
                var errorDiv = $('#error-alert-add');
                var type = ($(this).attr("page") == "add-option-category") ? 2 : 1;
                if (name.val() == "" || name.val() == undefined) {
                    errorDiv.css("display", "block");
                } else {
                    $.post("post/addCategory", {
                        id: "",
                        name: name.val(),
                        description: description.val(),
                        type: type,
                        creatorId: $(this).attr("data")
                    }, function (data, status) {
                        // console.log(data);
                        data = JSON.parse(data);
                        if (data.result == true) {
                            webToast.Success({
                                status: dictionary['successful'][lang],
                                message: dictionary['category-added'][lang],
                                delay: 5000
                            });
                            if ($('#add-btn').attr("page") == "add-product-category") {
                                var ul = $("#product-categories-ul");
                                var newbox = '<div class="mdc-form-field"><div class="mdc-checkbox"><input type="checkbox" name="product-category[]" value="' + data.data.id + '" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" /><div class="mdc-checkbox__background"><svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24"><path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" /></svg><div class="mdc-checkbox__mixedmark"></div></div></div><label for="basic-disabled-checkbox" class="mt-2 h6" id="basic-disabled-checkbox-label">' + data.data.name + '</label></div>';
                                ul.html(ul.html() + newbox);
                                console.log(ul.html());
                            } else {
                                var ul = $("#option-categories-ul");
                                ul.html(ul.html() + '<li class="mdc-list-item" data-value="' + data.data.id + '">' + data.data.name + '</li>');
                            }
                        } else {
                            errorDiv.html(dictionary['category-exist'][lang]);
                            errorDiv.css("display", "block");
                        }
                    });
                }
                break;
        }


    });
    $('#category-name').keyup(function () {
        if ($(this).val() != "" && $(this).val() != undefined) {
            $('#error-alert-add').css("display", "none");
        }
    });

    $('#save-average-time').click(function () {
        var btn = $(this);
        $.post("post/updateDeliveryTime",
            {
                id: btn.attr("data-id"),
                time: $('#avdetime').val()
            },
            function (data, status) {
                // console.log(data);
                data = JSON.parse(data);
                if (data.result == true || data.error == null) {
                    if (window.history.replaceState) {
                        window.history.replaceState(null, null, window.location.href);
                    }
                    webToast.Success({
                        status: dictionary['successful'][lang],
                        message: dictionary['delivery-time-edited'][lang],
                        delay: 5000
                    });
                    // location.reload();
                } else {
                    console.log(data);
                }
            });
    });

    $('#add-option-btn').click(function (e) {
        e.preventDefault();
        var category = $('input[name="option-category"]');
        var name = $('input[name="option-name"]');
        var availability = $('input[name="option-availability"]');
        var price = $('input[name="option-price"]');
        var type = $('input[name="option-type"]');
        var display = $('#options-input-div');
        var storage = $('input[name="options"]');
        errText(name, name.val());
        if (name.val() != undefined && name.val() != "") {
            var value = { category: { name: $('#option-category-name').html(), id: category.val() }, name: name.val(), available: availability.val(), price: price.val(), type: type.val() };
            var former = JSON.parse(base64de(storage.val()));
            var exist = false;
            if (Array.isArray(former)) {
                former.forEach(function (elem) {
                    elem = encode(JSON.stringify(elem));
                    if (encode(JSON.stringify(value)) == elem) {
                        exist = true;
                    }
                });
                if (!exist) {
                    former.push(value);
                    storage.val(base64en(JSON.stringify(former)));
                    display.html(display.html() + '<span class="badge rounded-pill bg-primary text-light option-span ml-1 mr-1">' + value.name + '<i class="icofont-close-line" onclick="delOption(this.parentNode.parentNode.childNodes,this.parentNode)"></i></span>');
                }
            } else {
                storage.val(base64en(JSON.stringify([value])));
                display.html('<span class="badge rounded-pill bg-primary text-light option-span ml-1 mr-1">' + value.name + '<i class="icofont-close-line" onclick="delOption(this.parentNode.parentNode.childNodes,this.parentNode)"></i></span>');
            }
        }


    });
    $('input[name="option-name"]').keyup(function () {
        errText($(this), $(this).val());
    });
    function errText(input, remove) {
        input.parent().addClass('mdc-text-field--invalid');
        input.parent().addClass('mdc-text-field--focused');
        input.addClass("mdc-text-field--invalid");
        if (remove) {
            input.parent().removeClass('mdc-text-field--invalid');
            input.parent().removeClass('mdc-text-field--focused');
            input.removeClass("mdc-text-field--invalid");
        }
    }
    function errSelect(input, remove) {
        input.parent().addClass('mdc-select--invalid');
        input.parent().addClass('mdc-select--focused');
        input.addClass("mdc-select--invalid");
        if (remove) {
            input.parent().removeClass('mdc-select--invalid');
            input.parent().removeClass('mdc-select--focused');
            input.removeClass("mdc-select--invalid");
        }
    }

    $("#pending-order").click(function () {
        var pendingDisplay = $('#pending-order-display');
        var completedDisplay = $('#completed-order-display');
        if (pendingDisplay.css("display") == "none") {
            completedDisplay.css("display", "none");
            pendingDisplay.css("display", "block");
            $(this).addClass('active');
            $("#completed-order").removeClass('active');
        }
    });
    $("#completed-order").click(function () {
        var pendingDisplay = $('#pending-order-display');
        var completedDisplay = $('#completed-order-display');
        if (completedDisplay.css("display") == "none") {
            completedDisplay.css("display", "block");
            pendingDisplay.css("display", "none");
            $(this).addClass('active');
            $("#pending-order").removeClass('active');
        }
    });

    var toogleBtns = $('.dropdown-toggle');
    for (var n = 0; n < toogleBtns.length; n++) {
        setColor($(toogleBtns[n]));
    }


    $('.dropdown-item').click(function () {
        var btn = ($(this).parent().prev());
        var input = (btn.prev());
        var tempTrn, tempHtml, tempColor, tempData;
        tempHtml = btn.html();
        tempTrn = btn.attr("trn");
        tempColor = btn.attr("color");
        tempData = btn.attr("data");
        btn.attr("trn", $(this).attr("trn"));
        btn.html($(this).html());
        btn.attr("color", $(this).attr("color"));
        btn.attr("data", $(this).attr("data"));
        if (input.prop("tagName") == "INPUT" && input.attr("type") == "hidden") {
            input.val(btn.attr("data"));
        }
        $(this).attr("trn", tempTrn);
        $(this).html(tempHtml);
        $(this).attr("color", tempColor);
        $(this).attr("data", tempData);
        setColor($(this));
        setColor(btn);
        async(btn.attr("data-async"), btn);
    });

    $('.async').click(function () {
        var async = $(this);
        lang = getCookie('lingo');
        mcxDialog.confirm(dictionary['are-you-sure'][lang], {
            // titleText: "",
            cancelBtnText: dictionary['cancel'][lang],
            sureBtnText: dictionary['proceed'][lang],
            sureBtnClick: function () {
                switch (async.attr("data-page")) {
                    case "delete-branch":
                        return $.post("post/deleteBranch",
                            {
                                id: async.attr("data-id")
                            },
                            function (data, status) {
                                console.log(data);
                                data = JSON.parse(data);
                                if (data.result == true) {
                                    if (window.history.replaceState) {
                                        window.history.replaceState(null, null, window.location.href);
                                    }
                                    webToast.Success({
                                        status: dictionary['successful'][lang],
                                        message: dictionary['branch-deleted'][lang],
                                        delay: 5000
                                    });
                                    location.reload();
                                } else {
                                    console.log(data);
                                }
                            });
                    case "delete-staff":
                        return $.post("post/deleteStaff",
                            {
                                id: async.attr("data-id")
                            },
                            function (data, status) {
                                console.log(data);
                                data = JSON.parse(data);
                                if (data.result == true) {
                                    if (window.history.replaceState) {
                                        window.history.replaceState(null, null, window.location.href);
                                    }
                                    webToast.Success({
                                        status: dictionary['successful'][lang],
                                        message: dictionary['staff-deleted'][lang],
                                        delay: 5000
                                    });
                                    location.reload();
                                } else {
                                    console.log(data);
                                }
                            });

                    case "delete-product":
                        spinner('products-main').show();
                        return $.post("post/deleteProduct",
                            {
                                id: async.attr("data-id")
                            },
                            function (data, status) {
                                console.log(data);
                                data = JSON.parse(data);
                                if (data.result == true) {
                                    if (window.history.replaceState) {
                                        window.history.replaceState(null, null, window.location.href);
                                    }
                                    webToast.Success({
                                        status: dictionary['successful'][lang],
                                        message: dictionary['product-deleted'][lang],
                                        delay: 5000
                                    });
                                    location.reload();
                                } else {
                                    console.log(data);
                                }
                            });
                }
            }
        });

    });

    $('img').on('dragstart', function (event) { event.preventDefault(); });
    $("body").on("contextmenu", "img", function (e) {
        return false;
    });
    $('.timepicker').mdtimepicker({
        timeFormat: 'hh:mm:ss.000', // format of the time value (data-time attribute)
        format: 'hh:mm tt', // format of the input value
        readOnly: false, // determines if input is readonly
        hourPadding: false,
        theme: 'indigo'//'#2C1E5C',// '#504071'
    });

});