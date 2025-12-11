<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surah</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Amiri&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 24px;
        }
        h1 {
            font-family: 'Roboto', Arial, sans-serif;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 12px;
            color: #2c3e50;
            text-align: center;
        }
        .info {
            text-align: center;
            color: #888;
            margin-bottom: 24px;
        }
        ol {
            padding-left: 0;
        }
        li {
            margin-bottom: 24px;
            background: #f9f9f9;
            border-radius: 8px;
            padding: 18px 16px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .arabic {
            font-family: 'Amiri', serif;
            font-size: 1.5rem;
            color: #222;
            direction: rtl;
            text-align: right;
            margin-bottom: 8px;
        }
        .translation {
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 1.05rem;
            color: #444;
            margin-bottom: 0;
        }
        .back {
            display: inline-block;
            margin-top: 24px;
            text-decoration: none;
            color: #2980b9;
            font-size: 1rem;
            border: 1px solid #2980b9;
            border-radius: 6px;
            padding: 6px 18px;
            transition: background 0.2s, color 0.2s;
        }
        .back:hover {
            background: #2980b9;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $surah['name'] }}</h1>
        <div class="info">Jumlah Ayat: {{ count($surah['ayahs']) }}</div>
        <ol>
            @foreach ($surah['ayahs'] as $ayah)
                <li>
                    <div class="arabic">{{ $ayah['text_arab'] }}</div>
                    <div class="translation">{{ $ayah['translation_id'] }}</div>
                </li>
            @endforeach
        </ol>
        <a class="back" href="{{ route('frontend.quran.index') }}">&#8592; Kembali ke daftar surah</a>
    </div>
</body>
</html>