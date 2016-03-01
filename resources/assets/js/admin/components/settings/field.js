import Vue from 'vue'

var adminSettingsField = {
    template: '#admin-settings-field-template',
    props: {
        field: Object
    },
    data: function(){
        return {
        };
    }
};

export default Vue.component('admin-settings-field', adminSettingsField);

//export default notifications