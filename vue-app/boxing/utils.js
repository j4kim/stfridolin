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

export function addToTl(
    animables,
    tl,
    fromFrame,
    toFrame,
    duration,
    ease = "power1.inOut",
    position = 0,
) {
    animables.forEach((el) => {
        const toSel = `#frame-${toFrame} [data-name=${el.dataset.name}]`;
        const toEl = document.querySelector(toSel);
        const vars = { ease, duration };
        if (el.nodeName === "path") {
            vars.morphSVG = {
                shape: toEl,
                shapeIndex: getShapeIndex(fromFrame, toFrame, el.dataset.name),
            };
        } else if (el.nodeName === "use") {
            vars.transform = toEl.attributes.transform.value;
        }
        tl.to(el, vars, position);
    });
}

export class Fighter {
    constructor(id) {
        this.id = id;
        this.baseTl = gsap.timeline({ repeat: -1, yoyo: true });
        this.punchTl = gsap.timeline({ paused: true });
        this.animables = [];
        const max = 1.1;
        const min = 0.7;
        this.animBodyDuration = Math.random() * (max - min) + min;
        this.punchInDuration = 0.6;
        this.punchInPause = 0.2;
        this.punchOutDuration = 0.5;
    }

    mount(animables) {
        this.animables = animables;
        addToTl(
            this.animables,
            this.baseTl,
            1,
            2,
            this.animBodyDuration,
            "power1.inOut",
            0,
        );
        addToTl(
            this.animables,
            this.punchTl,
            1,
            3,
            this.punchInDuration,
            "back.in(3)",
            0,
        );
        addToTl(
            this.animables,
            this.punchTl,
            3,
            1,
            this.punchOutDuration,
            "power1.inOut",
            this.punchInDuration + this.punchInPause,
        );
    }

    punch() {
        this.baseTl.pause();
        return this.punchTl.restart().then(() => {
            this.baseTl.restart();
        });
    }
}
