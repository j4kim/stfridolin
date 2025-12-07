import gsap from "gsap";
import { getShapeIndex } from "./utils";

export class Animation {
    constructor(fighter) {
        this.fighter = fighter;
        this.baseTl = gsap.timeline({ paused: true });
    }

    addSubTimeline(fromFrame, toFrame, duration, ease) {
        const tl = gsap.timeline();
        this.fighter.animables.forEach((el) => {
            const toSel = `#${this.fighter.id}_${toFrame} [data-name=${el.dataset.name}]`;
            const toEl = document.querySelector(toSel);
            if (!toEl) {
                console.warn("toEl not found", toSel);
                return;
            }
            const vars = { ease, duration };
            if (el.nodeName === "path") {
                vars.morphSVG = {
                    shape: toEl,
                    shapeIndex: getShapeIndex(
                        fromFrame,
                        toFrame,
                        el.dataset.name,
                    ),
                };
            } else if (el.nodeName === "use") {
                vars.transform = toEl.attributes.transform.value;
            }
            tl.to(el, vars, 0);
        });
        this.baseTl.add(tl);
    }
}

export class Sway extends Animation {
    constructor(fighter) {
        super(fighter);
        this.baseTl.repeat(-1).yoyo(true).resume();
        this.addSubTimeline("base1", "base2", 1, "power1.inOut");
    }
}
