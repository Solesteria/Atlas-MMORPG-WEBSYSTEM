function showDropdown(action) {
    const buyDropdown = document.getElementById("buy-dropdown");
    const sellDropdown = document.getElementById("sell-dropdown");

    if (action === "buy") {
        buyDropdown.classList.remove("hidden");
        sellDropdown.classList.add("hidden");
    } else if (action === "sell") {
        sellDropdown.classList.remove("hidden");
        buyDropdown.classList.add("hidden");
    }
}
