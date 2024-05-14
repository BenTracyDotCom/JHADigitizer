import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Vueform from '@vueform/vueform/plugin';
import vueformConfig from '../../vueform.config';
import vClickOutside from 'v-click-outside';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: () => `JHA Manager`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
    .use(Vueform, vueformConfig)
    .use(vClickOutside)  
    .use(plugin)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
