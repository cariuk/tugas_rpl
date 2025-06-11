<template>
    <FormKit
        type="autocomplete"
        :label="label"
        :placeholder="placeholder"
        :name="name"
        :options="doSearch"
        :option-loader="optionLoader"
        load-on-created
        clear-search-on-open
        validation-visibility="live"
    />
</template>

<script>
import {ref} from "vue"
import {get} from '@/Composables/Api'

export default {
    name: "VAutoComplete",
    components: {},
    props: {
        label: {
            type: String,
            default: "Autocomplete",
        },
        placeholder: {
            type: String,
            default: "Autocomplete",
        },
        name: {
            type: String,
            default: "Autocomplete",
        },
        defaultValue: ref({}),
        url: {
            type: String,
            default: "",
        },
        params: {
            type: Object,
            default: {search: ""},
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        autoload: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            setValue: this.defaultValue,
            options: ref([]),
        };
    },
    watch: {
        defaultValue: function (val) {
            this.setValue = val;
        },
        disabled: function (val) {
            if (!val) {
                this.doRequest(this.filters)
            }
        },
    },
    methods: {
        async doSearch({search}) {
            this.params.search = search;
            return await this.doRequest(this.params);
        },
        async doRequest(params) {
            let options = await get(
                this.url,
                params, false);

            if (options === undefined) {
                return []
            }

            if (options.data.length === 0) {
                return [];
            }

            return options.data;
        },
        async optionLoader(id, cachedOption) {
            if (cachedOption) return cachedOption

            let params = this.params;
            params.id = id;
            let loader = await get(
                this.url,
                params, false);

            params.id = null;
            return loader.data;
        },
    }, mounted() {
        if ((!this.disabled) && (this.autoload))
            this.doRequest(this.params);
    },
};
</script>

<style scoped></style>
