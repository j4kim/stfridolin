import { ref } from "vue";
import { gsap } from "gsap";
import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";
import { Lose, Punch1, Punch2, Receive, Sway, Win } from "./animations";
import { frameNames, frames } from "./utils";

gsap.registerPlugin(MorphSVGPlugin);

const parser = new DOMParser();

export class Fighter {
    constructor(id) {
        this.id = id;
        this.animables = [];
        this.root = null;
        this.imgId = `${id}-image`;
        this.svgFrames = ref([]);
        this.imgUrl = ref("");
        this.initialSvgContent = "";
        this.animations = [];
        this.punching = ref(false);
        this.nextPunchAnimation = 0;
        this.receiveTimout = null;
        this.ko = ref(false);
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

    computeSvgFrames() {
        this.svgFrames.value = frameNames.map((name) => {
            const svg = frames[this.id][name];
            return {
                id: name,
                content: this.getSvgContent(svg, name),
            };
        });
        const firstSvg = frames[this.id]["base1"];
        this.initialSvgContent = this.getSvgContent(firstSvg, "");
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
            receive: new Receive(this),
            win: new Win(this),
            lose: new Lose(this),
        };
    }

    pauseAnimations() {
        this.animations.receive.tl.pause();
        this.animations.sway.tl.pause();
        this.animations.punch[0].tl.pause();
        this.animations.punch[1].tl.pause();
        clearTimeout(this.receiveTimout);
        this.ko.value = false;
    }

    punch() {
        this.punching.value = true;
        this.pauseAnimations();
        const anim = this.animations.punch[this.nextPunchAnimation];
        return anim.tl.restart().then(() => {
            this.animations.sway.tl.restart();
            this.nextPunchAnimation = (this.nextPunchAnimation + 1) % 2;
            this.punching.value = false;
        });
    }

    receive() {
        this.receiveTimout = setTimeout(() => {
            this.pauseAnimations();
            return this.animations.receive.tl.restart().then(() => {
                this.animations.sway.tl.restart();
            });
        }, 600);
    }

    win() {
        this.pauseAnimations();
        return this.animations.win.tl.restart();
    }

    lose() {
        this.pauseAnimations();
        this.ko.value = true;
        return this.animations.lose.tl.restart();
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
