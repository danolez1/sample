
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
}

function encode(str) {
    if (!str) str = "";
    str = (str == "undefined" || str == "null") ? "" : str;
    try {
        var key = 146;
        var pos = 0;
        var ostr = '';
        while (pos < str.length) {
            ostr = ostr + String.fromCharCode(str.charCodeAt(pos) ^ key);
            pos += 1;
        }

        return ostr;
    } catch (ex) {
        return '';
    }
}

function decode(str) {
    if (!str) str = "";
    str = (str == "undefined" || str == "null") ? "" : str;
    try {
        var key = 146;
        var pos = 0;
        var ostr = '';
        while (pos < str.length) {
            ostr = ostr + String.fromCharCode(key ^ str.charCodeAt(pos));
            pos += 1;
        }

        return ostr;
    } catch (ex) {
        return '';
    }
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
function spinner(id) {
    return new jQuerySpinner({
        parentId: id
    });
}
function async(api) {
    switch (api) {
        case 'staff-level':
            break;
        case 'branch-status':
            break;
        case 'order-status':
            break;
        default:
            break;
    }
    console.log(api);
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
                $('input[name="' + inputName + '"]').val(e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
}
function delOption(nodeList, element) {
    var nodes = [];
    var index;
    for (i = 0; i < nodeList.length; i++) {
        nodes.push(nodeList[i]);
        if (element == nodeList[i]) {
            index = i;
        }
    }
    var display = $('#options-input-div');
    var storage = $('input[name="options"]');
    var former = JSON.parse(storage.val());
    former.splice(index, 1);
    nodes.splice(index, 1);
    storage.val(JSON.stringify(former));
    var temp = "";
    nodes.forEach(function (elem) {
        temp += elem.outerHTML;
    });
    display.html(temp);
}


$(document).ready(function () {
    var lang = getCookie('lingo');

    show("#add-staff", "#add-staff-form", 'table-row', true);
    show("#add-branch", "#add-branch-form", 'table-row', true);
    show("#delivery-time-fab", "#timer", 'block', true);
    getUpload("#browse", "#browse-preview", "banner");
    getUpload("#browse1", "#browse-preview1", "logo");
    getUpload("#browse-product", "#browse-preview", "product-img", "#preview-small");
    //preview-small
    $('#save-average-time').click(function () {
        // spinner('timer').show();
    });

    $('#addCategoryModal').on('show.bs.modal', function (e) {
        $('#add-btn').attr("data", e.relatedTarget.getAttribute('data-id'));
        $('#add-btn').attr("page", e.relatedTarget.getAttribute('data-page'));
    });
    $('.edit-product').click(function () {
        var productId = $(this).parent().parent().attr('data-id');
        setCookie('editProductId', productId, 1);
    });
    $('.del-product').click(function () {

    });

    getCookie('lingo') == 'en' ? $('a[lang="en"]').addClass('text-light') : $('a[lang="jp"]').addClass('text-light');
    $('.lang').click(function () {

        if ($(this).attr('lang') == 'en') {
            setCookie("lingo", 'en', 365);
            $('a[lang="jp"]').removeClass('text-light')
        } else {
            setCookie("lingo", 'jp', 365);
            $('a[lang="en"]').removeClass('text-light')
        }
        $(this).addClass('text-white');
    });

    $('#add-btn').click(function () {
        lang = getCookie('lingo');
        switch ($(this).attr("page")) {
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


    $('#add-option-btn').click(function (e) {
        e.preventDefault();
        var category = $('input[name="option-category"]');
        var name = $('input[name="option-name"]');
        var availability = $('input[name="option-availability"]');
        var price = $('input[name="option-price"]');
        var display = $('#options-input-div');
        var storage = $('input[name="options"]');
        errText(name, name.val());
        if (name.val() != undefined && name.val() != "") {
            var value = { category: category.val(), name: name.val(), available: availability.val(), price: price.val() };
            if (storage.val() != "" && storage.val() != undefined) {
                var former = JSON.parse(storage.val());
                var exist = false;
                former.forEach(function (elem) {
                    elem = encode(JSON.stringify(elem));
                    if (encode(JSON.stringify(value)) == elem) {
                        exist = true;
                    }
                });
                if (!exist) {
                    former.push(value);
                    storage.val(JSON.stringify(former));
                    display.html(display.html() + '<span class="badge rounded-pill bg-primary text-light option-span ml-1 mr-1">' + value.name + '<i class="icofont-close-line" onclick="delOption(this.parentNode.parentNode.childNodes,this.parentNode)"></i></span>');
                }
            } else {
                storage.val(JSON.stringify([value]));
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

    // $('.upload-image').click(function (e) {
    //     e.preventDefault();
    //     var input = $(this).find('input');
    //     input.click();
    //     console.log(input.attr('type'));
    // });

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
        async(btn.attr("data-async"));
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