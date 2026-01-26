<script setup>
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import {
    InputOTP,
    InputOTPGroup,
    InputOTPSlot,
} from "@/components/ui/input-otp";
import { ref } from "vue";
import { REGEXP_ONLY_DIGITS_AND_CHARS } from "vue-input-otp";
import { useRouter } from "vue-router";

const key = ref("");

const router = useRouter();

function moveToGuestPage() {
    router.push({ name: "guest-page", params: { key: key.value } });
}
</script>

<template>
    <Layout simple>
        <Card class="mx-auto mt-4 w-full max-w-sm">
            <CardHeader>
                <CardTitle>Authentification</CardTitle>
                <CardDescription>
                    Entre ton code de 4 caractères
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit="moveToGuestPage">
                    <InputOTP
                        v-model="key"
                        :maxlength="4"
                        :pattern="REGEXP_ONLY_DIGITS_AND_CHARS"
                    >
                        <InputOTPGroup class="mx-auto">
                            <InputOTPSlot :index="0" />
                            <InputOTPSlot :index="1" />
                            <InputOTPSlot :index="2" />
                            <InputOTPSlot :index="3" />
                        </InputOTPGroup>
                    </InputOTP>
                </form>
            </CardContent>
            <CardFooter class="flex flex-col gap-2">
                <Button class="w-full" @click="moveToGuestPage">
                    Valider
                </Button>
            </CardFooter>
        </Card>
    </Layout>
</template>
