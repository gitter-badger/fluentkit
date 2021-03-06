"use strict";System.register(["util","vue"],function(t,o){var e,s,a;return{setters:[function(t){e=t},function(t){s=t["default"]}],execute:function(){a={template:"#reset-password-form-template",props:["url","token"],data:function(){return{email:"",password:"",password_confirmation:"",errors:{global:[],email:[],password:[],password_confirmation:[]},loading:!1}},methods:{validateResetPassword:function(t){this.loading=!0,t.preventDefault(),this.$http.post(this.url,{email:this.email,token:this.token,password:this.password,password_confirmation:this.password_confirmation}).then(function(t){var o={message:t.data.message,timeout:3e3};this.$root.$dispatch("notification",o),setTimeout(function(){window.location.href=t.data.location},2e3)},function(t){if(422==t.status){this.errors.global=t.data.errors.global||[];var o=e.formatValidationErrors(t.data.errors);this.$setValidationErrors(o)}else{var s={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$root.$dispatch("notification",s)}this.loading=!1})}}},t("default",s.component("reset-password-form",a))}}});
//# sourceMappingURL=reset-password.js.map
