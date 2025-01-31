from flask import Flask, jsonify, render_template
import random
import pandas as pd
import seaborn as sns
import matplotlib.pyplot as plt
import io
import base64

app = Flask(__name__)

# Sample data generation for monthly earnings
def generate_monthly_earnings():
    months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
    earnings = [random.randint(500, 1500) for _ in months]
    return dict(zip(months, earnings))

@app.route('/')
def index():
    # Generate the real-time monthly earnings data
    earnings_data = generate_monthly_earnings()

    # Create a DataFrame for the Seaborn plot
    df = pd.DataFrame(list(earnings_data.items()), columns=['Month', 'Income'])

    # Create a Seaborn plot
    plt.figure(figsize=(10, 6))
    sns.lineplot(x='Month', y='Income', data=df, marker='o')
    plt.title('Monthly Income')
    plt.xlabel('Month')
    plt.ylabel('Income ($)')
    
    # Convert plot to PNG and encode it to base64
    img = io.BytesIO()
    plt.savefig(img, format='png')
    img.seek(0)
    plot_url = base64.b64encode(img.getvalue()).decode('utf8')

    return render_template('index.html', earnings_data=earnings_data, plot_url=plot_url)

if __name__ == '__main__':
    app.run(debug=True)
