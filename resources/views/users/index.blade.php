<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Impotar CSV</title>
</head>
<body>

    @session('success')
        <p style="color: #086">{!! $value !!}</p>        
    @endsession

    @session('error')
        <p style="color: #f00">{!! $value !!}</p>        
    @endsession

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: #f00;"> {{ $error }}</p>
        @endforeach
    @endif

    <form action="{{route('user.import')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="file" name="file"  id="file" accept=".csv"><br><br>
        <button type="submit" id="filebtn">Impotar</button>

    </form>
    @foreach ($users as $user)
        {{ $user->id }}
    @endforeach

</body>
</html>