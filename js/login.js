$(document).ready(function() {
    // 1. Helper function to show professional toast notifications
    function showToast(message, type = 'error') {
        const toast = $("#toast");
        toast.text(message);
        
        // Reset classes and apply the correct type (success or error)
        toast.removeClass('success error').addClass(type);
        
        // Show with a slide/fade effect
        toast.stop(true, true).fadeIn(300);

        // Auto-hide after 3 seconds
        setTimeout(() => {
            toast.fadeOut(300);
        }, 3000);
    }

    // 2. Handle Login Click
    $(document).on("click", "#loginbtn", function(e) {
        e.preventDefault();

        let un = $("#un").val().trim();
        let pw = $("#pw").val().trim();

        // Validation Check
        if (un === "" || pw === "") {
            showToast("Please enter both username and password", "error");
            return;
        }

        // Disable button to prevent multiple clicks
        const btn = $(this);
        btn.prop('disabled', true).text("Signing in...");

        $.ajax({
            url: "ajaxhandler/loginAjax.php",
            type: "POST",
            data: { user_name: un, password: pw },
            dataType: "json",
            success: function(response) {
                if (response.status === "ALL OK") {
                    showToast("Login successful! Redirecting...", "success");
                    
                    // Small delay so user can see the success toast
                    setTimeout(() => {
                        window.location.replace("attendance.php");
                    }, 1200);
                } else {
                    btn.prop('disabled', false).text("Sign In");
                    showToast("Invalid Username or Password", "error");
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).text("Sign In");
                console.error(xhr.responseText);
                showToast("Connection Error: Check server logs", "error");
            }
        });
    });

    // 3. Handle Register Button
    $(document).on("click", "#registerbtn", function(e) {
        e.preventDefault();
        window.location.href = "register.php";
    });
});