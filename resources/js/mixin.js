import Vue from 'vue';
import { statsBinding } from '~/config.js';

Vue.mixin({
    data() {
        return {
            statsBinding
        }
    },
    methods: {
        asset(fileName) {
            return `${config.root}/${fileName}`;
        },
        numberFormat(num) {
            var si = [{
                    value: 1,
                    symbol: ""
                }, {
                    value: 1E3,
                    symbol: "K"
                }, {
                    value: 1E6,
                    symbol: "M"
                }, {
                    value: 1E9,
                    symbol: "B"
                }, {
                    value: 1E12,
                    symbol: "T"
                }, {
                    value: 1E15,
                    symbol: "P"
                }, {
                    value: 1E18,
                    symbol: "E"
                }
            ];
            var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
            var i;
            for (i = si.length - 1; i > 0; i--) {
                if (num >= si[i].value) {
                    break;
                }
            }
            return (num / si[i].value).toFixed(3).replace(rx, "$1") + si[i].symbol;
        },
        numberFormatDetail(num) {
            num = parseInt(num);
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        },
    }
});
