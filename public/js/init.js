"use strict";System.register(["vue","vue-resource","vue-validator"],function(e,t){var n,u,r,a,o;return{setters:[function(e){n=e["default"]},function(e){u=e["default"]},function(e){r=e["default"]}],execute:function(){n.config.debug=!0,n.use(u),n.use(r),a=document.querySelector('meta[name="X-CSRF-TOKEN"]'),null!=a&&(n.http.headers.common["X-CSRF-TOKEN"]=a.content),o=document.querySelector('meta[name="api_token"]'),null!=o&&(n.http.headers.common.Authorization="Bearer "+o.content),n.validator("url",{message:"This is not a valid URL",check:function(e){return/^(http\:\/\/|https\:\/\/)(.{4,})$/.test(e)}}),n.validator("email",{message:"This is not a valid Email Address",check:function(e){return/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(e)}}),n.filter("count",function(e){return e.length})}}});
//# sourceMappingURL=init.js.map
