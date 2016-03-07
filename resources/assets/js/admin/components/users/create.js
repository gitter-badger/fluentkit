import * as util from 'util'
import Vue from 'vue'
import _ from 'lodash'

var adminUsersCreate = {
    template: '#admin-users-create-template',
    data: function(){
        return {
            user: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            loading: false
        };
    },
    methods: {
        triggerSave: function(){

            this.loading = true;

            this.$http.post(this.$root.routes.route('api.users.create'), this.user).then(function (response) {

                var data = {message: response.data.message, timeout: 3000};

                this.$dispatch('notification', data);

                window.location.href = this.$root.routes.route('admin.users.edit', {id: response.data.user.id});

            }, function (response) {

                if (response.status == 422) {

                    //validation/authorization error - set the errors as returned or clear
                    var errors = util.formatValidationErrors(response.data.errors);
                    /*var errors = _.flatMap(response.data.errors, function(messages, key){
                        return _.map(messages, function(message){
                            return {field: key, message: message};
                        });
                    });*/
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
        },
        closeForm: function(event){
            event.preventDefault();
            event.stopPropagation();
            this.$dispatch('close-create');
        }
    }
};

export default Vue.component('admin-users-create', adminUsersCreate);

//export default notifications