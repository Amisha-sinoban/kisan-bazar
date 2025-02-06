// Function to Fetch Weather and AI Recommendations Automatically According to User's Location

function fetchWeatherByLocation(latitude, longitude) {
    const apiUrl = `http://127.0.0.1:5000/get-weather?lat=${latitude}&lon=${longitude}`;
    
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(`Error: ${data.error}`);
                return;
            }

            // Display Weather Details
            document.getElementById("cityTitle").innerText = `Location: ${data.city}`;
            document.getElementById("temp").innerText = `${data.weather.list[0].main.temp}°C`;
            document.getElementById("wind").innerText = data.weather.list[0].wind.speed + " m/s";
            document.getElementById("humidity").innerText = data.weather.list[0].main.humidity + "%";
            document.getElementById("condition").innerText = data.weather.list[0].weather[0].description;

            // Display Forecast for 7 Days
            let forecastContainer = document.getElementById("forecastContainer");
            forecastContainer.innerHTML = "";
            for (let i = 0; i < 7; i++) {
                let forecast = data.weather.list[i];
                let forecastElement = document.createElement("div");
                forecastElement.classList.add("forecast-day");
                forecastElement.innerHTML = `
                    <h4>${forecast.dt_txt.split(" ")[0]}</h4>
                    <p>${forecast.main.temp}°C</p>
                `;
                forecastContainer.appendChild(forecastElement);
            }

            // Display AI Recommendations
            let recommendationsContainer = document.getElementById("recommendationsContainer");
            recommendationsContainer.innerHTML = "";
            data.recommendations.forEach(rec => {
                let recommendationElement = document.createElement("p");
                recommendationElement.innerText = `✅ ${rec}`;
                recommendationsContainer.appendChild(recommendationElement);
            });

        })
        .catch(error => console.error("Error fetching weather:", error));
}

// Function to Get User's Real-Time Location
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            console.log(`📍 Detected Location: Lat ${latitude}, Lon ${longitude}`);
            fetchWeatherByLocation(latitude, longitude);
        }, () => {
            alert("⚠️ Location access denied. Please allow location access.");
        });
    } else {
        alert("⚠️ Geolocation is not supported in this browser.");
    }
}

// Auto Fetch Weather on Page Load
window.onload = getLocation;