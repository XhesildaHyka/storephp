function slideLeft(sliderId = 'arrivalSlider') {
    const slider = document.getElementById(sliderId);
    if (!slider) return;

    const cardWidth = slider.querySelector('.product-card')?.offsetWidth || 250;
    slider.scrollBy({
        left: -cardWidth * 2,
        behavior: 'smooth'
    });
}

function slideRight(sliderId = 'arrivalSlider') {
    const slider = document.getElementById(sliderId);
    if (!slider) return;

    const cardWidth = slider.querySelector('.product-card')?.offsetWidth || 250;
    slider.scrollBy({
        left: cardWidth * 2,
        behavior: 'smooth'
    });
}
