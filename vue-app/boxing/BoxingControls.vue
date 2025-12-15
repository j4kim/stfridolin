<script setup>
import { useBoxingStore } from "../stores/boxing";

const boxingStore = useBoxingStore();
</script>

<template>
    <div v-if="!boxingStore.finished" class="flex gap-2">
        <button @click="boxingStore.punch('left')" class="btn btn-xs">
            left punch
        </button>
        <button @click="boxingStore.punch('right')" class="btn btn-xs">
            right punch
        </button>
        <button @click="boxingStore.win('left')" class="btn btn-xs">
            left wins
        </button>
        <button @click="boxingStore.win('right')" class="btn btn-xs">
            right wins
        </button>
    </div>
    <div v-else class="flex gap-2">
        <button
            v-if="boxingStore.running"
            @click="boxingStore.running = false"
            class="btn btn-xs"
        >
            stop
        </button>
        <button v-else @click="boxingStore.run" class="btn btn-xs">run</button>
    </div>
</template>
