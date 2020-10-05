
import { languages } from '~/config.js';

export default {
    app: {},
    showIntro: false,
    currentLang: sessionStorage.getItem('currentLang') || 'vie',
    languages,
    moreMenu: false,
    firebase: null,
    userCount: 0,
    author: process.env.MIX_APP_SALT,
    socket: null,
    loading: true,
    flash: true,
    detect: false,
    token: '',
    detailGear: {
        data: {
            health_points: {
                default: 0,
                percent: 0
            },
            strength: {
                default: 0,
                percent: 0
            },
            intelligent: {
                default: 0,
                percent: 0
            },
            agility: {
                default: 0,
                percent: 0
            },
            lucky: {
                default: 0,
                percent: 0
            },
            armor_strength: {
                default: 0,
                percent: 0
            },
            armor_intelligent: {
                default: 0,
                percent: 0
            },
            character: {},
            cates: {}
        },
        permission: 0
    },
    detailPet: {
        data: {},
        permission: 0
    },
    detailItem: {
        data: {},
        permission: 0
    },
    detailGem: {
        data: {},
        permission: 0
    },
    detailSkill: {
        data: {
            options: {
                energy: 0,
                coolDown: 0
            }
        },
        permission: 0,
    },
    data: {
        infor: {
            name: "",
            character: {
                id: "",
                name: "",
                avatar: ""
            },
            exp: 0,
            coins: 'Đang tải...',
            gold: 'Đang tải...',
            provider_id: "0",
            active: "",
            fame: 0,
            pvp_points: 0,
            energy: 0
        },
        stats: {
            data: {},
            used: 0,
            available: 0
        },
        rank: {
            brand: 'E',
            fame: {
                next: {}
            },
            pvp: {
                next: {}
            }
        },
        top: {
            fame: 0,
            level: 0,
            pvp: 0,
            power: 0
        },
        level: {
            next_level: "0",
            next_level_exp: 0,
            current_level: 0,
            current_user_exp: 0,
            percent: 0
        },
        raw_power: {
            total: 'Đang tải...',
            hp: 0,
            strength: 0,
            agility: 0,
            intelligent: 0,
            lucky: 0
        },
        power: {
            total: 'Đang tải...',
            hp: 0,
            strength: 0,
            agility: 0,
            intelligent: 0,
            lucky: 0
        },
        gears: [],
        skills: [],
        pet: {},
    },
    user: {},
    wheel: {
        spinning: false
    },
    chat: {
        messages: [],
        text: '',
        isIn: false,
        noti: true,
        percent: 0,
        previewImage: '',
        uploading: false,
        block: true
    },
    shop: [],
    profileInventory: [],
    userUtil: [],
    inventory: {},
    gears: [],
    pets: [],
    skills: [],
    items: [],
    gems: [],
    oven: {
        gem: {},
        gear: {},
        action: false
    },
    modalName: null,
    pvp: {
        rooms: [],
        match: {
            target: null,
            targetPlayer: {},
            playerAtk: {},
            isReady: false,
            room: {},
            status: 'NO_ENEMY',
            me: {
                effectAnimation: []
            },
            enemy: {}
        }
    },
}