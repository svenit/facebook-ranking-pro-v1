import Vue from 'vue';
let statsBinding = [{
    acronyms: 'HP',
    field: 'hp',
    name: 'Sinh lực'
}, {
    acronyms: 'STR',
    field: 'strength',
    name: 'Sát thương vật lý'
}, {
    acronyms: 'INT',
    field: 'intelligent',
    name: 'Sát thương phép thuật'
}, {
    acronyms: 'AGI',
    field: 'agility',
    name: 'Nhanh nhẹn'
}, {
    acronyms: 'LUK',
    field: 'lucky',
    name: 'May mắn'
}, {
    acronyms: 'DEF',
    field: 'armor_strength',
    name: 'Kháng sát thương vật lý'
}, {
    acronyms: 'AM',
    field: 'armor_intelligent',
    name: 'Kháng phép'
}];
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
