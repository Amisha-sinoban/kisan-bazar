// Smooth Scrolling
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            window.scrollTo({
                top: target.offsetTop - 60, // Adjust for navbar height
                behavior: "smooth",
            });
        });
    });

    // Testimonial Slider
    let index = 0;

    function showNextReview() {
        const reviews = document.querySelectorAll(".review");
        reviews.forEach(review => review.style.display = "none");
        reviews[index].style.display = "block";
        index = (index + 1) % reviews.length;
    }

    setInterval(showNextReview, 5000);
    showNextReview(); // Initialize first review
});
