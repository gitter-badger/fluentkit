<template id="admin-roles-page-template">
    <div class="mdl-card mdl-shadow--2dp roles-card">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">{{ trans('admin.roles_title') }}</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <p>{{ trans('admin.roles_description') }}</p>
        </div>

        <admin-roles-table :url="url" per_page="{{ config('api.per_page') }}" v-show="!edit_role" transition="fade"></admin-roles-table>

        <div class="mdl-card__menu">
            <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                <i class="material-icons">lock</i>
            </button>
        </div>
    </div>
</template>