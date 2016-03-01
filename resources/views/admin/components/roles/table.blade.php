<template id="admin-roles-table-template">
    <div id="admin-roles-table">

        <table class="roles-table mdl-data-table mdl-js-data-table">
            <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric">Role</th>
                <th>Permissions</th>
                <th>Users</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="role in roles">
                <td class="mdl-data-table__cell--non-numeric">
                    <a href="#" v-on:click="editRole(role, $event)" :disabled="role.name == 'administrator'">@{{ role.label }}</a>
                </td>
                <td><span v-show="role.name != 'administrator'">@{{ role.permissions | count }}</span><span v-show="role.name == 'administrator'">*</span></td>
                <td>@{{ role.users | count }}</td>
            </tr>
            </tbody>
        </table>

        <div class="mdl-card__actions roles-table-pagination">

            <div class="table-search">
                <button class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">search</i>
                </button>

                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="text" id="search-for" v-model="search" v-on:keyup="searchFor | debounce">
                    <label class="mdl-textfield__label" for="search-for">Search Roles</label>
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
</template>