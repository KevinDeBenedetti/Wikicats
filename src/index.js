const catLottie = document.querySelector('#catLottie')

let catRect = catLottie.getBoundingClientRect()

const animation = lottie.loadAnimation({
    container: catLottie,
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'https://assets9.lottiefiles.com/private_files/lf30_4gei4zbc.json'
});

let catPos = {
    x: 0,
    y: 0
}

let mouse = {
    x: 0,
    y: 0
}

document.addEventListener('mousemove', (e) => {
    mouse.x = e.clientX
    mouse.y = e.clientY
})

function lerp(a, b, t) {
    return (1 - t) * a + t * b;
}

let flipIt = false

let raf = () => {
    catRect = catLottie.getBoundingClientRect()

    flipIt = catRect.x + catRect.width / 2 > mouse.x
 
    catPos.x = lerp(catPos.x, mouse.x + catRect.width * (flipIt ? 0: -1), 0.03)
    catPos.y = lerp(catPos.y, mouse.y, 0.03)

    let angle = Math.atan((catRect.y + catRect.height / 2 - mouse.y) / (catRect.x + catRect.width / 2 - mouse.x));

    catLottie.style.webkitTransform = 
    `translate3d(${catPos.x}px, ${catPos.y - catRect.height / 2}px, 0) rotate(${angle}rad) scaleX(${flipIt ?-1: 1})`;

    let distance = Math.sqrt(Math.pow((mouse.x - (catRect.x + catRect.width * (flipIt ? 0: -1))), 2) + Math.pow((mouse.y - (catRect.y + catRect.height / 2)), 2));

    catLottie.style.opacity = distance / 100 + ''

    requestAnimationFrame(raf)
}

raf()


