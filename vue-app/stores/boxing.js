import { defineStore } from "pinia";
import { LeftFighter, RightFighter } from "../boxing/Fighter";

export const useBoxingStore = defineStore("boxing", () => {
    const fighters = {
        left: new LeftFighter(),
        right: new RightFighter(),
    };

    function punch(puncher) {
        const receiver = Object.values(fighters).find(
            (f) => f.id !== puncher.id,
        );
        puncher.punch();
        receiver.receive();
    }

    return { fighters, punch };
});
