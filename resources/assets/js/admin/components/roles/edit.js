import * as util from 'util'
import Vue from 'vue'
import mdl from 'material-design-lite/material'

var adminRolesEdit = {
    template: '#admin-roles-edit-template',
    props: ['id'],
    data: function(){
        return {
            role: {
                label: '',
                name: '',
                permissions: []
            },
            loading: true
        };
    },
    ready: function(){

        setTimeout(function(){
            this.$http.get(this.$root.routes.route('api.roles.show', {id: this.id}), {include: 'permissions'}).then(function(response){

                this.role = response.data.role;

                //reformat roles suitable for form
                var perms = [];
                this.role.permissions.forEach(function(permission){
                    perms.push(permission.name);
                });

                this.role.permissions = perms;

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

            this.$http.patch(this.$root.routes.route('api.roles.update', {id: this.id}), {name: this.role.name, label: this.role.label}).then(function (response) {

                // if we have success we should then update the permissions, use put instead of patch to ensure a full update

                this.$http.put(this.$root.routes.route('api.roles.permissions.set', {id: this.id}), {permissions: this.role.permissions}).then(function(presponse){

                    var data = {message: response.data.message, timeout: 3000};

                    this.$dispatch('notification', data);

                    this.loading = false;

                }, function(presponse){
                    if (presponse.status == 422) {

                        //validation/authorization error - set the errors as returned or clear
                        var errors = util.formatValidationErrors(presponse.data.errors);
                        this.$setValidationErrors(errors);

                    }else if (presponse.status == 401) {
                        //something bad happened
                        var data = {message: presponse.data, timeout: 3000};
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

export default Vue.component('admin-roles-edit', adminRolesEdit);

//export default notifications