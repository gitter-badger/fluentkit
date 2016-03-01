<template id="admin-settings-panel-template">
    <div class="admin-settings-panel mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-card mdl-shadow--2dp settings-card">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">@{{ group.name }}</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <p>@{{ group.description }}</p>
                </div>
                <template v-for="section in group.sections">
                    <div class="mdl-card__supporting-text mdl-card--border">
                        <admin-settings-section :section="section"></admin-settings-section>
                    </div>
                </template>
                <div class="mdl-card__actions mdl-card--border" v-show="can_save" transition="fade">
                    <small class="unsaved_warning" v-show="validator.valid">{{ trans('admin.settings_unsaved_warning') }}</small>
                    <small class="unsaved_warning" v-show="!validator.valid">{{ trans('admin.settings_unsaved_invalid_warning') }}</small>
                    <div class="text-right">
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect" v-on:click="resetPanel()">
                            {{ trans('global.discard') }}
                        </button>
                        <button class="mdl-button mdl-button--primary mdl-button--raised mdl-js-button mdl-js-ripple-effect" v-on:click="triggerSave()" :disabled="!validator.valid">
                            {{ trans('global.save_changes') }}
                        </button>
                    </div>
                </div>
                <div class="mdl-card__menu">
                    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" v-on:click="closePanel()">
                        <i class="material-icons">close</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>