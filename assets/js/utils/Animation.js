let pathToLoadingAnimation = require("public/files/loading_animation.svg");
import * as MathHelper from "./MathHelper";
import * as $ from "jquery";

export function showWaitAnimation() {
    "use strict";
    let body = $("body");
    if (body.attr("data-loading-animation") !== undefined) {
        return;
    }
    let divID = "div_" + MathHelper.randomNumber(0, 1000000);
    let imgID = "img_" + MathHelper.randomNumber(0, 1000000);
    body.attr("data-loading-animation", "data-loading-animation")
        .attr("data-loading-animation-div-id", divID)
        .attr("data-loading-animation-img-id", imgID)
        .append($("<div>")
            .addClass("loading-animation")
            .attr("id", divID))
        .append($(`<img id="${imgID}" class="loading-animation-img" alt="Loading animation" src="${pathToLoadingAnimation}">`));
    if (body.height() > $(window).height()) {
        body.css("overflow-y", "hidden").css("padding-right", "17px");
    }
    if (body.width() > $(window).width()) {
        body.css("overflow-x", "hidden").css("padding-bottom", "17px");
    }
}

export function hideWaitAnimation() {
    "use strict";
    let body = $("body");
    if (body.attr("data-loading-animation") === undefined) {
        return;
    }
    $("#" + body.attr("data-loading-animation-div-id")).remove();
    $("#" + body.attr("data-loading-animation-img-id")).remove();
    body.removeAttr("data-loading-animation-div-id")
        .removeAttr("data-loading-animation")
        .removeAttr("data-loading-animation-img-id")
        .css("overflow-x", "").css("padding-right", "").css("overflow-y", "").css("padding-bottom", "");
}