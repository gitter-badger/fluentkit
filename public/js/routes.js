(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://fluentkit.app',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/open","name":"debugbar.openhandler","action":"Barryvdh\Debugbar\Controllers\OpenHandlerController@handle"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/clockwork\/{id}","name":"debugbar.clockwork","action":"Barryvdh\Debugbar\Controllers\OpenHandlerController@clockwork"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/assets\/stylesheets","name":"debugbar.assets.css","action":"Barryvdh\Debugbar\Controllers\AssetController@css"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/assets\/javascript","name":"debugbar.assets.js","action":"Barryvdh\Debugbar\Controllers\AssetController@js"},{"host":null,"methods":["POST"],"uri":"polycast\/connect","name":null,"action":"Closure"},{"host":null,"methods":["POST"],"uri":"polycast\/receive","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"test","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"login\/{provider?}","name":"login","action":"Auth\AuthController@getLogin"},{"host":null,"methods":["GET","HEAD"],"uri":"login\/{provider?}\/callback","name":"login.social.callback","action":"Auth\AuthController@getLoginCallback"},{"host":null,"methods":["POST"],"uri":"login","name":"login.post","action":"Auth\AuthController@postLogin"},{"host":null,"methods":["GET","HEAD"],"uri":"logout","name":"logout","action":"Auth\AuthController@getLogout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"Auth\AuthController@getRegister"},{"host":null,"methods":["POST"],"uri":"register","name":"register.post","action":"Auth\AuthController@postRegister"},{"host":null,"methods":["GET","HEAD"],"uri":"forgot-password","name":"forgot_password","action":"Auth\AuthController@getForgotPassword"},{"host":null,"methods":["POST"],"uri":"forgot-password","name":"forgot_password.post","action":"Auth\AuthController@postForgotPassword"},{"host":null,"methods":["GET","HEAD"],"uri":"reset-password\/{token}","name":"reset_password","action":"Auth\AuthController@getResetPassword"},{"host":null,"methods":["POST"],"uri":"reset-password","name":"reset_password.post","action":"Auth\AuthController@postResetPassword"},{"host":null,"methods":["GET","HEAD"],"uri":"admin","name":"admin.dashboard","action":"Admin\DashboardController@getIndex"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/roles","name":"admin.roles","action":"Admin\RolesController@getIndex"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/roles\/{id}","name":"admin.roles.edit","action":"Admin\RolesController@getEdit"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/settings","name":"admin.settings","action":"Admin\SettingsController@getIndex"},{"host":null,"methods":["POST"],"uri":"admin\/settings","name":"admin.settings.post","action":"Admin\SettingsController@postIndex"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/roles","name":"api.roles","action":"Api\RolesController@getIndex"},{"host":null,"methods":["POST"],"uri":"api\/roles","name":"api.roles.create","action":"Api\RolesController@postCreate"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/roles\/{id}","name":"api.roles.show","action":"Api\RolesController@getShow"},{"host":null,"methods":["PATCH"],"uri":"api\/roles\/{id}","name":"api.roles.update","action":"Api\RolesController@patchUpdate"},{"host":null,"methods":["DELETE"],"uri":"api\/roles\/{id}","name":"api.roles.destroy","action":"Api\RolesController@deleteDestroy"},{"host":null,"methods":["PATCH"],"uri":"api\/roles\/{id}\/permissions","name":"api.roles.permissions.update","action":"Api\RolesController@patchPermissionsUpdate"},{"host":null,"methods":["PUT"],"uri":"api\/roles\/{id}\/permissions","name":"api.roles.permissions.set","action":"Api\RolesController@putPermissionsUpdate"},{"host":null,"methods":["DELETE"],"uri":"api\/roles\/{id}\/permissions\/{permissionid}","name":"api.roles.permissions.destroy","action":"Api\RolesController@deletePermissionsDestroy"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                return this.getCorrectUrl(uri + qs);
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if(!this.absolute)
                    return url;

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // routes.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // routes.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // routes.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // routes.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // routes.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // routes.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.routes = laroute;
    }

}).call(this);

