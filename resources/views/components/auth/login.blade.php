<template id="login-form-template">
    <div id="login" class="auth-card">
        <validator name="login">
            <form action="@{{ url }}" method="post" novalidate>
                <div class="mdl-card mdl-shadow--2dp login-card">
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

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $login.email.errors && $login.email.touched}">
                            <input class="mdl-textfield__input" type="email" id="email" name="email" v-model="email" v-validate:email="{required: true, email: {rule: true, message: '{{ trans('validation.email', ['attribute' => trans('global.email')]) }}'} }">
                            <label class="mdl-textfield__label" for="email">{{ trans('global.email') }}</label>
                            <template v-for="error in $login.email.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $login.password.errors && $login.password.touched}">
                            <input class="mdl-textfield__input" type="password" id="password" name="password" v-model="password"  v-validate:password="{minlength: { rule: 6, message: '{{ trans('validation.min.string', ['attribute' => trans('global.password'), 'min' => 6]) }}' } }">
                            <label class="mdl-textfield__label" for="password">{{ trans('global.password') }}</label>
                            <template v-for="error in $login.password.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <p>
                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
                                <input type="checkbox" id="remember" name="remember" class="mdl-checkbox__input" v-model="remember">
                                <span class="mdl-checkbox__label">{{ trans('auth.remember_me') }}</span>
                            </label>
                        </p>
                        <p>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" v-on:click="validateLogin" :disabled="$login.touched && $login.invalid || !$login.touched">{{ trans('auth.login') }}</button>
                        </p>

                        <p class="or"><small>Or login with</small></p>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
                                <a href="{{ route('login', ['provider' => 'google']) }}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" id="google">{{ trans('global.google') }}</a>
                            </div>
                            <div class="mdl-cell mdl-cell--4-col mdl-cell--2-col-phone">
                                <a href="{{ route('login', ['provider' => 'facebook']) }}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" id="facebook">{{ trans('global.facebook') }}</a>
                            </div>
                            <div class="mdl-cell mdl-cell--4-col mdl-cell--2-col-phone">
                                <a href="{{ route('login', ['provider' => 'twitter']) }}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" id="twitter">{{ trans('global.twitter') }}</a>
                            </div>
                        </div>

                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <a href="{{ route('register') }}">{{ trans('auth.register') }}</a>&nbsp;&nbsp;<small>or</small>&nbsp;&nbsp;<a href="{{ route('forgot_password') }}">{{ trans('auth.forgot_password') }}</a>
                    </div>
                </div>
            </form>
        </validator>
    </div>
</template>