<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Include SweetAlert Library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="flex flex-col md:flex-row gap-2 min-h-screen">
    <div class="w-full md:w-1/2 bg-gray-100 flex items-center justify-center">
      <div class="container w-full shadow-lg px-5 py-5 border rounded m-10 bg-white">
        <form id="form">
            <h1 class="text-4xl text-gray-500 font-bold text-center mb-5">Sign-In</h1>
            <div id="error" class="hidden border border-gray-500 rounded p-2 text-red-500 border-red-500 text-center text-lg mb-5"></div>
            <div class="flex flex-col md:flex-row w-full gap-2">
                <div class="flex flex-col w-full md:w-1/2 text-lg text-gray-500">
                    <label for="fName">First Name:</label>
                    <input type="text" id="fName" name="fName" class="border border-gray-500 rounded p-2">
                </div>
                <div class="flex flex-col w-full md:w-1/2 text-lg text-gray-500">
                    <label for="lName">Last Name:</label>
                    <input type="text" id="lName" name="lName" class="border border-gray-500 rounded p-2">
                </div>
            </div>
            <div class="flex flex-col mt-2">
              <label for="nic">NIC No:</label>
              <input type="text" id="nic" name="nic" class="border border-gray-500 rounded p-2">
            </div>
            <div class="flex flex-col mt-2">
              <label for="mobile">Mobile No:</label>
              <input type="text" id="mobile" name="mobile" class="border border-gray-500 rounded p-2">
            </div>
            <div class="flex flex-col mt-2">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" class="border border-gray-500 rounded p-2">
            </div>
            <div class="flex flex-col mt-2">
              <label for="gender">Gender:</label>
              <div class="flex gap-4">
                <div class="flex items-center">
                  <input type="radio" id="male" name="gender" value="male" class="mr-2">
                  <label for="male">Male</label>
                </div>
                <div class="flex items-center">
                  <input type="radio" id="female" name="gender" value="female" class="mr-2">
                  <label for="female">Female</label>
                </div>
              </div>
            </div>
            <div class="flex flex-col mt-2">
              <label for="dob">Date of Birth:</label>
              <input type="date" id="dob" name="dob" class="border border-gray-500 rounded p-2">
            </div>
            <div class="flex flex-col mt-2">
              <label for="adr">Address:</label>
              <textarea id="adr" name="adr" class="border border-gray-500 rounded p-2"></textarea>
            </div>
            <div class="flex flex-col md:flex-row w-full gap-2 mt-2">
              <div class="flex flex-col w-full md:w-1/3 text-lg text-gray-500">
                <label for="province">Province:</label>
                <select id="province" name="province" class="border border-gray-500 rounded p-2">
                  <option value="">Select Province</option>
                  <option value="western">Western</option>
                  <option value="central">Central</option>
                  <option value="southern">Southern</option>
                  <option value="northern">Northern</option>
                  <option value="eastern">Eastern</option>
                  <option value="northWestern">North Western</option>
                  <option value="northCentral">North Central</option>
                  <option value="uva">Uva</option>
                  <option value="sabaragamuwa">Sabaragamuwa</option>
                </select>
              </div>
              <div class="flex flex-col w-full md:w-1/3 text-lg text-gray-500">
                <label for="pollingDivision">District:</label>
                <select id="pollingDivision" name="pollingDivision" class="border border-gray-500 rounded p-2">
                  <option value="">Select District</option>
                </select>
              </div>
              <div class="flex flex-col w-full md:w-1/3 text-lg text-gray-500">
                <label for="pollingDivisionDetails">Polling Division:</label>
                <select id="pollingDivisionDetails" name="pollingDivisionDetails" class="border border-gray-500 rounded p-2">
                  <option value="">Select Polling Division</option>
                </select>
              </div>
            </div>
            <button type="submit" id="btn" class="w-full rounded bg-blue-500 text-white font-bold text-lg mt-5 px-10 py-2 cursor-pointer transition ease-in hover:bg-blue-600">
              Register for Vote
            </button>
        </form>
      </div>
    </div>
    <div class="hidden md:flex md:w-1/2 justify-center items-center bg-cover bg-center" style="background-image: url('./assets/voting.jpg');">
    </div>
  </div>

  <script>
    $(document).ready(function(){
      // On form submit
      $("#form").submit(function(e){
        e.preventDefault(); // Prevent default form submission

        // Get form values
        const formData = {
          fName: $("#fName").val().trim(),
          lName: $("#lName").val().trim(),
          nic: $("#nic").val().trim(),
          adr: $("#adr").val().trim(),
          mobile: $("#mobile").val().trim(),
          email: $("#email").val().trim(),
          gender: $("input[name='gender']:checked").val(), // Get value from radio button
          dob: $("#dob").val(),
          province: $("#province").val(),
          pollingDivision: $("#pollingDivision").val(),
          pollingDivisionDetails: $("#pollingDivisionDetails").val()
        };

        // Clear previous errors
        $("#error").addClass("hidden").text("");

        // Validate fields (basic front-end validation)
        if (!formData.fName || !formData.lName || !formData.nic || !formData.adr || 
            !formData.mobile || !formData.email || !formData.gender || 
            !formData.dob || !formData.province || !formData.pollingDivision || !formData.pollingDivisionDetails) {
          $("#error").removeClass("hidden").text("All fields are required!");
          return;
        }

        if (!/^\d{10}$/.test(formData.mobile)) {
          $("#error").removeClass("hidden").text("Mobile number must be numeric and 10 digits!");
          return;
        }

        if (!/^\d{9}[VvXx]$/.test(formData.nic)) {
          $("#error").removeClass("hidden").text("NIC must be 9 digits followed by V, v, X, or x!");
          return;
        }

        // Send data to the server using AJAX
        $.post("verify.php", formData, function(response){
          if (response.trim() === "Register Successful") {
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Register Successful!',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            }).then(() => {
              $("#form")[0].reset(); // Reset the form
            });
          } else {
            $("#error").removeClass("hidden").text(response); // Show server error
          }
        }).fail(function() {
          $("#error").removeClass("hidden").text("An error occurred while processing your request.");
        });
      });

      const districtsByProvince = {
        western: ["Colombo", "Gampaha", "Kalutara"],
        central: ["Kandy", "Matale", "Nuwara Eliya"],
        southern: ["Galle", "Matara", "Hambantota"],
        northern: ["Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu"],
        eastern: ["Batticaloa", "Ampara", "Trincomalee"],
        northWestern: ["Kurunegala", "Puttalam"],
        northCentral: ["Anuradhapura", "Polonnaruwa"],
        uva: ["Badulla", "Moneragala"],
        sabaragamuwa: ["Ratnapura", "Kegalle"]
      };

      const pollingDivisions = {
        colombo: ["Colombo North", "Colombo Central", "Colombo East", "Colombo West", "Colombo South", "Borella", "Dehiwala", "Ratmalana", "Kolonnawa", "Kaduwela", "Homagama", "Maharagama", "Kesbewa", "Moratuwa"],
        gampaha: ["Negombo", "Katana", "Divulapitiya", "Mirigama", "Minuwangoda", "Gampaha", "Attanagalla", "Mahara", "Dompe", "Wattala", "Ja-Ela", "Ragama", "Kelaniya", "Biyagama"],
        kalutara: ["Panadura", "Bandaragama", "Horana", "Bulathsinhala", "Kalutara", "Beruwala", "Matugama", "Agalawatta"],
        kandy: ["Akurana", "Harispattuwa", "Hewaheta", "Kandy", "Kundasale", "Pathahewaheta", "Senkadagala", "Teldeniya", "Udunuwara", "Yatinuwara"],
        matale: ["Dambulla", "Laggala", "Matale", "Rattota"],
        nuwaraEliya: ["Hanguranketha", "Kotmale", "Nuwara Eliya", "Walapane"],
        galle: ["Ambalangoda", "Baddegama", "Balapitiya", "Bentara-Elpitiya", "Galle", "Habaraduwa", "Hiniduma", "Karandeniya", "Ratgama"],
        matara: ["Akuressa", "Deniyaya", "Hakmana", "Kamburupitiya", "Matara", "Weligama"],
        hambantota: ["Beliatta", "Hambantota", "Mulkirigala", "Tangalle", "Tissamaharama"],
        jaffna: ["Jaffna", "Kankesanthurai", "Kayts", "Kopay", "Manipay", "Nallur", "Point Pedro", "Uduvil"],
        kilinochchi: ["Kilinochchi"],
        mannar: ["Mannar"],
        vavuniya: ["Vavuniya"],
        mullaitivu: ["Mullaitivu"],
        batticaloa: ["Batticaloa", "Kalkudah","Patrippu"],
        ampara: ["Ampara", "Kalmunai", "Samanthurai"],
        trincomalee: ["Trincomalee"],
        kurunegala: ["Bingiriya", "Dambadeniya", "Galgamuwa", "Hiriyala", "Katugampola", "Kurunegala", "Mawathagama", "Nikaweratiya", "Panduwasnuwara", "Polgahawela", "Wariyapola", "Yapahuwa"],
        puttalam: ["Anamaduwa", "Chilaw", "Nattandiya", "Puttalam", "Wennappuwa"],
        anuradhapura: ["Anuradhapura East", "Anuradhapura West", "Horowpothana", "Kebithigollewa", "Medawachchiya", "Mihintale"],
        polonnaruwa: ["Polonnaruwa"],
        badulla: ["Badulla", "Bandarawela", "Hali-Ela", "Mahiyanganaya", "Passara", "Uva-Paranagama", "Welimada"],
        moneragala: ["Bibile", "Moneragala", "Wellawaya"],
        ratnapura: ["Balangoda", "Eheliyagoda", "Kolonna", "Nivitigala", "Pelmadulla", "Ratnapura"],
        kegalle: ["Aranayaka", "Dedigama", "Galigamuwa", "Kegalle", "Mawanella", "Rambukkana", "Warakapola", "Yatiyanthota"]
      };

      $("#province").change(function() {
        const province = $(this).val();
        const districtOptions = districtsByProvince[province] || [];
        const $pollingDivision = $("#pollingDivision");
        $pollingDivision.empty().append('<option value="">Select District</option>');
        districtOptions.forEach(function(district) {
          $pollingDivision.append(`<option value="${district.toLowerCase()}">${district}</option>`);
        });
        $("#pollingDivisionDetails").empty().append('<option value="">Select Polling Division</option>');
      });

      $("#pollingDivision").change(function() {
        const district = $(this).val();
        const divisionOptions = pollingDivisions[district] || [];
        const $pollingDivisionDetails = $("#pollingDivisionDetails");
        $pollingDivisionDetails.empty().append('<option value="">Select Polling Division</option>');
        divisionOptions.forEach(function(division) {
          $pollingDivisionDetails.append(`<option value="${division}">${division}</option>`);
        });
      });
    });
  </script>
</body>
</html>
