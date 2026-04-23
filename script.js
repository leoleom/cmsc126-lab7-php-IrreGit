document.addEventListener("DOMContentLoaded", () => {
  const keywordInput = document.getElementById("keyword");
  const resultsDiv = document.getElementById("results");
  const updateDiv = document.getElementById("updateDiv");

  // SEARCH
  async function runSearch(keyword) {
    if (!keyword) {
      resultsDiv.innerHTML = "";
      return;
    }
    const res = await fetch("search.php?keyword=" + encodeURIComponent(keyword));
    const data = await res.json();
    resultsDiv.innerHTML = "";

    if (data.success) {
      let table = "<table border='1'><tr><th>Photo</th><th>ID</th><th>Name</th><th>Age</th><th>Email</th><th>Course</th><th>Year</th><th>Graduating?</th></tr>";
      data.students.forEach(s => {
        table += `<tr>
          <td><img src="${s.image_path}" width="50" height="50"></td>
          <td>${s.student_id}</td>
          <td>${s.student_name}</td>
          <td>${s.age}</td>
          <td>${s.email}</td>
          <td>${s.course_name}</td>
          <td>${s.year_level}</td>
          <td>${s.graduation_status}</td>
        </tr>`;
      });
      table += "</table>";
      resultsDiv.innerHTML = table;
    } else if (data.clear) {
      resultsDiv.innerHTML = "";
    } else {
      resultsDiv.textContent = data.message || "";
    }
  }

  // INSERT
  const insertForm = document.getElementById("insertForm");
  if (insertForm) {
    insertForm.addEventListener("submit", async e => {
      e.preventDefault();
      const formData = new FormData(insertForm);
      const res = await fetch("insert.php", { method: "POST", body: formData });
      const data = await res.json();
      alert(data.message);
      if (data.success) insertForm.reset();
    });
  }

  // DELETE
  async function runDelete(keyword) {
    if (!keyword) return;
    const res = await fetch("delete.php?keyword=" + encodeURIComponent(keyword));
    const data = await res.json();
    alert(data.message);
    if (data.success) {
      keywordInput.value = "";
      resultsDiv.innerHTML = "";
      updateDiv.innerHTML = "";
    }
  }

  // UPDATE
  async function runUpdateSearch(keyword) {
    if (!keyword) {
      updateDiv.innerHTML = "";
      return;
    }
    const res = await fetch("update.php?keyword=" + encodeURIComponent(keyword));
    const data = await res.json();
    updateDiv.innerHTML = "";

    if (data.clear) {
      updateDiv.innerHTML = "";
      return;
    }

    if (data.success) {
      const s = data.student;
      updateDiv.innerHTML = `
        <h2>Update Student Record</h2>
        <form id="updateForm">
          <input type="hidden" name="student_id" value="${s.student_id}">
          <label>Name</label>
          <input type="text" name="name" value="${s.student_name}"><br>
          <label>Age</label>
          <input type="number" name="age" value="${s.age}"><br>
          <label>Email</label>
          <input type="email" name="email" value="${s.email}"><br>
          <label>Course</label>
          <input type="text" name="course" value="${s.course_name}"><br>
          <label>Year Level</label>
          <input type="number" name="year_level" value="${s.year_level}" min="1" max="4"><br>
          <label>Graduating?</label>
          <input type="checkbox" name="graduation_status" value="1" ${s.graduation_status === "Yes" ? "checked" : ""}><br>
          <button type="submit">Save Changes</button>
        </form>
      `;

      const updateForm = document.getElementById("updateForm");
      updateForm.addEventListener("submit", async e => {
        e.preventDefault();
        const formData = new FormData(updateForm);
        const res = await fetch("update.php", { method: "POST", body: formData });
        const result = await res.json();
        alert(result.message);

        if (result.success) {
          updateForm.reset();
          updateDiv.innerHTML = "";
          keywordInput.value = "";
        }
      });
    } else {
      updateDiv.textContent = data.message || "";
    }
  }

  // BUTTONS
  document.getElementById("searchBtn").addEventListener("click", e => {
    e.preventDefault();
    runSearch(keywordInput.value.trim());
  });

  document.getElementById("deleteBtn").addEventListener("click", e => {
    e.preventDefault();
    runDelete(keywordInput.value.trim());
  });

  document.getElementById("updateBtn").addEventListener("click", e => {
    e.preventDefault();
    runUpdateSearch(keywordInput.value.trim());
  });
});
