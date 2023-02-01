<style>
.image_container {
    height: 120px;
    width: 200px;
    border-radius: 6px;
    overflow: hidden;
    margin: 10px;
}
.image_container img {
    height: 100%;
    width: auto;
    max-width: 170px;
    object-fit: cover;
}
.image_container span {
    top: -6px;
    right: 8px;
    color: red;
    font-size: 28px;
    font-weight: normal;
    cursor: pointer;
}
</style>


<body>
    <div class="container mt-3 w-100">
        <div class="card shadow-sm w-100">
            <div class="card-header d-flex justify-content-between">
                <h4>Preview Multiple Images</h4>
                <form class="form" action="../upload.php" method="post" id="form" enctype="multipart/form-data">                    
                    <input type="text" name="id" name="id" value="<?php echo date('dmY').rand(); ?>">
                    <input type="file" name="image[]" id="image" multiple onchange="image_select()">
                    <button class="btn btn-sm btn-primary" name="submit" type="submit">Submit</button>
                </form>
            </div>
            <div class="card-body d-flex flex-wrap justify-content-start" id="container">

            </div>
        </div>
    </div>
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    var images = [];
      function image_select() {
          var image = document.getElementById('image').files;
          for (i = 0; i < image.length; i++) {
            images.push({
                "name" : image[i].name,
                "url" : URL.createObjectURL(image[i]),
                "file" : image[i],
            })
          }
          document.getElementById('container').innerHTML = image_show();
      }

      function image_show() {
          var image = "";
          images.forEach((i) => {
             image += `<div class="image_container d-flex justify-content-center position-relative">
                  <img src="`+ i.url +`" alt="Image">
                  <span class="position-absolute" onclick="delete_image(`+ images.indexOf(i) +`)">&times;</span>
              </div>`;
          })
          return image;
      }
      function delete_image(e) {
        images.splice(e, 1);
        document.getElementById('container').innerHTML = image_show();

        const dt = new DataTransfer()
        const input = document.getElementById('image')
        const { files } = input

        for (let i = 0; i < files.length; i++) {
            const file = files[i]
            if (e !== i)
            dt.items.add(file);
        }

        input.files = dt.files;
        console.log(document.getElementById('image').files);


        $("#form").submit(function(e) {
            // console.log(input.files);
            // exit();
            // e.preventDefault();
            let formData = new FormData(this);
            // let formData = document.getElementById('image').files;
            // console.log(formData);
        
            $.ajax({
                url: "../upload.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                
            });
        });
      }
</script>
</body>

<?php
if (isset($_POST['submit'])) {
    $images = $_FILES['image'];
    $id = $_POST['id'];
    echo $id."<pre>";
    print_r($images);
    exit();
    
}    
?>
