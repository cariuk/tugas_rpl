<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import ListProducts from "@/Pages/LandingPage/ListProducts.vue";
</script>

<template>
    <GuestLayout :title="title">
        <div class="grid gap-2">
            <div class="flex items-center justify-center w-full h-[704px] max-[704px] m-auto shadow">
                <div class="w-[730px] h-[314.99px] bg-grey-50 shadow rounded"></div>
            </div>
            <ListProducts />
        </div>
    </GuestLayout>
</template>

<script>
export default {
    name: 'Welcome',
    props: {
        title: {
            type: String,
            required: true,
            default: 'Welcome'
        }
    }
}
</script>
