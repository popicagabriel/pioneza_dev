document.addEventListener("DOMContentLoaded", () => {
    const gears = document.querySelectorAll(".gear");

    let direction = 1;
    setInterval(() => {
        direction *= -1;
        gears.forEach((gear, index) => {
            const speed = 12 + index * 4;
            gear.style.animationDirection = direction === 1 ? "normal" : "reverse";
            gear.style.animationDuration = `${speed}s`;
        });
    }, 8000);
});

