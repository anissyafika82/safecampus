package com.example.myapplication;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.textfield.TextInputEditText;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class LoginActivity extends AppCompatActivity {

    private TextInputEditText usernameInput, passwordInput;
    private MaterialButton loginButton;
    private static final String LOGIN_URL = "http://10.0.2.2:8080/safecampus/login.php"; // Emulator localhost

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.loginpage);

        // Bind views
        usernameInput = findViewById(R.id.usernameInput);
        passwordInput = findViewById(R.id.passwordInput);
        loginButton = findViewById(R.id.loginSubmitButton);

        loginButton.setOnClickListener(v -> {
            String username = usernameInput.getText().toString().trim();
            String password = passwordInput.getText().toString().trim();

            if(username.isEmpty() || password.isEmpty()){
                Toast.makeText(LoginActivity.this, "Please fill all fields", Toast.LENGTH_SHORT).show();
                return;
            }

            // Send login request to server
            sendLoginRequest(username, password);
        });

        // Optional: navigate to RegisterActivity
        findViewById(R.id.signUpText).setOnClickListener(v -> {
            startActivity(new Intent(LoginActivity.this, RegisterActivity.class));
        });

        // Optional: back button
        findViewById(R.id.backButton).setOnClickListener(v -> finish());
    }

    private void sendLoginRequest(String username, String password) {
        StringRequest stringRequest = new StringRequest(
                Request.Method.POST,
                LOGIN_URL,
                response -> {
                    try {
                        JSONObject obj = new JSONObject(response);
                        String status = obj.getString("status");
                        String message = obj.getString("message");

                        if(status.equals("success")){
                            JSONObject user = obj.getJSONObject("user");
                            String usernameResp = user.getString("username");
                            String emailResp = user.getString("email");
                            int userId = user.getInt("id");

                            // Save user info to SharedPreferences
                            SharedPreferences sharedPreferences = getSharedPreferences("UserPrefs", Context.MODE_PRIVATE);
                            SharedPreferences.Editor editor = sharedPreferences.edit();
                            editor.putString("USERNAME", usernameResp);
                            editor.putString("EMAIL", emailResp);
                            editor.putInt("USER_ID", userId);
                            editor.apply();

                            Toast.makeText(this, message, Toast.LENGTH_SHORT).show();

                            // Navigate to HomepageActivity
                            Intent intent = new Intent(LoginActivity.this, HomepageActivity.class);
                            intent.putExtra("USERNAME", usernameResp);
                            startActivity(intent);
                            finish();

                        } else {
                            Toast.makeText(this, message, Toast.LENGTH_LONG).show();
                        }

                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(this, "JSON parse error", Toast.LENGTH_LONG).show();
                        Log.e("LoginJSONError", response);
                    }
                },
                error -> {
                    Toast.makeText(this, "Request failed: " + error.getMessage(), Toast.LENGTH_LONG).show();
                    Log.e("LoginError", error.toString());
                }
        ){
            @Override
            protected Map<String, String> getParams(){
                Map<String,String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);
                return params;
            }
        };

        // Add request to queue
        Volley.newRequestQueue(this).add(stringRequest);
    }
}
