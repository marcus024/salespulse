
function smoothNavigate(url) {
  // Add the fade-out class
  document.body.classList.add('fade-out');
  
  // After the transition ends, navigate to the new page
  setTimeout(function() {
    window.location.href = url;
  }, 500); // 500ms matches the CSS transition duration
}
