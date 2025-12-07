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
            const elName = el.dataset.name;
            const toSel = `#${this.fighter.id}_${toFrame} [data-name=${elName}]`;
            const toEl = document.querySelector(toSel);
            if (!toEl) {
                throw new Error(`toEl (${toSel}) not found`);
            }
            const vars = { ease, duration };
            if (el.nodeName === "path") {
                const shapeIndex = getShapeIndex(fromFrame, toFrame, elName);
                vars.morphSVG = { shape: toEl, shapeIndex };
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
