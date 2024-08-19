{{-- <div class="row d-md-none">    
  <div class="col-xl-12 col-md-12 mb-4 unit_title">
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> Owner</a></li>
        <?php $segments = ''; ?>
        @foreach(Request::segments() as $segment)
        <?php $segments .= '/'.$segment; ?>
        <li>
            <a href="{{ $segments }}" class="breadcrumb-item">{{$segment}}</a>
        </li>
        @endforeach
    </ol>
</div>
</div> --}}