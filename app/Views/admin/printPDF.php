<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Order PDF</title>
</head>

<body>
    <iframe id="pdfFrame" src="data:application/pdf;base64,<?= $pdfBase64 ?>" style="display:none;"></iframe>

    <script>
        window.onload = function () {
            const pdfFrame = document.getElementById('pdfFrame').contentWindow;
            pdfFrame.focus();
            pdfFrame.print(); 
        };
    </script>
</body>

</html>