document.addEventListener("DOMContentLoaded", function () {
    loadUsers();
    loadFiles();
});

function loadUsers() {
    const userList = document.getElementById("userList");
    userList.innerHTML = "<tr><td>1</td><td>Admin</td><td>admin@example.com</td><td><button onclick='deleteUser(1)'>Delete</button></td></tr>";
}

function addUser() {
    alert("Add user functionality will be implemented here.");
}

function deleteUser(userId) {
    alert("User " + userId + " deleted.");
}

function loadFiles() {
    const fileList = document.getElementById("fileList");
    fileList.innerHTML = "<tr><td>report.pdf</td><td>Student1</td><td><button onclick='deleteFile()'>Delete</button></td></tr>";
}

function deleteFile() {
    alert("File deleted.");
}

function saveSettings() {
    const toggleUploads = document.getElementById("toggleUploads").checked;
    alert("Upload setting changed: " + (toggleUploads ? "Enabled" : "Disabled"));
}
