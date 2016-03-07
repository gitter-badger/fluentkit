import * as util from 'util'
import Vue from 'vue'

var adminUsersPage = {
    template: '#admin-users-page-template',
    data: function(){
        return {
            add_user: false
        };
    },
    events: {
        'close-create': function(){
            this.add_user = false;
        },
        'add-user': function(){
            this.add_user = true;
        }
    }
};

export default Vue.component('admin-users-page', adminUsersPage);

//export default notifications