function loadFormData(input) {
    for (const [key, value] of Object.entries(input)) {
        var element = document.getElementsByName(key)[0];
        if (element.nodeName == "INPUT") {
            element.setAttribute("value", value);
        }
        if (element.nodeName == "TEXTAREA") {
            element.innerText = value;
        }
    };
}

function postalGeocoding(zip) {
    if (zip.length < 7) {
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
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