<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
</script>

<template>
    <GuestLayout :title="title">
        <div class="grid grid-cols-2 w-full lg:w-3/4 p-4 mx-auto mt-12 gap-10">
            <div class="h-[540px] border rounded shadow">
                <img src="/assets/placeholder-laptop.png" class="w-full h-full object-contain" alt="Product Image"/>
            </div>
            <div class="flex flex-col gap-10">
                <div class="text-[26px] font-bold">Product Name</div>
                <div class="text-[26px] font-bold text-green-600">Rp9.999.999</div>
                <div class="flex flex-col gap-8 text-xl py-4 px-8 w-full border rounded shadow">
                    <div>Processor : <span class="text-neutral-400">Lorem Ipsum</span></div>
                    <div>Ram : <span class="text-neutral-400">Lorem Ipsum</span></div>
                    <div>HDD/SSD : <span class="text-neutral-400">Lorem Ipsum</span></div>
                    <div>VGA : <span class="text-neutral-400">Lorem Ipsum</span></div>
                    <div class="flex w-full items-center justify-center gap-8">
                        <div>Dimensi:  <span class="text-neutral-400">10cmx5cm</span></div>
                        <div>Berat: <span class="text-neutral-400">400g</span></div>
                    </div>
                </div>
                <div>
                    <button class="w-full flex justify-center border bg-green-400 px-4 py-2 text-white font-bold text-lg cursor-pointer hover:bg-green-200 gap-4">
                        <img src="/assets/cart.svg" alt="cart"/>
                        <span>Order Sekarang</span>
                    </button>
                </div>
            </div>

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
            default: 'Detail Product'
        }
    }
}
</script>
