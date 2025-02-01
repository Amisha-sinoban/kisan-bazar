// Function to display the selected section
function showSection(section) {
    document.getElementById('farmer-section').style.display = 'none';
    document.getElementById('consumer-section').style.display = 'none';

    if (section === 'farmer') {
        document.getElementById('farmer-section').style.display = 'block';
    } else if (section === 'consumer') {
        document.getElementById('consumer-section').style.display = 'block';
    }
}

// Mock functions to simulate authentication
function sendOtp() {
    const aadhaar = document.getElementById('aadhaar').value;
    if (aadhaar) {
        console.log(`OTP sent to Aadhaar number: ${aadhaar}`);
        alert('OTP sent!');
    } else {
        alert('Please enter Aadhaar number.');
    }
}

function verifyOtp() {
    const otp = document.getElementById('otp').value;
    if (otp) {
        console.log(`OTP verified: ${otp}`);
        alert('OTP verified! Farmer logged in.');
    } else {
        alert('Please enter OTP.');
    }
}

function loginWithGoogle(userType) {
    console.log(`Google login for ${userType}`);
    alert(`${userType.charAt(0).toUpperCase() + userType.slice(1)} logged in with Google!`);
}