<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Order PDF</title>
</head>

<body>
    <!-- Embed the PDF in an invisible iframe -->
    <iframe id="pdfFrame" src="<?= $pdfUrl ?>" style="display:none;"></iframe>

    <script>
        window.onload = function () {
            const pdfFrame = document.getElementById('pdfFrame').contentWindow;
            pdfFrame.focus();
            pdfFrame.print();
        };
    </script>
</body>

</html>