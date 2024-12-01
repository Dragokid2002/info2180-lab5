document.addEventListener("DOMContentLoaded", () => {
    const lookupCountryButton = document.getElementById("lookup-country");
    const lookupCitiesButton = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");

    // Event listener for Lookup Country button
    lookupCountryButton.addEventListener("click", () => {
        const countryInput = document.getElementById("country").value;
        const url = `world.php?country=${encodeURIComponent(countryInput)}`;

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => console.error("Error:", error));
    });

    // Event listener for Lookup Cities button
    lookupCitiesButton.addEventListener("click", () => {
        const countryInput = document.getElementById("country").value;
        const url = `world.php?country=${encodeURIComponent(countryInput)}&lookup=cities`;

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => console.error("Error:", error));
    });
});
