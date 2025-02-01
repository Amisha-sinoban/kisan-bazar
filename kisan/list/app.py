from flask import Flask, jsonify, request
import pandas as pd

app = Flask(__name__)

# Sample farmers data with categories and quantity
farmers = [
    {"id": 1, "name": "Ramesh Kumar", "contact": "9876543210", "location": "Delhi, India", "rating": 4.5, "category": "Vegetables", "quantity": 100},
    {"id": 2, "name": "Suresh Patel", "contact": "8765432109", "location": "Mumbai, India", "rating": 4.2, "category": "Fruits", "quantity": 150},
    {"id": 3, "name": "Amit Verma", "contact": "7654321098", "location": "Pune, India", "rating": 3.8, "category": "Grains", "quantity": 120}
]

df = pd.DataFrame(farmers)

@app.route('/farmers', methods=['GET'])
def get_farmers():
    order = request.args.get("order", "desc")  # Default: High to Low
    sorted_farmers = df.sort_values(by="rating", ascending=(order == "asc")).to_dict(orient="records")
    return jsonify(sorted_farmers)

if __name__ == '__main__':
    app.run(debug=True)
