// JavaScript Functions
function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.classList.add('hidden');
    });
    document.getElementById(sectionId).classList.remove('hidden');
}

function logout() {
    alert("Logging out...");
    window.location.href = "login.html"; // Redirect to login page
}

const ctx = document.getElementById('incomeChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Monthly Income ($)',
            data: [500, 700, 800, 650, 900, 1100],
            borderColor: 'green',
            borderWidth: 2,
            fill: false
        }]
    }
});
