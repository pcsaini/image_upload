<html>
<head>
    <title>Image-Upload</title>
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <script src="js/jquery.min.js" rel="script" type="text/javascript"></script>
    <script src="js/jquery.form.js" rel="script" type="text/javascript"></script>
    <script>
        $(document).on('change', '#image_upload_file', function () {
            var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

            $('#image_upload_form').ajaxForm({
                beforeSend: function() {
                    progressBar.fadeIn();
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                success: function(html, statusText, xhr, $form) {
                    obj = $.parseJSON(html);
                    if(obj.status){
                        var percentVal = '100%';
                        bar.width(percentVal)
                        percent.html(percentVal);
                        $("#imgArea>img").prop('src',obj.image);
                    }else{
                        alert(obj.error);
                    }
                },
                complete: function(xhr) {
                    progressBar.fadeOut();
                }
            }).submit();

        });
    </script>
</head>
<body>
<h1 style="text-align: center;">Image Upload using ajax</h1>
<div id="imgContainer">
    <form enctype="multipart/form-data" action="image_process.php" method="post" name="image_upload_form" id="image_upload_form">
        <div id="imgArea"><img src="upload/default.jpg">
            <div class="progressBar">
                <div class="bar"></div>
                <div class="percent">0%</div>
            </div>
            <div id="imgChange"><span>Change Photo</span>
                <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
            </div>
        </div>
    </form>
</div>
</body>

</html>