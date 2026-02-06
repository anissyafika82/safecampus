package com.example.myapplication;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.textfield.TextInputEditText;

public class ForgotPasswordActivity extends AppCompatActivity {

    private TextInputEditText resetIdentifierInput, newPasswordInput;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.forgot_password);

        resetIdentifierInput = findViewById(R.id.resetIdentifierInput);
        newPasswordInput = findViewById(R.id.newPasswordInput);
        MaterialButton doneButton = findViewById(R.id.doneButton);
        
        doneButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String identifier = resetIdentifierInput.getText().toString();
                String newPassword = newPasswordInput.getText().toString();

                if (identifier.isEmpty() || newPassword.isEmpty()) {
                    Toast.makeText(ForgotPasswordActivity.this, "Please fill in all details", Toast.LENGTH_SHORT).show();
                    return;
                }

                // Update the saved password in SharedPreferences
                SharedPreferences sharedPreferences = getSharedPreferences("UserPrefs", Context.MODE_PRIVATE);
                String savedUsername = sharedPreferences.getString("USERNAME", null);

                // For simplicity, we assume the identifier matches the saved username
                if (identifier.equals(savedUsername)) {
                    SharedPreferences.Editor editor = sharedPreferences.edit();
                    editor.putString("PASSWORD", newPassword);
                    editor.apply();

                    Toast.makeText(ForgotPasswordActivity.this, "Password Updated Successfully!", Toast.LENGTH_SHORT).show();
                    
                    // Return to Login Page
                    Intent intent = new Intent(ForgotPasswordActivity.this, LoginActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                    finish();
                } else {
                    Toast.makeText(ForgotPasswordActivity.this, "Username not found.", Toast.LENGTH_SHORT).show();
                }
            }
        });

        findViewById(R.id.backButton).setOnClickListener(v -> finish());
    }
}