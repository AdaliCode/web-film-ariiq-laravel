@extends('../layout.main')
@section('title', "AFLIX | $title")
@section('container')
  <div class="row" id="info-video">
    {{-- <figure class="col-3">
        <img src="img/<?= $data['data_video_streaming']["cover"] ?? 'attack-on-titan.jpg'; ?>" alt="" style="width: 100%;">
    </figure> --}}
    <section class="col">
      <h1>{{ $title }}</h1>
        {{-- <p><?= $data['vid_release']; ?> | <?= $data['data_video_streaming']["vid_type"]; ?> | Episode : <?= $data['data_video_streaming']["episodes"]; ?></p>
        <hr>
        <p id="synopsis"><?= $data['data_video_streaming']["synopsis"] ?></p>
        <hr>
        <p>Pemeran : <?= $data['data_video_streaming']["cast"]; ?></p> --}}
    </section>
</div>
<hr>
<figure class="row">
    <video width="75%" src="vid/video.mp4" controls>
    </video>
</figure>
@endsection