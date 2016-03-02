import * as util from 'util'
import Vue from 'vue'

var adminRolesTable = {
    template: '#admin-roles-table-template',
    props: {
        per_page: String
    },
    data: function(){
        return {
            loading: true,
            roles: [],
            from: 0,
            to: 0,
            total: 0,
            prev_page_url: null,
            next_page_url: null,
            page: 1,
            search: ''
        };
    },
    methods: {
        setPerPage: function(perPage){
            this.per_page = perPage;
            this.fetchPage(1);
        },
        fetchPage: function(page, query = false){

            this.loading = true;

            var data = {
                include: "permissions,users",
                page: page,
                per_page: this.per_page
            };

            if(query == true && this.search != ''){
                data.q = ['label:like:' + this.search];
            }

            this.$http.get(this.$root.routes.route('api.roles'), data).then(function (response) {

                this.roles = response.data.data;
                this.from = response.data.from;
                this.to = response.data.to;
                this.total = response.data.total;
                this.prev_page_url = response.data.prev_page_url;
                this.next_page_url = response.data.next_page_url;

                this.loading = false;

                this.page = page;

            }, function (response) {

                if (response.data.hasOwnProperty('message')) {
                    var data = {message: response.data.message, timeout: 3000};
                    this.$dispatch('notification', data);
                }else{

                    //something bad happened
                    var data = {message: 'We encountered a technical problem performing this request, please contact the administrator.', timeout: 3000};
                    this.$dispatch('notification', data);

                }

                //hide the loader, they can try again
                this.loading = false;
            });
        },
        searchFor(){
            this.fetchPage(1, true);
        },
        editRole(role, event){
            event.preventDefault();
            event.stopPropagation();
            if(role.name == 'administrator'){
                return;
            }
            window.location.href = this.$root.routes.route('admin.roles.edit', {id: role.id});
        },
        addRole(event){
            event.preventDefault();
            event.stopPropagation();
            this.$dispatch('add-role');
        }
    },
    ready: function(){
        setTimeout(function(){
            this.fetchPage(this.page);
        }.bind(this), 100);
    }
};

export default Vue.component('admin-roles-table', adminRolesTable);

//export default notifications