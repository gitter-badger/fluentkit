import Vue from 'vue'
import mdl from 'material-design-lite/material'

var adminSettingsFieldToggle = {
    template: '#admin-settings-field-toggle-template',
    props: {
        field: Object
    },
    data: function(){
        return {

        };
    }
};

export default Vue.component('admin-settings-field-toggle', adminSettingsFieldToggle);

//export default notifications