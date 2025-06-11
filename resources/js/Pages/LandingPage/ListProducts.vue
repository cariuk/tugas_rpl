<script setup>

</script>

<template>
    <div class="mt-16 text-center">
        <div class="text-[40px] font-bold">Products</div>
        <div class="text-[18px] text-slate-500">Order it for you or for your beloved ones</div>
    </div>
    <div class="flex w-full justify-center items-center">
        <div class="w-3/4 border px-4 pt-4">
            <FormKit
                type="checkbox"
                v-model="statusRecommendation"
                label="10 Rekomendasi Laptop"
                help="Parameter Berasarkan Harga, Bobot, CPU Score dan GPU Score"
                name="terms"
            />
        </div>
    </div>
    <div class="flex w-full justify-center items-center">
        <div class="w-3/4 grid grid-cols-4 gap-6 mt-16 border p-4">
            <button v-for="product in products" :key="product.id" @click="showProductDetail(product.id)">
                <label class="flex flex-col w-full h-[280px] shadow cursor-pointer hover:bg-gray-200 rounded-md">
                    <span class="h-full max-h-[156px] flex items-center justify-center shadow">
                        <img src="assets/placeholder-laptop.png" class="w-full max-h-[156px] object-contain"
                             alt="Product Image"/>
                    </span>
                    <span class="grid h-[76px] px-4 py-2">
                        <span class="text-lg">{{ product.merk.nama }} - {{ product.model }}</span>
                        <span class="text-[20px] text-green-400">
                            Rp {{ product.harga.toLocaleString() }}
                        </span>
                        <span class="text-xs flex p-2 w-full items-center justify-center gap-8 rounded border">
                            <span>Berat <br/><span class="text-neutral-400">{{ product.bobot }}</span></span>
                            <span>CPU Score <br/><span class="text-neutral-400">{{ product.cpu_score }}</span></span>
                            <span>GPU Score <br/><span class="text-neutral-400">{{ product.gpu_score }}</span></span>
                        </span>
                    </span>
                </label>
            </button>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";

import {get} from "@/Composables/Api.js"

export default {
    name: "Products",
    data() {
        return {
            products: ref([]),
            statusRecommendation: ref(false)
        }
    },
    watch: {
        statusRecommendation() {
            this.getProducts();
        }
    },
    methods: {
        async getProducts() {
            let products = []

            let result = await get(route('products'), {
                recommendation: this.statusRecommendation
            })

            this.products = result.data
        },
        showProductDetail(productId) {
            router.visit('/product-detail/' + productId);
        },
    },
    mounted() {
        this.getProducts();
    }
}
</script>
