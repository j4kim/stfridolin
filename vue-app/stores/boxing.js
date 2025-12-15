import { defineStore } from "pinia";
import { LeftFighter, RightFighter } from "../boxing/Fighter";

export const useBoxingStore = defineStore("boxing", () => {
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
    }

    return { fighters, punch, win };
});
