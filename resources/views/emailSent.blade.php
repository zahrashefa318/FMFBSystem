<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Email Sent</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    @if(session('status'))
      <div class="alert alert-success text-center">
        {{ session('status') }}
      </div>
    @else
      <div class="alert alert-info text-center">
        No status available.
      </div>
    @endif
     {{-- Back button --}}
  <a href="{{route('dashboard')}}" class="btn btn-sm btn-secondary btn-custom-purple">Back</a>
  </div>
</body>
</html>
