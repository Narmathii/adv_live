<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script>
        <?php if (isset($payment_successful) && $payment_successful === true): ?>
            window.location.href = "<?= base_url('success'); ?>";
        <?php endif; ?>
    </script>
</body>

</html>