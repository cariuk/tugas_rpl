<template>
    <FormKit
        :outer-class="{
            '!mb-0': !mb
        }"
        :input-class="{
            '!mb-0': !mb,
            /* Size */
            '!px-4 !py-2.5 !shadow-sm !text-sm': size === 'sm',
            '!px-4 !py-3 !shadow-lg !text-lg': size === 'md',
            '!px-5 !py-4 !shadow-lg !text-lg': size === 'lg',
            /* Color */
            'text-blue-500 border-blue-500 bg-blue-50 hover:bg-blue-100': color === 'primary',
            'text-gray-500 border-gray-500 bg-gray-50 hover:bg-gray-100': color === 'default',
            'text-rose-500 border-rose-500 bg-rose-50 hover:bg-rose-100': color === 'danger',
            'text-emerald-500 border-emerald-500 bg-emerald-50 hover:bg-emerald-100': color === 'info',
            '!text-amber-500 !border-amber-500 !bg-amber-50 hover:!bg-amber-100': color === 'warning',
        }"
        type="button"
    ></FormKit>
</template>

<script lang="ts">

export enum enumSize {
    sm, lg
}

export enum enumColor {
    default, primary, info, danger, warning
}
export default {
    name: "VButton",
    components: {},
    props: {
        color: enumColor | 'primary',
        size: {
            type: String,
            default: 'sm'
        },
        mb: {
            type: Boolean,
            default: false
        }
    }
}
</script>
