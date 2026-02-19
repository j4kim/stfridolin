<script setup>
import { api } from "@/api";
import FullScreenMovement from "@/components/FullScreenMovement.vue";
import Layout from "@/components/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
import { Field, FieldLabel } from "@/components/ui/field";
import Input from "@/components/ui/input/Input.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { icon, tr } from "@/translate";
import { onMounted, ref, useTemplateRef } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const amount = ref(null);

const form = useTemplateRef("form");

onMounted(() => {
    form.value.querySelector("input").focus();
});

const movement = ref(null);
const submitting = ref(false);

async function submit() {
    submitting.value = true;
    const params = { currency: route.params.currency, amount: amount.value };
    try {
        const request = api("guests.spend").params(params);
        movement.value = await request.put();
    } finally {
        submitting.value = false;
    }
}
</script>

<template>
    <Layout v-if="!movement">
        <h2 class="my-2 px-4 font-bold">
            Dépenser des {{ tr(route.params.currency) }}
        </h2>
        <form class="px-4" @submit.prevent="submit" ref="form">
            <hr class="mb-4" />
            <Field>
                <FieldLabel for="amount">
                    <component
                        class="w-[1.3em]"
                        :is="icon(route.params.currency)"
                    />
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
            <Button
                class="mt-4 h-12 w-full"
                type="submit"
                :disabled="submitting"
            >
                <Spinner v-if="submitting"></Spinner>
                Valider
            </Button>
        </form>
    </Layout>

    <FullScreenMovement v-else :movement />
</template>
