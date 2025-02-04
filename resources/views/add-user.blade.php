<!-- Blade template for adding user (resources/views/add-user.blade.php) -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Add Users</h2>
        <form id="userForm">
            <label>Name:</label>
            <input type="text" id="name" class="form-control" required>
            <label>Email:</label>
            <input type="email" id="email" class="form-control" required>
            <label>Password:</label>
            <input type="password" id="password" class="form-control" required>
            <label>Mobile:</label>
            <input type="text" id="mobile" class="form-control" required>
            <label>Role:</label>
            <select id="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <label>Image:</label>
            <input type="file" id="image" class="form-control">
            <button type="button" onclick="addUser()" class="btn btn-primary mt-3">Add to Table</button>
        </form>

        <h3 class="mt-5">User List</h3>
        <table class="table table-bordered mt-3" id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        
        <form action="{{ route('user.store') }}" method="POST" id="submitForm">
            @csrf
            <input type="hidden" name="users" id="usersInput">
            <button type="submit" class="btn btn-success">Submit All</button>
        </form>

        <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control mt-3" required>
            <button type="submit" class="btn btn-info mt-2">Upload Excel</button>
        </form>

        <a href="{{ route('user.export') }}" class="btn btn-secondary mt-3">Download Excel</a>
    </div>
</body>
</html>
<script>
    function addUser() {
        let name = $("#name").val();
        let email = $("#email").val();
        let mobile = $("#mobile").val();
        let role = $("#role").val();
        let imageFile = $("#image")[0].files[0];

        if (!name || !email || !mobile) {
            alert("Please fill all required fields.");
            return;
        }

        let imageUrl = imageFile ? URL.createObjectURL(imageFile) : '';

        let newRow = `<tr>
            <td>${$("#userTable tbody tr").length + 1}</td>
            <td><img src="${imageUrl}" width="50" height="50" class="rounded"></td>
            <td>${name}</td>
            <td>${email}</td>
            <td>${mobile}</td>
            <td>${role}</td>
            <td>${new Date().toLocaleString()}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="editUser(this)">Edit</button>
               <button class="btn btn-danger btn-sm" onclick="deleteUser(this)">Delete</button>

            </td>
        </tr>`;

        $("#userTable tbody").append(newRow);
        $("#userForm")[0].reset();
    }


    function editUser(button) {
        let row = button.parentNode.parentNode;
        document.getElementById("name").value = row.cells[0].innerText;
        document.getElementById("email").value = row.cells[1].innerText;
        document.getElementById("mobile").value = row.cells[2].innerText;
        document.getElementById("role").value = row.cells[3].innerText;

        row.remove();
    }

    function deleteUser(button) {
        if (confirm("Are you sure you want to delete this user?")) {
            let row = button.parentNode.parentNode;
            row.remove();
        }
    }

    function clearForm() {
        document.getElementById("name").value = "";
        document.getElementById("email").value = "";
        document.getElementById("password").value = "";
        document.getElementById("mobile").value = "";
        document.getElementById("role").value = "user";
    }
</script>
