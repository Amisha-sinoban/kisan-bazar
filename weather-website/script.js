const API_KEY = '2036940a90b69ff383ea1ff0a96c541a';
const city = 'Kolkata'; // Change this to your desired location
const hourlyForecastContainer = document.getElementById('weather-forecast');
const recommendation = document.createElement('div');
recommendation.classList.add('recommendation');

async function fetchWeather() {
    try {
        const response = await fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${city}&units=metric&appid=${API_KEY}`);
        const data = await response.json();

        const today = new Date().getDate();
        const hourlyData = data.list.filter(item => new Date(item.dt_txt).getDate() === today);

        hourlyForecastContainer.innerHTML = '';

        let isBadWeather = false;

        hourlyData.forEach(hour => {
            const time = new Date(hour.dt_txt).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const temp = hour.main.temp.toFixed(1);
            const weather = hour.weather[0].description;
            const icon = hour.weather[0].icon;

            if (weather.includes('rain') || weather.includes('storm')) {
                isBadWeather = true;
            }

            const forecastItem = document.createElement('div');
            forecastItem.classList.add('weather-forecast-item');
            forecastItem.innerHTML = `
                <div class="hour">${time}</div>
                <img src="http://openweathermap.org/img/wn/${icon}@2x.png" alt="weather icon" class="w-icon">
                <div class="temp">${temp}&#176; C</div>
                <div class="condition">${weather}</div>
            `;
            hourlyForecastContainer.appendChild(forecastItem);
        });

        recommendation.innerHTML = isBadWeather
            ? '<p style="color: red;">Not good for harvesting or working in the field today.</p>'
            : '<p style="color: green;">All conditions are good to go for work.</p>';
        document.body.appendChild(recommendation);

    } catch (error) {
        console.error('Error fetching weather data:', error);
    }
}

fetchWeather();
