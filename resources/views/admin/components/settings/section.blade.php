<template id="admin-settings-section-template">
    <div class="admin-settings-section">
        <div class="section-info" v-on:click="fields_visible = !fields_visible">
            <p><strong>@{{ section.name }}</strong></p>
            <p>@{{ section.description }}</p>
        </div>
        <div class="section-fields" v-show="fields_visible" transition="fade">
            <div v-for="field in section.fields">
                <admin-settings-field :field="field"></admin-settings-field>
            </div>
        </div>
    </div>
</template>