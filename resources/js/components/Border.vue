<template>
    <div>
        <img class="pixel modal-border-top-left" :src="asset('assets/images/icon/Border.png')">
        <img class="pixel modal-border-top-right" :src="asset('assets/images/icon/Border.png')">
        <img class="pixel modal-border-bottom-left" :src="asset('assets/images/icon/Border.png')">
        <img class="pixel modal-border-bottom-right" :src="asset('assets/images/icon/Border.png')">
    </div>
</template>

<script>
export default {
    methods: {
        asset(fileName) {
            return `${config.root}/${fileName}`;
        },
    }
}
</script>