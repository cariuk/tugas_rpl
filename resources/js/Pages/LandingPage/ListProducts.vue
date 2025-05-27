<script setup>

</script>

<template>
    <div class="mt-16 text-center">
        <div class="text-[40px] font-bold">Products</div>
        <div class="text-[18px] text-slate-500">Order it for you or for your beloved ones</div>
    </div>
    <div class="flex w-full justify-center items-center">
        <div class="w-3/4 grid grid-cols-4 gap-6 mt-16">
            <div v-for="product in products" :key="product.id"
                 class="flex flex-col w-full h-[230px] shadow cursor-pointer hover:bg-gray-200 rounded-md">
                <div class="h-full flex items-center justify-center">
                    <img :src="product.image" alt="Product Image"/>
                </div>
                <div class="h-[76px] px-4 py-2">
                    <div class="text-lg">{{ product.name }}</div>
                    <div class="text-right text-[20px] text-green-400">Rp {{ product.price.toLocaleString() }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";

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
                    images: '',
                    price: 99999999,
                });
            }
            console.log(products)
            this.products = ref(products)
        }
    },
    mounted() {
        this.getProducts();
    }
}
</script>
