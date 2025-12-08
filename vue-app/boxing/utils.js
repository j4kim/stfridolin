import gsap from "gsap";

const morphShapeIndexes = {
    "1-3": {
        "leg_back-0": 0,
        "leg_back-1": 0,
        "arm_back-0": 0,
        "arm_back-1": 0,
        "arm_back-2": 0,
        "leg_front-0": 0,
        "leg_front-1": 6,
        "torso-0": 0,
        "arm_front-0": 7,
        "arm_front-1": 0,
        "arm_front-2": 0,
    },
    "3-2": {
        "leg_back-0": 0,
        "leg_back-1": 0,
        "arm_back-0": 0,
        "arm_back-1": 0,
        "arm_back-2": 0,
        "leg_front-0": 0,
        "leg_front-1": 0,
        "torso-0": 0,
        "arm_front-0": 1,
        "arm_front-1": 0,
        "arm_front-2": 0,
    },
};

export function getShapeIndex(fromFrame, toFrame, name) {
    return morphShapeIndexes[`${fromFrame}-${toFrame}`]?.[name];
}

export class Fighter {
    constructor(id) {
        this.id = id;
        this.swayTl = gsap.timeline({ repeat: -1, yoyo: true });
        this.punchTl = gsap.timeline({ paused: true });
        this.animables = [];
        const max = 1.1;
        const min = 0.7;
        this.animBodyDuration = Math.random() * (max - min) + min;
        this.punchInDuration = 0.6;
        this.punchInPause = 0.2;
        this.punchOutDuration = 0.5;
    }

    addToTl(
        tlName,
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
        this[tlName].add(subTl, position);
    }

    mount() {
        const root = document.getElementById(this.id);
        this.animables = root.querySelectorAll("path, use");
        this.addToTl("swayTl", 1, 2, this.animBodyDuration, "power1.inOut");
        this.addToTl("punchTl", 1, 3, 0.6, "back.in(3)");
        this.addToTl("punchTl", 3, 1, 0.5, "power1.inOut", "+=0.2");
    }

    punch() {
        this.swayTl.pause();
        return this.punchTl.restart().then(() => {
            this.swayTl.restart();
        });
    }
}
