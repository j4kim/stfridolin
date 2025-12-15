import { reactive } from "vue";

export function random(min, max) {
    return Math.random() * (max - min) + min;
}

export const frames = reactive({
    left: {
        // base1: "<?xml ..."
    },
    right: {},
});

export const frameNames = [
    "base1",
    "base2",
    "punch1",
    "punch2",
    "ouch",
    "winner",
    "loser",
];

export async function importFrames() {
    const promises = [];

    Object.keys(frames).forEach((boxerId) => {
        frameNames.forEach((name) => {
            const promise = import(`./svg/${boxerId}/${name}.svg?raw`).then(
                (m) => (frames[boxerId][name] = m.default),
            );
            promises.push(promise);
        });
    });

    await Promise.all(promises);
}
