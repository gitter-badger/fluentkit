<template id="admin-roles-page-template">
    <div id="admin-roles-page">
        <admin-roles-table per_page="{{ config('api.per_page') }}" v-show="!add_role" transition="fade"></admin-roles-table>
        <admin-roles-create v-show="add_role" transition="fade"></admin-roles-create>
    </div>
</template>