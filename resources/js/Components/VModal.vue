<template>
    <vue-final-modal overlay-transition="vfm-fade" :z-index-base="zIndexBase"
        class="flex justify-center items-center overflow-auto" :content-class="[
            'relative flex flex-col border border-primary bg-white',
            sizeWidth === 'sm' ? 'min-w-[10%] sm:max-w-[40%] mx-4 h-screen max-h-screen' : '',
            sizeWidth === 'md' ? 'min-w-[408px] sm:max-w-[60%] mx-4 max-h-screen' : '',
            sizeWidth === 'lg' ? 'min-w-[40%] sm:max-w-[80%] mx-4 max-h-screen' : '',
            sizeWidth === 'full' ? 'h-screen w-screen sm:min-w-screen' : '',
        ]" v-bind="$attrs">
        <div class="lg:py-2 lg:px-2 sm:py-1 sm:px-2 shadow bg-primary">
            <div class="flex justify-between items-center">
                <p class="capitalize text-neutral-white sm:text-xs lg:text-lg font-bold"> {{ title }}</p>
                <button @click="modal.close()" class="text-gray-200 hover:text-gray-400">
                    <XCircleIcon class="w-8 h-8" />
                </button>
            </div>
        </div>
        <div v-if="$slots.body" :class="[
            sizeWidth === 'full' ? 'h-full overflow-hidden':'h-full overflow-hidden',
        ]">
            <slot name="body"></slot>
        </div>
        <div v-if="$slots.button" :class="[
            'py-4 px-6 border-t shadow',
        ]">
            <slot name="button"></slot>
        </div>
    </vue-final-modal>
</template>

<script>
import { VueFinalModal } from "vue-final-modal";
import { XCircleIcon } from "@heroicons/vue/24/outline";
import {ref} from "vue";

export default {
    name: "VModal",
    components: { VueFinalModal, XCircleIcon },
    props: {
        title : String,
        modal: ref(),
        zIndexBase: {
            type: [ String, Number ],
            default: 30
        },
        sizeWidth: {
            type: String,
            default: 'lg'
        }
    },
    data(){
        return {
           options : {
               modelValue : false
           }
        }
    }
}
</script>
