$(function () {
    'use strict';

    // Select the app wrapper element
    let appWrapper = document.querySelector("#app");

    // Select the sidebar toggle button element
    let sidebarToggle = document.querySelector(".sidebar-toggle");
    // Select the sidebar element
    let sidebar = document.querySelector(".sidebar");
    // Select the container element
    let container = document.querySelector(".content");

    // Check if the sidebar toggle button element exists
    if (sidebarToggle) {
        // Check if the window width is greater than 767 pixels
        if (window.outerWidth > 767) {
            // Add 'active-sidebar' class to the sidebar element
            sidebar.classList.add("active-sidebar");
            // Add 'active-content' class to the container element
            container.classList.add("active-content");
        }

        // Add event listener for the sidebar toggle button
        sidebarToggle.addEventListener("click", () => {
            // Check if the window width is greater than 767 pixels
            if (window.outerWidth > 767) {
                // Toggle 'active-sidebar' class on the sidebar element
                sidebar.classList.toggle("active-sidebar");
                // Toggle 'active-content' class on the container element
                container.classList.toggle("active-content");
            } else {
                // Toggle 'active-sidebar' class on the sidebar element
                sidebar.classList.toggle("active-sidebar");
                // Toggle 'active-sidebar-toggle-overlay' class on the sidebar toggle button element
                sidebarToggle.classList.toggle("active-sidebar-toggle-overlay");
                // Toggle 'active-sidebar-overlay' class on the sidebar element
                sidebar.classList.toggle("active-sidebar-overlay");
            }
        });
    }

    // Page loader element
    let pageLoader = document.querySelector("#loader-wrapper");

    // Function to show the page content
    function showPage() {
        // Hide the loader wrapper
        pageLoader.style.display = "none";
        // Display the app wrapper
        appWrapper.style.display = "block";
    }

    // Call the showPage function to display the page content
    showPage();

    // Hide success message after 5 seconds
    // Select the alert box element
    let alertBox = document.querySelector(".alert");

    // Check if the alert box element exists
    if (alertBox) {
        // Set a timeout to initiate the fade-out effect after 5 seconds
        setTimeout(function () {
            // Apply a transition for a smooth fade-out effect
            alertBox.style.transition = 'opacity 0.2s';
            // Set the opacity to 0 to initiate the fade-out
            alertBox.style.opacity = '0';
            // Set a timeout to hide the element after the fade-out effect completes
            setTimeout(function() {
                // Hide the element after the fade-out effect
                alertBox.style.display = 'none';
            }, 200); // Adjust this value to match the duration of the fade-out effect
        }, 5000); // Delay the fade-out effect by 5000 milliseconds (5 seconds)
    }

});
