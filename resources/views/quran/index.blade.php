<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Surah</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Amiri&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
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
            margin-bottom: 24px;
            color: #2c3e50;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 16px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }
        a {
            text-decoration: none;
            color: #2980b9;
            font-size: 1.1rem;
            transition: color 0.2s;
        }
        a:hover {
            color: #e67e22;
        }
        .ayah-count {
            color: #888;
            font-size: 0.95rem;
            margin-left: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Surah</h1>
        <ul>
            @foreach ($surahs as $surah)
                <li>
                    <a href="{{ route('frontend.quran.show', ['id' => $surah['id']]) }}">
                        {{ $surah['name'] }}
                    </a>
                    <span class="ayah-count">({{ $surah['ayahs_count'] }} ayat)</span>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>