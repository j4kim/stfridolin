<script setup>
import SidebarMenuButton from "./ui/sidebar/SidebarMenuButton.vue";
import { useSidebar } from "./ui/sidebar";

defineOptions({
    inheritAttrs: false,
});

const sidebar = useSidebar();

const props = defineProps({
    to: Object | String,
    external: Boolean,
});
</script>

<template>
    <SidebarMenuButton v-if="external" as-child>
        <a v-if="external" v-bind="$attrs" :href="to">
            <slot />
        </a>
    </SidebarMenuButton>
    <RouterLink
        v-else
        :to="to"
        custom
        v-slot="{ isExactActive, href, navigate }"
    >
        <SidebarMenuButton as-child :is-active="isExactActive">
            <a
                v-bind="$attrs"
                :href="href"
                @click="
                    ($e) => {
                        navigate($e);
                        sidebar.setOpenMobile(false);
                    }
                "
            >
                <slot />
            </a>
        </SidebarMenuButton>
    </RouterLink>
</template>
