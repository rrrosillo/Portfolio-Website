document.querySelector('.back-to-top a').addEventListener('click', function(e) {
  e.preventDefault();
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

const buttons = document.querySelectorAll('.portfolio-filters button');
const grid = document.querySelector('#portfolio-grid');

buttons.forEach(button => {
  button.addEventListener('click', () => {

    // Active state
    buttons.forEach(b => b.classList.remove('active'));
    button.classList.add('active');

    const category = button.dataset.filter;

    // Animate OUT
    gsap.to('.portfolio-item', {
      opacity: 0,
      y: 40,
      duration: 0.3,
      stagger: 0.05,
      onComplete: () => {

        // AJAX CALL
        fetch(tg_ajax.ajax_url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `action=tg_filter_projects&category=${category}`
        })
        .then(res => res.text())
        .then(data => {

          grid.innerHTML = data;

          // Animate IN
          gsap.fromTo('.portfolio-item',
            { opacity: 0, y: 40 },
            {
              opacity: 1,
              y: 0,
              duration: 0.5,
              stagger: 0.08,
              ease: "power2.out"
            }
          );

        });

      }
    });

  });
});