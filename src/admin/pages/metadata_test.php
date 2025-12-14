<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Local Library Folder System</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            background: #f5f7fa;
            padding: 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        button {
            padding: 6px 10px;
            margin-left: 4px;
            cursor: pointer;
        }

        input {
            padding: 6px;
            margin: 4px 0;
        }

        ul {
            list-style: none;
            padding-left: 20px;
        }

        li {
            margin: 6px 0;
            background: #fff;
            padding: 8px;
            border-radius: 6px;
        }

        .folder {
            font-weight: bold;
        }

        .file {
            color: #444;
            margin-left: 12px;
        }

        .actions button {
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h1>📚 Digital Library (LocalStorage)</h1>

    <input id="deptName" placeholder="New Department">
    <button onclick="addDepartment()">Add Department</button>

    <hr>

    <ul id="library"></ul>

    <script>
        /* ===============================
           STORAGE
        ================================ */
        function getData() {
            return JSON.parse(localStorage.getItem("library")) || [];
        }
        function saveData(data) {
            localStorage.setItem("library", JSON.stringify(data));
        }
        function id(prefix) {
            return prefix + "-" + Date.now() + "-" + Math.floor(Math.random() * 1000);
        }

        /* ===============================
           DEPARTMENT
        ================================ */
        function addDepartment() {
            const name = document.getElementById("deptName").value.trim();
            if (!name) return alert("Enter department name");

            const data = getData();
            data.push({ id: id("dept"), name, folders: [] });
            saveData(data);
            document.getElementById("deptName").value = "";
            render();
        }

        function deleteDepartment(deptId) {
            saveData(getData().filter(d => d.id !== deptId));
            render();
        }

        /* ===============================
           FOLDER
        ================================ */
        function addFolder(deptId) {
            const name = prompt("Folder name:");
            if (!name) return;

            const data = getData();
            const dept = data.find(d => d.id === deptId);
            dept.folders.push({ id: id("folder"), name, files: [] });

            saveData(data);
            render();
        }

        function deleteFolder(deptId, folderId) {
            const data = getData();
            const dept = data.find(d => d.id === deptId);
            dept.folders = dept.folders.filter(f => f.id !== folderId);

            saveData(data);
            render();
        }

        /* ===============================
           FILE
        ================================ */
        function addFile(deptId, folderId) {
            const title = prompt("File title:");
            const author = prompt("Author:");
            if (!title) return;

            const data = getData();
            const folder = data
                .find(d => d.id === deptId)
                .folders.find(f => f.id === folderId);

            folder.files.push({
                id: id("file"),
                title,
                author,
                created: new Date().toLocaleString()
            });

            saveData(data);
            render();
        }

        function deleteFile(deptId, folderId, fileId) {
            const data = getData();
            const folder = data
                .find(d => d.id === deptId)
                .folders.find(f => f.id === folderId);

            folder.files = folder.files.filter(f => f.id !== fileId);
            saveData(data);
            render();
        }

        /* ===============================
           RENDER
        ================================ */
        function render() {
            const root = document.getElementById("library");
            root.innerHTML = "";

            getData().forEach(dept => {
                const d = document.createElement("li");
                d.innerHTML = `
                    <span class="folder">📁 ${dept.name}</span>
                    <span class="actions">
                        <button onclick="addFolder('${dept.id}')">+ Folder</button>
                        <button onclick="deleteDepartment('${dept.id}')">❌</button>
                    </span>
                    `;

                const folderUL = document.createElement("ul");

                dept.folders.forEach(folder => {
                    const f = document.createElement("li");
                    f.innerHTML = `
        📂 ${folder.name}
        <span class="actions">
          <button onclick="addFile('${dept.id}','${folder.id}')">+ File</button>
          <button onclick="deleteFolder('${dept.id}','${folder.id}')">❌</button>
        </span>
      `;

                    const fileUL = document.createElement("ul");

                    folder.files.forEach(file => {
                        const fileLI = document.createElement("li");
                        fileLI.className = "file";
                        fileLI.innerHTML = `
          📄 ${file.title} — ${file.author || "Unknown"}
          <button onclick="deleteFile('${dept.id}','${folder.id}','${file.id}')">❌</button>
        `;
                        fileUL.appendChild(fileLI);
                    });

                    f.appendChild(fileUL);
                    folderUL.appendChild(f);
                });

                d.appendChild(folderUL);
                root.appendChild(d);
            });
        }

        /* ===============================
           INIT
        ================================ */
        render();
    </script>

</body>

</html>