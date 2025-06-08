<script setup>

</script>

<template>
    <div class="mt-16 text-center">
        <div class="text-[40px] font-bold">Products</div>
        <div class="text-[18px] text-slate-500">Order it for you or for your beloved ones</div>
    </div>
    <div class="flex w-full justify-center items-center">
        <div class="w-3/4 grid grid-cols-4 gap-6 mt-16">
            <button v-for="product in products" :key="product.id" @click="showProductDetail(product.id)">
                <label class="flex flex-col w-full h-[230px] shadow cursor-pointer hover:bg-gray-200 rounded-md">
                    <span class="h-full max-h-[156px] flex items-center justify-center shadow">
                        <img :src="product.image" class="w-full max-h-[156px] object-cover" alt="Product Image"/>
                    </span>
                    <span class="grid h-[76px] px-4 py-2">
                        <label class="text-lg">{{ product.name }}</label>
                        <label class="text-right text-[20px] text-green-400">Rp {{
                                product.price.toLocaleString()
                            }}</label>
                    </span>
                </label>
            </button>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";

export default {
    name: "Products",
    data() {
        return {
            products: ref([])
        }
    },
    methods: {
        getProducts() {
            let products = []
            for (let i = 0; i < 8; i++) {
                products.push({
                    id: i,
                    name: "Product " + i,
                    image: 'assets/placeholder-laptop.png',
                    price: 99999999,
                });
            }
            console.log(products)
            this.products = ref(products)
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
