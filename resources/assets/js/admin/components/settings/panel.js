import Vue from 'vue'

var adminSettingsPanel = {
    template: '#admin-settings-panel-template',
    props: {
        group: Object,
        validator: Object
    },
    data: function(){
        return {
            can_save: false,
            original: {}
        };
    },
    ready: function(){
        this.original = JSON.parse(JSON.stringify(this.group));
    },
    methods: {
        triggerSave: function(){
            this.$dispatch('save');
        },
        hideSave: function(){
            //reset the can_save option to hide the save box
            this.can_save = false;
        },
        resetPanel: function(){

            //loop and set each original value
            this.original.sections.forEach(function(section, index){
                section.fields.forEach(function(field, fieldIndex){
                    this.group.sections[index].fields[fieldIndex].value = field.value;
                }.bind(this));
            }.bind(this));

            //allow watchers to run first, then hide
            setTimeout(function(){
                this.hideSave();
            }.bind(this), 500);

        },
        closePanel: function(){
            //send event up and down
            this.$broadcast('close-panel');
            this.$dispatch('close-panel');
        }
    },
    watch: {
        group: {
            handler: function(value, mutation){

                try {
                    value.sections.forEach(function (section, index) {
                        section.fields.forEach(function (field, fieldIndex) {
                            if (field.errors.length > 0 && field.modified == true  && field.touched == true) {
                                throw new Error('validation failed!')
                            }
                        });
                    });
                }catch(e){
                    this.can_save = false;
                    return;
                }

                this.can_save = true;
            },
            deep: true
        }
    },
    events: {
        saved: function(){
            this.hideSave();
            return true;
        }
    }
};

export default Vue.component('admin-settings-panel', adminSettingsPanel);

//export default notifications