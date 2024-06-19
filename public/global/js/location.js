if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
        original_lat = position.coords.latitude;
        original_lng = position.coords.longitude;

        // Store the latitude and longitude in localStorage
        localStorage.setItem("latitude", original_lat);
        localStorage.setItem("longitude", original_lng);
    });
} else {
    alert("Geolocation is not available in your browser.")
}

if ("geolocation" in navigator) {
    navigator.permissions.query({ name: "geolocation" }).then(function(permissionStatus) {
        if (permissionStatus.state === "granted") {
            console.log("Geolocation permission is granted.");
            flag_allow_permission = true;
        } else if (permissionStatus.state === "denied") {
            console.log("Geolocation permission is denied.");
            localStorage.removeItem("latitude");
            localStorage.removeItem("longitude");
        } else if (permissionStatus.state === "prompt") {
            console.log("Geolocation permission is prompt (not granted or denied yet).");
        }
    });
} else {
    console.log("Geolocation is not supported in this browser.");
}