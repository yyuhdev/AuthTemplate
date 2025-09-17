@extends('template.default')

@section('content')
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            @if(session("message"))
            console.log('aura')
            success("{{ session("message") }}")
            @endif

            const fileInput = document.getElementById("fileInput");
            const dropZone = document.getElementById("dropZone");
            const fileList = document.getElementById("fileList");

            ["dragenter", "dragover"].forEach(evt =>
                dropZone.addEventListener(evt, e => {
                    e.preventDefault();
                    dropZone.style.backgroundColor = "rgba(63,63,70,0.3)";
                })
            );

            ["dragleave", "drop"].forEach(evt =>
                dropZone.addEventListener(evt, e => {
                    e.preventDefault();
                    dropZone.style.backgroundColor = "";
                })
            );

            dropZone.addEventListener("drop", e => {
                e.preventDefault();
                fileInput.files = e.dataTransfer.files;
                updateFileList();
            });

            fileInput.addEventListener("change", updateFileList);

            function updateFileList() {
                fileList.innerHTML = "";
                Array.from(fileInput.files).forEach((file, index) => {
                    const item = document.createElement("div");
                    item.classList.add("file-item");
                    item.innerHTML = `
                <span class="file-name">${file.name}</span>
                <button type="button" class="remove-btn">&times;</button>
            `;
                    item.querySelector(".remove-btn").addEventListener("click", () => {
                        removeFile(index);
                    });
                    fileList.appendChild(item);
                });
            }

            function removeFile(index) {
                const dt = new DataTransfer();
                Array.from(fileInput.files)
                    .filter((_, i) => i !== index)
                    .forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
                updateFileList();
            }
        });

        function err(message) {
            const errorEl = document.getElementById("alert")
            const errorText = document.getElementById("alert-text")

            errorText.innerText = message
            errorEl.style.display = "block";
            setTimeout(() => {
                errorEl.style.display = "none";
            }, 5000);
        }


        function success(message) {
            const errorEl = document.getElementById("success")
            const errorText = document.getElementById("success-text")

            errorText.innerText = message
            errorEl.style.display = "block";
            setTimeout(() => {
                errorEl.style.display = "none";
            }, 5000);
        }

        function closeErr() {
            const errorEl = document.getElementById("alert");
            errorEl.style.display = "none";
        }
    </script>

    <div class="alert" id="alert">
        <div class="alert-top">
            <div class="alert-top-left">
                <p class="alert-header">
                    <i class="fa-solid fa-triangle-exclamation"></i> Error
                </p>
            </div>
            <div class="alert-top-right">
                <i class="fa-solid fa-xmark close-button" onclick="closeErr()"></i>
            </div>
        </div>
        <p id="alert-text" class="alert-text">There has been an issue creating your Account!</p>
    </div>

    <div class="alert" id="success">
        <div class="alert-top">
            <div class="alert-top-left">
                <p class="success-header">
                    <i class="fa-solid fa-thumbs-up"></i> Info
                </p>
            </div>
            <div class="alert-top-right">
                <i class="fa-solid fa-xmark close-button" onclick="closeErr()"></i>
            </div>
        </div>
        <p id="success-text" class="alert-text">There has been an issue creating your Account!</p>
    </div>

    <div class="upload-card">
        <h2 class="upload-title">Upload File</h2>

        <form action="{{ route('file-upload') }}" method="post" enctype="multipart/form-data"
              class="upload-form" id="uploadForm">
            @csrf

            <div class="drop-zone" id="dropZone">
                <span>Drag file here</span>
                <span>or <label for="fileInput" class="browse-link">browse</label></span>
                <input type="file" name="file" id="fileInput" hidden>
            </div>

            <div class="file-list" id="fileList"></div>

            <button type="submit" class="upload-button">Upload</button>
        </form>
    </div>
@endsection
