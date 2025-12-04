import { ref } from "vue";

const parser = new DOMParser();

export class Fighter {
    constructor(id) {
        this.id = id;
        this.imgId = `${id}-image`;
        this.svgFrames = ref([]);
        this.imgUrl = ref("");
        this.initialSvgContent = ref("");
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
        this.initialSvgContent.value = this.getSvgContent(frames[1].svg, "");
    }
}
