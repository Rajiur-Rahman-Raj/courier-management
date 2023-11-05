
// add bg to nav
// window.addEventListener("scroll", function () {
//     let scrollpos = window.scrollY;
//     const header = document.querySelector("nav");
//     const headerHeight = header.offsetHeight;

//     if (scrollpos >= headerHeight) {
//        header.classList.add("active");
//     } else {
//        header.classList.remove("active");
//     }
//     // console.log(scrollpos);
//  });

// preloader_area
var preloader = document.getElementById("preloader");
function preloder_function() {
    preloader.style.display = "none";
}


$(document).ready(function () {

    // testimonial_area
    $('.testimonial_carousel').owlCarousel({
        loop: true,
        autoplay: false,
        // center: true,
        margin: 20,
        nav: true,
        dots: false,
        // rtl:true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 2
            },
            1150: {
                items: 3
            }
        }
    });

    // achivement_area_start
    $('.achivement_counter').counterUp({
        delay: 10,
        time: 1000
    });

    // referrel_area
    $('.refarrel_counter').counterUp({
        delay: 10,
        time: 1000
    });

    // scroll_up
    $(".scroll_up").fadeOut();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $(".scroll_up").fadeIn();
        } else {
            $(".scroll_up").fadeOut();
        }
    });

	$("#shareBlock").socialSharingPlugin({
		urlShare: window.location.href,
		description: $("meta[name=description]").attr("content"),
		title: $("title").text(),
	});

});

// dashboard_toggle_sidemenu
const toggleSideMenu = () => {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("content").classList.toggle("active");
};
const hideSidebar = () => {
    document.getElementById("formWrapper").classList.remove("active");
    document.getElementById("formWrapper2").classList.remove("active");
};

// tab
const tabs = document.getElementsByClassName("tab");
const contents = document.getElementsByClassName("content");
for (const element of tabs) {
   const tabId = element.getAttribute("tab-id");
   const content = document.getElementById(tabId);
   element.addEventListener("click", () => {
      for (const t of tabs) {
         t.classList.remove("active");
      }
      for (const c of contents) {
         c.classList.remove("active");
      }
      element.classList.add("active");
      content.classList.add("active");
   });
}

// input file preview
const previewImage = (id) => {
   document.getElementById(id).src = URL.createObjectURL(event.target.files[0]);
};

