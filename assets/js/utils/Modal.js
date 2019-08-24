import * as $ from "jquery";
import * as TypeChecker from "./Type";
import * as MathHelper from "./MathHelper";

export class Modal {
    /**
     * @param {{}} [options]
     * @param {string} [options.title]
     * @param {string|HTMLElement|jQuery} [options.content]
     * @param {bool} [options.removeAfterClose]
     * @param {string} [options.type]
     * @param {string} [options.size}
     * @param {boolean|string|number} [options.defaultModalResult]
     * @param {{}|null} [options.buttons}
     * @param {string} [options.localization}
     */
    constructor(options = {
        title: "",
        content: "",
        removeAfterClose: true,
        type: Modal.Types.CUSTOM,
        size: Modal.Sizes.NORMAL,
        defaultModalResult: null,
        buttons: null,
        localization: "cs"
    }) {
        this.options = options;
        let delegate = document.createDocumentFragment();
        [
            'addEventListener',
            'dispatchEvent',
            'removeEventListener'
        ].forEach(f =>
            this[f] = (...xs) => delegate[f](...xs)
        )
    }

    /**
     * @param {string} eventName
     * @param {function} callback
     * @return {Modal}
     */
    on(eventName, callback) {
        this.addEventListener(eventName, callback);
        return this;
    }

    /**
     * @return {Modal}
     */
    show() {
        if (!TypeChecker.isUndefinedOrNull(this.modal)) {
            this.modal.modal("show");
            return;
        }
        let title = this.options.title || "";
        let content = this.options.content || "";
        let removeAfterClose = this.options.removeAfterClose || true;
        this.modalResult = this.options.defaultModalResult || null;
        this.clickedButtonId = null;
        this.modal = $("<div>").addClass("modal fade").attr("role", "dialog").attr("tabindex", "-1")
            .append($("<div>").addClass("modal-dialog").attr("role", "document")
                .append($("<div>").addClass("modal-content")
                    .append($("<div>").addClass("modal-header")
                        .append($("<h5>").addClass("modal-title").text(title))
                        .append($("<button>").attr("type", "button").addClass("close").attr("data-dismiss", "modal").html("&times;")))
                    .append($("<div>").addClass("modal-body")
                        .html(content))
                    .append($("<div>").addClass("modal-footer")
                        .append(this._createButtons()))))
            .on("hidden.bs.modal", function () {
                let data = {
                    modalResult: this.modalResult
                };
                if (TypeChecker.isString(this.clickedButtonId)) {
                    data.clickedButtonId = this.clickedButtonId
                }
                this.dispatchEvent(new CustomEvent(Modal.Events.MODAL_CLOSED, {detail: data}));
                if (removeAfterClose) {
                    this.remove();
                }
            }.bind(this))
            .on("show.bs.modal", function () {
                this.dispatchEvent(new Event(Modal.Events.MODAL_OPENING));
            }.bind(this))
            .on("shown.bs.modal", function () {
                this.dispatchEvent(new Event(Modal.Events.MODAL_OPENED));
            }.bind(this))
            .on("hide.bs.modal", function () {
                this.dispatchEvent(new Event(Modal.Events.MODAL_CLOSING));
            }.bind(this))
            .modal();
        if (this._getSize() !== Modal.Sizes.NORMAL) {
            this.modal.find("div[class='modal-dialog']").addClass("modal-" + this._getSize());
        }
        return this;
    }

    /**
     * @return {Modal}
     */
    hide() {
        if (!TypeChecker.isUndefinedOrNull(this.modal)) {
            this.modal.modal("hide");
        }
    }

    /**
     * @return {Modal}
     */
    remove() {
        if (!TypeChecker.isUndefinedOrNull(this.modal)) {
            this.hide();
            setTimeout(function () {
                this.modal.remove();
                this.modal = undefined;
            }.bind(this), 1000)
        }
    }

    /**
     * @return {string}
     * @private
     */
    _getSize() {
        let sizes = [Modal.Sizes.LARGE, Modal.Sizes.SMALL];
        let size = this.options.size || null;
        if (TypeChecker.isString(size)) {
            for (let i = 0; i < sizes.length; i++) {
                if (sizes[i].toLowerCase() === size.toLowerCase()) {
                    return sizes[i];
                }
            }
        }
        return Modal.Sizes.NORMAL;
    }

    /**
     * @return {string}
     * @private
     */
    _getType() {
        let types = [Modal.Types.YES_NO_CANCEL, Modal.Types.YES_NO];
        let type = this.options.type || null;
        if (TypeChecker.isString(type)) {
            for (let i = 0; i < types.length; i++) {
                if (types[i].toLowerCase() === type.toLowerCase()) {
                    return types[i];
                }
            }
        }
        return Modal.Types.CUSTOM;
    }

    /**
     * @return {string}
     * @private
     */
    _getLocalization() {
        let localizations = Object.keys(Modal.Localization);
        let localization = this.options.localization || null;
        if (TypeChecker.isString(localization)) {
            for (let i = 0; i < localizations.length; i++) {
                if (localizations[i].toLowerCase() === localization.toLowerCase()) {
                    return localizations[i];
                }
            }
        }
        return localizations[0];
    }

    /**
     * @return {Array}
     * @private
     */
    _getButtonsConfig() {
        let localization = this._getLocalization();
        let type = this._getType();
        let buttons = this.options.buttons || null;
        if (buttons === null && Modal.Types.YES_NO === type) {
            return [{
                id: "YES_BUTTON_" + MathHelper.randomNumber(0, 1000000),
                content: Modal.Localization[localization].yes,
                class: "btn btn-primary min-width",
                modalResult: true
            }, {
                id: "NO_BUTTON_" + MathHelper.randomNumber(0, 1000000),
                content: Modal.Localization[localization].no,
                class: "btn btn-secondary min-width",
                modalResult: false
            }]
        } else if (buttons === null && Modal.Types.YES_NO_CANCEL === type) {
            return [{
                id: "YES_BUTTON_" + MathHelper.randomNumber(0, 1000000),
                content: Modal.Localization[localization].yes,
                class: "btn btn-primary min-width",
                modalResult: true
            }, {
                id: "NO_BUTTON_" + MathHelper.randomNumber(0, 1000000),
                content: Modal.Localization[localization].no,
                class: "btn btn-secondary min-width",
                modalResult: false
            }, {
                id: "NO_BUTTON_" + MathHelper.randomNumber(0, 1000000),
                content: Modal.Localization[localization].cancel,
                class: "btn btn-secondary min-width",
                modalResult: false
            }]
        } else if (buttons === null && Modal.Types.CUSTOM === type) {
            return [{
                id: "CLOSE_BUTTON_" + MathHelper.randomNumber(0, 1000000),
                content: Modal.Localization[localization].close,
                class: "btn btn-primary min-width"
            }]
        }
        return buttons;
    }

    /**
     * @return {Array}
     * @private
     */
    _createButtons() {
        let buttonsConfig = this._getButtonsConfig();
        let buttons = [];
        buttonsConfig.forEach(function (item) {
            let button = $("<button>").attr("data-dismiss", "modal");
            if (!TypeChecker.isUndefinedOrNull(item.id)) {
                button.attr("id", item.id);
            }
            if (!TypeChecker.isUndefinedOrNull(item.content)) {
                button.html(item.content);
            }
            if (!TypeChecker.isUndefined(item.modalResult)) {
                button.attr("data-modal-result", item.modalResult);
            }
            if (TypeChecker.isString(item.class)) {
                button.addClass(item.class);
            }
            button.click(this._buttonClick.bind(this));
            if (!TypeChecker.isFunction(item.click)) {
                button.click(item.click)
            }
            buttons.push(button);
        }.bind(this));
        return buttons;
    }

    /**
     * @param eventArgs
     * @private
     */
    _buttonClick(eventArgs) {
        let button = $(eventArgs.target);
        if (!TypeChecker.isUndefined(button.data("modalResult"))) {
            this.modalResult = button.data("modalResult");
        }
        if (!TypeChecker.isUndefined(button.attr("id"))) {
            this.clickedButtonId = button.attr("id");
        }
    }
}

Modal.Types = {};
Modal.Types.YES_NO = "YES_NO";
Modal.Types.YES_NO_CANCEL = "YES_NO_CANCEL";
Modal.Types.CUSTOM = "CUSTOM";

Modal.Sizes = {};
Modal.Sizes.NORMAL = "";
Modal.Sizes.LARGE = "lg";
Modal.Sizes.SMALL = "sm";

Modal.Events = {};
Modal.Events.MODAL_CLOSED = "modal.closed";
Modal.Events.MODAL_CLOSING = "modal.closing";
Modal.Events.MODAL_OPENED = "modal.opened";
Modal.Events.MODAL_OPENING = "modal.opening";

Modal.Localization = {};
Modal.Localization["cs"] = {
    close: "Zavřít",
    cancel: "Zrušit",
    yes: "Ano",
    no: "Ne"
};
Modal.Localization["en"] = {
    close: "Close",
    cancel: "Cancel",
    yes: "Yes",
    no: "No"
};