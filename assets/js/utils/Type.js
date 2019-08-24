import * as $ from "jquery";

/**
 * @param object
 * @return {boolean}
 */
export function isUndefined (object) {
    return typeof object === "undefined";
}

/**
 * @param object
 * @return {boolean}
 */
export function isNull(object) {
    return object === null
}

/**
 * @param object
 * @return {boolean}
 */
export function isFunction(object) {
    return typeof object === "function";
}

/**
 * @param object
 * @return {boolean}
 */
export function isUndefinedOrNull(object) {
    return isUndefined(object) || isNull(object);
}

/**
 * @param object
 * @return {boolean}
 */
export function isString(object) {
    return typeof object === "string"
}

/**
 * @param {string} text
 * @return {boolean}
 */
export function isNullOrWhiteSpace(text) {
    return isNull(text) || text.trim() === "";
}

/**
 * @param object
 * @return {boolean}
 */
export function isJQueryObject(object) {
    return object instanceof $;
}

/**
 * @param object
 * @return {boolean}
 */
export function isBoolean(object) {
    return object === true || object === false;
}

