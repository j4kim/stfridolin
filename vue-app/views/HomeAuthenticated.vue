<script setup>
import AnimatedCount from "@/components/AnimatedCount.vue";
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
    HatGlasses,
    Trophy,
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
                    <AnimatedCount :value="guestStore.guest.tokens" />
                    jetons.
                </span>
                Les jetons sont la monnaie de participation aux jeux. Si tu
                gagnes à un jeu, tu reçoit des
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
                            :to="{
                                name: 'race-index',
                                params: { gameName: 'marble-race' },
                            }"
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
                <Card>
                    <CardHeader>
                        <CardTitle>Concours hippique</CardTitle>
                        <CardDescription>
                            À 21h30, une course épique et hippique diffusée sur
                            écran géant sur scène. Mise sur ton canasson favori
                            pour remporter des points.
                        </CardDescription>
                    </CardHeader>
                    <CardFooter>
                        <RouterLink
                            class="w-full"
                            :to="{
                                name: 'race-index',
                                params: { gameName: 'horse-show' },
                            }"
                        >
                            <Button class="w-full">
                                <Trophy />
                                Parier
                            </Button>
                        </RouterLink>
                    </CardFooter>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Où est Joe ?</CardTitle>
                        <CardDescription>
                            À 22h30, trouve l'intrus dans chaque vidéo pour
                            décrocher des points.
                        </CardDescription>
                    </CardHeader>
                    <CardFooter>
                        <RouterLink
                            class="w-full"
                            :to="{
                                name: 'race-index',
                                params: { gameName: 'where-is-joe' },
                            }"
                        >
                            <Button class="w-full">
                                <HatGlasses />
                                Détectiver
                            </Button>
                        </RouterLink>
                    </CardFooter>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Domingold</CardTitle>
                        <CardDescription>
                            Tu peux acheter des tickets de tombola au kiosque à
                            plaisir. Tirage au sort de 10 gagnant-e-s à minuit.
                        </CardDescription>
                    </CardHeader>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Dégustation de Goron</CardTitle>
                        <CardDescription>
                            Au PMU, on parie sur des courses, on discute avec
                            les copains et, très occasionnellement, on y boit
                            des coups. Et pas n’importe quels coups, bien
                            souvent du rouge qui tâche.
                            <br />
                            De 19h30 à 21h30 près de la scène.
                        </CardDescription>
                    </CardHeader>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Coin Forain</CardTitle>
                        <CardDescription>
                            Gagne des points aux jeux d'adresses proposés par le
                            coin forain. En bas, à côté du kisque.
                        </CardDescription>
                    </CardHeader>
                </Card>
            </div>

            <div class="h-12"></div>
        </div>
    </Layout>
</template>
