<template id="admin-settings-field-template">
    <div class="admin-settings-field mdl-grid">
        <div class="mdl-cell mdl-cell--4-col">
            <label :for="field.id" class="field-label" v-bind:class="{'is-invalid': field.modified}">@{{ field.label }}</label>
        </div>
        <div class="mdl-cell mdl-cell--8-col">
            <admin-settings-field-text :field="field" v-if="field.type == 'text'"></admin-settings-field-text>
            <admin-settings-field-email :field="field" v-if="field.type == 'email'"></admin-settings-field-email>
            <admin-settings-field-select :field="field" v-if="field.type == 'select'"></admin-settings-field-select>
            <admin-settings-field-toggle :field="field" v-if="field.type == 'toggle'"></admin-settings-field-toggle>
            <p><small>@{{{ field.description }}}</small></p>
        </div>
    </div>
</template>