import { defineStore } from "pinia";
import { reactive } from "vue";
import { Fighter } from "../boxing/Fighter";

export const useBoxingStore = defineStore("boxing", () => {
    const fighters = reactive({
        left: new Fighter("left"),
        // right: new Boxer("right"),
    });

    return { fighters };
});
