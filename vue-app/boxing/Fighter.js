import { ref } from "vue";
import { gsap } from "gsap";
import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";
import { getShapeIndex } from "./utils";

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
        const frames = ["base1", "base2", "punch"].map((id) => ({ id }));
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

    addTimeline(fromFrameId, toFrameId, duration, ease, position = 0) {
        const tl = gsap.timeline({ repeat: -1, yoyo: true });
        this.animables.forEach((el) => {
            const toSel = `#${this.id}_${toFrameId} [data-name=${el.dataset.name}]`;
            const toEl = document.querySelector(toSel);
            const vars = { ease, duration };
            if (el.nodeName === "path") {
                vars.morphSVG = {
                    shape: toEl,
                    shapeIndex: getShapeIndex(
                        fromFrameId,
                        toFrameId,
                        el.dataset.name,
                    ),
                };
            } else if (el.nodeName === "use") {
                vars.transform = toEl.attributes.transform.value;
            }
            tl.to(el, vars, position);
        });
        return tl;
    }

    initTimelines() {
        this.root = document.getElementById(this.id);
        this.animables = this.root.querySelectorAll("path, use");
        const sway = this.addTimeline("base1", "base2", 1, "power1.inOut");
    }
}
