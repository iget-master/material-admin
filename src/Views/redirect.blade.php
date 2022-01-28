<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="2;url={!! $url !!}" />
    <title>You are being redirected</title>
</head>
<body>
<script language="JavaScript">
    window.location="{!! $url !!}"";
</script>

<noscript>
    If you are not redirected automatically, click <a href="{!! $url !!}">here</a>.
</noscript>
</body>
</html>