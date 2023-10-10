document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");
  const userListDiv = document.getElementById("userList");
  const loginContainer = document.getElementById("loginContainer");
  const userTableBody = document.getElementById("userTableBody");
  const addUserButton = document.getElementById("addUserButton");
  const errorDisplay = document.getElementById("errorDisplay"); // Add an error display element

  let authToken = null;

  function addRandomUser() {
    fetch("http://localhost/api/add-random-user", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${authToken}`,
      },
    })
      .then((response) => response.json())
      .then(() => {
        fetchUserList();
      })
      .catch((error) => console.error(error));
  }

  function fetchUserList() {
    fetch("http://localhost/api/users", {
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${authToken}`,
      },
    })
      .then((response) => response.json())
      .then((data) => {
        const users = data.data;

        const userRows = users
          .map(
            (user) => `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.lastname}</td>
                                <td>${user.email}</td>
                                <td>${user.id}</td>
                                <td>${user.phone_number}</td>
                            </tr>
                        `
          )
          .join("");

        userTableBody.innerHTML = userRows;
      })
      .catch((error) => console.error(error));
  }

  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    fetch("http://localhost/api/login", {
      method: "POST",
      body: JSON.stringify({ email, password }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.data && data.data.token) {
          authToken = data.data.token;

          loginContainer.style.display = "none";
          userListDiv.style.display = "block";

          fetchUserList();
        } else {
          window.confirm("Wrong credentials. Please try again.");
        }
      })
      .catch((error) => {
        window.confirm("Wrong credentials. Please try again.");
      });
  });

  addUserButton.addEventListener("click", addRandomUser);
});
