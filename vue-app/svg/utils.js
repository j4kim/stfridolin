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
