from flask import Flask, request, jsonify
import joblib
import pandas as pd

# ========== Konfigurasi ==========
API_KEY = "test-123"  # Ganti dengan key rahasia Anda

# ========== Load Model ==========
model_gender = joblib.load("model_naive_bayes/model_gender.pkl")
model_price = joblib.load("model_naive_bayes/model_price.pkl")
model_description = joblib.load("model_naive_bayes/model_description.pkl")
preprocessor = joblib.load("model_naive_bayes/preprocessor.pkl")
le_gender = joblib.load("model_naive_bayes/le_gender.pkl")
le_description = joblib.load("model_naive_bayes/le_description.pkl")

# ========== Inisialisasi App ==========
app = Flask(__name__)

# ========== Endpoint ==========
@app.route('/predict', methods=['POST'])
def predict():
    # Cek API key
    api_key = request.headers.get('x-api-key')
    if api_key != API_KEY:
        return jsonify({'error': 'Unauthorized'}), 401

    # Ambil data input
    try:
        data = request.get_json()
        new_input = pd.DataFrame([data])
        input_transformed = preprocessor.transform(new_input).toarray()

        # Prediksi
        pred_gender = le_gender.inverse_transform(model_gender.predict(input_transformed))[0]
        pred_price = model_price.predict(input_transformed)[0]
        pred_description = le_description.inverse_transform(model_description.predict(input_transformed))[0]

        # Return hasil
        return jsonify({
            'Gender': pred_gender,
            'Price_INR': float(pred_price),
            'Description': pred_description
        })

    except Exception as e:
        return jsonify({'error': str(e)}), 500

# ========== Jalankan Server ==========
if __name__ == '__main__':
    app.run(debug=True)
