<div class="row" id="movie-cover">
    <h1 class="text-uppercase">{{ $coverName }}</h1>
    @foreach ($movieCollection[$coverName] as $key => $item)
        <div class="col-md-3">
            <a href="/video/detail/{{ $key+1 }}" class="text-decoration-none text-dark">
                <img src="storage/pictures/one-piece.jpeg" alt="" style="width: 100%;"><br>
                <i class="bi bi-play-circle" hidden></i>
                <span>{{ $item["title"] }}</span>
            </a>
            <p>2024</p>
        </div>
    @endforeach
</div>