<template id="admin-settings-field-email-template">
    <div class="mdl-textfield mdl-js-textfield" v-bind:class="{'is-invalid': field.invalid && field.modified}">
        <input class="mdl-textfield__input" type="email" :id="field.id" v-model="field.value">
        <label class="mdl-textfield__label" :for="field.id">@{{ field.label }}</label>
        <template v-for="error in field.errors">
            <span class="mdl-textfield__error">@{{ error.message }}</span>
        </template>
    </div>
</template>