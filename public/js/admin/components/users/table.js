"use strict";System.register(["util","vue"],function(t,e){var a,i,s;return{setters:[function(t){a=t},function(t){i=t["default"]}],execute:function(){s={template:"#admin-users-table-template",props:{per_page:String},data:function(){return{loading:!0,users:[],from:0,to:0,total:0,prev_page_url:null,next_page_url:null,page:1,search:""}},methods:{setPerPage:function(t){this.per_page=t,this.fetchPage(1)},fetchPage:function(t){var e=arguments.length<=1||void 0===arguments[1]?!1:arguments[1];this.loading=!0;var a={include:"roles",page:t,per_page:this.per_page};1==e&&""!=this.search&&(a.q=["first_name:like:"+this.search,"last_name:like:"+this.search,"email:like:"+this.search]),this.$http.get(this.$root.routes.route("api.users"),a).then(function(e){this.users=e.data.data,this.from=e.data.from,this.to=e.data.to,this.total=e.data.total,this.prev_page_url=e.data.prev_page_url,this.next_page_url=e.data.next_page_url,this.loading=!1,this.page=t},function(t){if(t.data.hasOwnProperty("message")){var e={message:t.data.message,timeout:3e3};this.$dispatch("notification",e)}else{var e={message:"We encountered a technical problem performing this request, please contact the administrator.",timeout:3e3};this.$dispatch("notification",e)}this.loading=!1})},searchFor:function(){this.fetchPage(1,!0)},editUser:function(t,e){e.preventDefault(),e.stopPropagation(),window.location.href=this.$root.routes.route("admin.users.edit",{id:t.id})},addUser:function(t){t.preventDefault(),t.stopPropagation(),this.$dispatch("add-user")}},ready:function(){setTimeout(function(){this.fetchPage(this.page)}.bind(this),100)}},t("default",i.component("admin-users-table",s))}}});
//# sourceMappingURL=table.js.map
