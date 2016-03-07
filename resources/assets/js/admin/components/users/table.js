import * as util from 'util'
import Vue from 'vue'

var adminUsersTable = {
    template: '#admin-users-table-template',
    props: {
        per_page: String
    },
    data: function(){
        return {
            loading: true,
            users: [],
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
                include: "roles",
                page: page,
                per_page: this.per_page
            };

            if(query == true && this.search != ''){
                data.q = [
                    'first_name:like:' + this.search,
                    'last_name:like:' + this.search,
                    'email:like:' + this.search
                ];
            }

            this.$http.get(this.$root.routes.route('api.users'), data).then(function (response) {

                this.users = response.data.data;
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
        editUser(user, event){
            event.preventDefault();
            event.stopPropagation();
            window.location.href = this.$root.routes.route('admin.users.edit', {id: user.id});
        },
        addUser(event){
            event.preventDefault();
            event.stopPropagation();
            this.$dispatch('add-user');
        }
    },
    ready: function(){
        setTimeout(function(){
            this.fetchPage(this.page);
        }.bind(this), 100);
    }
};

export default Vue.component('admin-users-table', adminUsersTable);

//export default notifications