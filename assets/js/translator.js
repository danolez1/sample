var translator = function (lang) {
    for (const [key, value] of Object.entries(dictionary)) {
        // console.log(key);
        if (value[lang] != null && value[lang] != "") {

            $(".hpii").each(function (i, obj) {
                if (!obj.src.includes("/" + lang + "/")) {
                    if (lang == "jp") {
                        obj.src = obj.src.replace('en', 'jp')
                    } else {
                        obj.src = obj.src.replace('jp', 'en')
                    }
                }

            });

            var cleanString = (lang == 'jp') ? (value[lang].trim().replace(/\s+/g, '').replace(/\s+/g, ' ').trim()) : value[lang].trim();
            var input = ['INPUT', "TEXTAREA"];
            document.querySelectorAll("[trn='" + key + "']").forEach((element) => {
                if (input.includes(element.nodeName)) {
                    element.setAttribute("placeholder", cleanString);
                } else {
                    $("[trn='" + key + "']").html(cleanString);
                }
            });
            var width = '';
            switch (key) {
                case 'menu':
                    width = '88px';
                    break;
                case 'branches':
                    width = '90px';
                    break;
                case 'Porfolio':
                    width = '55px';
                    break;
                case 'contact-us':
                    width = '110px';
                    break;
                case 'cart':
                case 'home':
                    width = '55px';
                    break;
                case 'llogin':
                case 'lprofile':
                    width = '75px';
                    break;
            }
            // console.log($("[trn='" + key + "']"));
            if (lang == 'jp') {
                $("[trn='" + key + "']").parent().css("width", width);
                $('.nav-link').css('padding', '0 10px');
            }
            else {
                $("[trn='" + key + "']").parent().css("width", '');
                $('.nav-link').css('padding', '0 16px');
            }
        }
    }
}

$(document).ready(function () {
    var timeZone = (Intl.DateTimeFormat().resolvedOptions().timeZone);
    var continent = timeZone.split("/")[0];

    var defaultL;
    if (continent == "Asia") {
        defaultL = getCookie("lingo") == "" ? 'jp' : getCookie("lingo");
    } else {
        defaultL = getCookie("lingo") == "" ? 'en' : getCookie("lingo");
    }

    translator(defaultL);
    $("#defaultLang").val(defaultL);

    if ($("#defaultLang").val() == "en") {
        $("#lang1").html('日本語');
        $("#lang1").val('jp');
        $("#defaultLang").html('English');
        translator(defaultL);
    } else {
        $("#defaultLang").html('日本語');
        $("#lang1").html('English');
        $("#lang1").val('en');
        translator(defaultL);
    }

    $("#lang1").click(function () {
        translator($(this).val());
        if ($("#defaultLang").val() == "en") {
            setCookie("lingo", 'jp', 365);
            $("#defaultLang").html('日本語');
            $("#defaultLang").val('jp');
            $(this).html('English');
            $(this).val('en');
        } else {
            $(this).html('日本語');
            $(this).val('jp');
            setCookie("lingo", 'en', 365);
            $("#defaultLang").html('English');
            $("#defaultLang").val('en');
        }
    });

});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}