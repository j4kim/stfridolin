<script setup>
import { useLink } from "vue-router";
import SidebarMenuButton from "./ui/sidebar/SidebarMenuButton.vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    to: Object | String,
    external: Boolean,
});

const { isExactActive, navigate, href } = useLink(props);

function onClick() {
    navigate();
}
</script>

<template>
    <SidebarMenuButton as-child :is-active="isExactActive">
        <a v-if="external" v-bind="$attrs" :href="to">
            <slot />
        </a>
        <a v-else v-bind="$attrs" :href="href" @click.prevent="onClick">
            <slot />
        </a>
    </SidebarMenuButton>
</template>
