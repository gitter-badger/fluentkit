import Vue from 'vue'

var notifications = {
    template: '#notifications-template',
    ready: function(){
        //re-fire the notification back down to us
        this.$root.$on('notification', function(data){
            this.$root.$broadcast('notification', data);
        });
    },
    events: {
        'notification': 'notify'
    },
    methods:{
        notify: function(data){
            this.$el.MaterialSnackbar.showSnackbar(data);
        }
    }
};

export default Vue.component('notifications', notifications);

//export default notifications