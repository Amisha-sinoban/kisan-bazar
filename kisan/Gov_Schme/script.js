// Example API URLs for fetching government schemes
const apiUrls = [
    'https://api.example.com/government-schemes', // Replace with actual API URLs
    'https://another-api.example.com/schemes'
];

let schemes = []; // Store fetched schemes

// Fetch schemes from multiple APIs
async function fetchSchemes() {
    try {
        let allSchemes = [];
        for (let url of apiUrls) {
            const response = await fetch(url);
            const data = await response.json();
            allSchemes = allSchemes.concat(data.schemes); // Assuming the API returns a 'schemes' array
        }
        schemes = allSchemes;
        displaySchemes(schemes);
    } catch (error) {
        console.error('Error fetching schemes:', error);
    }
}

// Display schemes on the page
function displaySchemes(schemesList) {
    const container = document.getElementById('schemeContainer');
    container.innerHTML = ''; // Clear any existing content

    schemesList.forEach(scheme => {
        const card = document.createElement('div');
        card.classList.add('scheme-card');
        card.innerHTML = `
            <img src="${scheme.imageUrl}" alt="${scheme.name}">
            <h3>${scheme.name}</h3>
            <p>${scheme.description}</p>
            <a href="${scheme.url}" target="_blank">Apply Now</a>
        `;
        container.appendChild(card);
    });
}

// Search functionality
function searchSchemes() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const filteredSchemes = schemes.filter(scheme => 
        scheme.name.toLowerCase().includes(searchTerm) || 
        scheme.description.toLowerCase().includes(searchTerm)
    );
    displaySchemes(filteredSchemes);
}

// Initial fetch when the page loads
window.onload = fetchSchemes;
