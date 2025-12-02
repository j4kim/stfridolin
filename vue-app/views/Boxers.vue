<script setup>
import Boxer from "../svg/Boxer.vue";
</script>

<template>
    <div>
        <svg width="100%" height="100%" viewBox="0 0 1500 1000">
            <Boxer />
            <Boxer transform="scale(-1, 1)" transform-origin="center" />
        </svg>
    </div>
</template>
