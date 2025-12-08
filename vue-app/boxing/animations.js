import gsap from "gsap";
import { getShapeIndex, random } from "./utils";

export class Animation {
    constructor(fighter) {
        this.fighter = fighter;
        this.tl = gsap.timeline({ paused: true });
    }

    addSubTimeline(fromFrame, toFrame, duration, ease, pos = null) {
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
        this.tl.add(tl, pos);
    }
}

export class Sway extends Animation {
    constructor(fighter) {
        super(fighter);
        this.duration = random(0.7, 1.1);
        this.tl.repeat(-1).yoyo(true);
        this.addSubTimeline("base1", "base2", this.duration, "power1.inOut");
    }
}

export class Punch extends Animation {
    constructor(fighter) {
        super(fighter);
        this.addSubTimeline("base2", "punch", 0.6, "back.in(3)");
        this.addSubTimeline("punch", "base1", 0.5, "power1.inOut", "+=0.2");
    }
}
