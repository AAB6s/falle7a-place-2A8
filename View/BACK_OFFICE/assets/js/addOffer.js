function validateTitle() { return document.getElementById('title').value.trim().length >= 3 }
function validateDestination() { return /^[A-Za-z\s]{3,}$/.test(document.getElementById('destination').value.trim()) }
function validateDate() { return new Date(document.getElementById('return').value) >= new Date(document.getElementById('departure').value) }
function validatePrice() { const priceValue = document.getElementById('price').value.trim(); return priceValue !== "" && parseFloat(priceValue) >= 0 }
function validateCategory() { return document.getElementById('category').value !== "" }
function showMessage(span, condition, validity, type)
{ 
    span.innerHTML = condition + "<br>" + validity; 
    span.style.color = type === 'error' ? 'red' : 'green' 
}
document.getElementById('title').addEventListener('blur', () => showMessage(document.getElementById('titleMessage'), 'The title must contain at least 3 characters.', validateTitle() ? 'Valid' : 'Invalid', validateTitle() ? 'success' : 'error'));
document.getElementById('destination').addEventListener('blur', () => showMessage(document.getElementById('destinationMessage'), 'The destination must contain only letters and spaces, and at least 3 characters.', validateDestination() ? 'Valid' : 'Invalid', validateDestination() ? 'success' : 'error'));
document.getElementById('return').addEventListener('blur', () => showMessage(document.getElementById('dateMessage'), 'The return date must be later than the departure date.', validateDate() ? 'Valid' : 'Invalid', validateDate() ? 'success' : 'error'));
document.getElementById('price').addEventListener('blur', () => showMessage(document.getElementById('priceMessage'), 'The price must be a positive number.', validatePrice() ? 'Valid' : 'Invalid', validatePrice() ? 'success' : 'error'));
document.getElementById('category').addEventListener('blur', () => showMessage(document.getElementById('categoryMessage'), 'A category must be selected.', validateCategory() ? 'Valid' : 'Invalid', validateCategory() ? 'success' : 'error'));