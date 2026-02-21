import { defineStore } from "pinia";
import { Fighter, LeftFighter, RightFighter } from "@/boxing/Fighter";
import { ref } from "vue";
import { pusher } from "@/broadcasting";
import { useFightStore } from "./fight";
import { importFrames } from "@/boxing/utils";
import { api } from "@/api";

export const useBoxingStore = defineStore("boxing", () => {
    const running = ref(true);
    const finished = ref(false);

    const tossAnimation = ref(null);

    const fightStore = useFightStore();

    const fighters = {
        left: null,
        right: null,
    };

    const initialized = ref(false);

    async function initializeFighters() {
        await importFrames();
        fighters.left = new LeftFighter();
        fighters.right = new RightFighter();
        initialized.value = true;
    }

    /**
     * @param {'left' | 'right'} side
     * @returns {Fighter[]}
     */
    function getSorted(side) {
        const f1 = fighters[side];
        const f2 = fighters[side === "left" ? "right" : "left"];
        return [f1, f2];
    }

    function punch(side) {
        const [puncher, receiver] = getSorted(side);
        puncher.punch();
        receiver.receive();
    }

    function win(side) {
        const [winner, loser] = getSorted(side);
        winner.win();
        loser.lose();
        finished.value = true;
    }

    function startToss(winnerSide) {
        tossAnimation.value = winnerSide;
        setTimeout(() => {
            win(winnerSide);
            tossAnimation.value = null;
        }, 4_000);
    }

    function run() {
        const fight = fightStore.fight;
        if (!fight) {
            throw new Error("There is no current fight");
        }
        fighters.left.headImgUrl.value = fight.left_track.img_url;
        fighters.right.headImgUrl.value = fight.right_track.img_url;
        fighters.left.sponsorImgUrl.value = fight.sponsor_logo_1;
        fighters.right.sponsorImgUrl.value = fight.sponsor_logo_2;
        running.value = true;
        finished.value = false;
    }

    pusher.subscribe("votes").bind("VoteCreated", (data) => {
        const fight = fightStore.fight;
        if (!fightStore.fight) {
            throw new Error("There is no current fight");
        }
        const trackId = data.model.track_id;
        const side = fight.left_track.id == trackId ? "left" : "right";
        fight[`${side}_track`].votes_count++;
        punch(side);
    });

    pusher.subscribe("fights").bind("EndFight", (data) => {
        if (data.draw) {
            startToss(data.winner);
        } else {
            win(data.winner);
        }
    });

    pusher.subscribe("fights").bind("NewFight", (data) => {
        running.value = false;
        setTimeout(() => run(), 200);
    });

    return {
        running,
        finished,
        tossAnimation,
        fighters,
        initialized,
        initializeFighters,
        punch,
        win,
        run,
    };
});
