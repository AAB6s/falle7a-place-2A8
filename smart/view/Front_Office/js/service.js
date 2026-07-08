//client
const token = localStorage.getItem('token');
var clientId=null;
if (token) 
{
    clientId = JSON.parse(atob(token.split('.')[1])).data.id;
}
else
{
    document.getElementById('history_service').style.display = 'none';
    document.getElementById('submit-button').disabled = true;
    const formMessage = document.getElementById('form_message');
    if (formMessage) 
    {
        formMessage.innerHTML = `You need to <a href="http://localhost/smart/view/signin.php">log in</a> to submit a request.`;
        formMessage.classList.add('form-error');
    }
}

//service_request_form
const serviceSelect = document.getElementById("service-selection");
const serviceDescription = document.getElementById("description");
const preferredDate = document.getElementById("preferred-date");
const preferredTime = document.getElementById("preferred-time");
const workerCount = document.getElementById("worker-count");
const addressInput = document.getElementById("address-input");
const serviceForm = document.getElementById("service-form");
serviceSelect.addEventListener("change", () => { checkField(serviceSelect, "service-selection-error");switch_state();checkField(serviceDescription, "description-error");});
serviceDescription.addEventListener("input", () => checkField(serviceDescription, "description-error"));
preferredDate.addEventListener("input", () => checkField(preferredDate, "preferred-date-error"));
preferredTime.addEventListener("input", () => checkField(preferredTime, "preferred-time-error"));
workerCount.addEventListener("blur", () => { if (workerCount.value < 1) workerCount.value = 1 });
const map = L.map("map").setView([34.0, 9.0], 7); L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { maxZoom: 18, attribution: "© OpenStreetMap contributors" }).addTo(map); let marker; function setMarkerAndUpdate(lat, lng, manualInput = "") { if (marker) marker.setLatLng([lat, lng]); else marker = L.marker([lat, lng]).addTo(map); fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`).then(r => r.json()).then(d => { const a = d.address || {}, p = [a.road, a.neighbourhood, a.city || a.town || a.village, a.state, a.country].filter(Boolean).join(", "), pl = `Lat: ${lat.toFixed(5)}, Lon: ${lng.toFixed(5)}`; document.getElementById("address-input").value = manualInput ? p : `${p} (${pl})`; document.getElementById("address-input").classList.remove("is-invalid"); document.getElementById("address-input-error").classList.add("d-none"); }).catch(() => { document.getElementById("address-input").value = `Lat: ${lat.toFixed(5)}, Lon: ${lng.toFixed(5)}`; document.getElementById("address-input").classList.add("is-invalid"); document.getElementById("address-input-error").textContent = "Could not fetch detailed location."; document.getElementById("address-input-error").classList.remove("d-none"); }); } map.on("click", e => { const { lat, lng } = e.latlng; setMarkerAndUpdate(lat, lng); }); document.getElementById("address-input").addEventListener("change", function () { const address = this.value.trim(), errorElement = document.getElementById("address-input-error"); if (!address) { errorElement.textContent = "Address cannot be empty."; errorElement.classList.remove("d-none"); this.classList.add("is-invalid"); this.value = ""; return; } fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`).then(r => r.json()).then(d => { if (d && d[0]) { const { lat, lon } = d[0]; map.setView([lat, lon], 12); setMarkerAndUpdate(lat, lon, address); this.classList.remove("is-invalid"); errorElement.classList.add("d-none"); } else { errorElement.textContent = "No results found. Using approximate location."; errorElement.classList.remove("d-none"); this.classList.add("is-invalid"); this.value = ""; } }).catch(() => { errorElement.textContent = "Error occurred during the search. Please try again."; errorElement.classList.remove("d-none"); this.classList.add("is-invalid"); this.value = ""; }); });
function checkField(field, errorId){const errorElement = document.getElementById(errorId);if (!field.value.trim()) {errorElement.classList.remove("d-none");field.classList.add("is-invalid");return false; } else {errorElement.classList.add("d-none");field.classList.remove("is-invalid");return true;}}
function handle_form(event) {
  event.preventDefault();
  let isValid = true,
    firstInvalidField = null;
  if (!checkField(serviceSelect, "service-selection-error")) {
    isValid = false;
    if (!firstInvalidField) firstInvalidField = serviceSelect;
  }
  if (!checkField(serviceDescription, "description-error")) {
    isValid = false;
    if (!firstInvalidField) firstInvalidField = serviceDescription;
  }
  if (!checkField(preferredDate, "preferred-date-error")) {
    isValid = false;
    if (!firstInvalidField) firstInvalidField = preferredDate;
  }
  if (!checkField(preferredTime, "preferred-time-error")) {
    isValid = false;
    if (!firstInvalidField) firstInvalidField = preferredTime;
  }
  if (!checkField(addressInput, "address-input-error")) {
    isValid = false;
    if (!firstInvalidField) firstInvalidField = addressInput;
  }
  if (!isValid) {
    firstInvalidField.focus();
    firstInvalidField.scrollIntoView({ behavior: "smooth", block: "center" });
  } else {
    const formMessage = document.getElementById("form_message");
    formMessage.textContent = "Submitting your request...";
    formMessage.style.color = "blue";
    formMessage.classList.remove("d-none");
    const formData = new FormData(serviceForm);
    fetch(
      `http://localhost/smart/View/Front_Office/add_service_request.php?client_id=${clientId}`,
      { method: "POST", body: formData }
    )
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          formMessage.textContent = "Request submitted successfully!";
          formMessage.style.color = "green";
          serviceForm.reset();
          setTimeout(() => formMessage.classList.add("d-none"), 3000);
        } else {
          formMessage.textContent = "Error while submitting. Please try again.";
          formMessage.style.color = "red";
        }
      })
      .catch(() => {
        formMessage.textContent = "Error while submitting. Please try again.";
        formMessage.style.color = "red";
      });
  }
}
function switch_state() {const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];if (selectedOption.index === 1) {serviceDescription.value="";serviceDescription.removeAttribute("readonly");}else if (selectedOption.parentElement.tagName === "OPTGROUP") {serviceDescription.setAttribute("readonly", true);serviceDescription.value = selectedOption.getAttribute("data-description");}}
function handle_service_option(){previousServiceData=[...service_type_name_id];let newOptionsHTML=`<option value="" disabled selected>Select a Service</option><option value="Custom">Custom Service</option>`;service_type_name_id.forEach(type=>{if(type.services.length>0){newOptionsHTML+=`<optgroup label="${type.name}">`;type.services.forEach(service=>{newOptionsHTML+=`<option value="${service.name}[${type.name}]" data-description="${service.description}">${service.name}</option>`;});newOptionsHTML+=`</optgroup>`;}});serviceSelect.innerHTML=newOptionsHTML;}

//service_request_history
function historique_service() { fetch(`http://localhost/smart/View/Front_Office/display_service_requests.php?client_id=${clientId}`).then(response => response.json()).then(data => { if (data.status === "success") { display_section("all-requests", data.allRequests, "#ffffff"); display_section("pending-requests", data.pendingRequests, "#fff4e5", "fas fa-hourglass-start"); display_section("approved-requests", data.approvedRequests, "#e6ffed", "fas fa-check-circle"); display_section("disapproved-requests", data.disapprovedRequests, "#ffe6e6", "fas fa-times-circle"); } else console.error("Invalid service data received."); }).catch(error => console.error("Fetch error:", error.message || error)); }
function display_section(elementId, requests, bgColor, iconClass = "fas fa-tools") { const section = document.getElementById(elementId); section.innerHTML = requests.map(service => `<div class="col-md-6 mb-4 d-flex align-items-stretch"><div class="card p-4 shadow-sm w-100" style="background-color: ${bgColor}; border-radius: 8px;"><h5 class="mb-3"><i class="${iconClass}"></i> Service Title: ${service.custom_name || "Custom Service"}</h5><p><strong>Description:</strong> ${service.custom_description}</p><p><strong>Date Requested:</strong> ${new Date(service.date_requested).toLocaleString()}</p><p><strong>Date Needed:</strong> ${new Date(service.date_needed).toLocaleDateString()}</p><p><strong>Location:</strong> ${service.location}</p><p><strong>Number of Workers:</strong> ${service.worker_count}</p><p><strong>Special Instructions:</strong> ${service.instructions || "None"}</p><p><strong>Status:</strong> ${service.status}</p></div></div>`).join(""); }

//view services
const serviceFilters = document.getElementById("service-type-filters");
const serviceTypeTitle = document.getElementById("service_type_title");
const serviceTypeDescription = document.getElementById("service_type_description");
const filteredServices = document.getElementById("filtered_services");
var service_type_name_id = [],previousServiceData = [];
var activeFilter = { serviceTypeId: null, typeName: "All Services", typeDescription: "All available services" };
function fetchServiceTypes(){fetch("http://localhost/smart/View/Back_Office/display_service_types.php").then(response=>response.json()).then(serviceTypes=>{let filterButtonsHTML=`<li class="nav-item"><a class="nav-link ${activeFilter.serviceTypeId===null?"active":""}" href="#" onclick="setActiveFilter(event, this, null, 'All Services', 'All available services')">All</a></li>`;serviceTypes.forEach(type=>{filterButtonsHTML+=`<li class="nav-item"><a class="nav-link ${activeFilter.serviceTypeId===type.service_type_id?"active":""}" href="#" onclick="setActiveFilter(event, this, ${type.service_type_id}, '${type.name}', '${type.short_description}')">${type.name}</a></li>`;});serviceFilters.innerHTML=filterButtonsHTML;service_type_name_id=serviceTypes.map(type=>({id:type.service_type_id,name:type.name,services:[]}));service_type_name_id.forEach(type=>{fetch(`http://localhost/smart/View/Back_Office/display_service.php?filter_service_type=${type.id}`).then(response=>response.json()).then(services=>{type.services=services.map(service=>({name:service.service_name,description:service.description}));}).catch(error=>console.error(`Error fetching services for type ${type.id}:`,error));});}).catch(error=>console.error("Error fetching service types:",error));}
function fetchAndDisplayServices(){fetch(`http://localhost/smart/View/Back_Office/display_service.php?filter_service_type=${activeFilter.serviceTypeId||""}`).then(response=>response.json()).then(services=>{serviceTypeTitle.textContent=activeFilter.typeName;serviceTypeDescription.textContent=activeFilter.typeDescription;filteredServices.innerHTML=services.map(service=>{const iconClass=service.icon.startsWith("fa")?service.icon:"fas fa-tools";const name=service.service_name;const description=service.description;return`<div class="col-md-4 mb-4 d-flex align-items-stretch"><div class="card p-3 shadow-sm w-100" style="border-radius: 8px;"><h5 class="mb-3"><i class="${iconClass}"></i> ${name}</h5><p>${description}</p><div class="mt-auto"><a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill request-service-btn w-100" onclick="handleRequestService('${name}[${service.type_name}]', '${description}')">Request Service</a></div></div></div>`;}).join("");}).catch(error=>console.error("Error fetching services:",error));}
function setActiveFilter(event, element, serviceTypeId, typeName, typeDescription) {event.preventDefault();activeFilter = { serviceTypeId, typeName, typeDescription };document.querySelectorAll("#service-type-filters .nav-link").forEach(link => link.classList.remove("active"));element.classList.add("active");fetchAndDisplayServices();}
function handleRequestService(serviceNameWithType, serviceDes) {const matchingOption = Array.from(serviceSelect.options).find((option) => option.value === serviceNameWithType);if (matchingOption) {serviceSelect.value = serviceNameWithType;serviceDescription.setAttribute("readonly", true);serviceDescription.value = serviceDes;serviceForm.scrollIntoView({ behavior: "smooth", block: "center" });}else console.error("Requested service option not found.");}

//Refresh
function Refresh() 
{
    fetchServiceTypes();
    if(JSON.stringify(service_type_name_id)!==JSON.stringify(previousServiceData))
    {
        fetchAndDisplayServices();
        handle_service_option();
    }
    historique_service();
}
Refresh();
setInterval(Refresh, 1000);