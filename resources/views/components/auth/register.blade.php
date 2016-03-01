<template id="register-form-template">
    <div id="register" class="auth-card">
        <validator name="register">
            <form action="@{{ url }}" method="post">
                <div class="mdl-card mdl-shadow--2dp register-card">
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

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $register.first_name.errors && $register.first_name.touched}">
                            <input class="mdl-textfield__input" type="text" id="first_name" name="first_name" v-model="first_name" v-validate:first_name="{required: true, maxlength: {rule: 255, message: '{{ trans('validation.max.string', ['attribute' => trans('global.first_name')]) }}'} }">
                            <label class="mdl-textfield__label" for="first_name">{{ trans('global.first_name') }}</label>
                            <template v-for="error in $register.first_name.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $register.last_name.errors && $register.last_name.touched}">
                            <input class="mdl-textfield__input" type="text" id="last_name" name="last_name" v-model="last_name" v-validate:last_name="{required: true, maxlength: {rule: 255, message: '{{ trans('validation.max.string', ['attribute' => trans('global.last_name')]) }}'} }">
                            <label class="mdl-textfield__label" for="last_name">{{ trans('global.last_name') }}</label>
                            <template v-for="error in $register.last_name.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $register.email.errors && $register.email.touched}">
                            <input class="mdl-textfield__input" type="email" id="email" name="email" v-model="email" v-validate:email="{required: true, email: {rule: true, message: '{{ trans('validation.email', ['attribute' => trans('global.email')]) }}'} }">
                            <label class="mdl-textfield__label" for="email">{{ trans('global.email') }}</label>
                            <template v-for="error in $register.email.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $register.password.errors && $register.password.touched}">
                            <input class="mdl-textfield__input" type="password" id="password" name="password" v-model="password" v-validate:password="{minlength: { rule: 6, message: '{{ trans('validation.min.string', ['attribute' => trans('global.password'), 'min' => 6]) }}' } }">
                            <label class="mdl-textfield__label" for="password">{{ trans('global.password') }}</label>
                            <template v-for="error in $register.password.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" v-bind:class="{'is-invalid': $register.password_confirmation.errors && $register.password_confirmation.touched}">
                            <input class="mdl-textfield__input" type="password" id="password_confirmation" name="password_confirmation" v-model="password_confirmation" v-validate:password_confirmation="{minlength: { rule: 6, message: '{{ trans('validation.min.string', ['attribute' => trans('global.password_confirmation'), 'min' => 6]) }}' } }">
                            <label class="mdl-textfield__label" for="password_confirmation">{{ trans('global.password_confirmation') }}</label>
                            <template v-for="error in $register.password_confirmation.errors">
                                <span class="mdl-textfield__error">@{{ error.message }}</span>
                            </template>
                        </div>

                        <p>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" v-on:click="validateRegister" :disabled="$register.touched && $register.invalid || !$register.touched">{{ trans('auth.register') }}</button>
                        </p>

                        <p class="or"><small>Or register with</small></p>

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
                        <a href="{{ route('login') }}">{{ trans('auth.login') }}</a>
                    </div>
                </div>
            </form>
        </template>
    </div>
</template>