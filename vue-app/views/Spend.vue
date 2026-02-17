<script setup>
import { api } from "@/api";
import FullScreenMovement from "@/components/FullScreenMovement.vue";
import Layout from "@/components/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
import { Field, FieldLabel } from "@/components/ui/field";
import Input from "@/components/ui/input/Input.vue";
import { CircleStar, Gift } from "lucide-vue-next";
import { computed, onMounted, ref, useTemplateRef } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const icon = computed(() => {
    return {
        points: Gift,
        tokens: CircleStar,
    }[route.params.currency];
});

const heading = computed(() => {
    return {
        points: "Dépenser des points",
        tokens: "Dépenser des jetons",
    }[route.params.currency];
});

const amount = ref(null);

const form = useTemplateRef("form");

onMounted(() => {
    form.value.querySelector("input").focus();
});

const movement = ref(null);

async function submit() {
    const params = { currency: route.params.currency, amount: amount.value };
    const request = api("guests.spend").params(params);
    movement.value = await request.put();
}
</script>

<template>
    <Layout v-if="!movement">
        <h2 class="my-2 px-4 font-bold">{{ heading }}</h2>
        <form class="px-4" @submit.prevent="submit" ref="form">
            <hr class="mb-4" />
            <Field>
                <FieldLabel for="amount">
                    <component class="w-[1.3em]" :is="icon" />
                    Montant
                </FieldLabel>
                <Input
                    v-model="amount"
                    class="h-12 px-4 text-center text-xl"
                    id="amount"
                    type="number"
                    :min="1"
                    required
                />
            </Field>
            <Button class="mt-4 h-12 w-full" type="submit">Valider</Button>
        </form>
    </Layout>

    <FullScreenMovement v-else :movement />
</template>
