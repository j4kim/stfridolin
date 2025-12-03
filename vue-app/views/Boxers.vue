<script setup>
import { ref } from "vue";
import Boxer from "../svg/Boxer.vue";
import boxer1 from "../svg/boxer-1.svg?raw";
import boxer2 from "../svg/boxer-2.svg?raw";

const parser = new DOMParser();

function getBoxerSvgContent(svg, id) {
    const dom = parser.parseFromString(svg, "application/xml");
    const rootG = dom.querySelector("g");
    Array.from(rootG.children).forEach((g) => {
        g.dataset.name = g.id;
        g.id = `${id}-${g.id}`;
        Array.from(g.children).forEach((el, index) => {
            el.id = `${g.id}-${index}`;
            el.dataset.name = `${g.dataset.name}-${index}`;
        });
    });
    return rootG.innerHTML;
}

const framesXml = [
    { id: "frame-1", svg: boxer1 },
    { id: "frame-2", svg: boxer2 },
].map(({ id, svg }) => {
    return { id, content: getBoxerSvgContent(svg, id) };
});

const imgUrls = ref({
    left: "https://i.scdn.co/image/ab67616d0000b27389b9e48b79603248d4fea627",
    right: "https://i.scdn.co/image/ab67616d0000b2734e09836e2d1938337c416bf2",
});
</script>

<template>
    <div>
        <svg class="max-h-[80vh] w-full" viewBox="0 0 1500 1000">
            <defs>
                <g
                    v-for="svg in framesXml.splice(1)"
                    :id="svg.id"
                    v-html="svg.content"
                ></g>
                <image
                    id="_Image1"
                    width="4px"
                    height="4px"
                    :href="imgUrls.left"
                />
                <image
                    id="_Image2"
                    width="4px"
                    height="4px"
                    :href="imgUrls.right"
                />
            </defs>
            <Boxer
                id="boxer-left"
                :initialSvgContent="getBoxerSvgContent(boxer1, 'boxer-left')"
            />
            <Boxer
                id="boxer-right"
                reversed
                :initialSvgContent="
                    getBoxerSvgContent(boxer1, 'boxer-right').replace(
                        '_Image1',
                        '_Image2',
                    )
                "
            />
        </svg>
    </div>
</template>
