document.addEventListener('DOMContentLoaded', function() {
  var labels = document.querySelectorAll('.signup-option label');
  var signupButton = document.getElementById("signup-button");
  var selectedOptionId = ""; // Variable to store the selected option's ID

  // Function to handle label clicks
  function handleLabelClick() {
    var selectedOption = this.getAttribute('for');
    signupButton.textContent = selectedOption === "client-option" ? "Join as a client" : "Join as an employee";
    
    // Store the selected option's ID
    selectedOptionId = selectedOption;
    
    // Remove selected class from all labels
    labels.forEach(function(label) {
      label.parentElement.classList.remove('selected');
    });
    
    // Add selected class to the clicked label's parent element
    this.parentElement.classList.add('selected');
    
    updateButtonState();
  }

  // Add event listeners to labels
  labels.forEach(function(label) {
    label.addEventListener('click', handleLabelClick);
  });

  // Function to update button state
  function updateButtonState() {
    var selectedOption = document.querySelector('input[name="user-type"]:checked');
    if (selectedOption) {
      signupButton.disabled = false;
      signupButton.classList.remove('disabled');
    } else {
      signupButton.disabled = true;
      signupButton.classList.add('disabled');
    }
  }

  // Add event listener to signup button
  signupButton.addEventListener('click', function(event) {
    var selectedOption = document.querySelector('input[name="user-type"]:checked');
    if (selectedOption) {
      if (selectedOptionId === "client-option") {
        window.location.href = "registerRecruiter.php"; // Redirect to client registration page
      } else if (selectedOptionId === "freelancer-option") {
        window.location.href = "registerWorker.php"; // Redirect to freelancer registration page
      }
    } else {
      document.getElementById("signup-message").textContent = "Please select an option.";
      event.preventDefault(); // Prevent form submission if no option is chosen
    }
  });
});
