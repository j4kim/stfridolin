import { defineStore } from "pinia";
import { LeftFighter, RightFighter } from "../boxing/Fighter";
import { ref } from "vue";
import { get } from "../api";
import { pusher } from "../broadcasting";

export const useBoxingStore = defineStore("boxing", () => {
    const running = ref(true);
    const finished = ref(false);
    const fight = ref(null);

    const fighters = {
        left: new LeftFighter(),
        right: new RightFighter(),
    };

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

    async function fetchCurrentFight() {
        fight.value = await get("fights.current");
        fighters.left.imgUrl.value = fight.value.left_track.img_url;
        fighters.right.imgUrl.value = fight.value.right_track.img_url;
    }

    pusher.subscribe("votes").bind("VoteCreated", (data) => {
        const trackId = data.model.track_id;
        const side = fight.value.left_track.id == trackId ? "left" : "right";
        fight.value[`${side}_track`].votes_count++;
        punch(side);
        if (fight.value[`${side}_track`].votes_count % 5 === 0) {
            setTimeout(() => win(side), 1000);
        }
    });

    return {
        running,
        finished,
        fight,
        fighters,
        punch,
        win,
        run,
        fetchCurrentFight,
    };
});
