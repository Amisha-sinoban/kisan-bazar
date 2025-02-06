from flask import Flask, request, jsonify
import requests
from flask_cors import CORS

app = Flask(__name__)
CORS(app)  # Enable CORS for frontend API calls

OPENWEATHER_API_KEY = "2036940a90b69ff383ea1ff0a96c541a"
OPENWEATHER_URL = "https://api.openweathermap.org/data/2.5/forecast"

def fetch_weather(lat, lon):
    """Fetch real-time weather based on latitude and longitude."""
    params = {
        "lat": lat,
        "lon": lon,
        "appid": OPENWEATHER_API_KEY,
        "units": "metric"
    }
    response = requests.get(OPENWEATHER_URL, params=params)
    return response.json()

def generate_recommendations(weather_data):
    """Generate AI-driven farming recommendations based on weather conditions."""
    forecast = weather_data["list"][0]
    temp = forecast["main"]["temp"]
    humidity = forecast["main"]["humidity"]
    wind_speed = forecast["wind"]["speed"]
    rain = forecast.get("rain", {}).get("3h", 0)

    recommendations = []
    if rain > 10:
        recommendations.append("🌧️ Heavy rain expected. Store harvested crops indoors!")
    if temp > 35:
        recommendations.append("🔥 High temperatures detected! Increase irrigation.")
    if wind_speed > 20:
        recommendations.append("💨 Strong winds detected! Avoid pesticide spraying.")
    if not recommendations:
        recommendations.append("✅ Weather looks good. No immediate actions needed.")

    return recommendations

@app.route('/get-weather', methods=['GET'])
def get_weather():
    """Fetch weather data based on geolocation (lat, lon)"""
    lat = request.args.get("lat")
    lon = request.args.get("lon")

    if not lat or not lon:
        return jsonify({"error": "Latitude and Longitude are required!"}), 400

    weather_data = fetch_weather(lat, lon)
    if "list" not in weather_data:
        return jsonify({"error": "Invalid location or API rate limit exceeded!"}), 400

    recommendations = generate_recommendations(weather_data)

    return jsonify({
        "city": weather_data["city"]["name"],
        "weather": weather_data,
        "recommendations": recommendations
    })

if __name__ == "__main__":
    app.run(debug=True)