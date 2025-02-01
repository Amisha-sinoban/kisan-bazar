let farmers = [
    {
        id: 1,
        name: "Ramesh Kumar",
        contact: "9876543210",
        location: "Delhi, India",
        rating: 4.5,
        categories: ["Vegetables", "Organic Farming"]
    },
    {
        id: 2,
        name: "Suresh Patel",
        contact: "8765432109",
        location: "Mumbai, India",
        rating: 4.2,
        categories: ["Dairy", "Grains"]
    }
];

// Function to Display Farmers
function displayFarmers(filteredFarmers = farmers) {
    const farmerList = document.getElementById("farmer-list");
    farmerList.innerHTML = "";
    filteredFarmers.forEach(farmer => {
        let li = document.createElement("li");
        li.innerHTML = `
            <div class="farmer-info">
                <h3>${farmer.name}</h3>
                <p>Location: ${farmer.location}</p>
                <p class="rating">
                    <span>${farmer.rating}</span> 
                    <img src="star-icon.png" alt="⭐" width="20">
                </p>
            </div>
            <button class="view-profile" onclick="openProfile(${farmer.id})">View Profile</button>
        `;
        farmerList.appendChild(li);
    });
}

// Open Profile in a New Page
function openProfile(id) {
    window.open(`profile.html?id=${id}`, "_blank");
}

// Search Farmers by Name
function searchFarmers() {
    let searchText = document.getElementById("search-bar").value.toLowerCase();
    let filtered = farmers.filter(farmer => farmer.name.toLowerCase().includes(searchText));
    displayFarmers(filtered);
}

// Filter by Rating and Category
function filterFarmers() {
    let minRating = parseFloat(document.getElementById("rating-filter").value);
    let category = document.getElementById("category-filter").value;

    let filtered = farmers.filter(farmer => 
        farmer.rating >= minRating &&
        (category === "All" || farmer.categories.includes(category))
    );
    displayFarmers(filtered);
}

// Initial Display
displayFarmers();
