<template id="admin-settings-field-select-template">
    <div class="mdl-textfield mdl-js-textfield" v-bind:class="{'is-invalid': field.invalid && field.modifed}">
        <select :id="field.id" v-model="field.value">
            <option v-for="option in field.options" v-bind:value="option.value">
                @{{ option.text }}
            </option>
        </select>
        <template v-for="error in field.errors">
            <span class="mdl-textfield__error">@{{ error.message }}</span>
        </template>
    </div>
</template>