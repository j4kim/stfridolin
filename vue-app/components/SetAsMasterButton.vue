<script setup>
import { Button } from "@/components/ui/button";
import { useClientStore } from "@/stores/client";

const client = useClientStore();
</script>

<template>
    <Button v-if="client.isMaster" size="sm" disabled>
        This client is master
    </Button>
    <Button v-else @click="client.setAsMaster" size="sm">
        Set this client as master
    </Button>
</template>
