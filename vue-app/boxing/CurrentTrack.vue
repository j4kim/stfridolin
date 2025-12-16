<script setup>
defineProps({
    track: Object,
});
</script>

<template>
    <div class="flex items-center gap-[3vw] px-[3vw]">
        <div class="w-1/5 text-right text-[1.6vw]">
            À l'écoute actuellement:
        </div>
        <div class="card card-side card-md w-4/5 bg-black/60">
            <figure>
                <img :src="track.img_url" class="aspect-square h-[7.5vw]" />
            </figure>
            <div class="card-body p-[1.8vw]">
                <p class="text-[1.4vw]">
                    <span class="font-bold">{{ track.name }}</span>
                    -
                    <span>{{ track.artist_name }}</span>
                </p>
                <progress
                    class="progress h-[0.8vw]"
                    value="10"
                    max="100"
                ></progress>
            </div>
        </div>
    </div>
</template>
