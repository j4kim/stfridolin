<script setup>
defineProps({
    track: Object,
});
</script>

<template>
    <div class="p-[1vw] pt-[3vw] text-center">
        <div class="text-[2.2vw] font-semibold">
            {{ track.name }}
        </div>
        <div class="text-[2.2vw] font-light">
            {{ track.artist_name }}
        </div>
        <div class="text-[10vw] leading-none font-bold">
            {{ track.votes_count }}
        </div>
        <div class="text-[2.2vw] font-bold">votes</div>
    </div>
</template>
