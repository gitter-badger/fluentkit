import Polycast from 'leemason-polycast'
import Vue from 'vue'
import mdl from 'material-design-lite/material'
import routes from 'routes'

let vm = {
    el: 'body',
    data: {
        url: '',
        user: null,
        socket: '',
        loading: true,
        routes: null
    },
    ready: function(){

        this.routes = routes;

        //get url
        var url = document.querySelector('meta[name="url"]');
        this.url = url.content;

        this.socket = new Polycast(this.url + '/polycast');

        this.subscribeToGlobalNotifications();

        var user = document.querySelector('meta[name="user"]');
        if(user != null) {
            this.user = JSON.parse(user.content);

            this.subscribeToUserNotifications();
        }

        //upgrade elements
        mdl.componentHandler.upgradeDom();

        //hide loader
        this.loading = false;
    },
    methods: {
        subscribeToGlobalNotifications: function(){
            // fire global notifications down the tree
            this.socket.subscribe('notifications').on('App\\Events\\Notification', function(data){
                var notification = {message: data.message, timeout: 3000};
                this.$broadcast('notification', notification);
            }.bind(this));
        },
        subscribeToUserNotifications: function(){
            // fire user notifications down the tree
            this.socket.subscribe('user.' + this.user.email).on('App\\Events\\User\\Notification', function(data){
                var notification = {message: data.message, timeout: 3000};
                this.$broadcast('notification', notification);
            }.bind(this));
        }
    }
};

class FluentKit{

    constructor(){
        this.vm = null;

        this.events = {};
    }

    start(){
        if(this.vm != null){
            return;
        }
        this.dispatch('beforeStart', this);
        this.vm = new Vue(vm);
        this.dispatch('afterStart', this);
    }

    vm(){
        return this.vm;
    }

    on(event, callback, context){
        this.events.hasOwnProperty(event) || (this.events[event] = []);
        this.events[event].push([callback, context]);
    }

    dispatch(event, data){

        this.events.hasOwnProperty(event) || (this.events[event] = []);

        var tail = Array.prototype.slice.call(arguments, 1),
            callbacks = this.events[event];
        for(var i = 0, l = callbacks.length; i < l; i++) {
            var callback = callbacks[i][0],
                context = callbacks[i][1] === undefined ? this : callbacks[i][1];
            callback.apply(context, tail);
        }
    }
}

var app = new FluentKit();

export var app;

export default app;