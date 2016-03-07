<template id="admin-users-edit-template">
    <div id="admin-users-edit">
        <validator name="validator">
            <div class="mdl-card mdl-shadow--2dp users-edit-card">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">{{ trans('admin.users_edit_title') }}</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <p>{{ trans('admin.users_edit_description') }}</p>
                </div>

                <div class="mdl-card__menu">
                    <a href="{{ route('admin.users') }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                        <i class="material-icons">close</i>
                    </a>
                </div>

                <div class="mdl-card__supporting-text mdl-card--border">
                    <div class="admin-user-section">
                        <div class="user-fields">

                            <div class="admin-user-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="user-first-name" class="field-label">{{ trans('global.first_name') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty" v-bind:class="{'is-invalid': $validator.first_name.errors && $validator.first_name.touched, 'is-dirty': true}">
                                        <input class="mdl-textfield__input" type="text" id="user-first-name" v-model="user.first_name" v-validate:first_name="{
                                            required: {rule: true, message: '{{ trans('validation.required', ['attribute' => trans('global.first_name')]) }}' }
                                        }">
                                        <label class="mdl-textfield__label" for="user-first-name">{{ trans('global.first_name') }}</label>
                                        <template v-for="error in $validator.first_name.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-user-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="user-last-name" class="field-label">{{ trans('global.last_name') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty" v-bind:class="{'is-invalid': $validator.last_name.errors && $validator.last_name.touched, 'is-dirty': true}">
                                        <input class="mdl-textfield__input" type="text" id="user-last-name" v-model="user.last_name" v-validate:last_name="{
                                            required: {rule: true, message: '{{ trans('validation.required', ['attribute' => trans('global.last_name')]) }}' }
                                        }">
                                        <label class="mdl-textfield__label" for="user-last-name">{{ trans('global.last_name') }}</label>
                                        <template v-for="error in $validator.last_name.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-user-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="user-email" class="field-label">{{ trans('global.email') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty" v-bind:class="{'is-invalid': $validator.email.errors && $validator.email.touched, 'is-dirty': true}">
                                        <input class="mdl-textfield__input" type="email" id="user-email" v-model="user.email" v-validate:email="{
                                            required: {rule: true, message: '{{ trans('validation.required', ['attribute' => trans('global.email')]) }}' },
                                            email: {rule: true, message: '{{ trans('validation.email', ['attribute' => trans('global.email')]) }}' }
                                        }">
                                        <label class="mdl-textfield__label" for="user-email">{{ trans('global.email') }}</label>
                                        <template v-for="error in $validator.email.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-user-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="user-roles" class="field-label">{{ trans('global.roles') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <select id="user-roles" multiple v-model="user.roles" v-validate:roles="{}">
                                        @foreach(\App\Models\Role::all() as $role)
                                            <option value="{{ $role->name }}">{{ $role->label }}</option>
                                        @endforeach
                                    </select>

                                    <div class="mdl-textfield mdl-js-textfield is-dirty" v-bind:class="{'is-invalid': $validator.roles.errors && $validator.roles.touched, 'is-dirty': true}">
                                        <template v-for="error in $validator.roles.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-user-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="user-password" class="field-label">{{ trans('global.password') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty" v-bind:class="{'is-invalid': $validator.password.errors && $validator.password.touched}">
                                        <input class="mdl-textfield__input" type="password" id="user-password" v-model="user.password" v-validate:password="{}">
                                        <label class="mdl-textfield__label" for="user-password">{{ trans('global.password') }}</label>
                                        <template v-for="error in $validator.password.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-user-field mdl-grid">
                                <div class="mdl-cell mdl-cell--3-col">
                                    <label for="user-password-confirmation" class="field-label">{{ trans('global.password_confirmation') }}</label>
                                </div>
                                <div class="mdl-cell mdl-cell--9-col">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty" v-bind:class="{'is-invalid': $validator.password_confirmation.errors && $validator.password_confirmation.touched}">
                                        <input class="mdl-textfield__input" type="password" id="user-password-confirmation" v-model="user.password_confirmation" v-validate:password_confirmation="{}">
                                        <label class="mdl-textfield__label" for="user-password-confirmation">{{ trans('global.password_confirmation') }}</label>
                                        <template v-for="error in $validator.password_confirmation.errors">
                                            <span class="mdl-textfield__error">@{{ error.message }}</span>
                                        </template>
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
                            {{ trans('admin.users_update') }}
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