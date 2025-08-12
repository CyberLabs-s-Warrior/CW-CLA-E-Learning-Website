<style>
    .judul {
        margin-bottom: 10px;
    }

    .comment-section textarea {
        width: 100%;
        height: 80px;
        padding: 10px;
        resize: vertical;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .comment-section button {
        padding: 8px 16px;
        background-color: #065fd4;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .comment {
        display: flex;
        align-items: flex-start;
        margin-top: 20px;
        padding: 10px;
        border-radius: 8px;
        /* background-color: #f9f9f9; */
    }

    .comment img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .comment-body {
        display: flex;
        flex-direction: column;
        /* background-color: #f9f9f9; */
    }

    .comment-name {
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .comment-text {
        font-size: 14px;
        color: #333;
    }
</style>

<div class="comment-section">
    <h2>Comments</h2>
    <form id="comment-form">
        <textarea id="comment-input" placeholder="Add a public comment..." required></textarea>
        <button type="submit">Comment</button>
    </form>

    <p class="judul">Semua Komentar</p>
    <div id="comment-list">
        <div class="comment">
            <img src="https://i.pravatar.cc/150?img=11" alt="Avatar">
            <p class="comment-name">Nina Zahra</p>
            {{-- <div class="comment-body"> --}}
            <p class="comment-text">Materi kursusnya keren banget! 🔥</p>
            {{-- </div> --}}
        </div>
    </div>
</div>
