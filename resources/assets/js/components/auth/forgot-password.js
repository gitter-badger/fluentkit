import * as util from 'util'
import Vue from 'vue'

var forgotPasswordForm = {
    template: '#forgot-password-form-template',
    props: ['url'],
    data: function(){
        return {
            email: '',
            errors: {
                global: [],
                email: []
            },
            loading: false
        }
    },
    methods: {
        validateForgotPassword: function (event) {

            //show the loader
            this.loading = true;

            //prevent submission
            event.preventDefault();

            //validate - authorize the request
            this.$http.post(this.url, {
                email: this.email
            }).then(function (response) {

                var data = {message: response.data.message, timeout: 3000};

                this.$root.$dispatch('notification', data);

                this.email = '';

                //hide the loader, they can try again
                this.loading = false;

            }, function (response) {

                if (response.status == 422) {

                    //validation/authorization error - set the errors as returned or clear
                    this.errors.global = response.data.errors.global || [];

                    var errors = util.formatValidationErrors(response.data.errors);
                    this.$setValidationErrors(errors);

                }else{

                    //something bad happened
                    var data = {message: 'We encountered a technical problem performing this request, please contact the administrator.', timeout: 3000};
                    this.$root.$dispatch('notification', data);

                }

                //hide the loader, they can try again
                this.loading = false;
            });
        }
    }
};

export default Vue.component('forgot-password-form', forgotPasswordForm);

//export default forgotPasswordForm