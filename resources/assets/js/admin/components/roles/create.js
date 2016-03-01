import * as util from 'util'
import Vue from 'vue'

var adminRolesCreate = {
    template: '#admin-roles-create-template',
    props: {
        url: String
    },
    data: function(){
        return {
            role: {
                label: '',
                name: '',
                permissions: []
            }
        };
    }
};

export default Vue.component('admin-roles-create', adminRolesCreate);

//export default notifications