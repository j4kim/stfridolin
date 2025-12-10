import { defineStore } from "pinia";
import { shallowReactive } from "vue";
import { Fighter } from "../boxing/Fighter";

export const useBoxingStore = defineStore("boxing", () => {
    const fighters = shallowReactive({
        left: new Fighter("left"),
        right: new Fighter("right"),
    });

    return { fighters };
});
