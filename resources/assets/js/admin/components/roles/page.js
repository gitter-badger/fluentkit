import * as util from 'util'
import Vue from 'vue'

var adminRolesPage = {
    template: '#admin-roles-page-template',
    props: {
        url: String
    },
    data: function(){
        return {
            edit_role: false,
            role: {
                name: '',
                label: '',
                permissions: []
            }
        };
    },
    events:{
        editRole: function(role){
            this.role = role;
            this.edit_role = true;
        }
    },
    methods: {
        addNew: function(){

        }
    }
};

export default Vue.component('admin-roles-page', adminRolesPage);

//export default notifications