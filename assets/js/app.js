// CSS
import "bootstrap/scss/bootstrap.scss";
import "font-awesome/scss/font-awesome.scss";
import "jquery-datetimepicker/build/jquery.datetimepicker.min.css";
import "assets-css/app.css";

// JS
import "popper.js/dist/popper.min";
import "bootstrap/dist/js/bootstrap.min";
import * as $ from "jquery";
import "jquery-datetimepicker/build/jquery.datetimepicker.full.min";
$.datetimepicker.setLocale('cs');
import {Modal} from "assets-js/utils/Modal";
import * as Animation from "assets-js/utils/Animation";

class App {

    constructor() {
    }

    init() {
        this.tooltips();
        this.pageLoader();
    }

    tooltips() {
        $("[data-toggle='tooltip']").tooltip();
        $("[data-tooltip='tooltip']").tooltip();
    }

    pageLoader() {
        let pageLoader = $("#page_loader");
        $(window).on("load", function () {
            if (pageLoader.length > 0) {
                pageLoader.fadeOut(500, function () {
                    //pageLoader.hide();
                    pageLoader.remove();
                });
            }
        });
    }
}

let app = new App().init();

$("#search_request_form").submit(function () {
    let input = $(this).find("input[type='text']");
    if (input.val().length > 0 && input.val().length < 8) {
        input.val(input.val().padStart(8, "0"));
    }
});

$(".company-detail").click(function () {
    let button = $(this);
    if (button.data("detailLoaded") === true) {
        button.data("detailModal").show();
        return;
    }
    Animation.showWaitAnimation();
    $.ajax({
        type: "GET",
        url: Routing.generate("app_ares_company_detail", {id: button.data("companyId")}),
        success: function (data, textStatus, jqXHR) {
            Animation.hideWaitAnimation();
            let modal = new Modal({
                title: button.closest("tr").find("td:first-child").text(),
                content: data,
                size: Modal.Sizes.LARGE
            });
            modal.show();
            button.data("detailModal", modal).data("detailLoaded", true);
        }.bind(this),
        error: function (jqXHR, textStatus, errorThrown) {
            Animation.hideWaitAnimation();
            console.log(textStatus);
            console.log(errorThrown);
            let modal = new Modal({
                title: "Chyba",
                content: "Při spojování se serverem došlo k chybě."
            });
            modal.show();
        }
    });
});

$("input[data-toggle='datetime-picker']").each(function (index, item) {
    item = $(item).attr("autocomplete", "off");
    let clickEventSet = false;
    item.datetimepicker({
        format: "d.m.Y H:i",
        step: 5
    });
});

let sendAddressForm = $("#send_address_form");
if (sendAddressForm.length > 0 && sendAddressForm.find(".is-invalid").length > 0) {
    sendAddressForm.find(".modal").modal("show");
}