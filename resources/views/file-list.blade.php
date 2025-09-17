@extends('template.default')
@section('content')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("fileSearch");
            const fileItems = document.querySelectorAll(".file-item");

            searchInput.addEventListener("input", () => {
                const query = searchInput.value.toLowerCase();
                fileItems.forEach(item => {
                    const name = item.querySelector(".file-name").textContent.toLowerCase();
                    if (name.includes(query)) {
                        item.style.display = "";
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        });
    </script>

    <div class="file-table-container">
        <h3 class="file-list-title">Uploaded Files</h3>

        <input type="text" id="fileSearch" placeholder="Search files..." class="search-bar">

        <table class="file-table">
            <thead>
            <tr>
                <th>Filename</th>
                <th style="width: 60px;">Actions</th>
            </tr>
            </thead>
            <tbody>
                @forelse($files as $file)
                    <tr class="file-item">
                        <td class="file-name">{{ $file->name }}</td>
                        <td class="actions">
                            <a href="{{ route('file.download', $file->name) }}">
                                <i class="fa-solid fa-download download-btn"></i>
                            </a>
                            <form action="{{ route('file.delete') }}" method="POST" class="inline-form">
                                @csrf
                                <input type="hidden" name="filename" value="{{ $file->name }}">
                                <button type="submit" class="fa-solid fa-xmark delete-btn"></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="file-empty">No files uploaded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
