const morphShapeIndexes = {
    "base2-punch": {
        arm_front_0: 7,
    },
    "punch-base2": {
        arm_front_0: 1,
    },
};

export function getShapeIndex(fromFrame, toFrame, name) {
    const couple = `${fromFrame}-${toFrame}`;
    const index = morphShapeIndexes[couple]?.[name] ?? 0;
    return index;
}

export function random(min, max) {
    return Math.random() * (max - min) + min;
}
