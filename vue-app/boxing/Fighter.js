import gsap from "gsap";
import { getShapeIndex } from "./utils";

export class Fighter {
    constructor(id) {
        this.id = id;
        this.animations = {
            sway: gsap.timeline({ repeat: -1, yoyo: true }),
            punch: gsap.timeline({ paused: true }),
        };
        this.animables = [];
        const max = 1.1;
        const min = 0.7;
        this.animBodyDuration = Math.random() * (max - min) + min;
        this.punchInDuration = 0.6;
        this.punchInPause = 0.2;
        this.punchOutDuration = 0.5;
    }

    addToTl(
        anim,
        fromFrame,
        toFrame,
        duration,
        ease = "power1.inOut",
        position = null,
    ) {
        const subTl = gsap.timeline();
        this.animables.forEach((el) => {
            const toSel = `#frame-${toFrame} [data-name=${el.dataset.name}]`;
            const toEl = document.querySelector(toSel);
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
            subTl.to(el, vars, 0);
        });
        this.animations[anim].add(subTl, position);
    }

    mount() {
        const root = document.getElementById(this.id);
        this.animables = root.querySelectorAll("path, use");
        this.addToTl("sway", 1, 2, this.animBodyDuration, "power1.inOut");
        this.addToTl("punch", 1, 3, 0.6, "back.in(3)");
        this.addToTl("punch", 3, 1, 0.5, "power1.inOut", "+=0.2");
    }

    punch() {
        this.animations.sway.pause();
        return this.animations.punch.restart().then(() => {
            this.animations.sway.restart();
        });
    }
}
