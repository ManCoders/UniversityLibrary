<h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6 border-b dark:border-gray-700 pb-2">
    Metadata Management Overview
</h1>

<!-- Tabs for Adding Metadata / Dashboard -->
<div class="mb-6 border-b border-gray-200 dark:border-gray-700">
    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
        <button id="tab-dashboard"
            class="tab-button border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Metadata Dashboard
        </button>
        <button id="tab-add-metadata"
            class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Add New Metadata
        </button>
        <button id="tab-metadata-table"
            class="tab-button border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Metadata Table
        </button>
    </nav>
</div>

<!-- Tab Contents -->
<div id="tab-content">
    <!-- Metadata Dashboard -->
    <div id="dashboard-content" class="tab-panel">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-indigo-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Metadata Items</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">4,289</p>
                <p class="text-xs text-green-500 mt-2">↑ 12.5% this month</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-emerald-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New Metadata Entries</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">1,024</p>
                <p class="text-xs text-red-500 mt-2">↓ 3.1% this month</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Approvals</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">14</p>
                <p class="text-xs text-yellow-500 mt-2">Last updated 5 mins ago</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Errors / Conflicts</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-1">3</p>
                <p class="text-xs text-red-500 mt-2">Action required</p>
            </div>
        </div>

        <!-- Recent Metadata Activity -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mt-8">
            <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-100">Recent Metadata Activity</h2>
            <div class="space-y-3">
                <p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                    Metadata 'Product Catalog V3' was added.
                    <span class="float-right text-xs text-gray-400 dark:text-gray-500">2 min ago</span>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                    Metadata 'Research Paper 2025' was updated.
                    <span class="float-right text-xs text-gray-400 dark:text-gray-500">1 hour ago</span>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 border-b dark:border-gray-700 pb-1">
                    Metadata 'Book Catalog' approval completed.
                    <span class="float-right text-xs text-gray-400 dark:text-gray-500">3 hours ago</span>
                </p>
            </div>
        </div>

        <!-- Extended Metadata Section -->
        <div class="mt-12 p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">Extended Metadata Tools</p>
            <p class="mt-4 text-gray-500 dark:text-gray-400">
                Use this section for metadata reports, advanced tools, or insights.
            </p>
            <div
                class="h-[60vh] bg-gray-50 dark:bg-gray-700 mt-4 rounded-lg flex items-center justify-center text-gray-400 dark:text-gray-500 text-sm border-2 border-dashed dark:border-gray-600">
                Placeholder for Metadata Charts/Tables
            </div>
        </div>
    </div>

    <!-- Add New Metadata Form -->
    <div id="add-metadata-content" class="tab-panel hidden">
        <!-- Section: Folder Management -->
        <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Add New Metadata</h2>
            <div class="mb-1">
                <!-- Placeholder for Folder Management (Optional) -->
            </div>
        </div>
        <form class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
            <!-- Section: Metadata Entry Form -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                <!-- Left Column (File Upload + Auto-fill Metadata) -->
                <div class="flex flex-col justify-start">
                    <div class="border p-4 rounded-md">
                        <!-- Book Cover Image Section -->
                        <div class="mb-2 text-center">
                            <img id="auto-book-cover-img" src="../../../assets/image/library.png"
                                alt="Sample Book Cover" class="w-32 h-32 object-cover mx-auto mb-2" />
                            <p class="text-sm text-gray-500 dark:text-gray-400">Sample Book Cover</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Upload your book cover image here.
                            </p>

                            <!-- File Upload for Metadata -->
                            <input type="file" id="auto-metadata-file-upload"
                                class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full mb-2"
                                accept=".pdf">

                            <!-- Manual Metadata Fields (for user input) -->
                            <input type="text" id="auto-book-title" placeholder="Metadata Title"
                                class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full mb-2">
                            <textarea id="auto-book-description" placeholder="Metadata Description"
                                class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full"
                                rows="3"></textarea>
                            <input type="text" id="auto-author" placeholder="Author"
                                class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">
                            <input type="text" id="auto-publisher" placeholder="Publisher"
                                class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">
                            <input type="text" id="auto-isbn" placeholder="ISBN"
                                class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">
                            <input type="text" id="auto-category" placeholder="Category"
                                class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">

                            <!-- Additional Metadata Fields -->
                            <div id="auto-book-fields" class="grid grid-cols-1 gap-2">
                                <input type="text" id="auto-academic-year" placeholder="Academic Year"
                                    class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                                <input type="text" id="auto-course-name" placeholder="Course Name (if applicable)"
                                    class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                                <input type="text" id="auto-course-code" placeholder="Course Code (if applicable)"
                                    class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                                <input type="text" id="auto-keywords" placeholder="Keywords (comma separated)"
                                    class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                                <input type="date" id="auto-publication-date" placeholder="Publication Date"
                                    class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                                <input type="text" id="auto-document-type"
                                    placeholder="Document Type (Research Paper, Thesis, etc.)"
                                    class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                                <button type="submit"
                                    class="mt-2 mx-auto bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
                                    Save Metadata
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Manual Metadata Entry) -->
                <div class="border p-4 rounded-md">
                    <div class="text-center">
                        <img id="manual-cover-img" src="../../../assets/image/library.png" alt="Sample Book Cover"
                            class="w-32 h-32 object-cover mx-auto mb-2" />
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sample Book Cover</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Upload your book cover image here.</p>

                        <input type="file" id="manual-cover-upload"
                            class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full mb-2"
                            accept="image/*">
                    </div>

                    <!-- Manual Metadata Fields -->
                    <input type="text" id="manual-title" placeholder="Metadata Title"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full mb-2">
                    <textarea id="manual-description" placeholder="Metadata Description"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full" rows="3"></textarea>
                    <input type="text" id="manual-author" placeholder="Author"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">
                    <input type="text" id="manual-publisher" placeholder="Publisher"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">
                    <input type="text" id="manual-isbn" placeholder="ISBN"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">
                    <input type="text" id="manual-category" placeholder="Category"
                        class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm mb-2">

                    <div id="manual-fields" class="grid grid-cols-1 gap-2">
                        <input type="text" id="manual-academic-year" placeholder="Academic Year"
                            class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                        <input type="text" id="manual-course-name" placeholder="Course Name (if applicable)"
                            class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                        <input type="text" id="manual-course-code" placeholder="Course Code (if applicable)"
                            class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                        <input type="text" id="manual-keywords" placeholder="Keywords (comma separated)"
                            class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                        <input type="date" id="manual-publication-date" placeholder="Publication Date"
                            class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                        <input type="text" id="manual-document-type"
                            placeholder="Document Type (Research Paper, Thesis, etc.)"
                            class="p-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 w-full text-sm">
                        <button type="submit"
                            class="mt-2 mx-auto bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
                            Save Metadata
                        </button>
                    </div>
                </div>



            </div>

        </form>
    </div>

    <script>
        // --- Handle file upload for auto-fill metadata (Left Column) ---
        document.getElementById('auto-metadata-file-upload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    try {
                        const metadata = JSON.parse(e.target.result); // assuming it's JSON metadata
                        document.getElementById('auto-book-fields').classList.remove('hidden');

                        // Fill in metadata fields
                        document.getElementById('auto-book-title').value = metadata.title || '';
                        document.getElementById('auto-book-description').value = metadata.description || '';
                        document.getElementById('auto-author').value = metadata.author || '';
                        document.getElementById('auto-publisher').value = metadata.publisher || '';
                        document.getElementById('auto-isbn').value = metadata.isbn || '';
                        document.getElementById('auto-category').value = metadata.category || '';

                        // Fill additional metadata
                        document.getElementById('auto-academic-year').value = metadata.academicYear || '';
                        document.getElementById('auto-course-name').value = metadata.courseName || '';
                        document.getElementById('auto-course-code').value = metadata.courseCode || '';
                        document.getElementById('auto-keywords').value = Array.isArray(metadata.keywords)
                            ? metadata.keywords.join(', ')
                            : (metadata.keywords || '');
                        document.getElementById('auto-publication-date').value = metadata.publicationDate || '';
                        document.getElementById('auto-document-type').value = metadata.documentType || '';
                    } catch (error) {
                        console.error('Invalid JSON file:', error);
                        alert('Invalid metadata file. Please upload a valid JSON file.');
                    }
                };
                reader.readAsText(file);
            }
        });

        // --- Handle image upload preview (reusable function) ---
        function handleImageUpload(inputId, imgId) {
            const inputEl = document.getElementById(inputId);
            if (!inputEl) return;

            inputEl.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const imgEl = document.getElementById(imgId);
                        if (imgEl) imgEl.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Please upload a valid image file.');
                }
            });
        }

        // Initialize image upload handlers
        handleImageUpload('manual-cover-upload', 'manual-cover-img');
        handleImageUpload('auto-metadata-file-upload', 'auto-book-cover-img');
    </script>




    <!-- jQuery Tab Script -->
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

            // Initial tab
            activateTab('#tab-dashboard', '#dashboard-content');

            $('#tab-dashboard').click(function () { activateTab('#tab-dashboard', '#dashboard-content'); });
            $('#tab-add-metadata').click(function () { activateTab('#tab-add-metadata', '#add-metadata-content'); });
            $('#tab-metadata-table').click(function () { activateTab('#tab-metadata-table', '#metadata-table-content'); });

            // Show/hide fields based on category selection
            $('#metadata-category').change(function () {
                var category = $(this).val();

                // Hide all dynamic fields first
                $('#book-fields').addClass('hidden');
                $('#journal-fields').addClass('hidden');
                $('#article-fields').addClass('hidden');
                $('#research-docs-fields').addClass('hidden');

                // Show fields based on selected category
                if (category === 'books') {
                    $('#book-fields').removeClass('hidden');
                } else if (category === 'journals') {
                    $('#journal-fields').removeClass('hidden');
                } else if (category === 'articles') {
                    $('#article-fields').removeClass('hidden');
                } else if (category === 'research_docs') {
                    $('#research-docs-fields').removeClass('hidden');
                }
            });
        });
    </script>



    <!-- Metadata Table -->
    <div id="metadata-table-content" class="tab-panel hidden">
        <table
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl shadow-lg text-xs">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        ID</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Title</th>
                    <th
                        class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Category</th>
                    <th
                        class="px-4 py-2 text-center font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Example Metadata Item -->
                <tr>
                    <td class="px-4 py-2">1</td>
                    <td class="px-4 py-2">Product Catalog V3</td>
                    <td class="px-4 py-2">Catalog</td>
                    <td class="px-2 py-2 text-center space-x-1">
                        <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs">View</button>
                        <button
                            class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 text-xs">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<!-- jQuery Tab Script -->
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

        // Initial tab
        activateTab('#tab-dashboard', '#dashboard-content');

        $('#tab-dashboard').click(function () { activateTab('#tab-dashboard', '#dashboard-content'); });
        $('#tab-add-metadata').click(function () { activateTab('#tab-add-metadata', '#add-metadata-content'); });
        $('#tab-metadata-table').click(function () { activateTab('#tab-metadata-table', '#metadata-table-content'); });
    });
</script>