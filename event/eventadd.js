document.addEventListener('DOMContentLoaded', function () {
  // Add event listeners for input change
  document.getElementById('eventName').addEventListener('input', function () {
      updateValidation(this, 'eventNameError');
  });

  document.getElementById('eventDescription').addEventListener('input', function () {
      updateValidation(this, 'eventDescriptionError');
  });

  // Add similar listeners for other form fields
});

function validateEventForm() {
  // Get all form fields
  var eventNameInput = document.getElementById('eventName');
  var eventDescriptionInput = document.getElementById('eventDescription');
  // Add similar declarations for other form fields

  // Resetting all error messages and styles
  resetErrorMessage('eventNameError');
  resetErrorMessage('eventDescriptionError');
  // Reset other error messages

  // Validation logic for Event Name
  if (!validateInputField(eventNameInput, 'red', 'eventNameError', 'Please enter a valid event name')) {
      return false;
  }

  // Validation logic for Event Description
  if (!validateInputField(eventDescriptionInput, 'red', 'eventDescriptionError', 'Please enter a valid event description')) {
      return false;
  }

  // Add similar validation logic for other form fields

  // You can proceed with the form submission logic here
  alert('Event added successfully!');
  return true;
}

// Function to validate an input field
function validateInputField(inputElement, borderColor, errorId, errorMessage) {
  var inputValue = inputElement.value.trim();
  if (inputValue === '') {
      addErrorClass(inputElement, borderColor);
      showError(errorId, errorMessage);
      return false;
  } else {
      removeErrorClass(inputElement);
      return true;
  }
}

// Function to update border color and validation message based on input value
function updateValidation(inputElement, errorId) {
  var inputValue = inputElement.value.trim();
  if (inputValue === '') {
      addErrorClass(inputElement, 'red');
      showError(errorId, 'This field is required');
  } else {
      // Remove red border and reset error message when the input value is not empty
      removeErrorClass(inputElement);
      resetErrorMessage(errorId);
  }
}

// Function to reset error message
function resetErrorMessage(errorId) {
  document.getElementById(errorId).innerHTML = '';
}

// Function to show error message
function showError(errorId, errorMessage) {
  document.getElementById(errorId).innerHTML = errorMessage;
}

// Function to remove error class from input element
function removeErrorClass(element) {
  element.classList.remove('error');
  element.style.borderColor = ''; // Remove border color
}

// Function to add error class to input element
function addErrorClass(element, borderColor) {
  element.classList.add('error');
  element.style.borderColor = borderColor;
}



function validateAndDisplayChosenImageName() {
  const fileInput = document.getElementById('eventposter');
  const selectedFileNameElement = document.getElementById('selectedFileName');
  if (fileInput.files.length > 0) {
      selectedFileNameElement.textContent = fileInput.files[0].name;
  } else {
      selectedFileNameElement.textContent = '';
  }
}
var eventId = 0;

function addEventFields() {
  eventId++;
  var eventsContainer = document.getElementById('eventsContainer');
  var eventDiv = document.createElement('div');
  eventDiv.innerHTML = `
  <form class="form-container" >
    <label for="eventName${eventId}">Event Name:</label>
    <input type="text" id="eventName${eventId}" name="eventName${eventId}" required oninput="removeError('eventName${eventId}')">

    <label for="eventvenue${eventId}">Event Venue:</label>
    <input type="text" id="eventvenue${eventId}" name="eventvenue${eventId}" required oninput="removeError('eventvenue${eventId}')">

    <label for="eventmode${eventId}" class="dropdown-label">Event Mode:</label>
    <select id="eventmode${eventId}" name="eventmode${eventId}" class="dropdown" style="width: 150px;" required>
        <option value="Online">Online</option>
        <option value="Offline">Offline</option>
    </select>

    <label for="eventtype${eventId}" class="next-label">Event Type:</label>
    <select id="eventtype${eventId}" name="eventtype${eventId}" class="dropdown" style="width: 150px;" required>
        <option value="Technical">Technical</option>
        <option value="Non-Technical">Non-Technical</option>
    </select>

    <label for="formlink${eventId}" class="next-label">Form link:</label>
    <input type="text" id="formlink${eventId}" name="formlink${eventId}" required oninput="removeError('formlink${eventId}')">
    </from>
  `;
  eventsContainer.appendChild(eventDiv);
}
function removeEventFields() {
  var eventsContainer = document.getElementById('eventsContainer');
  if (eventId > 0) {
    var lastEventDiv = eventsContainer.lastChild;
    eventsContainer.removeChild(lastEventDiv);
    eventId--;
  }
}
    