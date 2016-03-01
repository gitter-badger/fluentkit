import * as util from 'util'
import Vue from 'vue'

var adminSettingsPage = {
    template: '#admin-settings-page-template',
    props: {
        groups: Array,
        url: String
    },
    data: function(){
        return {
            active_panel: null,
            loading: false
        };
    },
    methods: {
        getFieldsForSave: function(){
            var request = {settings : {}};

            this.groups.forEach(function(group){
                group.sections.forEach(function(section){
                    section.fields.forEach(function(field){
                        request.settings[field.id] = {
                            id: field.id,
                            value: field.value
                        };
                    });
                });
            });

            return request;
        },
        syncFieldValidation: function(event){

            if(event === undefined){
                return;
            }

            //modify the field
            try {
                event.errors = this.$settings[event.id].errors || [];
                event.touched = this.$settings[event.id].touched || false;
                event.valid = this.$settings[event.id].valid || false;
                event.invalid = this.$settings[event.id].invalid || false;
                event.modified = this.$settings[event.id].modified || false;
                event.dirty = this.$settings[event.id].dirty || false;
            }catch(e){

            }
        }
    },
    events: {
        'close-panel': function(){
            this.active_panel = null;
        },
        'save': function(){

            this.loading = true;

            this.$http.post(this.url, this.getFieldsForSave()).then(function (response) {

                var data = {message: response.data.message, timeout: 3000};

                this.$dispatch('notification', data);

                this.$broadcast('saved');

                this.loading = false;

            }, function (response) {

                if (response.status == 422) {

                    //validation/authorization error - set the errors as returned or clear
                    var errors = util.formatValidationErrors(response.data.errors);
                    errors.forEach(function(error){
                        error.field = error.field.substring(9);
                    });
                    this.$setValidationErrors(errors);

                }else if (response.status == 401) {
                    //something bad happened
                    var data = {message: response.data, timeout: 3000};
                    this.$dispatch('notification', data);
                }else{

                    //something bad happened
                    var data = {message: 'We encountered a technical problem performing this request, please contact the administrator.', timeout: 3000};
                    this.$dispatch('notification', data);

                }

                this.loading = false;

            });

        }
    }
};

export default Vue.component('admin-settings-page', adminSettingsPage);

//export default notifications