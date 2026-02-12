<script setup>
import { getErrorMsg } from "@/api";
import Layout from "@/components/Layout.vue";
import { Alert, AlertDescription } from "@/components/ui/alert";
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
import { useGuestStore } from "@/stores/guest";
import { TriangleAlert } from "lucide-vue-next";
import { ref } from "vue";
import { REGEXP_ONLY_DIGITS_AND_CHARS } from "vue-input-otp";
import { useRouter } from "vue-router";

const key = ref("");

const router = useRouter();

const guestStore = useGuestStore();

function moveToGuestPage() {
    guestStore.guest = {};
    router.push({ name: "guest-page", params: { key: key.value } });
}
</script>

<template>
    <Layout simple>
        <form @submit.prevent="moveToGuestPage" ref="form">
            <Card class="mx-auto mt-4 w-full max-w-sm">
                <CardHeader>
                    <CardTitle>Authentification</CardTitle>
                    <CardDescription>
                        Entre ton code de 4 caractères
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <InputOTP
                        v-model="key"
                        :maxlength="4"
                        :pattern="REGEXP_ONLY_DIGITS_AND_CHARS"
                        inputmode="text"
                        required
                        autocapitalize="none"
                    >
                        <InputOTPGroup class="mx-auto">
                            <InputOTPSlot :index="0" />
                            <InputOTPSlot :index="1" />
                            <InputOTPSlot :index="2" />
                            <InputOTPSlot :index="3" />
                        </InputOTPGroup>
                    </InputOTP>
                    <Alert
                        class="mt-4"
                        variant="destructive"
                        v-if="guestStore.error"
                    >
                        <TriangleAlert />
                        <AlertDescription
                            v-if="guestStore.error.status === 404"
                        >
                            Code non reconnu
                        </AlertDescription>
                        <AlertDescription v-else>
                            {{ getErrorMsg(guestStore.error) }}
                        </AlertDescription>
                    </Alert>
                </CardContent>
                <CardFooter class="flex flex-col gap-2">
                    <Button class="w-full" type="submit"> Valider </Button>
                </CardFooter>
            </Card>
        </form>
    </Layout>
</template>
