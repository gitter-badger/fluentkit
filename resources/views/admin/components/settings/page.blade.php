<template id="admin-settings-page-template">
    <div id="admin-settings-page">
        <div class="mdl-grid settings-grid" v-show="active_panel == null" transition="fade">
            <div class="mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet" v-for="group in groups">
                <div class="mdl-card mdl-shadow--2dp settings-card">
                    <div class="mdl-card__title">
                        <h2 class="mdl-card__title-text">@{{ group.name }}</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <p>@{{ group.description }}</p>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" v-on:click="active_panel = group.id">@{{ group.link_text }}</a>
                    </div>
                    <div class="mdl-card__menu">
                        <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                            <i class="material-icons">@{{ group.icon }}</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <validator name="settings">
            <div v-for="group in groups">
                <div v-for="section in group.sections">
                    <div v-for="field in section.fields">
                        <input
                                type="hidden"
                                :id="field.id"
                                v-model="field.value"
                                :field="field.id"
                                v-validate="field.validate"
                                v-on:valid="syncFieldValidation(field)"
                                v-on:invalid="syncFieldValidation(field)"
                                v-on:touched="syncFieldValidation(field)"
                                v-on:modified="syncFieldValidation(field)"
                                v-on:dirty="syncFieldValidation(field)"
                                />
                    </div>
                </div>
            </div>

            <template v-for="group in groups">
                <admin-settings-panel :group="group" :validator="$settings" v-show="active_panel == group.id" transition="fade"></admin-settings-panel>
            </template>

        </validator>

        <div id="loading-overlay" v-show="loading" transition="fade">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
    </div>
</template>