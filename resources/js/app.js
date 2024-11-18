import "./bootstrap";
import "../css/app.css";
import "floating-vue/dist/style.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import VueClickAway from "vue3-click-away";

/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core";

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

/* import specific icons */
import { fas } from "@fortawesome/free-solid-svg-icons";
import { fab } from "@fortawesome/free-brands-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
library.add(fas, far, fab);

/* import color picker */
import Vue3ColorPicker from "vue3-colorpicker";
import "vue3-colorpicker/style.css";

const appName = import.meta.env.VITE_APP_NAME || "PCC Digital System";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component("font-awesome-icon", FontAwesomeIcon)
            .use(VueClickAway)
            .use(Vue3ColorPicker)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        delay: 500,
        color: "#F85C04",
        includeCSS: true,
        showSpinner: false,
    },
});
