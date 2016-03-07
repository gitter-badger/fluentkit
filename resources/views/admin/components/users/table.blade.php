<template id="admin-users-table-template">
    <div class="mdl-card mdl-shadow--2dp roles-card">

        <div class="mdl-card__menu">
            <a href="#" v-on:click="addUser($event)" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                <i class="material-icons">add_circle</i>
            </a>
        </div>

        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">{{ trans('admin.users_title') }}</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <p>{{ trans('admin.users_description') }}</p>
        </div>

        <div id="admin-users-table">

            <table class="users-table mdl-data-table mdl-js-data-table">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">{{ trans('global.email') }}</th>
                    <th class="mdl-data-table__cell--non-numeric">{{ trans('global.name') }}</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td class="mdl-data-table__cell--non-numeric">
                            <a href="#" v-on:click="editUser(user, $event)">@{{ user.email }}</a>
                        </td>
                        <td class="mdl-data-table__cell--non-numeric">
                            @{{ user.first_name }} @{{ user.last_name }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mdl-card__actions users-table-pagination">

                <div class="table-search">
                    <button class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">search</i>
                    </button>

                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="search-for" v-model="search" v-on:keyup="searchFor | debounce">
                        <label class="mdl-textfield__label" for="search-for">Search Users</label>
                    </div>
                </div>

                <small>@{{ from }} - @{{ to }} {{ trans('global.of') }} @{{ total }}</small>
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" v-on:click="fetchPage(page - 1)" :disabled="page == 1">
                    <i class="material-icons">navigate_before</i>
                </button>
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" v-on:click="fetchPage(page + 1)" :disabled="to == total">
                    <i class="material-icons">navigate_next</i>
                </button>
            </div>

            <div id="loading-overlay" v-show="loading" transition="fade">
                <div class="mdl-spinner mdl-js-spinner is-active"></div>
            </div>
        </div>
    </div>
</template>