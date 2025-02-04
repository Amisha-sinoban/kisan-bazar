from flask import Flask, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)  # Enable CORS for frontend access

# Sample Farmers Data with Ratings
farmers = [
    {"id": 1, "name": "Ramesh Kumar", "contact": "9876543210", "location": "Delhi, India", "rating": 4.5, "ratings": [5, 4, 5, 4, 5]},
    {"id": 2, "name": "Suresh Patel", "contact": "8765432109", "location": "Mumbai, India", "rating": 4.2, "ratings": [4, 4, 5, 4, 4]},
    {"id": 3, "name": "Amit Verma", "contact": "7654321098", "location": "Pune, India", "rating": 3.8, "ratings": [3, 4, 4, 3, 4]},
]

@app.route('/farmer/<int:farmer_id>', methods=['GET'])
def get_farmer(farmer_id):
    farmer = next((f for f in farmers if f["id"] == farmer_id), None)
    if farmer:
        return jsonify(farmer)
    return jsonify({"error": "Farmer Not Found"}), 404

if __name__ == '__main__':
    app.run(debug=True)
