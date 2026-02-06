package com.example.myapplication;

import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.DatePicker;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.textfield.TextInputEditText;

import java.util.Calendar;
import java.util.HashMap;
import java.util.Map;

public class RegisterActivity extends AppCompatActivity {

    private TextInputEditText nameInput, usernameInput, emailInput, phoneInput, birthdateInput, passwordInput;
    private AutoCompleteTextView genderDropdown;
    private static final String REGISTER_URL = "http://10.0.2.2:8080/safecampus/register.php"; // Emulator localhost

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.register);

        // Bind views
        nameInput = findViewById(R.id.nameInput);
        usernameInput = findViewById(R.id.usernameRegisterInput);
        emailInput = findViewById(R.id.emailInput);
        phoneInput = findViewById(R.id.phoneInput);
        birthdateInput = findViewById(R.id.birthdateInput);
        passwordInput = findViewById(R.id.passwordInput);
        genderDropdown = findViewById(R.id.genderDropdown);
        ImageButton backButton = findViewById(R.id.backButton);
        MaterialButton registerSubmitButton = findViewById(R.id.registerSubmitButton);
        TextView loginText = findViewById(R.id.loginText);

        // Setup Gender Dropdown
        String[] genders = {"Male", "Female"};
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, genders);
        genderDropdown.setAdapter(adapter);

        // Date picker for birthdate
        birthdateInput.setOnClickListener(v -> showDatePicker());

        // Back button
        backButton.setOnClickListener(v -> finish());

        // Register button
        registerSubmitButton.setOnClickListener(v -> {
            String name = nameInput.getText().toString().trim();
            String username = usernameInput.getText().toString().trim();
            String email = emailInput.getText().toString().trim();
            String phone = phoneInput.getText().toString().trim();
            String password = passwordInput.getText().toString().trim();
            String birthdate = birthdateInput.getText().toString().trim();
            String gender = genderDropdown.getText().toString().trim();

            // Validate input
            if(name.isEmpty() || username.isEmpty() || email.isEmpty() || phone.isEmpty() || password.isEmpty() || birthdate.isEmpty() || gender.isEmpty()) {
                Toast.makeText(this, "Please fill in all details", Toast.LENGTH_SHORT).show();
                return;
            }

            // Save locally
            saveToSharedPreferences(name, username, email, password, phone);

            // Send POST request to PHP
            sendRegisterRequest(name, username, email, phone, password, birthdate, gender);
        });

        // Login text
        loginText.setOnClickListener(v -> finish());
    }

    private void saveToSharedPreferences(String name, String username, String email, String phone, String password) {
        SharedPreferences sharedPreferences = getSharedPreferences("UserPrefs", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString("NAME", name);
        editor.putString("USERNAME", username);
        editor.putString("EMAIL", email);
        editor.putString("PHONE", phone);
        editor.putString("PASSWORD", password);
        editor.apply();
    }

    private void sendRegisterRequest(String name, String username, String email, String phone, String password, String birthdate, String gender) {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, REGISTER_URL,
                response -> {
                    Toast.makeText(RegisterActivity.this, "Server Response: " + response, Toast.LENGTH_SHORT).show();
                    Log.d("RegisterResponse", response);

                    // Navigate to LoginActivity
                    Intent intent = new Intent(RegisterActivity.this, LoginActivity.class);
                    startActivity(intent);
                    finish();
                },
                error -> {
                    Toast.makeText(RegisterActivity.this, "Error: " + error.getMessage(), Toast.LENGTH_LONG).show();
                    Log.e("RegisterError", error.toString());
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String,String> params = new HashMap<>();
                params.put("name", name);
                params.put("username", username);
                params.put("email", email);
                params.put("phone", phone);
                params.put("password", password);
                params.put("birthdate", birthdate);
                params.put("gender", gender);
                return params;
            }
        };

        Volley.newRequestQueue(this).add(stringRequest);
    }

    private void showDatePicker() {
        final Calendar c = Calendar.getInstance();
        int year = c.get(Calendar.YEAR);
        int month = c.get(Calendar.MONTH);
        int day = c.get(Calendar.DAY_OF_MONTH);

        DatePickerDialog datePickerDialog = new DatePickerDialog(this,
                (DatePicker view, int year1, int monthOfYear, int dayOfMonth) -> {
                    birthdateInput.setText(String.format("%04d-%02d-%02d", year1, monthOfYear+1, dayOfMonth));
                }, year, month, day);
        datePickerDialog.show();
    }
}
