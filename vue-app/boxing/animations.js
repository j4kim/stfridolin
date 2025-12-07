import gsap from "gsap";
import { getShapeIndex } from "./utils";

export class Sway {
    constructor(fighter) {
        this.fighter = fighter;
        this.tl = gsap.timeline({ repeat: -1, yoyo: true });
        this.fromFrameId = "base1";
        this.toFrameId = "base2";
        this.duration = 1;
        this.ease = "power1.inOut";
        this.addTweens();
    }

    addTweens() {
        this.fighter.animables.forEach((el) => {
            const toSel = `#${this.fighter.id}_${this.toFrameId} [data-name=${el.dataset.name}]`;
            const toEl = document.querySelector(toSel);
            const vars = { ease: this.ease, duration: this.duration };
            if (el.nodeName === "path") {
                vars.morphSVG = {
                    shape: toEl,
                    shapeIndex: getShapeIndex(
                        this.fromFrameId,
                        this.toFrameId,
                        el.dataset.name,
                    ),
                };
            } else if (el.nodeName === "use") {
                vars.transform = toEl.attributes.transform.value;
            }
            this.tl.to(el, vars, 0);
        });
    }
}
