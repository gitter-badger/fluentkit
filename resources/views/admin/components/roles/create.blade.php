<template id="admin-roles-create-template">
    <div id="admin-roles-create">
        <validator name="rolevalidation">
            <div class="mdl-card mdl-shadow--2dp roles-create-card">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">{{ trans('admin.roles_title') }}</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <p>{{ trans('admin.roles_create_description') }}</p>
                </div>

                <div class="mdl-card__menu">
                    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                        <i class="material-icons">lock</i>
                    </button>
                </div>

                <div class="mdl-card__supporting-text mdl-card--border">
                    <div class="admin-role-section">
                        <div class="role-fields">
                            <div class="admin-role-field mdl-grid">
                                <div class="mdl-cell mdl-cell--4-col">
                                    <label for="role-name" class="field-label">{{ trans('global.role_name') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--8-col">
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="text" id="role-name" v-model="role.name" placeholder="{{ trans('global.role_name') }}" v-validate:role_name="{required: true}">
                                        <template v-for="error in $rolevalidator.role_name.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-role-field mdl-grid">
                                <div class="mdl-cell mdl-cell--4-col">
                                    <label for="role-label" class="field-label">{{ trans('global.role_label') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--8-col">
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="text" id="role-label" v-model="role.label" placeholder="{{ trans('global.role_label') }}" v-validate:role_label="{required: true}">
                                        <template v-for="error in $rolevalidator.role_label.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-role-field mdl-grid">
                                <div class="mdl-cell mdl-cell--4-col">
                                    <label for="role-permissions" class="field-label">{{ trans('global.permissions') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--8-col">
                                    @foreach(\App\Models\Permission::all() as $permission)
                                        <div class="mdl-textfield mdl-js-textfield">
                                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect">
                                                <input type="checkbox" class="mdl-switch__input" value="{{ $permission->name }}" v-model="role.permissions"/>
                                                <span class="mdl-switch__label">{{ $permission->label }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mdl-card__actions mdl-card--border" transition="fade">
                    <div class="text-right">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" v-on:click="resetPanel()">
                            {{ trans('global.discard') }}
                        </button>
                        <button class="mdl-button mdl-button--primary mdl-button--raised mdl-js-button mdl-js-ripple-effect" v-on:click="triggerSave()" :disabled="!$rolevalidation.valid">
                            {{ trans('global.save_changes') }}
                        </button>
                    </div>
                </div>
            </div>
        </validator>
    </div>
</template>