<script setup>
defineProps({
    track: Object,
});
</script>

<template>
    <div class="p-[1cqw] pt-[3cqw] text-center">
        <div class="text-[2.2cqw] font-semibold">
            {{ track.name }}
        </div>
        <div class="text-[2.2cqw] font-light">
            {{ track.artist_name }}
        </div>
        <div class="text-[10cqw] leading-none font-bold">
            {{ track.votes_count }}
        </div>
        <div class="text-[2.2cqw] font-bold">votes</div>
    </div>
</template>
