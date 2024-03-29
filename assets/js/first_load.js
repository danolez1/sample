function loadFormData(input) {
    for (const [key, value] of Object.entries(input)) {
        var elements = document.getElementsByName(key);
        elements.forEach(function (element) {
            if (element.nodeName == "INPUT") {
                if (element.getAttribute('type') == "radio") {
                    if (element.value == value) {
                        element.setAttribute("value", value);
                        element.setAttribute("checked", true);
                        // console.log(element.value);
                    }
                } else {

                    if (value != '')
                        element.setAttribute("value", value);
                }
            }
            if (element.nodeName == "TEXTAREA") {
                if (value != '')
                    element.innerText = value;
            }
        });
        // var element = document.getElementsByName(key)[0];

    };
}

String.prototype.stripSlashes = function () {
    return this.replace(/\\(.)/mg, "$1");
}

function playSound(url) {
    var btn = document.createElement('button');
    btn.style.display = "none";
    var audio = document.createElement('audio');
    audio.style.display = "none";
    audio.src = url;
    audio.autoplay = true;
    audio.loop = false;
    audio.preload = true;
    audio.onended = function () {
        audio.remove() //Remove when played.
    };
    document.body.appendChild(audio);
    btn.addEventListener('click', function () {
        audio.play;
        audio.pause;
        audio.play;
    });
    document.body.appendChild(btn);
    btn.click();

}

function spinner(id) {
    return new jQuerySpinner({
        parentId: id
    });
}

function base64en(val) {
    return btoa(unescape(encodeURIComponent(val)));
}
function base64de(val) {
    return decodeURIComponent(escape(atob(val)));
}

function unicodeToChar(text) {
    return text.replace(/\\u[\dA-F]{4}/gi,
        function (match) {
            return String.fromCharCode(parseInt(match.replace(/\\u/g, ''), 16));
        });
}

function postalGeocoding(zip) {
    if (zip.length < 7) {
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // console.log(this.responseText);
                for (const [key, value] of Object.entries(JSON.parse(this.responseText))) {
                    var input = document.getElementById(key);
                    if (input != undefined) {
                        input.value = value;
                        input.removeAttribute("disabled");
                    }
                }
            }
        };
        xmlhttp.open("GET", "get/postalGeoCode?zip=" + zip, true);
        xmlhttp.send();
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

function pad(num) {
    num = parseInt(num);
    if (num < 10) {
        return "0" + num;
    } else return num;
}

function listToArray(list) {
    var nodes = [];
    for (var i = 0; i < list.length; i++) {
        nodes.push(list[i]);
    }
    return nodes;
}

function cardBrand(cardNumber) {
    var cardBrands = {
        "AMERICAN_EXPRESS": { "regex": /^3[47][0-9]{13}$/, "logo": '<i class="icofont-american-express"></i>' },
        "BCGLOBAL": { "regex": /^(6541|6556)[0-9]{12}$/, "logo": '' },
        "CARTE_BLANCHE_CARD": { "regex": /^389[0-9]{11}$/, "logo": '' },
        "DINERS_CLUB_CARD": { "regex": /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/, "logo": '<i class="icofont-diners-club"></i>' },
        "DISCOVER_CARD": { "regex": /^65[4-9][0-9]{13}|64[4-9][0-9]{13}|6011[0-9]{12}|(622(?:12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])[0-9]{10})$/, "logo": '<i class="icofont-discover"></i>' },
        "INSTA_PAYMENT_CARD": { "regex": /^63[7-9][0-9]{13}$/, "logo": '' },
        "JCB": { "regex": /^(?:2131|1800|35\d{3})\d{11}$/, "logo": '<i class="icofont-jcb"></i>' },
        "KOREAN_LOCAL_CARD": { "regex": /^9[0-9]{15}$/, "logo": '' },
        "LASER_CARD": { "regex": /^(6304|6706|6709|6771)[0-9]{12,15}$/, "logo": '' },
        "MAESTRO_CARD": { "regex": /^(5018|5020|5038|6304|6759|6761|6763)[0-9]{8,15}$/, "logo": '<i class="icofont-maestro"></i>' },
        "MASTERCARD": { "regex": /^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/, "logo": ' <i class="icofont-mastercard"></i>' },
        "RUPAY": { "regex": /(508[5-9][0-9]{12})|(6069[8-9][0-9]{11})|(607[0-8][0-9]{12})|(6079[0-8][0-9]{11})|(608[0-5][0-9]{12})|(6521[5-9][0-9]{11})|(652[2-9][0-9]{12})|(6530[0-9]{12})|(6531[0-4][0-9]{11})/, "logo": '' },
        "SOLO_CARD": { "regex": /^(6334|6767)[0-9]{12}|(6334|6767)[0-9]{14}|(6334|6767)[0-9]{15}$/, "logo": '' },
        "SWITCH_CARD": { "regex": /^(4903|4905|4911|4936|6333|6759)[0-9]{12}|(4903|4905|4911|4936|6333|6759)[0-9]{14}|(4903|4905|4911|4936|6333|6759)[0-9]{15}|564182[0-9]{10}|564182[0-9]{12}|564182[0-9]{13}|633110[0-9]{10}|633110[0-9]{12}|633110[0-9]{13}$/, "logo": '' },
        "UNION_PAY": { "regex": /^(62[0-9]{14,17})$/, "logo": '' },
        "VISA": { "regex": /^4[0-9]{12}(?:[0-9]{3})?$/, "logo": '<i class="icofont-visa"></i>' },
        "VISA_MASTERCARD": { "regex": /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/, "logo": '' },
    }

    for (const [key, value] of Object.entries(cardBrands)) {
        if (value.regex.test(cardNumber)) {
            return value.logo;
        }
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=Lax;Secure";
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
var lang = getCookie('lingo');