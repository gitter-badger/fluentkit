<template id="admin-users-page-template">
    <div id="admin-users-page">
        <admin-users-table per_page="{{ config('api.per_page') }}" v-show="!add_user" transition="fade"></admin-users-table>
        <admin-users-create v-show="add_user" transition="fade"></admin-users-create>
    </div>
</template>