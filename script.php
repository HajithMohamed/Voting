<script>
   $(document).ready(function () {
    $("#btn").click(function (event) {
        event.preventDefault();
        
        let data = {
            fName: $("#fName").val(),
            lName: $("#lName").val(),
            nic: $("#nic").val(),
            adr: $("#adr").val(),
            mobile: $("#mobile").val(),
            dob: $("#dob").val(),
            pollingDivision: $("#pollingDivision").val(),
        };

        $.ajax({
            url: 'Login.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message); // Display success alert
                    $("#form")[0].reset(); // Reset the form
                    $("#error").addClass("hidden").text('');
                } else {
                    $("#error").removeClass("hidden").text(response.message); // Display error message
                }
            },
            error: function (xhr, status, error) {
                console.error("Error: ", xhr.responseText); // Log error for debugging
                $("#error").removeClass("hidden").text("An error occurred. Please try again.");
            }
        });
    });
});

</script>