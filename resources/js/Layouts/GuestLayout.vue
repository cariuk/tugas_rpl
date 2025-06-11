<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Head} from '@inertiajs/vue3';
import { ModalsContainer } from 'vue-final-modal'
</script>

<template>
    <Head :title="title"></Head>
    <!--Navbar-->
    <div class="flex flex-col mix-w-screen border-t border-gray-200 shadow sticky top-0 z-50 bg-white">
        <div class="flex flex-col w-full lg:w-3/4 p-4 m-auto">
            <ApplicationLogo class="w-[197px] h-[34px] fill-current text-gray-500 cursor-pointer" @click="toWelcome()"/>
        </div>
    </div>
    <div class="flex flex-col justify-between h-full min-h-screen">
        <div class="h-full min-h-full">
            <slot></slot>
        </div>
        <div class="flex flex-col mix-w-screen border-t border-gray-200 bg-gray-100 shadow">
            <div class="flex w-full lg:w-3/4 p-4 mx-auto justify-between">
                <div>©All Rights Reserved.</div>
                <div>Designed @2025</div>
            </div>
        </div>
    </div>
    <modals-container></modals-container>
</template>

<script>
import {router} from "@inertiajs/vue3";

export default {
    name: 'GuestLayout',
    props: {
        title: {
            type: String,
            required: true,
        }
    },
    methods: {
        toWelcome(){
            router.visit('/')
        }
    }
}
</script>
