<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
      <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
       
    <style>
        .quran {
            text-align: right;
            display: -moz-box;
            flex-direction: row;
            flex-wrap: auto;   
            width: 1840px;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            

        } 
         
    </style>
</head>
<body>
 <div class="container">
       <div class="quran">
    @foreach ($ayahs as $ayah)
        <p style="font-size: 1.5rem">{{ $ayah->text_arab }}  ({{ $ayah->ayah_number }})</p>
        <p>{{ $ayah->translation_id }}</p>
        <br>
    @endforeach
    </div>
 </div>
</body>
</html>