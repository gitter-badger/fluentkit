"use strict";System.register(["util","vue","material-design-lite/material"],function(t,e){var i,s,a,r;return{setters:[function(t){i=t},function(t){s=t["default"]},function(t){a=t["default"]}],execute:function(){r={template:"#admin-users-edit-template",props:["id"],data:function(){return{user:{first_name:"",last_name:"",email:"",password:"",password_confirmation:"",roles:[]},loading:!0}},ready:function(){setTimeout(function(){this.$http.get(this.$root.routes.route("api.users.show",{id:this.id}),{include:"roles"}).then(function(t){this.user=t.data.user;var e=[];this.user.roles.forEach(function(t){e.push(t.name)}),this.user.roles=e,this.loading=!1},function(t){if(401==t.status){var e={message:t.data,timeout:3e3};this.$dispatch("notification",e)}else{var e={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$dispatch("notification",e)}this.loading=!1})}.bind(this),500)},methods:{triggerSave:function(){this.loading=!0;var t={first_name:this.user.first_name,last_name:this.user.last_name,email:this.user.email,password:this.user.password,password_confirmation:this.user.password_confirmation};this.$http.patch(this.$root.routes.route("api.users.update",{id:this.id}),t).then(function(t){this.$http.put(this.$root.routes.route("api.users.roles.set",{id:this.id}),{roles:this.user.roles}).then(function(e){var i={message:t.data.message,timeout:3e3};this.$dispatch("notification",i),this.loading=!1},function(t){if(422==t.status){var e=i.formatValidationErrors(t.data.errors);this.$setValidationErrors(e)}else if(401==t.status){var s={message:t.data,timeout:3e3};this.$dispatch("notification",s)}else{var s={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$dispatch("notification",s)}this.loading=!1})},function(t){if(422==t.status){var e=i.formatValidationErrors(t.data.errors);this.$setValidationErrors(e)}else if(401==t.status){var s={message:t.data,timeout:3e3};this.$dispatch("notification",s)}else{var s={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$dispatch("notification",s)}this.loading=!1})}}},t("default",s.component("admin-users-edit",r))}}});
//# sourceMappingURL=edit.js.map
