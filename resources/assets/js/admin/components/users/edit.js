import * as util from 'util'
import Vue from 'vue'
import mdl from 'material-design-lite/material'

var adminUsersEdit = {
    template: '#admin-users-edit-template',
    props: ['id'],
    data: function(){
        return {
            user: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                roles: []
            },
            loading: true
        };
    },
    ready: function(){

        setTimeout(function(){
            this.$http.get(this.$root.routes.route('api.users.show', {id: this.id}), {include: 'roles'}).then(function(response){

                this.user = response.data.user;

                //reformat roles suitable for form
                var roles = [];
                this.user.roles.forEach(function(role){
                    roles.push(role.name);
                });

                this.user.roles = roles;

                this.loading = false;

            }, function(response){

                if (response.status == 401) {
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
        }.bind(this), 500);

    },
    methods: {
        triggerSave: function(){

            this.loading = true;

            var payload = {
                first_name: this.user.first_name,
                last_name: this.user.last_name,
                email: this.user.email,
                password: this.user.password,
                password_confirmation: this.user.password_confirmation
            };

            this.$http.patch(this.$root.routes.route('api.users.update', {id: this.id}), payload).then(function (response) {

                // if we have success we should then update the permissions, use put instead of patch to ensure a full update

                this.$http.put(this.$root.routes.route('api.users.roles.set', {id: this.id}), {roles: this.user.roles}).then(function(rresponse){

                    var data = {message: response.data.message, timeout: 3000};

                    this.$dispatch('notification', data);

                    this.loading = false;

                }, function(rresponse){
                    if (rresponse.status == 422) {

                        //validation/authorization error - set the errors as returned or clear
                        var errors = util.formatValidationErrors(rresponse.data.errors);
                        this.$setValidationErrors(errors);

                    }else if (rresponse.status == 401) {
                        //something bad happened
                        var data = {message: rresponse.data, timeout: 3000};
                        this.$dispatch('notification', data);
                    }else{

                        //something bad happened
                        var data = {message: 'We encountered a technical problem performing this request, please contact the administrator.', timeout: 3000};
                        this.$dispatch('notification', data);

                    }

                    this.loading = false;
                });

            }, function (response) {

                if (response.status == 422) {

                    //validation/authorization error - set the errors as returned or clear
                    var errors = util.formatValidationErrors(response.data.errors);
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

export default Vue.component('admin-users-edit', adminUsersEdit);

//export default notifications