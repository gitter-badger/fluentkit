import _ from 'lodash'

/**
 * converts API response errors to suitable structure for vue validator
 * @param errors
 * @returns {Object|Array}
 */
export function formatValidationErrors(errors){
    return _.flatMap(errors, function(messages, key){
        return _.map(messages, function(message){
            return {field: key, message: message};
        });
    });
}