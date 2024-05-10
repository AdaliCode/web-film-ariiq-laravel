@extends('layout.main')
@section('title', "AFLIX")
@section('container')
    <div class="row" id="korean-drama-cover">
        <h1 class="text-uppercase">DRAMA KOREA</h1>
        {{-- <?php foreach ($data['data_video_streaming'] as $key => $dvs) : ?>
            <div class="col-md-3">
                <a href="<?= BASEURL; ?>/video/detail/<?= $dvs['id'] ?>" class="text-decoration-none text-dark">
                    <img src="<?= IMAGEURL; ?>/<?= $dvs["cover"] ?? 'attack-on-titan.jpg'; ?>" alt="" style="width: 100%;"><br>
                    <i class="bi bi-play-circle" hidden></i>
                    <span><?= $dvs['title']; ?></span>
                </a>
                <p><?= $dvs['vid_release']; ?></p>
            </div>
        <?php endforeach; ?> --}}
    </div>
    <h1 class="text-uppercase">Anime</h1>
    <h1 class="text-uppercase">Variety Show</h1>
{{-- <script src="<?= BASEURL; ?>/js/script.js"></script> --}}
@endsection