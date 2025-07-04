<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1.0">
    <title>Delete Confirmation Modal</title>
    <link href=
"https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
          rel="stylesheet">
    <link href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" 
          rel="stylesheet">
    <style>
        .modal-content {
            border: 4px solid #10B981;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center 
             justify-center h-screen">
    <button id="showModalBtn"
            class="bg-red-500 text-white px-4 py-2 
                   rounded-full transition 
                   duration-300 hover:bg-red-600">
        Show Delete Confirmation
    </button>
    <div id="modal" class="modal-container hidden">
        <div class="modal-content bg-white 
                    shadow-lg rounded-lg p-8">
            <h2 class="text-lg font-semibold
                       text-gray-800 mb-4">
                Delete Confirmation
            </h2>
            <p class="confirmation-message 
                      text-gray-600 mb-6">
                Apakah kamu ingin menghapus item ini?
            </p>
            <div class="button-container flex justify-center">
                <button id="cancelBtn"
                        class="bg-gray-300 text-gray-700 px-4 
                               py-2 rounded-full mr-4 
                               hover:bg-gray-400 transition
                               duration-300">
                    Cancel
                </button>
                <button id="deleteBtn"
                        class="bg-red-500 text-white px-4 
                               py-2 rounded-full hover:bg-red-600
                               transition duration-300">
                    Delete
                </button>
            </div>
        </div>
    </div>
    <div id="message" class="hidden bg-green-500 text-white
                             px-4 py-2 rounded-full mt-4">
        Item deleted successfully!
    </div>
    <script>
        const modal = document.getElementById('modal');
        const message = document.getElementById('message');
        const showModalBtn = document.getElementById('showModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const deleteBtn = document.getElementById('deleteBtn');
        function showModal() {
            modal.classList.remove('hidden');
        }
        function hideModal() {
            modal.classList.add('hidden');
        }
        function showMessage() {
            message.classList.remove('hidden');
            setTimeout(() => {
                message.classList.add('hidden');
            }, 3000);
        }
        showModalBtn.addEventListener('click', () => {
            showModalBtn.classList.add('hidden');
            modal.classList.remove('hidden');
        });
        cancelBtn.addEventListener('click', hideModal);
        deleteBtn.addEventListener('click', () => {
            hideModal();
            showMessage();
        });
    </script>
</body>

</html>
