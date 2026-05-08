document.querySelector('.back-to-top a').addEventListener('click', function(e) {
  e.preventDefault();
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

document.addEventListener("DOMContentLoaded", function(event){

 console.log("DOM loaded");

 //wait until images, links, fonts, stylesheets, and js is loaded
 window.addEventListener("load", function(e){
    gsap.registerPlugin(ScrollTrigger);

    // GSAP ANIMATION CODES
    gsap.from(".hero-right img", {
        scrollTrigger: {
          trigger: ".hero-right img",
          start: "top 80%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none"
        },
        x: 300,
        opacity: 0,
        duration: 1.5,
        ease: "power1.out"
    });

    gsap.from("p.small", {
        scrollTrigger: {
          trigger: "p.small",
          start: "top 80%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none"
        },
        x: -300,
        opacity: 0,
        duration: 0.8,
        ease: "power1.out"
    });

    gsap.from(".hero-left h1", {
        scrollTrigger: {
          trigger: ".hero-left h1",
          start: "top 80%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none"
        },
        x: -400,
        opacity: 0,
        delay: 0.5,
        duration: 1,
        ease: "power1.out"
    });

     gsap.from("p.role", {
        scrollTrigger: {
          trigger: "p.role",
          start: "top 80%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none",
          once: true
        },
        x: -500,
        opacity: 0,
        delay: 0.8,
        duration: 1.2,
        ease: "power1.out"
    });

     gsap.from(".hero-socials", {
        scrollTrigger: {
          trigger: ".hero-socials",
          start: "top 80%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none",
          once: true
        },
        x: 0,
        opacity: 0,
        delay: 1.8,
        duration: 1.5,
        ease: "power2.out"
    });

     gsap.from(".heading-box", {
        scrollTrigger: {
          trigger: ".heading-box",
          start: "top 80%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none",
          once: true
        },
        x: 0,
        opacity: 0,
        duration: 1,
        ease: "power2.out"
    });

    gsap.from(".berries h2, .berries p", {
        scrollTrigger: {
          trigger: ".berries h2, .berries p",
          start: "top 80%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none"
        },
        x: 300,
        opacity: 0,
        duration: 1.7,
        ease: "power1.out"
    });

    // END GSAP TEST SCRIPT

    // SCROLL TO TOP JS
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
    // END SCROLL TO TOP JS
    // PORTFOLIO SECTION JS
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
              action: 'rrportfolio_filter_projects',
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
    // END PORTFOLIO SECTION JS
    console.log("window loaded");
  }, false);

});