import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.naive_bayes import MultinomialNB
import pickle
import os

# Load dataset
data = pd.read_csv('C:/laragon/www/online-shop/public/python/online_shop.csv')


# Pilih kolom yang dibutuhkan untuk training
# Misalnya: Nama Produk, Merk, Warna untuk memprediksi Jenis Kelamin
features = ['ProductName', 'ProductBrand', 'PrimaryColor']
target = 'JenisPakaian'

# Drop baris yang memiliki nilai kosong di kolom-kolom tersebut
data.dropna(subset=features + [target], inplace=True)

# Label Encoding untuk fitur dan target
encoders = {}
X_encoded = pd.DataFrame()

for col in features:
    enc = LabelEncoder()
    X_encoded[col] = enc.fit_transform(data[col])
    encoders[col] = enc

# Encode target
target_encoder = LabelEncoder()
y_encoded = target_encoder.fit_transform(data[target])
encoders['target'] = target_encoder

# Split dataset
X_train, X_test, y_train, y_test = train_test_split(X_encoded, y_encoded, test_size=0.2, random_state=42)

# Train model Naive Bayes
model = MultinomialNB()
model.fit(X_train, y_train)

os.makedirs("public/python", exist_ok=True)
# Save model
with open("public/python/model.pkl", "wb") as f:
    pickle.dump(model, f)

os.makedirs("public/python", exist_ok=True)

# Save encoders
with open("public/python/encoders.pkl", "wb") as f:
    pickle.dump(encoders, f)

print("Model dan encoders berhasil disimpan.")
