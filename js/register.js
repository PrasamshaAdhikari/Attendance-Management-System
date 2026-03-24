$(document).ready(function() {

    function showToast(message, type = 'error') {
        const toast = $("#toast");
        toast.text(message);
        
        toast.removeClass('success error').addClass(type);
        
        // Animation effect
        toast.stop(true, true).fadeIn(300);

        // Auto-hide after 3 seconds
        setTimeout(() => {
            toast.fadeOut(300);
        }, 3000);
    }

    // Register Logic
    $(document).on("click", "#register", function(e) {
        e.preventDefault();

        // Get and trim values
        let name = $("#n").val().trim();
        let user_name = $("#un").val().trim();
        let email = $("#email").val().trim();
        let password = $("#pw").val().trim();
        let department = $("#department").val();

        // .. VALIDATION CHECKS ..

        // Check for empty fields
        if(!name || !user_name || !email || !password || !department){
            showToast("Please fill all fields to continue", "error");
            return;
        }

        // Domain check
        if (!email.endsWith("@ioepc.edu.np")) {
            showToast("Only college mail addresses (@ioepc.edu.np) are allowed", "error");
            return;
        }

        // Disable button to prevent double-clicks
        const btn = $(this);
        btn.prop('disabled', true).text("Processing...");

        // Send AJAX Request
        $.post("ajaxhandler/registerAjax.php", {
            action: "register",
            name: name,
            user_name: user_name,
            email: email,
            password: password,
            department: department 
        }, function(res){
            if (res.status === "SUCCESS") {
                showToast(res.message, "success");
                
                // Delay redirect so user can see the success toast
                setTimeout(() => {
                    window.location.href = "login.php"; 
                }, 1500);
            } else {
                // Re-enable button on failure
                btn.prop('disabled', false).text("Register");
                showToast(res.message, "error"); 
            }
        }, "json").fail(function() {
            btn.prop('disabled', false).text("Register");
            showToast("Connection error. Server is unreachable.", "error");
        });
    });

    //  Handle Login Redirect Button
    $(document).on("click", "#redirect", function(e){
        e.preventDefault();
        window.location.href = "login.php";
    });
});