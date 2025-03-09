<div class="modal fade" id="addPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="img/post.jpg" id="post-image-preview" class="post-image-preview w-100 rounded border">
        <form method="post" action="php/addPost.php?addPost" enctype="multipart/form-data">
          <div class="my-3">
            <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-primary rounded-2 btn-upload ">
                Upload Photo
                <input class="form-control" type="file" name="post_image" id="select-post-image">
              </button>
            </div>
          </div>
          

          <div class="mb-3">
            <label for="caption" class="form-label">Say Something</label>
            <textarea class="form-control textarea rounded-3" name="caption" id="caption" rows="4"></textarea>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Post</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="bootstrap/js/script.js?v=<?= time() ?>"></script>
</body>

</html>
