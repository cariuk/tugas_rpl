<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Link} from '@inertiajs/vue3'
import VAutoComplete from "@/Components/VAutoCompleteFormKit.vue";
</script>

<template>
    <div class="grid grid-cols-2">
        <div>
            <GuestLayout :title="title">
                <div class="flex flex-col w-full lg:w-3/4 p-4 mx-auto mt-12 gap-10">
                    <div class="text-lg">
                        <Link href="/" class="text-green-400">Produk</Link>
                        >
                        <Link :href="route('product-detail',product.id)" class="text-green-400">Detail</Link>
                        > <span>Pegiriman</span> > <span>Payment</span>
                    </div>
                    <div class="flex flex-col gap-4 px-4 py-8 border rounded border-green-500 border-opacity-20">
                        <div class="flex">
                            <FormKit
                                v-model="checkOutTransaction.nama_peneriman"
                                type="text"
                                name="nama_penerima"
                                label="Nama Penerima"
                                placeholder="Silahkan Tuliskan Nama Penerima"
                            />
                        </div>
                        <div class="w-full border-b border-green-400 border-opacity-30"></div>
                        <VAutoComplete
                            label="Petugas Medis"
                            name="petugas_medis"
                            v-model="checkOutTransaction.lokasi_peneriman"
                            :url="route('products-pengiriman.lokasi')"
                            validation="required"
                            placeholder="Lokasi Penerimaan"
                        />
                        <div class="w-full border-b border-green-400 border-opacity-30"></div>
                        <FormKit
                            v-model="checkOutTransaction.alamat_peneriman"
                            type="textarea"
                            name="instructions"
                            label="Alamat Lengkap"
                            placeholder="Silahkan Tuliskan Alamat Lengkap Anda"
                        />
                    </div>
                </div>
            </GuestLayout>
        </div>
        <div class="bg-gray-200 lg:bg-gray-200 px-28 py-16">
            <div class="flex flex-col gap-10">
                <div class="flex h-[127px] gap-20">
                    <div><img src="/assets/placeholder-laptop.png" class="w-full h-full object-contain"
                              alt="Product Image"/></div>
                    <div class="flex flex-col gap-4">
                        <div class="text-lg font-bold">{{ product.merk.nama }} - {{ product.model }}</div>
                        <div class="text-lg font-bold text-green-600">Rp{{ product.harga.toLocaleString() }}</div>
                    </div>
                </div>
                <div class="w-full border-b border-green-400 border-opacity-30"></div>
                <div class="text-lg flex justify-between gap-4 text-neutral-600">
                    <div>Subtotal</div>
                    <div class="flex flex-col gap-4">Rp{{ checkOutTransaction.sub_total.toLocaleString() }}</div>
                </div>
                <div class="text-lg flex justify-between gap-4 text-neutral-600">
                    <div>Ongkos Kirim</div>
                    <div class="flex flex-col gap-4">Rp{{ checkOutTransaction.ongkos_kirim.toLocaleString() }}</div>
                </div>
                <div class="w-full border-b border-green-400 border-opacity-30"></div>
                <div class="text-lg flex justify-between gap-4 text-neutral-600">
                    <div>Total</div>
                    <div class="flex flex-col gap-4">
                        Rp{{ (checkOutTransaction.sub_total + checkOutTransaction.ongkos_kirim).toLocaleString() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {ref} from "vue";

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
    data() {
        return {
            checkOutTransaction: {
                product_id: this.product.id,
                sub_total: this.product.harga,
                nama_peneriman: "",
                lokasi_peneriman: "",
                alamat_peneriman: "",
                jenis_pengiriman: "",
                ongkos_kirim: 0,
                total: this.product.harga
            }
        }
    },
    watch: {
        "checkOutTransaction.ongkos_kirim": function () {
            this.checkOutTransaction.total = this.checkOutTransaction.total + this.checkOutTransaction.ongkos_kirim;
        }
    },
    methods: {}
}
</script>
