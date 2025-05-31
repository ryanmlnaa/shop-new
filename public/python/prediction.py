import joblib
import pandas as pd
import json

# Load semua komponen
model_gender = joblib.load("model_naive_bayes/model_gender.pkl")
model_price = joblib.load("model_naive_bayes/model_price.pkl")
model_description = joblib.load("model_naive_bayes/model_description.pkl")
preprocessor = joblib.load("model_naive_bayes/preprocessor.pkl")
le_gender = joblib.load("model_naive_bayes/le_gender.pkl")
le_description = joblib.load("model_naive_bayes/le_description.pkl")

with open("input.json") as f:
    data = json.load(f)
# Contoh input dari user (bisa nanti diganti dari request API)
new_input = pd.DataFrame([data])

# Transformasi input
input_transformed = preprocessor.transform(new_input).toarray()

# Prediksi
pred_gender = le_gender.inverse_transform(model_gender.predict(input_transformed))[0]
pred_price = model_price.predict(input_transformed)[0]
pred_description = le_description.inverse_transform(model_description.predict(input_transformed))[0]

# Output
print("Hasil Prediksi:")
print("Gender       :", pred_gender)
print("Price (INR)  :", pred_price)
print("Description  :", pred_description)
