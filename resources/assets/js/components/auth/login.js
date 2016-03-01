import * as util from 'util'
import Vue from 'vue'

var loginForm = {
    template: '#login-form-template',
    props: ['url'],
    data: function(){
        return {
            email: '',
            password: '',
            remember: false,
            errors: {
                global: [],
                email: [],
                password: []
            },
            loading: false
        }
    },
    methods: {
        validateLogin: function (event) {

            //show the loader
            this.loading = true;

            //prevent submission
            event.preventDefault();

            //validate - authorize the request
            this.$http.post(this.url, {
                email: this.email,
                password: this.password,
                remember: this.remember
            }).then(function (response) {

                var data = {message: response.data.message, timeout: 3000};

                this.$dispatch('notification', data);

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
                    this.$dispatch('notification', data);

                }

                //hide the loader, they can try again
                this.loading = false;
            });
        }
    }
};

export default Vue.component('login-form', loginForm);

//export default loginForm