import { defineStore } from "pinia";
import { LeftFighter, RightFighter } from "../boxing/Fighter";

export const useBoxingStore = defineStore("boxing", () => {
    const fighters = {
        left: new LeftFighter(),
        right: new RightFighter(),
    };

    function punch(puncherId) {
        const puncher = fighters[puncherId];
        const receiver = fighters[puncherId === "left" ? "right" : "left"];
        puncher.punch();
        receiver.receive();
    }

    return { fighters, punch };
});
