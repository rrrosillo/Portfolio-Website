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
        x: 300,
        opacity: 0,
        duration: 1.5,
        ease: "power1.out"
    });

    gsap.from("p.small", {
        x: -300,
        opacity: 0,
        duration: 0.8,
        ease: "power1.out"
    });

    gsap.from(".hero-left h1", {
        x: -400,
        opacity: 0,
        delay: 0.5,
        duration: 1,
        ease: "power1.out"
    });

     gsap.from("p.role", {
        x: -500,
        opacity: 0,
        delay: 0.8,
        duration: 1.2,
        ease: "power1.out"
    });

     gsap.to(".hero-socials", {
      opacity: 1,
      delay: 2,
      duration: 1.2,
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

     gsap.from("#about-me .heading-box", {
        x: 0,
        opacity: 0,
        delay: 0.5,
        duration: 1.2,
        ease: "power2.out",
        scrollTrigger: {
          trigger: "#about-me .heading-box",
          start: "top 100%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none",
          once: true
        }
    });

    gsap.from("#about-me p:first-child", {
      y: 100,          // starts 100px below
      opacity: 0,
      delay: 1,
      duration: 1,
      ease: "power3.out",
      scrollTrigger: {
        trigger: "#about-me",
        start: "top 80%",
        toggleActions: "play none none none",
        once: true
      }
    });

    gsap.from("#about-me p:nth-child(2)", {
        y: 100,          // starts 100px below
        opacity: 0,
        delay: 1.2,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: "#about-me",
          start: "top 80%",
          toggleActions: "play none none none",
          once: true
        }
      });

     gsap.from("#about-me p:nth-child(3)", {
        y: 100,          // starts 100px below
        opacity: 0,
        delay: 1.5,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: "#about-me",
          start: "top 80%",
          toggleActions: "play none none none",
          once: true
        }
      });

      gsap.to(".services-section", {
        opacity: 1,
        delay: 0.5,
        duration: 1,
        ease: "power2.out",
        scrollTrigger: {
          trigger: ".services-section",
          start: "top 100%",
          toggleActions: "play none none none",
          once: true
        }
      });

      gsap.from("#skills .heading-box", {
        x: 0,
        opacity: 0,
        delay: 0.5,
        duration: 1.2,
        ease: "power2.out",
        scrollTrigger: {
          trigger: "#skills .heading-box",
          start: "top 100%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none",
          once: true
        }
      });

      /*gsap.from("#contact-me .heading-box", {
        x: 0,
        opacity: 0,
        delay: 0.5,
        duration: 1.2,
        ease: "power2.out",
        scrollTrigger: {
          trigger: "#contact-me .heading-box",
          start: "top 100%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none",
          once: true
        }
      });*/

      gsap.from("#portfolio .heading-box", {
        x: 0,
        opacity: 0,
        delay: 0.5,
        duration: 1.2,
        ease: "power2.out",
        scrollTrigger: {
          trigger: "#portfolio .heading-box",
          start: "top 100%", // animation starts when box reaches 80% of viewport
          toggleActions: "play none none none",
          once: true
        }
      });

      gsap.from(".skills-section", {
        y: 300,          // starts 100px below
        duration: 1,
        opacity: 0,
        ease: "power3.out",
        scrollTrigger: {
          trigger: ".skills-section",
          start: "top 100%",
          toggleActions: "play none none none",
          once: true
        }
      });

      /*gsap.from("#contact-me h3", {
          x: 300,          // starts 100px below
          opacity: 0,
          duration: 1,
          ease: "power3.out",
          scrollTrigger: {
            trigger: "#contact-me h3",
            start: "top 80%",
            toggleActions: "play none none none",
            once: true
          }
      });

      gsap.from("#contact-me .p-1", {
          x: -300,          // starts 100px below
          opacity: 0,
          duration: 1,
          ease: "power3.out",
          scrollTrigger: {
            trigger: "#contact-me .p-1",
            start: "top 80%",
            toggleActions: "play none none none"
          }
      });

      gsap.from("#contact-me .p-2", {
          x: 300,          // starts 100px below
          opacity: 0,
          duration: 1,
          ease: "power3.out",
          scrollTrigger: {
            trigger: "#contact-me .p-2",
            start: "top 80%",
            toggleActions: "play none none none"
          }
      });

      gsap.from("#contact-me .contact-form", {
        y: 300,          // starts 100px below
        duration: 1,
        opacity: 0,
        ease: "power3.out",
        scrollTrigger: {
          trigger: "#contact-me .contact-form",
          start: "top 100%",
          toggleActions: "play none none none"
        }
      });*/
    // END GSAP SCRIPT

    // NAVIGATION MENU SCRIPT
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileNav = document.querySelector('.main-nav');

    menuToggle.addEventListener('click', () => {

      menuToggle.classList.toggle('active');
      mobileNav.classList.toggle('active');

    });

    /* CLOSE MENU WHEN CLICKING LINKS */
    document.querySelectorAll('.nav-menu a').forEach(link => {

      link.addEventListener('click', () => {
        menuToggle.classList.remove('active');
        mobileNav.classList.remove('active');
      });

    });
    // END NAVIGATION MENU SCRIPT

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

// SCROLL TO TOP JS AND CHANGE LOGO ON SCROLL
const header = document.getElementById('site-header');
const logo = document.querySelector('.site-logo img');
const defaultLogo = rrportfolio_ajax.theme_url + '/assets/img/portfolio-logo.png';
const scrollLogo  = rrportfolio_ajax.theme_url + '/assets/img/portfolio-logo-white.png';
window.addEventListener('scroll', () => {
  if (window.scrollY > 50) {
    header.classList.add('scrolled');
    logo.src = scrollLogo;
  } else {
    header.classList.remove('scrolled');
    logo.src = defaultLogo;
  }
});
// END SCROLL TO TOP JS
if (history.scrollRestoration) {
    history.scrollRestoration = 'manual';
}

// NEW PORTFOLIO SCRIPT
/* PORTFOLIO MOBILE FILTER */
const filterToggle = document.querySelector('.portfolio-filter-toggle');
const portfolioFilters = document.querySelector('.portfolio-filters');

if (filterToggle) {

  filterToggle.addEventListener('click', () => {

    filterToggle.classList.toggle('active');
    portfolioFilters.classList.toggle('active');

  });

}

/* CLOSE FILTERS AFTER CLICK (MOBILE) */
document.querySelectorAll('.portfolio-filters button').forEach(button => {

  button.addEventListener('click', () => {

    if(window.innerWidth < 768){

      portfolioFilters.classList.remove('active');
      filterToggle.classList.remove('active');

    }

  });

});

