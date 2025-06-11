<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Link, router} from '@inertiajs/vue3'
</script>

<template>
    <GuestLayout :title="title">
        <div class="grid grid-cols-2">
            <div>
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
                                validation="required"
                                validation-visibility="live"
                            />
                        </div>
                        <div class="w-full border-b border-green-400 border-opacity-30"></div>
                        <div class="flex justify-center items-center w-full gap-2">
                            <FormKit
                                v-model="searchLocation"
                                type="text"
                                name="pencarianLokasi"
                                label="Pencarian Tujuan Pengiriman"
                                placeholder="Silahkan Tuliskan Nama Penerima"
                            />
                            <div class="pt-6">
                                <FormKit
                                    type="button"
                                    label="Cari"
                                    prefix-icon="search"
                                    @click="getLocation"
                                />
                            </div>
                        </div>
                        <FormKit
                            v-if="locations.length > 0"
                            v-model="checkOutTransaction.tujuan_pengiriman"
                            type="radio"
                            label="Pilihan Tujuan Pengiriman"
                            :options="locations"
                            help="Silahkan Pilih Tujuan Pengiriman?"
                            validation="required"
                            validation-visibility="live"
                        />
                        <div class="w-full border-b border-green-400 border-opacity-30"></div>
                        <FormKit
                            v-model="checkOutTransaction.alamat_lengkap"
                            type="textarea"
                            name="instructions"
                            label="Alamat Lengkap"
                            placeholder="Silahkan Tuliskan Alamat Lengkap Anda"
                            validation="required"
                            validation-visibility="live"
                        />
                        <FormKit
                            type="button"
                            label="Check Ongkos Kirim"
                            prefix-icon="submit"
                            @click="calculateDomesticCost"
                        />
                        <div class="w-full border-b border-green-400 border-opacity-30"></div>
                        <FormKit
                            v-if="metodePengiriman.length > 0"
                            v-model="checkOutTransaction.metode_pengiriman"
                            type="radio"
                            label="Metode Pengiriman"
                            :options="metodePengiriman"
                            help="Silahkan Pilih Metode Pengiriman?"
                            validation="required"
                            validation-visibility="live"
                        />
                    </div>
                </div>
            </div>
            <div class="relative top-0 z-50 bg-gray-200 lg:bg-gray-200 px-28 py-16 min-h-screen">
                <div class="sticky top-0 z-50 flex flex-col gap-10">
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
                    <div class="flex">
                        <FormKit
                            type="button"
                            label="Kembali Detail Produk"
                            prefix-icon="arrowLeft"
                            @click="router.visit(route('product-detail', { id: product.id }))"
                        />
                        <FormKit
                            type="button"
                            label="Lanjutkan Ke Pembayaran"
                            prefix-icon="flag"
                            @click="gotoPayment"
                        />
                    </div>

                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script>
import {ref} from "vue";
import {get} from "@/Composables/Api.js";
import {search} from "@formkit/icons";

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
            searchLocation: "",
            locations: ref([]),
            metodePengiriman: ref([]),
            checkOutTransaction: {
                product_id: this.product.id,
                sub_total: this.product.harga,
                bobot: this.product.bobot,
                nama_peneriman: "",
                tujuan_pengiriman: "",
                alamat_peneriman: "",
                metode_pengiriman: "",
                ongkos_kirim: 0,
                total: this.product.harga
            }
        }
    },
    watch: {
        "checkOutTransaction.metode_pengiriman": function (val) {
            this.checkOutTransaction.ongkos_kirim = Number(val.cost)
        },
        "checkOutTransaction.ongkos_kirim": function () {
            this.checkOutTransaction.total = this.checkOutTransaction.total + this.checkOutTransaction.ongkos_kirim;
        }
    },
    methods: {
        async getLocation() {
            let result = await get(
                route('products-pengiriman.lokasi'), {search: this.searchLocation}
            );

            if (result === undefined) {
                this.location = []
                this.$swal("Lokasi Tidak Ditemukan")
                return false;
            }

            this.locations = result.data.map(item => {
                return {
                    label: item.label,
                    value: item,
                }
            })
        },
        async calculateDomesticCost() {
            let result = await get(
                route('products-pengiriman.domestic-cost'), {
                    destination: this.checkOutTransaction.tujuan_pengiriman,
                    weight: this.checkOutTransaction.bobot,
                }
            );

            if (result === undefined) {
                this.metodePengiriman = []
                this.$swal("Metode Pengiriman Tidak Ditemukan")
                return false;
            }

            this.metodePengiriman = result.data.map(item => {
                return {
                    label: item.description + ' | ' + item.name + ' | ' + item.etd + ' | ' + item.cost.toLocaleString(),
                    value: item,
                }
            })
        },
        async gotoPayment() {

        }
    }
}
</script>
