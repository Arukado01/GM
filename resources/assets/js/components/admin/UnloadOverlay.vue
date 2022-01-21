<template>
</template>
<script>
    export default {
        mounted(){
            this.$eventHideOverlay.$emit('hide');
        }
    }
</script>