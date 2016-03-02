import * as util from 'util'
import Vue from 'vue'

var adminRolesPage = {
    template: '#admin-roles-page-template',
    data: function(){
        return {
            add_role: false
        };
    },
    events: {
        'close-create': function(){
            this.add_role = false;
        },
        'add-role': function(){
            this.add_role = true;
        }
    }
};

export default Vue.component('admin-roles-page', adminRolesPage);

//export default notifications