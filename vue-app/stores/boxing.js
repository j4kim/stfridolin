import { defineStore } from "pinia";
import { LeftFighter, RightFighter } from "../boxing/Fighter";

export const useBoxingStore = defineStore("boxing", () => {
    const fighters = {
        left: new LeftFighter(),
        right: new RightFighter(),
    };

    return { fighters };
});
