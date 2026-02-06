package com.example.myapplication;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.SearchView;
import androidx.core.app.ActivityCompat;

import com.android.volley.Request;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapView;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.material.button.MaterialButton;
import com.google.android.material.chip.Chip;
import com.google.android.material.chip.ChipGroup;
import com.google.android.material.textfield.TextInputEditText;

import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class HomepageActivity extends AppCompatActivity implements OnMapReadyCallback {

    private MapView mapView;
    private GoogleMap googleMap;
    private ImageButton logoutButton;
    private TextView userWelcomeText;
    private MaterialButton submitReportButton, btnSearchLocation;
    private SearchView locationSearch;
    private FusedLocationProviderClient fusedLocationClient;
    private double latitude = 0.0;
    private double longitude = 0.0;

    private TextInputEditText incidentDescription;
    private ChipGroup incidentChipGroup;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.homepage);

        fusedLocationClient = LocationServices.getFusedLocationProviderClient(this);

        userWelcomeText = findViewById(R.id.userWelcomeText);
        logoutButton = findViewById(R.id.logoutButton);
        submitReportButton = findViewById(R.id.submitReportButton);
        btnSearchLocation = findViewById(R.id.btnSearchLocation);
        locationSearch = findViewById(R.id.locationSearch);
        mapView = findViewById(R.id.mapView);
        incidentDescription = findViewById(R.id.incidentDescription);
        incidentChipGroup = findViewById(R.id.incidentChipGroup);

        String username = getIntent().getStringExtra("USERNAME");
        userWelcomeText.setText(username != null && !username.isEmpty() ? "Hi, " + username : "Hi, User");

        // Logout
        logoutButton.setOnClickListener(v -> logoutUser());

        // Submit report
        submitReportButton.setOnClickListener(v -> submitReport());

        // Search location
        btnSearchLocation.setOnClickListener(v -> {
            String location = locationSearch.getQuery().toString().trim();
            searchLocation(location);
        });

        // Initialize map
        mapView.onCreate(savedInstanceState);
        mapView.getMapAsync(this);
    }

    private void submitReport() {
        if (latitude == 0.0 && longitude == 0.0) {
            Toast.makeText(this, "Please select a location first", Toast.LENGTH_SHORT).show();
            return;
        }

        int selectedChipId = incidentChipGroup.getCheckedChipId();
        if (selectedChipId == -1) {
            Toast.makeText(this, "Please select incident type", Toast.LENGTH_SHORT).show();
            return;
        }
        Chip selectedChip = findViewById(selectedChipId);
        String incidentType = selectedChip.getText().toString();

        String description = incidentDescription.getText().toString().trim();
        if (description.isEmpty()) {
            Toast.makeText(this, "Please enter description", Toast.LENGTH_SHORT).show();
            return;
        }

        String locationName = locationSearch.getQuery().toString().trim();
        if (locationName.isEmpty()) {
            locationName = "Pinned Location";
        }

        String timestamp = new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss", Locale.getDefault())
                .format(new java.util.Date());

        sendReportToServer(
                getIntent().getStringExtra("USERNAME"),
                incidentType,
                description,
                locationName,
                latitude,
                longitude,
                timestamp
        );
    }

    private void searchLocation(String location) {
        if (location.isEmpty()) {
            Toast.makeText(this, "Please enter a location", Toast.LENGTH_SHORT).show();
            return;
        }

        Geocoder geocoder = new Geocoder(this, Locale.getDefault());
        try {
            List<Address> addressList = geocoder.getFromLocationName(location, 1);
            if (addressList != null && !addressList.isEmpty()) {
                Address address = addressList.get(0);
                LatLng latLng = new LatLng(address.getLatitude(), address.getLongitude());
                googleMap.clear();
                googleMap.addMarker(new MarkerOptions().position(latLng).title(location));
                googleMap.animateCamera(CameraUpdateFactory.newLatLngZoom(latLng, 15));

                latitude = latLng.latitude;
                longitude = latLng.longitude;
            } else {
                Toast.makeText(this, "Location not found, tap map to select manually", Toast.LENGTH_LONG).show();
            }
        } catch (IOException e) {
            e.printStackTrace();
            Toast.makeText(this, "Unable to resolve location, tap map to select manually", Toast.LENGTH_SHORT).show();
        }
    }

    private void sendReportToServer(String username, String incidentType, String description,
                                    String locationName, double lat, double lon, String timestamp) {
        String url = "http://10.0.2.2:8080/safecampus/submit_report.php";

        StringRequest request = new StringRequest(Request.Method.POST, url,
                response -> Toast.makeText(this, "Report submitted successfully!", Toast.LENGTH_SHORT).show(),
                error -> Toast.makeText(this, "Failed: " + error.toString(), Toast.LENGTH_LONG).show()) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("incident_type", incidentType);
                params.put("description", description);
                params.put("location", locationName);
                params.put("latitude", String.valueOf(lat));
                params.put("longitude", String.valueOf(lon));
                params.put("timestamp", timestamp);
                return params;
            }
        };

        Volley.newRequestQueue(this).add(request);
    }

    private void logoutUser() {
        Toast.makeText(this, "Logged out successfully", Toast.LENGTH_SHORT).show();
        Intent intent = new Intent(HomepageActivity.this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }

    @Override
    public void onMapReady(@NonNull GoogleMap map) {
        googleMap = map;

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                == PackageManager.PERMISSION_GRANTED) {
            googleMap.setMyLocationEnabled(true);

            fusedLocationClient.getLastLocation().addOnSuccessListener(this, location -> {
                if (location != null) {
                    latitude = location.getLatitude();
                    longitude = location.getLongitude();
                    LatLng userLocation = new LatLng(latitude, longitude);
                    googleMap.moveCamera(CameraUpdateFactory.newLatLngZoom(userLocation, 16));
                    googleMap.addMarker(new MarkerOptions().position(userLocation).title("Your current location"));
                }
            });
        } else {
            ActivityCompat.requestPermissions(this,
                    new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 1);
        }

        // Tap map to select location manually
        googleMap.setOnMapClickListener(latLng -> {
            googleMap.clear();
            googleMap.addMarker(new MarkerOptions().position(latLng).title("Pinned Location"));
            latitude = latLng.latitude;
            longitude = latLng.longitude;
        });
    }

    // MapView lifecycle
    @Override protected void onResume() { super.onResume(); mapView.onResume(); }
    @Override protected void onPause() { mapView.onPause(); super.onPause(); }
    @Override protected void onDestroy() { mapView.onDestroy(); super.onDestroy(); }
    @Override public void onLowMemory() { super.onLowMemory(); mapView.onLowMemory(); }
}
