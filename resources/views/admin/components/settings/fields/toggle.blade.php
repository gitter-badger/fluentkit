<template id="admin-settings-field-toggle-template">
        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" :id="field.id">
            <input type="checkbox" class="mdl-switch__input" v-model="field.value" :id="field.id"/>
            <span class="mdl-switch__label">@{{ field.toggle_label }}</span>
        </label>
</template>