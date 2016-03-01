<template id="reset-password-form-template">
    <div id="reset-password" class="auth-card">
        <validator name="reset_password">
            <form action="@{{ url }}" method="post">
                <div class="mdl-card mdl-shadow--2dp reset-password-card">
                    <!--<div class="mdl-card__title mdl-card--expand">
                        <h2 class="mdl-card__title-text">Login</h2>
                    </div>-->
                    <div class="mdl-card__supporting-text">

                        <img src="http://www.getmdl.io/templates/dashboard/images/user.jpg" id="image"/>

                        <div id="loading" v-show="loading">
                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': errors.global.length}">
                            <template v-for="error in errors.global">
                                <span class="mdl-textfield__error">@{{ error }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $reset_password.email.errors && $reset_password.email.touched}">
                            <input class="mdl-textfield__input" type="email" id="email" name="email" v-model="email" v-validate:email="{required: true, email: {rule: true, message: '{{ trans('validation.email', ['attribute' => trans('global.email')]) }}'} }">
                            <label class="mdl-textfield__label" for="email">{{ trans('global.email') }}</label>
                            <template v-for="error in $reset_password.email.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $reset_password.password.errors && $reset_password.password.touched}">
                            <input class="mdl-textfield__input" type="password" id="password" name="password" v-model="password" v-validate:password="{minlength: { rule: 6, message: '{{ trans('validation.min.string', ['attribute' => trans('global.password'), 'min' => 6]) }}' } }">
                            <label class="mdl-textfield__label" for="password">{{ trans('global.password') }}</label>
                            <template v-for="error in errors.password">
                                <span class="mdl-textfield__error">@{{ error }}</span>
                            </template>
                            <template v-for="error in $reset_password.password.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $reset_password.password_confirmation.errors && $reset_password.password_confirmation.touched}">
                            <input class="mdl-textfield__input" type="password" id="password_confirmation" name="password_confirmation" v-model="password_confirmation" v-validate:password_confirmation="{minlength: { rule: 6, message: '{{ trans('validation.min.string', ['attribute' => trans('global.password_confirmation'), 'min' => 6]) }}' } }">
                            <label class="mdl-textfield__label" for="password_confirmation">{{ trans('global.password_confirmation') }}</label>
                            <template v-for="error in errors.password_confirmation">
                                <span class="mdl-textfield__error">@{{ error }}</span>
                            </template>
                            <template v-for="error in $reset_password.password_confirmation.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <p>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" v-on:click="validateResetPassword" :disabled="$reset_password.touched && $reset_password.invalid || !$reset_password.touched">{{ trans('auth.reset_password') }}</button>
                        </p>

                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <a href="{{ route('login') }}">{{ trans('auth.login') }}</a>
                    </div>
                </div>
            </form>
        </validator>
    </div>
</template>