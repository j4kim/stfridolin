<script setup>
import Layout from "@/components/Layout.vue";
import Badge from "@/components/ui/badge/Badge.vue";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemGroup,
    ItemSeparator,
    ItemTitle,
} from "@/components/ui/item";
import { useGuestStore } from "@/stores/guest";
import { icon, tr } from "@/translate";
import dayjs from "dayjs";
import localizedFormat from "dayjs/plugin/localizedFormat";
import "dayjs/locale/fr";
dayjs.locale("fr");
dayjs.extend(localizedFormat);

const guestStore = useGuestStore();

guestStore.fetchGuestMovements({ with: ["article"] });
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Historique</h2>

        <ItemGroup>
            <ItemSeparator />
            <template v-for="m in guestStore.movements" :key="m.id">
                <Item>
                    <ItemContent>
                        <div>
                            <ItemTitle>
                                {{ m.article?.description ?? tr(m.type) }}
                            </ItemTitle>
                            <ItemDescription>
                                {{ dayjs(m.created_at).format("lll") }}
                            </ItemDescription>
                        </div>
                    </ItemContent>
                    <ItemActions>
                        <template v-for="cur in ['chf', 'tokens', 'points']">
                            <Badge
                                v-if="m[cur]"
                                :variant="m[cur] < 0 ? 'secondary' : ''"
                            >
                                <span>
                                    <span v-if="m[cur] > 0">+</span>{{ m[cur] }}
                                </span>
                                {{ tr(cur) }}
                                <component :is="icon(cur)" />
                            </Badge>
                        </template>
                    </ItemActions>
                </Item>
                <ItemSeparator />
            </template>
        </ItemGroup>
    </Layout>
</template>
