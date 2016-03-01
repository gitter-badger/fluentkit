import Vue from 'vue'

var adminSettingsSection = {
    template: '#admin-settings-section-template',
    props: {
        section: Object
    },
    data: function(){
        return {
            fields_visible: false
        };
    },
    methods: {
        closeSection: function(){
            fields_visible = false;
        }
    },
    events: {
        'close-panel': function(){
            this.fields_visible = false;
        }
    }
};

export default Vue.component('admin-settings-section', adminSettingsSection);

//export default notifications