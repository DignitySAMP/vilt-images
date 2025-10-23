import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import Vue3Toastify from "vue3-toastify";
import "../css/toastify.css";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./pages/**/*.vue", { eager: true });
        return pages[`./pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Vue3Toastify, {
				position: "bottom-right",
				autoClose: 7500,
				clearOnUrlChange: false, // some forms cause redirects, toasts should stay
			})
            .mount(el);
    },
});
