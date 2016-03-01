import * as util from 'util'
import Vue from 'vue'

var registerForm = {
    template: '#register-form-template',
    props: ['url'],
    data: function(){
        return {
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: {
                global: [],
                first_name: [],
                last_name: [],
                email: [],
                password: [],
                password_confirmation: []
            },
            loading: false
        }
    },
    methods: {
        validateRegister: function (event) {

            //show the loader
            this.loading = true;

            //prevent submission
            event.preventDefault();

            //validate - authorize the request
            this.$http.post(this.url, {
                first_name: this.first_name,
                last_name: this.last_name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            }).then(function (response) {

                var data = {message: response.data.message, timeout: 3000};

                this.$root.$dispatch('notification', data);

                setTimeout(function () {
                    window.location.href = response.data.location;
                }, 2000);

                //don't hide the loader here, we don't want them clicking while we redirect them.

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

export default Vue.component('register-form', registerForm);

//export default registerForm