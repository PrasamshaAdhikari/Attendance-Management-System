$(document).ready(function() {
    console.log("JQuery Ready. Button ID check: ", $("#register").length);
// Login
    $(document).on("click", "#register", function(e) {
        e.preventDefault();
        // alert("Click Detected!"); 
        let name = $("#n").val();
        let user_name = $("#un").val();
        let email = $("#email").val();
        let password = $("#pw").val();
        let department = $("#department").val();

        if(!name || !user_name || !email || !password || !department){
            return alert("Please fill all fields");
        }
        if (!email.endsWith("@ioepc.edu.np")) {
        return alert("Only college mail addresses are allowed");
    }
        $.post("ajaxhandler/registerAjax.php", {
            action: "register",
            name: name,
            user_name: user_name,
            email: email,
            password: password,
            department: department 
        }, function(res){
            console.log(res);
            if (res.status === "SUCCESS") {
                alert(res.message);
                window.location.href = "login.php"; 
            } else {
                alert(res.message); 
            }
        }, "json");

        
    });

});

// $(document).on("click", "#register", function(e){
//     e.preventDefault();
//         window.location.href = "login.php";
//     });
$(document).on("click", "#redirect", function(e){
    e.preventDefault();
        window.location.href = "login.php";
    });