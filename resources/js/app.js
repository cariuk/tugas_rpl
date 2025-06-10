import '../css/app.css';

import { plugin as pluginFormkit, defaultConfig } from '@formkit/vue'
import { createProPlugin, inputs } from '@formkit/pro'
const pro = createProPlugin('fk-54875842db8', inputs);

import configFormKit from '../../formkit.config.js';
import { genesisIcons } from '@formkit/icons'

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import {createVfm} from "vue-final-modal";

const vfm = createVfm();

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(pluginFormkit, defaultConfig(defaultConfig(
                {
                    plugins: [pro],
                    config: configFormKit.config,
                    icons: {
                        ...genesisIcons
                    }
                })))
            .use(vfm)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
