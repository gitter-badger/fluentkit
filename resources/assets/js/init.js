import Vue from 'vue'
import VueResource from 'vue-resource'
import VueValidator from 'vue-validator'

//turn on debug
Vue.config.debug = true;

//use vue resource
Vue.use(VueResource);

//use vue validator
Vue.use(VueValidator);

//set csrf if present
var token = document.querySelector('meta[name="X-CSRF-TOKEN"]');
if(token != null){
    Vue.http.headers.common['X-CSRF-TOKEN'] = token.content;
}

//set api token if present
var apiToken = document.querySelector('meta[name="api_token"]');
if(apiToken != null){
    Vue.http.headers.common['Authorization'] = 'Bearer ' + apiToken.content;
}

//add validators
Vue.validator('url', {
    message: 'This is not a valid URL', // error message with plain string
    check: function (val) {
        return /^(http\:\/\/|https\:\/\/)(.{4,})$/.test(val)
    }
});

Vue.validator('email', {
    message: 'This is not a valid Email Address', // error message with plain string
    check: function (val) { // define validator
        return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(val)
    }
});

//add filters
Vue.filter('count', function (value) {
    return value.length;
})
