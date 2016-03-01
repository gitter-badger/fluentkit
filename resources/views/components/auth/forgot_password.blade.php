<template id="forgot-password-form-template">
    <div id="forgot-password" class="auth-card">
        <validator name="forgot_password">
            <form action="@{{ url }}" method="post">
                <div class="mdl-card mdl-shadow--2dp forgot-password-card">
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

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $forgot_password.email.errors && $forgot_password.email.touched}">
                            <input class="mdl-textfield__input" type="email" id="email" name="email" v-model="email" v-validate:email="{required: true, email: {rule: true, message: '{{ trans('validation.email', ['attribute' => trans('global.email')]) }}'} }">
                            <label class="mdl-textfield__label" for="email">{{ trans('global.email') }}</label>
                            <template v-for="error in $forgot_password.email.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <p>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" v-on:click="validateForgotPassword" :disabled="$forgot_password.touched && $forgot_password.invalid || !$forgot_password.touched">{{ trans('auth.reset_password') }}</button>
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