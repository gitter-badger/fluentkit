<template id="admin-roles-create-template">
    <div id="admin-roles-create">
        <validator name="validator">
            <div class="mdl-card mdl-shadow--2dp roles-create-card">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">{{ trans('admin.roles_create_title') }}</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <p>{{ trans('admin.roles_create_description') }}</p>
                </div>

                <div class="mdl-card__menu">
                    <a href="#" v-on:click="closeForm($event)" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                        <i class="material-icons">close</i>
                    </a>
                </div>

                <div class="mdl-card__supporting-text mdl-card--border">
                    <div class="admin-role-section">
                        <div class="role-fields">
                            <div class="admin-role-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="role-name" class="field-label">{{ trans('global.role_name') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $validator.name.errors && $validator.name.touched}">
                                        <input class="mdl-textfield__input" type="text" id="role-name" v-model="role.name" v-validate:name="{
                                            required: {rule: true, message: '{{ trans('validation.required', ['attribute' => trans('global.role_name')]) }}' },
                                            minlength: { rule: 4, message: '{{ trans('validation.min.string', ['attribute' => trans('global.role_name'), 'min' => 4]) }}' },
                                            pattern: { rule: '/^[a-zA-Z0-9_]+$/', message: '{{ trans('validation.alpha_dash', ['attribute' => trans('global.role_name')]) }}' }
                                        }">
                                        <label class="mdl-textfield__label" for="role-name">{{ trans('global.role_name') }}</label>
                                        <template v-for="error in $validator.name.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-role-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="role-label" class="field-label">{{ trans('global.role_label') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $validator.label.errors && $validator.label.touched}">
                                        <input class="mdl-textfield__input" type="text" id="role-label" v-model="role.label" v-validate:label="{
                                            required: {rule: true, message: '{{ trans('validation.required', ['attribute' => trans('global.role_label')]) }}' },
                                            minlength: { rule: 4, message: '{{ trans('validation.min.string', ['attribute' => trans('global.role_label'), 'min' => 4]) }}' }
                                        }">
                                        <label class="mdl-textfield__label" for="role-label">{{ trans('global.role_name') }}</label>
                                        <template v-for="error in $validator.label.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-role-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="role-permissions" class="field-label">{{ trans('global.permissions') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-grid">
                                        @foreach(\App\Models\Permission::all() as $permission)
                                            <div class="mdl-cell mdl-cell--4-col">
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
                </div>

                <div class="mdl-card__actions mdl-card--border" transition="fade">
                    <div class="text-right">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" v-on:click="resetPanel()">
                            {{ trans('global.discard') }}
                        </button>
                        <button class="mdl-button mdl-button--primary mdl-button--raised mdl-js-button mdl-js-ripple-effect" v-on:click="triggerSave()" :disabled="!$validator.valid">
                            {{ trans('global.save_changes') }}
                        </button>
                    </div>
                </div>
            </div>
        </validator>
        <div id="loading-overlay" v-show="loading" transition="fade">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
    </div>
</template>