// Chatbot toggle function
function toggleChatbot() {
    const chatbotWindow = document.querySelector("#chatbot-window");
    if (chatbotWindow.style.display === "none" || !chatbotWindow.style.display) {
        chatbotWindow.style.display = "block";
    } else {
        chatbotWindow.style.display = "none";
    }
}

// Navbar function
function initializeNavbar() {
    const navbar = document.createElement("nav");
    document.body.prepend(navbar);
}

initializeNavbar();

document.addEventListener('DOMContentLoaded', function() {
    const profileIcon = document.getElementById('profile-icon');
    const dropdownContent = document.querySelector('.dropdown-content');

    profileIcon.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    });

    // Close the dropdown if the user clicks outside of it
    window.addEventListener('click', function(event) {
        if (!event.target.matches('#profile-icon') && !event.target.closest('.dropdown')) {
            dropdownContent.style.display = 'none';
        }
    });
});

 // Handle accept button clicks
 const acceptButtons = document.querySelectorAll('.accept');
 acceptButtons.forEach(button => {
     button.addEventListener('click', function() {
         const order = this.closest('.recieved');
         const orderData = {
             item: order.querySelector('p:nth-child(2)').textContent,
             quantity: order.querySelector('p:nth-child(3)').textContent,
             price: order.querySelector('p:nth-child(4)').textContent,
             duration: order.querySelector('p:nth-child(5)').textContent
         };
         saveOrderToLocalStorage(orderData);
         order.remove(); // Remove the order from the list
     });
 });

 // Handle reject button clicks
 const rejectButtons = document.querySelectorAll('.reject');
 rejectButtons.forEach(button => {
     button.addEventListener('click', function() {
         const order = this.closest('.recieved');
         order.remove(); // Remove the order from the list
     });
 });

 function saveOrderToLocalStorage(order) {
    let orders = localStorage.getItem('acceptedOrdersPage');
    if (orders) {
        orders = JSON.parse(orders);
    } else {
        orders = [];
    }
    orders.push(order);
    localStorage.setItem('acceptedOrdersPage', JSON.stringify(orders));
}

// Slider functionality
const slides = document.querySelector('.slides');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
let currentIndex = 0;
const totalSlides = slides.children.length;

function showSlide(index) {
    const slideWidth = slides.children[0].offsetWidth;
    slides.style.transform = `translateX(${-index * slideWidth}px)`;
}

function showNextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}

prevButton.addEventListener('click', function() {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
    showSlide(currentIndex);
});

nextButton.addEventListener('click', function() {
    currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
    showSlide(currentIndex);
});

// Automatically change slides every 3 seconds
setInterval(showNextSlide, 3000);

const { GoogleGenerativeAI } = require("@google/generative-ai");

const genAI = new GoogleGenerativeAI({apiKey: "AIzaSyB-E4xnfie4JXLWf2C0y1WK6k07LLrntw0"});
const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
const generate = async (question) => {
    try {
        const result = await model.generateContent({
            prompt: question
        });
        const response = result.response;
        console.log(response.text());
        return response.text();
    } catch (error) {
        console.log("response error", error);
    }
};

// Example usage
generate("Explain how AI works");