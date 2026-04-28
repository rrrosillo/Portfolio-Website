document.querySelector('.close-top')?.addEventListener('click', () => {
  document.querySelector('.top-bar').style.display = 'none';
});

document.querySelectorAll('.faq-card').forEach(card => {

  card.addEventListener('click', () => {

    document.querySelectorAll('.faq-card').forEach(item => {
      if(item !== card) item.classList.remove('active');
    });

    card.classList.toggle('active');

  });

});

new Swiper('.property-slider', {
  slidesPerView: 3,
  spaceBetween: 25,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev'
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    768: { slidesPerView: 2 },
    1200: { slidesPerView: 3 }
  }
});

new Swiper('.faq-slider', {
  slidesPerView: 1,
  spaceBetween: 30,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev'
  }
});