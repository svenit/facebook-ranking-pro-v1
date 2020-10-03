import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
        key: process.env.MIX_GOOGLE_MAP_KEY,
    },
    region: 'VI',
    language: 'vi',
    installComponents: true
});

Vue.component('google-map', VueGoogleMaps.Map);
