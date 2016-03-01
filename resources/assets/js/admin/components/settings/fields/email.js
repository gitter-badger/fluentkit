import Vue from 'vue'

var adminSettingsFieldEmail = {
    template: '#admin-settings-field-email-template',
    props: {
        field: Object
    },
    data: function(){
        return {

        };
    }
};

export default Vue.component('admin-settings-field-email', adminSettingsFieldEmail);

//export default notifications