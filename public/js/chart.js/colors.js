function generateDynamicColorArrayHSLA(length, colorOptions) {
    let colors = [];
    let colorOption = typeof colorOptions === 'undefined' ? {
        S: 100,
        L: 50,
        A: 1,
        totalH: 360
    } : colorOptions;

    let H = 0;
    const S = colorOption['S'];
    const L = colorOption['L'];
    const A = colorOption['A'];

    const constant = Math.floor((colorOption['totalH']) / length);

    for (let i = 0; i < length; i++) {
        colors.push("hsla(" + H + ", " + S + "%, " + L + "%, " + A + ")");
        H += constant;
    }

    return colors;
}

function generateRandomColorArrayRGBA(length, a = 1) {
    let colors = [];

    for (let i = 0; i < length; i++) {
        colors.push(generateRandomColorRGBA(a));
    }

    return colors;
}

function generateRandomColorRGBA(a = 1) {
    let r = Math.floor(Math.random() * 255);
    let g = Math.floor(Math.random() * 255);
    let b = Math.floor(Math.random() * 255);

    return "rgba(" + r + "," + g + "," + b + ',' + a + ')';
}
