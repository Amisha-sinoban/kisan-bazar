from flask import Flask, render_template
import matplotlib.pyplot as plt
import numpy as np
import os

app = Flask(__name__)

# Sample rating data from user reviews
ratings = [5, 4, 5, 4, 5, 5, 4, 5, 4, 5, 5, 5]  # Example ratings from user reviews

# Calculate statistics
total_reviews = len(ratings)
average_rating = np.mean(ratings)
rating_counts = {i: ratings.count(i) for i in range(1, 6)}

# Generate bar chart and save it
def generate_chart():
    plt.figure(figsize=(8, 5))
    plt.bar(rating_counts.keys(), rating_counts.values(), color=['red', 'orange', 'yellow', 'lightgreen', 'green'])
    plt.xlabel('Star Rating')
    plt.ylabel('Number of Reviews')
    plt.title('User Ratings Distribution')
    plt.xticks(range(1, 6))
    plt.ylim(0, max(rating_counts.values()) + 2)

    chart_path = "static/rating_chart.png"
    plt.savefig(chart_path)  # Save the figure
    plt.close()
    return chart_path

@app.route('/')
def home():
    chart_path = generate_chart()
    return render_template('index.html', total_reviews=total_reviews, 
                           average_rating=round(average_rating, 2),
                           chart_path=chart_path)

if __name__ == '__main__':
    app.run(debug=True)
from flask import Flask, render_template
import matplotlib.pyplot as plt
import numpy as np
import os

app = Flask(__name__)

# Sample rating data from user reviews
ratings = [5, 4, 5, 4, 5, 5, 4, 5, 4, 5, 5, 5]  # Example ratings from user reviews

# Calculate statistics
total_reviews = len(ratings)
average_rating = np.mean(ratings)
rating_counts = {i: ratings.count(i) for i in range(1, 6)}

# Generate bar chart and save it
def generate_chart():
    plt.figure(figsize=(8, 5))
    plt.bar(rating_counts.keys(), rating_counts.values(), color=['red', 'orange', 'yellow', 'lightgreen', 'green'])
    plt.xlabel('Star Rating')
    plt.ylabel('Number of Reviews')
    plt.title('User Ratings Distribution')
    plt.xticks(range(1, 6))
    plt.ylim(0, max(rating_counts.values()) + 2)

    chart_path = "static/rating_chart.png"
    plt.savefig(chart_path)  # Save the figure
    plt.close()
    return chart_path

@app.route('/')
def home():
    chart_path = generate_chart()
    return render_template('index.html', total_reviews=total_reviews, 
                           average_rating=round(average_rating, 2),
                           chart_path=chart_path)

if __name__ == '__main__':
    app.run(debug=True)
