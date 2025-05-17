



document.addEventListener("DOMContentLoaded", function () {
    const elements = document.querySelectorAll(".scroll-reveal");
    let lastScrollTop = window.scrollY; 

    function revealOnScroll() {
        const currentScrollTop = window.scrollY; 

        elements.forEach((element) => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;
            const windowHeight = window.innerHeight;
            const middleScreen = windowHeight / 2; 

            if (elementTop < middleScreen && elementBottom > middleScreen) {
                element.classList.add("show"); 
            } else if (currentScrollTop < lastScrollTop) {
            
                element.classList.remove("show");
            }
        });

        lastScrollTop = currentScrollTop; 
    }

    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll(); 
});

const loginLink = document.querySelector('.category-item:last-child .category-link');

if (loginLink) {
  
    const toggleLoginBox = (e) => {
        e.preventDefault();
        const loginBox = document.querySelector('.login-box');
        if (loginBox) {
            loginBox.classList.toggle('show');
            
            if (loginBox.classList.contains('show')) {
                setTimeout(() => {
                    document.addEventListener('click', closeOnClickOutside);
                }, 10);
            } else {
                document.removeEventListener('click', closeOnClickOutside);
            }
        }
    };

    const closeOnClickOutside = (e) => {
        const loginBox = document.querySelector('.login-box');
        const isClickInside = loginBox.contains(e.target) || e.target === loginLink;
        
        if (!isClickInside && loginBox.classList.contains('show')) {
            loginBox.classList.remove('show');
            document.removeEventListener('click', closeOnClickOutside);
        }
    };

    loginLink.addEventListener('click', toggleLoginBox);
}


