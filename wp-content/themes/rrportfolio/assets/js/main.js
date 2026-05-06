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

    console.log(rrportfolio_ajax.ajax_url);

    // Animate OUT
    gsap.to('.portfolio-item', {
      opacity: 0,
      y: 40,
      duration: 0.3,
      stagger: 0.05,
      onComplete: () => {


        fetch(rrportfolio_ajax.ajax_url, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
  },
  body: new URLSearchParams({
    action: 'tg_filter_projects',
    category: category || 'all'
  })
})
.then(response => response.text())
.then(data => {
  document.querySelector('#portfolio-grid').innerHTML = data;
})
.catch(err => console.error('AJAX ERROR:', err));


      }
    });

  });
});

const header = document.getElementById('site-header');

window.addEventListener('scroll', () => {
  if (window.scrollY > 50) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
});