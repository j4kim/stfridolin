import { defineStore } from "pinia";
import { Fighter, LeftFighter, RightFighter } from "@/boxing/Fighter";
import { ref, watch } from "vue";
import { pusher } from "@/broadcasting";
import { useFightStore } from "./fight";

export const useBoxingStore = defineStore("boxing", () => {
    const running = ref(true);
    const finished = ref(false);

    const fightStore = useFightStore();

    const fighters = {
        left: new LeftFighter(),
        right: new RightFighter(),
    };

    watch(
        fightStore.fight,
        (fight) => {
            if (!fight) return;
            fighters.left.imgUrl.value = fight.left_track.img_url;
            fighters.right.imgUrl.value = fight.right_track.img_url;
        },
        { immediate: true },
    );

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

    function run() {
        running.value = true;
        finished.value = false;
    }

    pusher.subscribe("votes").bind("VoteCreated", (data) => {
        const fight = useFightStore().fight;
        const trackId = data.model.track_id;
        const side = fight.left_track.id == trackId ? "left" : "right";
        fight[`${side}_track`].votes_count++;
        punch(side);
    });

    pusher.subscribe("fights").bind("EndFight", (data) => {
        win(data.winner);
    });

    pusher.subscribe("fights").bind("NewFight", (data) => {
        running.value = false;
        setTimeout(() => {
            run();
        }, 200);
    });

    return {
        running,
        finished,
        fighters,
        punch,
        win,
        run,
    };
});
