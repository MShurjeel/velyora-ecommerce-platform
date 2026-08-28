const accountDropdown = document.querySelector(".account-dropdown");
const accountDropdownToggle = document.querySelector(".account-dropdown-toggle");
if (accountDropdown && accountDropdownToggle) {
    accountDropdownToggle.addEventListener("click", function(event) {
        event.stopPropagation();
        accountDropdown.classList.toggle("active");
    });
    document.addEventListener("click", function(event) {
        if (!event.target.closest(".account-dropdown")) {
            accountDropdown.classList.remove("active");
        }
    });
}