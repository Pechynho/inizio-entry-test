/**
 * @param {int} from
 * @param {int} to
 * @return {int}
 */
export function randomNumber (from, to) {
    return Math.floor(Math.random() * to) + from
}