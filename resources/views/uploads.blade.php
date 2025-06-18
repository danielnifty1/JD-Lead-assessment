<html>
    <body>
        <form action="upload" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file">
            <input type="submit" value="Upload">
        </form> 
    </body>
</html> 