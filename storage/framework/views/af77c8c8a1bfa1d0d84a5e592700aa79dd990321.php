<!DOCTYPE html>
<html>
<head>
    <title>CSRF Token Mismatch</title>
</head>
<body>
    <div>
        <h1>CSRF Token Mismatch</h1>
        <p>The security token mismatched. Please refresh the page and try again.</p>
    </div>
    <script>
        window.location.href = '<?php echo e(url("/logout")); ?>';
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/errors/419.blade.php ENDPATH**/ ?>