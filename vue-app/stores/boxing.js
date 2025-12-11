import { defineStore } from "pinia";
import { Fighter } from "../boxing/Fighter";

export const useBoxingStore = defineStore("boxing", () => {
    const fighters = {
        left: new Fighter("left"),
        right: new Fighter("right"),
    };

    return { fighters };
});
