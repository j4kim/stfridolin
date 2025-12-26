import { defineStore } from "pinia";
import { Fighter, LeftFighter, RightFighter } from "@/boxing/Fighter";
import { ref } from "vue";
import { pusher } from "@/broadcasting";
import { useFightStore } from "./fight";

export const useBoxingStore = defineStore("boxing", () => {
    const running = ref(true);
    const finished = ref(false);

    const fighters = {
        left: new LeftFighter(),
        right: new RightFighter(),
    };

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

    return {
        running,
        finished,
        fighters,
        punch,
        win,
        run,
    };
});
