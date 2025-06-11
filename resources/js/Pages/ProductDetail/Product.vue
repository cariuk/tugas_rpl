<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {router} from "@inertiajs/vue3";
</script>

<template>
    <GuestLayout :title="title">
        <div class="grid grid-cols-2 w-full lg:w-3/4 p-4 mx-auto mt-12 gap-10">
            <div class="h-[540px] border rounded shadow">
                <img src="/assets/placeholder-laptop.png" class="w-full h-full object-contain" alt="Product Image"/>
            </div>
            <div class="flex flex-col gap-10">
                <div class="text-[26px] font-bold">{{ product.model }}</div>
                <div class="text-[26px] font-bold text-green-600">Rp{{ product.harga.toLocaleString() }}</div>
                <div class="flex flex-col gap-8 text-xl py-4 px-8 w-full border rounded shadow">
                    <div>Processor : <span class="text-neutral-400">{{ product.deskripsi.cpu }}</span></div>
                    <div>Ram : <span class="text-neutral-400">{{ product.deskripsi.ram }}</span></div>
                    <div>HDD/SSD : <span class="text-neutral-400">{{ product.deskripsi.penyimpanan }}</span></div>
                    <div>VGA : <span class="text-neutral-400">{{ product.deskripsi.gpu }}</span></div>
                    <div class="flex w-full items-center justify-center gap-8">
                        <div>Berat: <span class="text-neutral-400">{{ product.bobot }}</span></div>
                        <div>CPU Score: <span class="text-neutral-400">{{ product.cpu_score }}</span></div>
                        <div>GPU Scoore: <span class="text-neutral-400">{{ product.gpu_score }}</span></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button @click="router.visit('/')"
                            class="flex justify-center border bg-red-400 px-4 py-2 text-white font-bold text-lg cursor-pointer hover:bg-red-200 gap-4">
                        Kembali
                    </button>
                    <button @click="showPengirimanProduk(product.id)"
                            class="w-full flex justify-center border bg-green-400 px-4 py-2 text-white font-bold text-lg cursor-pointer hover:bg-green-200 gap-4">
                        <img src="/assets/cart.svg" alt="cart"/>
                        <span>Order Sekarang</span>
                    </button>
                </div>
            </div>

        </div>
    </GuestLayout>
</template>

<script>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";

export default {
    name: 'Welcome',
    props: {
        product: ref({}),
        title: {
            type: String,
            required: true,
            default: 'Detail Product'
        }
    },
    methods: {
        showPengirimanProduk(productId) {
            router.visit('/product-pengiriman/' + productId);
        }
    }
}
</script>
