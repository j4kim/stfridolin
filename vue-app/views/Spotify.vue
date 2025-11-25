<script setup>
import { get } from "../api";

get("spotify.devices").then((data) => console.log(data));
</script>

<template>
    <div>Spotify remote</div>
</template>
