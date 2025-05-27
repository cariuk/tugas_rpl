<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head :title="title"></Head>
    <!--Navbar-->
    <div class="flex flex-col mix-w-screen border-t border-gray-200 shadow">
        <div class="flex flex-col w-full lg:w-3/4 p-4 m-auto">
            <ApplicationLogo class="w-[197px] h-[34px] fill-current text-gray-500"/>
        </div>
    </div>
    <div class="mb-12">
        <slot></slot>
    </div>
    <div class="flex flex-col mix-w-screen border-t border-gray-200 bg-gray-100 shadow">
        <div class="flex w-full lg:w-3/4 p-4 mx-auto justify-between">
            <div>©All Rights Reserved.</div>
            <div>Designed @2025</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'GuestLayout',
    props: {
        title: {
            type: String,
            required: true,
        }
    },
}
</script>
