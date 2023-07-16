// Function to adjust the height of the textarea based on the content
function adjustTextareaHeight(textarea) {
textarea.style.height = '100px'; // Reset the height to the default value
textarea.style.height = textarea.scrollHeight + 'px'; // Adjust the height based on the content
}

// Add an event handler for each textarea
var textareas = document.querySelectorAll('textarea');
textareas.forEach(function(textarea) {
textarea.addEventListener('input', function() {
    adjustTextareaHeight(this);
});
// Call the initial function to adjust the height when the page loads
adjustTextareaHeight(textarea);
});
