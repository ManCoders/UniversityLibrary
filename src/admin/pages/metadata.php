<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    Library References
</h1>


<!-- Tabs Navigation -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <nav class="flex items-center justify-between">

        <!-- Left Tabs -->
        <div class="flex space-x-4">
            <button id="tab-add-metadata"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 py-4 px-1 border-b-2 font-medium text-sm">
                Department
            </button>

            <button id="tab-metadata-table"
                class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 py-4 px-1 border-b-2 font-medium text-sm">
                Catalog
            </button>
        </div>

    </nav>
</div>


<div id="tab-content">


    <!-- ADD METADATA -->
    <div id="add-metadata-content" class="tab-panel hidden">
        <!-- Toolbar -->
        <div class="flex flex-wrap gap-2 mb-4">

            <button type="button" id="new-folder-btn"
                class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded text-sm">
                Enter Department - Years Level
            </button>
        </div>

        <h2 class="text-lg font-semibold text-indigo-600">📁 File Manager</h2>
        <input type="file" id="context-file-upload" class="hidden" accept=".pdf,image/*">
        <input type="file" id="context-folder-upload" class="hidden" multiple>

        <!-- Folder List -->
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mt-4">
            <div class="border p-4 rounded-md flex flex-col">
                <ul id="folder-list" class="space-y-2 text-sm text-gray-800 dark:text-gray-100">

                </ul>
            </div>
        </div>
    </div>
    <!-- METADATA TABLE -->
    <div id="metadata-table-content" class="tab-panel hidden ">
        <div class="overflow-x-auto max-h-96 ">
            <table id="metadataTable"
                class="w-full border-collapse bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
                <thead class=" bg-gray-50 dark:bg-gray-700 top-0 z-10">
                    <tr>
                        <th
                            class="w-[5%] px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            #</th>

                        <th
                            class="w-[25%] px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Book Title</th>
                        <th
                            class="w-[20%] px-2 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Author</th>
                        <th
                            class="w-[15%] px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Isbn</th>
                        <th
                            class="w-[15%] px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            CopyRight</th>


                        <th
                            class="w-[20%] px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="metadatafile" class="divide-y divide-gray-200 dark:divide-gray-700">

                </tbody>
            </table>
        </div>
    </div>



    <!-- Edit Metadata Modal -->
    <div id="editMetaModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4 overflow-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-3xl w-full p-6 relative mx-auto"
            style="max-height: 90vh; overflow-y: auto;">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Edit Book Metadata</h2>
                <button onclick="$('#editMetaModal').hide()"
                    class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-200">&times;</button>
            </div>

            <form id="editMetaForm">
                <input type="hidden" name="book_id" value="">

                <div class="mb-3">
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Other Metadata</label>
                    <table class="w-full border-collapse" id="otherMetaTable">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                <th class="border px-2 py-1">Key</th>
                                <th class="border px-2 py-1">Value</th>
                                <th class="border px-2 py-1">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <button type="button" id="addMetaRow"
                        class="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Add Row</button>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="$('#editMetaModal').hide()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>




    <!-- View Metadata Modal with Book Cover -->
    <div id="viewMetaModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden overflow-auto">

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-4xl w-90 p-0 relative mx-auto">

            <!-- Header -->
            <div class="flex justify-between items-center bg-gray-200 dark:bg-gray-700 p-4 rounded-t-lg">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Bibliographic Reference</h2>
                <button onclick="$('#viewMetaModal').hide()"
                    class="text-gray-800 dark:text-gray-100 hover:text-red-500 font-bold text-lg">&times;</button>
            </div>

            <!-- Body -->
            <div class="grid w-100 grid-cols-2 md:grid-cols-2 p-2" style="max-height: 75vh; overflow-y: auto;">
                <div class="flex justify-center p-2 mx-auto justify-content-evenly w-full max-w-xs">
                    <img id="viewMetaCover" src="" alt="Book Cover"
                        class="w-full h-auto object-cover rounded shadow-md">
                </div>


                <!-- Right: Metadata Details -->
                <div class="flex flex-col space-y-2 text-gray-700 dark:text-gray-200 modal-body">
                    <p><span class="font-semibold">Title:</span> <span id="viewMetaTitle">—</span></p>
                    <p><span class="font-semibold">Author:</span> <span id="viewMetaAuthor">—</span></p>
                    <p><span class="font-semibold">ISBN:</span> <span id="viewMetaISBN">—</span></p>
                    <p><span class="font-semibold">Folder:</span> <span id="viewMetaFolder">—</span></p>
                    <p><span class="font-semibold">Copyright:</span> <span id="viewcopyright">—</span></p>
                    <p><span class="font-semibold">Metadata:</span> </p>
                    <pre id="viewMetaOther"
                        class="bg-gray-100 dark:bg-gray-700 p-2 rounded max-h-48 overflow-auto whitespace-pre-wrap break-words text-sm"></pre>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end bg-gray-200 dark:bg-gray-700 p-4 rounded-b-lg space-x-2">
                <button onclick="$('#viewMetaModal').hide()"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Close
                </button>
                <button id="readMetaButton" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Read
                </button>
            </div>
        </div>

    </div>




    <!-- 🆕 NEW FOLDER MODAL -->
    <div id="new-folder-modal"
        class="fixed w-100 inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-100 p-5">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3 lg:text-center ">Enter Department & Year Level
            </h3>

            <!-- <select id="folder-name-input" class="w-100 p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 mb-4"
                required>
                <option value="" disabled selected>Select Department</option>
                <option value="College of Information Computing and Sciences">College of Information Computing and
                    Sciences</option>
                <option value="College of Maritime Education">College of Maritime Education</option>
                <option value="College of Engineering & Technology Department">College of Engineering & Technology
                    Department</option>
                <option value="College of Arts, Humanities and Social Sciences">College of Arts, Humanities and Social
                    Sciences</option>
                <option value="College of Physical Education and Sports">College of Physical Education and Sports
                </option>
                <option value="College of Engineering and Technology">College of Engineering and Technology</option>
                <option value="School of Business Administration">School of Business Administration</option>
                <option value="College of Teacher Education">College of Teacher Education</option>
            </select> -->
            <input type="text" id="folder-name-input" placeholder="Enter Department Name"
                class="w-full p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 mb-4" required />


            <div class="flex justify-end gap-2">
                <button id="cancel-folder-btn"
                    class="px-3 py-1 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md text-sm">Cancel</button>
                <button id="create-folder-btn"
                    class="px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md text-sm">Create</button>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            function activateTab(tabId, contentId) {
                $('.tab-panel').addClass('hidden');
                $('.tab-button').removeClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                    .addClass('border-transparent text-gray-500 dark:text-gray-400');
                $(contentId).removeClass('hidden');
                $(tabId).addClass('border-indigo-500 text-indigo-600 dark:text-indigo-400')
                    .removeClass('border-transparent text-gray-500 dark:text-gray-400');
            }

            activateTab('#tab-add-metadata', '#add-metadata-content');
            $('#tab-add-metadata').click(() => activateTab('#tab-add-metadata', '#add-metadata-content'));
            $('#tab-metadata-table').click(() => activateTab('#tab-metadata-table', '#metadata-table-content'));


            const $modal = $('#new-folder-modal');
            // const $input = $('#folder-name-input');
            const name = $('#folder-name-input').val().trim();

            // --- Show modal ---
            $('#new-folder-btn').on('click', function () {
                
                $modal.removeClass('hidden').addClass('flex');
                $name.focus();
            });

            // --- Hide modal ---
            function closeModal() {
                $modal.addClass('hidden').removeClass('flex');
                $input.val('');
            }

            $('#cancel-folder-btn').on('click', closeModal);

            function attachFolderToggle(folderToggle) {
                $(folderToggle).off('click').on('click', function () {
                    const $list = $(this).next('ul');
                    const $icon = $(this).find('.toggle-icon');
                    $list.toggleClass('hidden');
                    $icon.text($list.hasClass('hidden') ? '▶' : '▼');
                });
            }


            loadFolders();
            function loadFolders() {
                $.getJSON(base_url + "auth/action.php?action=getFolders", res => {
                    if (res.status !== 1) return;
                    const $list = $('#folder-list').empty();

                    res.folders.forEach(folder => {
                        const $li = $(`
                            <li class="folder">
                                <div class="flex items-center justify-between cursor-pointer folder-toggle bg-white dark:bg-gray-800 border rounded-md px-3 py-1 hover:bg-indigo-50 dark:hover:bg-gray-700">
                                    <div class="flex items-center">
                                        <span class="text-gray-400 toggle-icon">▶</span>
                                        <span class="mr-2">📂</span>
                                        <span class="mainFolder font-medium flex-1">${folder.name}</span>
                                    </div>
                                    <div class="flex gap-1">
                                        <button class="delete-folder-btn text-sm px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded">🗑️ Delete</button>
                                        <button class="upload-file-btn text-sm px-2 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded">⬆️ Upload File</button>
                                        <button class="upload-folder-btn text-sm px-2 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded">⬆️ Upload Folder</button>
                                    </div>
                                </div>
                                <ul class="ml-6 mt-2 hidden space-y-1">

                                ${folder.db_data && folder.db_data.folder_data
                                ? JSON.parse(folder.db_data.folder_data).map((f, index) => {
                                    // Convert to sentence case
                                    const title = (() => {
                                        const t = f.metadata?.Title || f.metadata?.['dc:title'] || f.metadata?.title;
                                        if (!t || (Array.isArray(t) ? t[0].toLowerCase().includes('untitled') : t.toLowerCase().includes('untitled'))) {
                                            return f.filename.replace(/\.pdf$/i, '');
                                        }
                                        const str = Array.isArray(t) ? t[0] : t;
                                        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
                                    })();

                                    // Truncate to 60 characters
                                    const truncatedTitle = title.length > 60 ? title.slice(0, 57) + '...' : title;

                                    return `
                                        <li class="file grid grid-cols-12 bg-white dark:bg-gray-800 px-3 py-1 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer items-center">
                                            <span class=" font-semibold">${index + 1}</span> <!-- Serial Number -->
                                            <span class="col-span-11 text-gray-500 dark:text-gray-300">${truncatedTitle}</span> <!-- Truncated Title -->
                                        </li>
                                        `;
                                }).join('')
                                : `<li class="text-gray-400 text-xs italic">Empty folder</li>`
                            }
                                </ul>




                                <input type="file" class="hidden folder-file-input" accept=".pdf">
                                <input type="file" class="hidden folder-folder-input" webkitdirectory directory multiple>
                            </li>
                        `);
                        $list.append($li);

                        attachFolderToggle($li.find('.folder-toggle')[0]);


                        $li.find('.delete-folder-btn').click(function (e) {
                            e.stopPropagation();

                            if (!confirm(`Are you sure you want to delete "${folder.name}"?`)) {
                                return; // NO spinner here
                            }

                            $('#upload-spinner').removeClass('hidden'); // show when confirmed

                            $.post(
                                base_url + "auth/action.php?action=deleteFolder",
                                { folder_name: folder.name },
                                res => {
                                    $('#upload-spinner').addClass('hidden'); // hide

                                    if (res.status === 1) {
                                        alert('Folder deleted successfully');
                                        loadFolders();
                                        loadMetadata();

                                    } else {
                                        alert(res.message || 'Failed to delete folder');
                                    }
                                },
                                'json'
                            )
                                .fail(() => {
                                    $('#upload-spinner').addClass('hidden'); // hide on failure
                                    alert('Server error during deletion');
                                });
                        });


                        // Handle upload file button
                        $li.find('.upload-file-btn').click(function (e) {
                            e.stopPropagation();
                            $li.find('.folder-file-input').click();
                        });

                        // Handle upload folder button
                        $li.find('.upload-folder-btn').click(function (e) {
                            e.stopPropagation();
                            $li.find('.folder-folder-input').click();
                        });


                        $li.find('.folder-file-input').on('change', async function () {
                            const files = this.files;
                            if (!files.length) return;
                            $('#upload-spinner').removeClass('hidden').show();
                            const metadataList = [];
                            const folderName = $li.find('.mainFolder').text();

                            const formData = new FormData();
                            formData.append('folder', folderName);

                            for (let file of files) {
                                if (file.type !== 'application/pdf') continue; // skip non-PDFs

                                // Add file to FormData
                                formData.append('files[]', file);

                                // Read file as ArrayBuffer
                                const arrayBuffer = await file.arrayBuffer();
                                const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;

                                // ---------- 1️⃣ Extract Metadata ----------
                                const meta = await pdf.getMetadata().catch(() => ({}));
                                const info = meta?.info || {};
                                const xmp = meta?.metadata ? meta.metadata.getAll() : {};
                                const combinedMetadata = { ...info, ...xmp };
                                const filteredMetadata = Object.fromEntries(
                                    Object.entries(combinedMetadata).filter(
                                        ([key, value]) => key && value && String(value).trim() !== ''
                                    )
                                );

                                // ---------- 2️⃣ Extract Cover Image (first page render) ----------
                                const page = await pdf.getPage(1);
                                const scale = 1.5;
                                const viewport = page.getViewport({ scale });

                                // create off-screen canvas
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                canvas.width = viewport.width;
                                canvas.height = viewport.height;

                                const renderContext = { canvasContext: ctx, viewport };
                                await page.render(renderContext).promise;

                                // convert canvas to base64 image (PNG)
                                const coverImageData = canvas.toDataURL('image/png');

                                // Optional: Convert Base64 to Blob if you want to upload it separately
                                const coverBlob = await (await fetch(coverImageData)).blob();
                                const coverFileName = file.name.replace(/\.pdf$/i, '_cover.png');
                                formData.append('covers[]', coverBlob, coverFileName);

                                // ---------- 3️⃣ Add all metadata ----------
                                metadataList.push({
                                    foldername: folderName,
                                    filename: file.name,
                                    metadata: filteredMetadata,
                                    cover: coverFileName // link between PDF and cover
                                });
                            }
                            formData.append('metadata', JSON.stringify(metadataList));

                            console.log('metadata', JSON.stringify(metadataList))
                            // ---------- 4️⃣ Send FormData to backend ----------
                            $.ajax({
                                url: base_url + "auth/action.php?action=uploadFile",
                                method: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: 'json',

                                // 🔹 Show spinner before upload starts
                                beforeSend: function () {
                                    $('#upload-spinner').removeClass('hidden').show();
                                    console.log("📤 File upload started...");
                                },

                                success: res => {
                                    console.log("✅ Upload response:", res);

                                    if (res.status === 1) {
                                        alert(res.message || '✅ File upload success');
                                        $('#upload-spinner').removeClass('hidden').hide();
                                        console.log('Uploaded files:', res.files);
                                        loadFolders();
                                    } else {
                                        alert(res.message || '❌ File upload failed');
                                    }
                                    loadFolders();
                                    loadMetadata();
                                },

                                // 🔹 Handle any server error
                                error: (jqXHR, textStatus, errorThrown) => {
                                    console.error("🚨 AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                                    alert('Server error during file upload. Check console for details.');
                                },

                                // 🔹 Always hide spinner after completion
                                complete: function () {
                                    $('#upload-spinner').fadeOut(200).addClass('hidden');
                                    console.log("✅ File upload complete");
                                }
                            });


                            $(this).val(''); // reset input
                        });


                        $li.find('.folder-folder-input').on('change', async function () {
                            const files = this.files;
                            if (!files.length) return;
                            $('#upload-spinner').removeClass('hidden').show();
                            const folderName = $li.find('.mainFolder').text().trim();
                            if (!folderName) {
                                alert('Could not determine the target folder name.');
                                $(this).val('');
                                return;
                            }

                            const formData = new FormData();
                            formData.append('folder', folderName);

                            const metadataList = [];

                            for (let file of files) {
                                if (file.type !== 'application/pdf') continue;

                                formData.append('files[]', file, file.name);
                                formData.append('filePaths[]', file.name);

                                const fileMetadata = {
                                    foldername: folderName,
                                    filename: file.name,
                                    metadata: {}
                                };

                                try {
                                    // --- Read PDF and extract metadata
                                    const arrayBuffer = await file.arrayBuffer();
                                    const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
                                    const meta = await pdf.getMetadata().catch(() => ({}));

                                    const info = meta?.info || {};
                                    const xmp = meta?.metadata ? meta.metadata.getAll() : {};
                                    const combinedMetadata = { ...info, ...xmp };

                                    fileMetadata.metadata = Object.fromEntries(
                                        Object.entries(combinedMetadata).filter(([key, value]) =>
                                            key && value && String(value).trim() !== ''
                                        )
                                    );

                                    // --- Generate cover (client-side preview optional)
                                    const page = await pdf.getPage(1);
                                    const scale = 1.5;
                                    const viewport = page.getViewport({ scale });

                                    const canvas = document.createElement('canvas');
                                    const ctx = canvas.getContext('2d');
                                    canvas.width = viewport.width;
                                    canvas.height = viewport.height;

                                    await page.render({ canvasContext: ctx, viewport }).promise;

                                    const coverBase64 = canvas.toDataURL('image/jpeg', 0.8);
                                    const coverBlob = await (await fetch(coverBase64)).blob();
                                    const coverFileName = file.name.replace(/\.pdf$/i, '_cover.png');

                                    formData.append('covers[]', coverBlob, coverFileName);
                                    fileMetadata.cover = coverFileName;
                                } catch (e) {
                                    console.warn('⚠️ Error reading PDF metadata or cover:', file.name, e);
                                }

                                metadataList.push(fileMetadata);
                            }

                            formData.append('metadata', JSON.stringify(metadataList));

                            // Show spinner before AJAX
                            $('#upload-spinner').removeClass('hidden');

                            $.ajax({
                                url: base_url + "auth/action.php?action=uploadFolder",
                                method: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: 'json',

                                // 🔹 Show spinner before upload starts
                                beforeSend: function () {
                                    $('#upload-spinner').removeClass('hidden').show();
                                    console.log("📤 Upload started...");
                                },

                                success: res => {
                                    console.log('✅ Upload response:', res);

                                    if (res.status === 1) {
                                        const $fileList = $li.find('ul').empty();
                                        alert(res.message || '✅ Folder upload success');
                                        $('#upload-spinner').removeClass('hidden').hide();
                                        if (res.files_uploaded?.length) {
                                            res.files_uploaded.forEach(f => {
                                                const $fileItem = $(`
                                                <li class="file bg-white dark:bg-gray-800 px-3 py-1 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer flex justify-between items-center">
                                                    <span>${f}</span>
                                                    <span class="text-xs text-gray-400">${res.folder_name}</span>
                                                </li>
                                            `);
                                                $fileList.append($fileItem);
                                            });
                                        } else {
                                            $fileList.append('<li class="text-gray-400 text-xs italic">No files uploaded</li>');
                                        }

                                    } else {
                                        alert(res.message || '❌ Folder upload failed.');
                                    }
                                    loadFolders();
                                    loadMetadata();
                                },

                                // 🔹 Handle server or connection errors
                                error: (jqXHR, textStatus, errorThrown) => {
                                    console.error("🚨 AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                                    alert('Server error during folder upload. Check console for details.');
                                },

                                // 🔹 Always hide spinner at the end
                                complete: function () {
                                    $('#upload-spinner').fadeOut(200).addClass('hidden');
                                    console.log("✅ Upload complete");
                                }
                            });


                            $(this).val(''); // reset input
                        });


                        $('#folder-list').on('click', '.file', function () {
                            const $fileItem = $(this);
                            const filename = $fileItem.text().trim(); // Get file name
                            const $folderLi = $fileItem.closest('.folder'); // Get parent folder li
                            const folderName = $folderLi.find('.mainFolder').text().trim();

                            console.log('Clicked file:', filename, 'in folder:', folderName);

                        });
                    });
                });

            }
            // Create folder + reload list
            $('#create-folder-btn').click(function () {
                const $btn = $(this);
                const name = $('#folder-name-input').val().trim();
                if (!name) return alert('Enter folder name');

                $.post(base_url + "auth/action.php?action=createFolder", { folder_name: name }, res => {
                    if (res.status === 1) {
                        window.location.reload();
                        closeModal();
                        loadFolders();
                    } else alert(res.message || 'Failed to create folder');
                }, 'json').fail(() => alert('Server error')).always(() => $btn.text("Create Folder"));
            });

            /* METADATA FILE HERE */

            loadMetadata();
            function loadMetadata(query = "") {
                $.ajax({
                    url: base_url + "auth/action.php?action=getMetadata",
                    method: "GET",
                    dataType: "json",
                    success: function (res) {
                        if (res.status !== 1) {
                            alert(res.message || "Failed to load metadata");
                            return;
                        }

                        // Destroy previous DataTable if initialized
                        if ($.fn.DataTable.isDataTable("#metadataTable")) {
                            $("#metadataTable").DataTable().destroy();
                        }

                        const $tbody = $("#metadatafile").empty();
                        const q = query.toLowerCase();

                        // Filter and create rows
                        res.data
                            .filter(item => {
                                return (
                                    item.title?.toLowerCase().includes(q) ||
                                    item.author?.toLowerCase().includes(q) ||
                                    item.book_id?.toLowerCase().includes(q) ||
                                    item.isbn?.toLowerCase().includes(q)
                                );
                            })
                            .forEach((item, index) => {
                                const bookId = item.book_id?.trim() || '—';
                                const title = item.title?.trim() || '—';
                                const author = item.author?.trim() || '—';
                                const isbn = item.isbn?.trim() || '—';
                                const copyright = item.copyright?.trim().match(/\d{4}/)?.[0] || '—';

                                const row = `
                                        <tr>
                                            <td class="px-4 py-2 text-center">${index + 1}</td>
                                            <td class="px-4 py-2 truncate max-w-xs" title="${title}">${title}</td>
                                            <td class="px-4 py-2 truncate max-w-xs" title="${author}">${author}</td>
                                            <td class="px-4 py-2 truncate max-w-xs" title="${isbn}">${isbn}</td>
                                            <td class="px-4 py-2 text-center truncate max-w-xs" title="${copyright}">${copyright}</td>
                                            
                                            <td class="px-4 py-2 text-center flex justify-center gap-1">
                                                <button class="view-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs" data-id="${bookId}">View</button>
                                                <button class="edit-btn bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs" data-id="${bookId}">Edit</button>
                                                <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs" data-id="${bookId}">Delete</button>
                                            </td>
                                        </tr>
                                    `;

                                $tbody.append(row);
                            });

                        // Initialize DataTable
                        $("#metadataTable").DataTable({
                            searching: true,
                            paging: true,
                            ordering: true,
                            info: true,
                            lengthMenu: [10, 20, 50],
                            language: {
                                lengthMenu: "_MENU_ Number of Books",
                                info: "Displaying _START_ to _END_ of _TOTAL_ books"
                            },
                            pageLength: 10,
                            columnDefs: [
                                { orderable: false, targets: 4 } // Disable ordering on Actions column
                            ]
                        });
                    },
                    error: function () {
                        alert("Server error while loading metadata");
                    }
                });
            }

            // Delegate button clicks
            $("#metadatafile").on("click", ".view-btn, .edit-btn, .delete-btn", function () {
                const bookId = $(this).data("id");

                if ($(this).hasClass("view-btn")) {
                    // --- View Metadata ---
                    $("#upload-spinner").removeClass("hidden");

                    $.ajax({
                        url: base_url + `auth/action.php?action=viewmeta&book_id=${bookId}`,
                        method: "GET",
                        dataType: "json",
                        success: function (res) {
                            if (res.status === 1) {
                                const data = res.data;
                                const meta = data.metadata || {};

                                // Book cover
                                const coverPath = data.cover_path ? base_url + "auth/" + data.cover_path : "../../assets/images/no-cover.png";
                                $("#viewMetaCover").attr("src", coverPath).on("error", function () {
                                    $(this).attr("src", "../../assets/images/no-cover.png");
                                });

                                // Title and author
                                let rawTitle = meta.Title || meta.title || (data.filename ? data.filename.replace(/\.[^/.]+$/, "") : "") || meta["dc:title"] || "—";
                                let extractedAuthor = "—";
                                const authorMatch = rawTitle.match(/\(([^)]+)\)/);
                                if (authorMatch) {
                                    extractedAuthor = authorMatch[1].trim();
                                    rawTitle = rawTitle.replace(/\s*\([^)]+\)\s*$/, "").trim();
                                }

                                const formatDate = (dt) => {
                                    if (!dt) return "—";
                                    return new Date(dt).toISOString().split("T")[0];
                                };

                                $("#viewMetaTitle").text(rawTitle);
                                $("#viewMetaAuthor").text(meta.Author || meta.author || extractedAuthor || meta["Creator"] || "—");

                                // ISBN, Folder, Filename

                                $("#viewMetaISBN").text(meta["prism:isbn"]?.ISBN || meta["pdfx:isbn"] || meta["dc:identifier"] || meta["isbn"] || "—");
                                $("#viewMetaFolder").text(data.foldername || "—");
                                $("#viewMetaFilename").text(data.filename || "—");
                                $("#viewcopyright").text(formatDate(meta['dc:date'] ?? meta['xmp:createdate']));

                                // Other metadata
                                let otherMeta = "";
                                $.each(meta, function (key, value) {
                                    if (!["Title", "Author", "prism:isbn", "pdfx:isbn"].includes(key)) {
                                        if (typeof value === "object") value = JSON.stringify(value, null, 2);
                                        otherMeta += key + ": " + value + "\n";
                                    }
                                });
                                $("#viewMetaOther").text(otherMeta || "No other metadata available.");

                                // Show modal
                                $("#viewMetaModal").fadeIn(200);

                                // Attach Read button
                                $("#readMetaButton").off("click").on("click", function () {
                                    $.ajax({
                                        url: base_url + "auth/action.php?action=readingbooks",
                                        method: "POST",
                                        data: {
                                            file: data.file_path,
                                            book_title: rawTitle,
                                            book_author: meta.Author || meta.author || extractedAuthor || "—"
                                        },
                                        dataType: "json",
                                        success: function (res) {
                                            if (res.status === 1 && res.data) {
                                                window.open(res.data, "_blank");
                                            } else {
                                                alert(res.message || "Cannot open book.");
                                            }
                                        },
                                        error: function () {
                                            alert("Server error while opening the book.");
                                        }
                                    });
                                });

                            } else {
                                alert(res.message || "Failed to load metadata");
                            }
                        },
                        error: function () {
                            alert("Server error while fetching metadata");
                        },
                        complete: function () {
                            $("#upload-spinner").addClass("hidden");
                        }
                    });

                } else if ($(this).hasClass("edit-btn")) {
                    openEditModal(bookId);

                } else if ($(this).hasClass("delete-btn")) {
                    if (!confirm("Are you sure you want to delete this book?")) return;

                    $.ajax({
                        url: base_url + "auth/action.php?action=deletemeta",
                        method: "POST",
                        data: { book_id: bookId },
                        dataType: "json",
                        beforeSend: function () {
                            $("#upload-spinner").removeClass("hidden"); // show spinner
                        },
                        success: function (res) {
                            if (res.status === 1) {
                                alert("Book deleted successfully");
                                loadMetadata();
                            } else {
                                alert(res.message || "Failed to delete book");
                            }
                        },
                        error: function () {
                            alert("Server error while deleting metadata");
                        },
                        complete: function () {
                            $("#upload-spinner").addClass("hidden"); // hide spinner
                        }
                    });
                }
            });


            // --- Edit Modal Logic ---
            function openEditModal(bookId) {
                $.ajax({
                    url: base_url + "auth/action.php?action=viewmeta",
                    method: "POST",
                    data: { book_id: bookId },
                    dataType: "json",
                    success: function (res) {
                        if (res.status !== 1) return alert(res.message || "Failed to fetch metadata");

                        const data = res.data;
                        const meta = data.metadata || {};

                        // Populate core fields
                        const $form = $("#editMetaForm");
                        $form.find("input[name='book_id']").val(bookId);
                        $form.find("input[name='title']").val(meta.title || '');
                        $form.find("input[name='author']").val(meta.author || '');
                        $form.find("input[name='isbn']").val(meta['prism:isbn'] || meta['pdfx:isbn'] || '');

                        // Populate Other Metadata table
                        const $tbody = $("#otherMetaTable tbody").empty();
                        for (let key in meta) {
                            addMetaRow(key, meta[key]);
                        }

                        $("#editMetaModal").show();
                    },
                    error: function () {
                        alert("Server error while fetching metadata");
                    }
                });
            }

            // Add new row
            function addMetaRow(key = '', value = '') {
                if (typeof value === 'object') value = JSON.stringify(value);
                $("#otherMetaTable tbody").append(`
                    <tr>
                        <td class="border px-2 py-1">
                            <input type="text" class="w-full border px-1 py-1 rounded" name="other_key[]" value="${key}">
                        </td>
                        <td class="border px-2 py-1">
                            <input type="text" class="w-full border px-1 py-1 rounded" name="other_value[]" value="${value}">
                        </td>
                        <td class="border px-2 py-1 text-center">
                            <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded remove-row">X</button>
                        </td>
                    </tr>
                `);
            }

            // Remove row
            $(document).on("click", ".remove-row", function () {
                $(this).closest("tr").remove();
            });

            // Add empty row button
            $("#addMetaRow").click(function () {
                addMetaRow();
            });

            $("#editMetaForm").submit(function (e) {
                e.preventDefault();

                const $form = $(this);
                const bookId = $form.find("input[name='book_id']").val();
                const title = $form.find("input[name='title']").val();
                const author = $form.find("input[name='author']").val();
                const isbn = $form.find("input[name='isbn']").val();

                // Build other metadata object
                const otherMeta = {};
                $("#otherMetaTable tbody tr").each(function () {
                    const key = $(this).find("input[name='other_key[]']").val();
                    const value = $(this).find("input[name='other_value[]']").val();
                    if (key.trim() !== '') otherMeta[key] = value;
                });

                const payload = { Title: title, Author: author, 'prism:isbn': { ISBN: isbn }, ...otherMeta };

                $.ajax({
                    url: base_url + "auth/action.php?action=editmeta",
                    method: "POST",
                    data: { book_id: bookId, metadata: JSON.stringify(payload) },
                    dataType: "json",
                    success: function (res) {
                        if (res.status === 1) {
                            alert("Metadata updated successfully");
                            $("#editMetaModal").hide();
                            $form.trigger('reset');   // reset form fields
                            $("#otherMetaTable tbody").empty(); // clear other metadata rows
                            loadMetadata();
                        } else {
                            alert(res.message || "Failed to update metadata");
                        }
                    },
                    error: function () {
                        alert("Server error while updating metadata");
                    }
                });
            });


        });



    </script>