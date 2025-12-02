<script setup>
import { onMounted, ref, useTemplateRef } from "vue";
import { gsap } from "gsap";

import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";

gsap.registerPlugin(MorphSVGPlugin);

const props = defineProps({
    imageUrl: String,
});

const frames = [
    {
        leg_back: {
            paths: [
                "M481.978,581.345l60.118,87.023l14.456,135.059l49.254,33.621l-78.776,-4.63l-20.065,-141.157l-87.564,-73.841l62.577,-36.075Z",
                "M387.893,549.369l-0,54.63l59.174,60.409l79.963,-51.889l-65.041,-71.881l-74.096,8.731Z",
            ],
        },
        arm_back: {
            paths: [
                "M438.561,384.86l98.681,126.946l133.14,-85.781l-17.924,-36.343l-100.144,67.926l-47.889,-91.44l-42.035,-25.414l-23.829,44.106Z",
                "M616.165,413.459l18.52,25.068l53.383,-10.456l36.53,-39.825l-48.958,-57.201l-55.872,26.765l-3.603,55.649Z",
                "M596.398,425.301l32.229,30.18l28.14,-20.674l-40.059,-33.859l-20.31,24.353Z",
            ],
            cls: "arm",
        },
        leg_front: {
            paths: [
                "M315.339,592.45l72.554,115.716l-59.175,155.146l82.279,3.391l-37.229,-24.383l73.299,-134.154l-48.211,-116.523l-83.517,0.807Z",
                "M328.718,527.904l-13.379,30.908l-9.191,43.711l49.109,88.05l91.81,-50.942l-47.247,-98.993l-71.102,-12.734Z",
            ],
        },
        torso: {
            paths: [
                "M328.718,527.904l73.598,30.908l55.145,-8.681l54.939,-171.037l-28.228,-37.381l-51.04,-14.907l-45.239,21.38l-59.175,179.718Z",
            ],
        },
        head: {
            image: {
                href: props.imageUrl,
                x: 362,
                y: 116,
                width: 272,
                height: 272,
                rotate: 17,
            },
        },
        arm_front: {
            paths: [
                "M381.203,397.299l38.198,104.331l132.913,-21.379l-6.108,-37.442l-88.745,9.464l-10.394,-73.666l-42.035,-25.413l-23.829,44.105Z",
                "M544.978,444.778l4.479,30.843l51.99,16.006l51.011,-17.84l-16.124,-73.545l-61.888,-2.808l-29.468,47.344Z",
                "M512.265,441.844l6.863,47.347l43.091,-4.893l-8.551,-58.273l-41.403,15.819Z",
            ],
            cls: "arm",
        },
    },
    {
        leg_back: {
            paths: [
                "M429.482,561.61l96.1,106.052l30.97,135.765l49.254,33.621l-78.776,-4.63l-36.579,-141.864l-125.814,-87.817l64.845,-41.127Z",
                "M354.433,558.741l7.014,54.178l66.441,52.311l72.639,-61.725l-73.731,-62.936l-72.363,18.172Z",
            ],
        },
        arm_back: {
            paths: [
                "M406.537,384.86l98.68,126.946l133.14,-85.781l-17.924,-36.343l-100.144,67.926l-47.888,-91.44l-42.036,-25.414l-23.828,44.106Z",
                "M584.141,413.459l18.519,25.068l53.383,-10.456l36.53,-39.825l-48.958,-57.201l-55.871,26.765l-3.603,55.649Z",
                "M564.373,425.301l32.229,30.18l28.141,-20.674l-40.06,-33.859l-20.31,24.353Z",
            ],
        },
        leg_front: {
            paths: [
                "M283.817,602.899l94.976,93.367l-50.075,167.046l82.279,3.391l-37.229,-24.383l62.468,-154.752l-69.453,-113.912l-82.966,29.243Z",
                "M291.529,527.904l-9.971,32.17l-4.428,44.446l58.31,82.247l85.787,-60.537l-57.638,-93.327l-72.06,-4.999Z",
            ],
        },
        torso: {
            paths: [
                "M296.693,527.904l73.598,30.908l55.146,-8.681l54.938,-171.037l-28.228,-37.381l-51.04,-14.907l-45.239,21.38l-59.175,179.718Z",
            ],
        },
        head: {
            image: {
                href: props.imageUrl,
                x: 329,
                y: 116,
                width: 272,
                height: 272,
                rotate: 17,
            },
        },
        arm_front: {
            paths: [
                "M349.179,397.299l38.197,104.331l132.913,-21.379l-6.107,-37.442l-88.745,9.464l-10.394,-73.666l-42.036,-25.413l-23.828,44.105Z",
                "M512.954,444.778l4.479,30.843l51.989,16.006l51.011,-17.84l-16.124,-73.545l-61.888,-2.808l-29.467,47.344Z",
                "M480.241,441.844l6.862,47.347l43.091,-4.893l-8.551,-58.273l-41.402,15.819Z",
            ],
        },
    },
];

const animables = useTemplateRef("animables");

onMounted(() => {
    const duration = 0.8 + (Math.random() - 0.05);
    const ease = "power1.inOut"; // "back.inOut" is cool too
    animables.value.forEach((el) => {
        const [id, idx] = el.id.split("-");
        const toObj = frames[1][id];
        if (el.nodeName === "path") {
            const morphSVG = toObj.paths[idx];
            gsap.to(el, { duration, morphSVG, repeat: -1, yoyo: true, ease });
        } else if (el.nodeName === "image") {
            gsap.to(el, {
                duration,
                attr: toObj.image,
                repeat: -1,
                yoyo: true,
                ease,
            });
        }
    });
});
</script>

<template>
    <g>
        <g v-for="(group, id) in frames[0]" :id :class="group.cls">
            <path
                v-for="(d, idx) in group.paths"
                :d
                :id="`${id}-${idx}`"
                ref="animables"
            />
            <image
                v-if="group.image"
                :href="group.image.href"
                :x="group.image.x"
                :y="group.image.y"
                :width="group.image.width"
                :height="group.image.height"
                :style="{
                    rotate: `${group.image.rotate}deg`,
                }"
                :id="`${id}-0`"
                ref="animables"
            />
        </g>
    </g>
</template>

<style scoped>
path {
    fill: #ebebeb;
    stroke: #000;
    stroke-width: 1px;
}
image {
    transform-box: fill-box;
    transform-origin: center;
}
@keyframes animatearms {
    0% {
        rotate: 0deg;
    }
    100% {
        rotate: 12deg;
    }
}
g.arm {
    animation: animatearms infinite ease-in-out alternate;
}
g#arm_front {
    transform-origin: 28% 39%;
    animation-duration: var(--anim-arm-front-dur, 0.8s);
}
g#arm_back {
    transform-origin: 28% 39%;
    animation-duration: var(--anim-arm-back-dur, 1s);
}
g#head path {
    fill: url(#img1);
}
</style>
