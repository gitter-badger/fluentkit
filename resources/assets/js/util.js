import _ from 'lodash'

export function formatValidationErrors(errors){
    return _.flatMap(errors, function(messages, key){
        return _.map(messages, function(message){
            return {field: key, message: message};
        });
    });
}