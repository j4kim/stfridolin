<script setup>
import { get } from "../api";

get("spotify.playback-state").then((data) => console.log(data));
</script>

<template>
    <div>Spotify remote</div>
</template>
