import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.naive_bayes import GaussianNB
from sklearn.pipeline import make_pipeline
from sklearn.compose import ColumnTransformer
from sklearn.preprocessing import OneHotEncoder
from sklearn.impute import SimpleImputer
import joblib

# Load dataset
df = pd.read_csv("C:/laragon/www/online-shop/public/python/online_shop.csv")  # Ganti path-nya

# Kolom input & target
input_cols = ['JenisPakaian', 'ProductBrand', 'PrimaryColor']
target_cols = ['Gender', 'Price (INR)', 'Description']

# Hapus baris kosong di kolom penting
df = df.dropna(subset=input_cols + target_cols)

# Preprocessing input (OneHot encoding untuk kolom kategori)
preprocessor = ColumnTransformer(
    transformers=[
        ('cat', OneHotEncoder(handle_unknown='ignore'), input_cols)
    ]
)

# Pisahkan X dan Y
X = df[input_cols]
Y = df[target_cols].copy()

# Encode target kolom kategorikal
le_gender = LabelEncoder()
le_description = LabelEncoder()

Y['Gender_enc'] = le_gender.fit_transform(Y['Gender'])
Y['Description_enc'] = le_description.fit_transform(Y['Description'])

# Target akhir
Y_train = Y[['Gender_enc', 'Price (INR)', 'Description_enc']]

# Transform input
X_transformed = preprocessor.fit_transform(X)

# Model Naive Bayes (GaussianNB) per target (karena berbeda jenis)
model_gender = GaussianNB()
model_price = GaussianNB()
model_description = GaussianNB()

# Train model satu-satu
model_gender.fit(X_transformed.toarray(), Y_train['Gender_enc'])
model_price.fit(X_transformed.toarray(), Y_train['Price (INR)'])
model_description.fit(X_transformed.toarray(), Y_train['Description_enc'])


# ----------- Prediksi ------------------
# Input dari user
# new_input = pd.DataFrame([{
#     "ProductName": "Raymond Men Blue Self-Design Single-Breasted Bandhgala Suit",
#     "ProductBrand": "Raymond",
#     "PrimaryColor": "Blue"
# }])

# # Transform input baru
# new_input_transformed = preprocessor.transform(new_input).toarray()

# # Prediksi
# pred_gender = le_gender.inverse_transform(model_gender.predict(new_input_transformed))[0]
# pred_price = model_price.predict(new_input_transformed)[0]
# pred_description = le_description.inverse_transform(model_description.predict(new_input_transformed))[0]

# # Tampilkan hasil
# print("Hasil Prediksi:")
# print("Gender       :", pred_gender)
# print("Price (INR)  :", pred_price)
# print("Description  :", pred_description)

# Simpan model-model
joblib.dump(model_gender, "model_gender.pkl")
joblib.dump(model_price, "model_price.pkl")
joblib.dump(model_description, "model_description.pkl")

# Simpan preprocessor dan label encoder
joblib.dump(preprocessor, "preprocessor.pkl")
joblib.dump(le_gender, "le_gender.pkl")
joblib.dump(le_description, "le_description.pkl")

print("Model dan encoder berhasil disimpan.")
