import Vue from 'vue'

var adminSettingsFieldSelect = {
    template: '#admin-settings-field-select-template',
    props: {
        field: Object
    },
    data: function(){
        return {

        };
    }
};

export default Vue.component('admin-settings-field-select', adminSettingsFieldSelect);

//export default notifications