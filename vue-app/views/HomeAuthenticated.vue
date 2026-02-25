<script setup>
import Layout from "@/components/Layout.vue";
import SvgTitle from "@/components/SvgTitle.vue";
import Button from "@/components/ui/button/Button.vue";
import {
    Card,
    CardHeader,
    CardDescription,
    CardFooter,
    CardTitle,
} from "@/components/ui/card";
import { useGuestStore } from "@/stores/guest";
import {
    CirclePile,
    CircleStar,
    Gift,
    HandFist,
    Weight,
} from "lucide-vue-next";

const guestStore = useGuestStore();

guestStore.fetchGuestMovementsIfMissing();
</script>

<template>
    <Layout>
        <div class="mx-auto max-w-3xl">
            <SvgTitle class="mx-auto max-w-md p-12" />
            <p class="mb-4 px-8 text-xl font-extralight">
                Hello ! Bienvenue au PMU de soutien de la Saint-Fridolin. Une
                soirée de taxation de votre héritage au profit d'Estelle Zamme,
                agrémentée de plein de jeux de pari rigolos.
            </p>
            <p class="mb-2 px-8">
                Cette application créée pour l'occasion permet de jouer aux
                différents jeux et gagner des lots.
            </p>
            <p class="mb-2 px-8">
                Tu as actuellement
                <span class="inline-flex items-baseline gap-1 font-extrabold">
                    <CircleStar size="1em" class="self-center" />
                    {{ guestStore.guest.tokens }} jetons.
                </span>
                Les jetons sont une monnaie d'échange pour participer aux jeux.
                Si tu gagnes à un jeu, tu reçoit des
                <span class="inline-flex items-baseline gap-1 font-extrabold">
                    <Gift size="1em" class="self-center" />
                    points,
                </span>
                que tu pourras échanger contre des super lots au kiosque à
                plaisir.
            </p>
            <p class="mb-2 px-8">
                <RouterLink :to="{ name: 'buy-tokens' }">
                    <Button class="w-full" size="lg" variant="outline">
                        <CircleStar />
                        Acheter des jetons
                    </Button>
                </RouterLink>
            </p>

            <h2 class="my-4 px-8 text-2xl font-bold">Jouer</h2>

            <div class="flex flex-col gap-4 px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Course de billes</CardTitle>
                        <CardDescription>
                            Toutes les heures de 19h à 23h, 10 billes s'élancent
                            sur le parcours. Pariez sur l'une des trois
                            premières pour gagner des points.
                        </CardDescription>
                    </CardHeader>
                    <CardFooter>
                        <RouterLink
                            class="w-full"
                            :to="{ name: 'marble-races' }"
                        >
                            <Button class="w-full">
                                <CirclePile />
                                Parier sur votre championne
                            </Button>
                        </RouterLink>
                    </CardFooter>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Jukeboxe</CardTitle>
                        <CardDescription>
                            Vous choisissez la musique qui passe pendant toute
                            la soirée. Vous pouvez dépenser des jetons pour
                            ajouter des morceaux en file d'attente, et pour
                            voter pour un des deux morceux sur le ring.
                        </CardDescription>
                    </CardHeader>
                    <CardFooter>
                        <RouterLink class="w-full" :to="{ name: 'vote' }">
                            <Button class="w-full">
                                <HandFist />
                                Voter pour le prochain morceau
                            </Button>
                        </RouterLink>
                    </CardFooter>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Poids de Joe</CardTitle>
                        <CardDescription>
                            Vous avez vu notre beau dauphin à facette ?
                            Pronostiquez son poids. La personne la plus proche
                            décroche le gros lot.
                        </CardDescription>
                    </CardHeader>
                    <CardFooter>
                        <RouterLink
                            class="w-full"
                            :to="{ name: 'joes-weight' }"
                        >
                            <Button class="w-full">
                                <Weight />
                                Lezgo je pronostique
                            </Button>
                        </RouterLink>
                    </CardFooter>
                </Card>
            </div>

            <h2 class="my-4 px-8 text-2xl font-bold">Programme</h2>

            <div class="px-8">
                <table class="w-full">
                    <tbody>
                        <tr>
                            <th class="text-left tabular-nums">18:30</th>
                            <td>Cérémonie d'ouverture</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">19:00</th>
                            <td>Course de bille - qualifications</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">19:30</th>
                            <td>Course EZ</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">20:00</th>
                            <td>Course de bille - qualifications</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">20:30</th>
                            <td>Quiz de la Saint-Fridolin</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">21:00</th>
                            <td>Course de bille - demi-finale</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">21:30</th>
                            <td>Course EZ</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">22:00</th>
                            <td>Course de bille - demi-finale</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">20:30</th>
                            <td>Quiz Estelle Zamme</td>
                        </tr>
                        <tr>
                            <th class="text-left tabular-nums">23:00</th>
                            <td>Course de bille - finale</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="h-12"></div>
        </div>
    </Layout>
</template>
