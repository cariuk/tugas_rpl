<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import VButtonFormKit from "@/Components/VButtonFormKit.vue";
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
                        <div class="flex">
                            <FormKit
                                v-model="checkOutTransaction.phone_peneriman"
                                type="text"
                                name="phone_peneriman"
                                label="Nomor Tlp Penerima"
                                placeholder="Silahkan Tuliskan Kontak Penerima"
                                validation="required"
                                validation-visibility="live"
                            />
                        </div>
                        <div class="flex">
                            <FormKit
                                v-model="checkOutTransaction.email_peneriman"
                                type="email"
                                name="email_peneriman"
                                label="Email Penerima"
                                placeholder="Silahkan Tuliskan Email Penerima"
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
                                placeholder="Silahkan Tuliskan Kode Pos / Kecamatan / Kota Kabupaten"
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
                        <div v-if="recomendationMetodePengiriman.recommended_option"
                             class="w-full border-b border-green-400 border-opacity-30 p-2 bg-green-100 rounded shadow">
                            <div> Rekomendasi Pengiriman Terbaik </div>
                            <div>
                                {{ recomendationMetodePengiriman.recommended_option.description + ' | ' + recomendationMetodePengiriman.recommended_option.name + ' | ' + recomendationMetodePengiriman.recommended_option.etd + ' | ' + recomendationMetodePengiriman.recommended_option.cost.toLocaleString() }}
                            </div>
                        </div>
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
                    <div class="flex justify-between gap-4">
                        <div>
                            <VButtonFormKit
                                label="Kembali Detail Produk"
                                prefix-icon="arrowLeft"
                                @click="router.visit(route('product-detail', { id: product.id }))"
                                color="danger"
                            />
                        </div>
                        <div>
                            <VButtonFormKit
                                label="Lanjutkan Ke Pembayaran"
                                prefix-icon="flag"
                                @click="gotoPayment"
                            />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script>
import {ref} from "vue";
import {get, post} from "@/Composables/Api.js";
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
            recomendationMetodePengiriman: ref({}),
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

            this.recomendationMetodePengiriman = result.best_option
            if (this.recomendationMetodePengiriman.recommended_option) {
                this.checkOutTransaction.metode_pengiriman = this.recomendationMetodePengiriman.recommended_option
            }
        },
        async gotoPayment() {
            this.$swal({
                title: "Apa kamu yakin?",
                text: `Anda Melanjutkan Ke Pembayaran ini!`,
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Iya!",
                cancelButtonText: "Batal",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.$swal.fire({
                        allowOutsideClick: false,
                        timerProgressBar: true,
                        didOpen: async () => {
                            this.$swal.showLoading();
                            // let result = await post(route('payment'), this.checkOutTransaction)
                            // if (result === undefined) {
                            //     this.$swal("Gagal Melakukan Penyimpanan")
                            //     return false;
                            // }
                            //
                            // result = result._value.data;
                            // let result = await post(
                            //     this.storeUrl,
                            //     this.formData
                            // ).finally(() => {
                            //     this.$swal.close();
                            // })
                            //
                            // result = await result._value;
                            //
                            // if (result.status !== 200) {
                            //     this.$swal({
                            //         icon: 'error',
                            //         title: result.message
                            //     });
                            //
                            //     return false
                            // }
                            //
                            // if (result.status === 422) {
                            //     this.formErrors = handleValidationMessage(
                            //         result,
                            //         this.formErrors
                            //     );
                            //     return false
                            // }
                            //
                            // result = result.data
                            // Object.assign(this.data, result.data);
                            // this.data.action = this.action
                            //
                            // this.modal.close()
                            this.$swal.close();
                        },
                        willClose: () => {}
                    });
                }
            });
        }
    }
}
</script>
