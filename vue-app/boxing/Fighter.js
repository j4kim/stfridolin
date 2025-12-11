import { ref } from "vue";
import { gsap } from "gsap";
import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";
import { Punch1, Punch2, Sway } from "./animations";

gsap.registerPlugin(MorphSVGPlugin);

const parser = new DOMParser();

export class Fighter {
    constructor(id) {
        this.id = id;
        this.ready = false;
        this.animables = [];
        this.root = null;
        this.imgId = `${id}-image`;
        this.svgFrames = ref([]);
        this.imgUrl = ref("");
        this.initialSvgContent = "";
        this.animations = [];
        this.nextPunchAnimation = 0;
        this.computeSvgFrames();
    }

    getSvgContent(svg, frameId) {
        const dom = parser.parseFromString(svg, "image/svg+xml");
        const rootG = dom.querySelector("g");
        Array.from(rootG.children).forEach((g) => {
            g.dataset.name = g.id;
            g.id = `${this.id}_${frameId}_${g.id}`;
            Array.from(g.children).forEach((el, index) => {
                el.id = `${g.id}_${index}`;
                el.dataset.name = `${g.dataset.name}_${index}`;
            });
        });
        rootG.querySelector("use").setAttribute("xlink:href", `#${this.imgId}`);
        return rootG.innerHTML;
    }

    async computeSvgFrames() {
        const promises = [];
        const frames = ["base1", "base2", "punch1", "punch2"].map((id) => ({
            id,
        }));
        frames.forEach((frame) => {
            const promise = import(`./svg/${this.id}/${frame.id}.svg?raw`).then(
                (m) => {
                    frame.svg = m.default;
                    frame.content = this.getSvgContent(frame.svg, frame.id);
                },
            );
            promises.push(promise);
        });
        await Promise.all(promises);
        this.svgFrames.value = frames;
        this.initialSvgContent = this.getSvgContent(frames[0].svg, "");
        this.ready = true;
    }

    getShapeIndex(fromFrame, toFrame, name) {
        const couple = `${fromFrame}-${toFrame}`;
        const index = this.morphShapeIndexes[couple]?.[name];
        return index ?? 0;
    }

    initTimelines() {
        this.root = document.getElementById(this.id);
        this.animables = this.root.querySelectorAll("path, use");
        this.animations = {
            sway: new Sway(this),
            punch: [new Punch1(this), new Punch2(this)],
        };
    }

    punch() {
        this.animations.sway.tl.pause();
        const anim = this.animations.punch[this.nextPunchAnimation];
        return anim.tl.restart().then(() => {
            this.animations.sway.tl.restart();
            this.nextPunchAnimation = (this.nextPunchAnimation + 1) % 2;
        });
    }
}

export class LeftFighter extends Fighter {
    morphShapeIndexes = {
        "base2-punch1": {
            arm_front_0: 7,
        },
        "punch1-base2": {
            arm_front_0: 1,
        },
    };

    constructor() {
        super("left");
    }
}

export class RightFighter extends Fighter {
    morphShapeIndexes = {};

    constructor() {
        super("right");
    }
}
