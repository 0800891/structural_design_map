<!-- resources/views/translation.blade.php -->

<html>
<head>
    <meta charset='utf-8' />
</head>
<body>
    <h2>Translation Result</h2>
    
    <p hidden><strong>Original Text:</strong></p>
    <p hidden>{{ $sentence }}</p>

    <p><strong>Translated to {{ $target_lang }}:</strong></p>
    <p>{{ $translated_text }}</p>

    <a href="{{ url()->previous() }}">Go Back</a>
</body>
</html>