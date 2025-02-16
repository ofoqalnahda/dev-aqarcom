let navbar = document.querySelector('.navbar')
window.addEventListener('scroll',()=>{
    if(window.scrollY > 0){
        navbar.classList.add('navbarbg')

        }
        else{
            navbar.classList.remove('navbarbg')
        }
        
})


var swiper = new Swiper(".mySwiper", {
    // slidesPerView: "auto",
    spaceBetween: 0,
    slidesPerView: 1,
    loop:true,
    // centeredSlides: true,
    speed: 4000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
		320: {
			slidesPerView: 2,
		},
		560: {
			slidesPerView: 3,
		},
		990: {
			slidesPerView: 4,
		}
	},
  });