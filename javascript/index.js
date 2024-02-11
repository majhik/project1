
document.addEventListener('DOMContentLoaded', function () {
    // Wait for the DOM to be fully loaded
    var greeting = document.getElementById('greeting');
  
    // Add the class to start the animation
    greeting.classList.add('animate');
  });
  
  function submitted() {
    document.getElementById("feedback").innerHTML = alert("Feedback Submitted Successfully!");
  }
