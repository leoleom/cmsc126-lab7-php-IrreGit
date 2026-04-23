<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">

        <section class="form-card">
            <header class="form-header">
                <h1>Student Registration</h1>
                <p>All fields marked * are required.</p>
            </header>

            <form action="insert.php" method="POST" enctype="multipart/form-data">

                <div class="form-section">
                    <h2>Personal Information</h2>

                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" maxlength="40" placeholder="e.g. Juan dela Cruz" required>
                    </div>

                    <div class="form-group">
                        <label for="age">Age *</label>
                        <input type="number" id="age" name="age" min="0" max="99" placeholder="0 - 99" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" maxlength="40" placeholder="e.g. juan@example.com" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Academic Information</h2>

                    <div class="form-group">
                        <label for="course">Course *</label>
                        <input type="text" id="course" name="course" maxlength="40" placeholder="e.g. BS Computer Science" required>
                    </div>

                    <div class="form-group">
                        <label for="year_level">Year Level *</label>
                        <select id="year_level" name="year_level" required>
                            <option value="">Select year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>

                    <div class="form-group checkbox-group">
                        <label>Graduating this year? *</label>
                        <div class="checkbox-row">
                            <input type="checkbox" id="graduation_status" name="graduation_status" value="1">
                            <label for="graduation_status">Yes</label>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Profile Photo</h2>

                    <div class="form-group">
                        <label for="profile_image">Profile Image *</label>
                        <input type="file" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="submit-btn">Submit Registration</button>
                    <button type="reset" class="reset-btn">Clear Form</button>
                </div>

            </form>
        </section>

        <section class="record-card">
            <h2>Record Management</h2>

            <form method="GET" class="record-form">
                <label for="search">Look up by Student ID or Name</label>
                <input type="text" id="search" name="keyword" required>

                <div class="button-group">
                    <button formaction="search.php">Search</button>
                    <button formaction="update.php">Update</button>
                    <button formaction="delete.php">Delete</button>
                </div>
            </form>
        </section>

    </main>
</body>
</html>