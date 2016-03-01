import Vue from 'vue'

var adminSettingsFieldText = {
    template: '#admin-settings-field-text-template',
    props: {
        field: Object
    },
    data: function(){
        return {

        };
    }
};

export default Vue.component('admin-settings-field-text', adminSettingsFieldText);

//export default notifications