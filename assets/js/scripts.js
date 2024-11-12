// document.addEventListener("DOMContentLoaded", () => {
//     const searchInput = document.getElementById("search");
//     const usersTable = document.getElementById("usersTable").querySelector("tbody");

//     function fetchUsers() {
//         fetch("fetch_users.php")
//             .then(response => response.json())
//             .then(users => {
//                 usersTable.innerHTML = "";
//                 users.forEach(user => {
//                     const row = document.createElement("tr");
//                     row.innerHTML = `<td>${user.username}</td><td>${user.email}</td>`;
//                     usersTable.appendChild(row);
//                 });
//             });
//     }

//     searchInput.addEventListener("input", () => {
//         const searchTerm = searchInput.value.toLowerCase();
//         Array.from(usersTable.children).forEach(row => {
//             const username = row.children[0].textContent.toLowerCase();
//             const email = row.children[1].textContent.toLowerCase();
//             row.style.display = username.includes(searchTerm) || email.includes(searchTerm) ? "" : "none";
//         });
//     });

//     fetchUsers();
// });
