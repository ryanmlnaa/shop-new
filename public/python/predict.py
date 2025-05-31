import json
import pickle
import pandas as pd

# Load input
with open('input.json', 'r') as f:
    input_data = json.load(f)

# Convert to DataFrame
input_df = pd.DataFrame([input_data])

# Load encoders
with open('encoders.pkl', 'rb') as f:
    encoders = pickle.load(f)

# Encode input using saved encoders
for col in input_df.columns:
    if col in encoders:
        input_df[col] = encoders[col].transform(input_df[col])

# Load model
with open('model.pkl', 'rb') as f:
    model = pickle.load(f)

# Predict
prediction = model.predict(input_df)

# Output result
print(prediction[0])
# print(prediction[1])
# print(prediction[2])



