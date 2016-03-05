"use strict";System.register(["util","vue","material-design-lite/material"],function(t,i){var e,s,a,o;return{setters:[function(t){e=t},function(t){s=t["default"]},function(t){a=t["default"]}],execute:function(){o={template:"#admin-roles-edit-template",props:["id"],data:function(){return{role:{label:"",name:"",permissions:[]},loading:!0}},ready:function(){setTimeout(function(){this.$http.get(this.$root.routes.route("api.roles.show",{id:this.id}),{include:"permissions"}).then(function(t){this.role=t.data.role;var i=[];this.role.permissions.forEach(function(t){i.push(t.name)}),this.role.permissions=i,this.loading=!1},function(t){if(401==t.status){var i={message:t.data,timeout:3e3};this.$dispatch("notification",i)}else{var i={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$dispatch("notification",i)}this.loading=!1})}.bind(this),500)},methods:{triggerSave:function(){this.loading=!0,this.$http.patch(this.$root.routes.route("api.roles.update",{id:this.id}),{name:this.role.name,label:this.role.label}).then(function(t){this.$http.put(this.$root.routes.route("api.roles.permissions.set",{id:this.id}),{permissions:this.role.permissions}).then(function(i){var e={message:t.data.message,timeout:3e3};this.$dispatch("notification",e),this.loading=!1},function(t){if(422==t.status){var i=e.formatValidationErrors(t.data.errors);this.$setValidationErrors(i)}else if(401==t.status){var s={message:t.data,timeout:3e3};this.$dispatch("notification",s)}else{var s={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$dispatch("notification",s)}this.loading=!1})},function(t){if(422==t.status){var i=e.formatValidationErrors(t.data.errors);this.$setValidationErrors(i)}else if(401==t.status){var s={message:t.data,timeout:3e3};this.$dispatch("notification",s)}else{var s={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$dispatch("notification",s)}this.loading=!1})}}},t("default",s.component("admin-roles-edit",o))}}});
//# sourceMappingURL=edit.js.map
