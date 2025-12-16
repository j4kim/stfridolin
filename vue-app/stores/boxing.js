import { defineStore } from "pinia";
import { LeftFighter, RightFighter } from "../boxing/Fighter";
import { ref } from "vue";
import { get } from "../api";

export const useBoxingStore = defineStore("boxing", () => {
    const running = ref(true);
    const finished = ref(false);
    const fight = ref(null);
    const track = ref(null);

    const fighters = {
        left: new LeftFighter(),
        right: new RightFighter(),
    };

    function getSorted(fighterId) {
        const f1 = fighters[fighterId];
        const f2 = fighters[fighterId === "left" ? "right" : "left"];
        return [f1, f2];
    }

    function punch(puncherId) {
        const [puncher, receiver] = getSorted(puncherId);
        puncher.punch();
        receiver.receive();
    }

    function win(puncherId) {
        const [winner, loser] = getSorted(puncherId);
        winner.win();
        loser.lose();
        finished.value = true;
    }

    function run() {
        running.value = true;
        finished.value = false;
    }

    async function fetchCurrentFight() {
        console.log("fetchCurrentFight");
        fight.value = await get("fights.current");
        fighters.left.imgUrl.value = fight.value.left_track.img_url;
        fighters.right.imgUrl.value = fight.value.right_track.img_url;
    }

    async function fetchCurrentTrack() {
        track.value = await get("tracks.current");
    }

    return {
        running,
        finished,
        fight,
        track,
        fighters,
        punch,
        win,
        run,
        fetchCurrentFight,
        fetchCurrentTrack,
    };
});
