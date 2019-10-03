<div class="container">
  <h2>Products List</h2>
         
  <table class="table">
    <thead>
      <tr>
        <th>Product Id</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>#1</td>
        <td>Pizza</td>
        <td>Pizza</td>
        <td>
            <button type="button" class="btn btn-default" ><a href="<?= \Moly\Supports\Facades\Route::of('productEdit', ["veg"]) ?>">Edit</a></button>
            <button type="button" class="btn btn-primary">Delete</button>
        </td>
      </tr>
      <tr>
        <td>#2</td>
        <td>Burger</td>
        <td>Burger</td>
        <td>
            <button type="button" class="btn btn-default" ><a href="<?= \Moly\Supports\Facades\Route::of('productEdit', ["veg"]) ?>">Edit</a></button>
            <button type="button" class="btn btn-primary">Delete</button>
        </td>
      </tr>
      <tr>
        <td>#3</td>
        <td>Sandwich</td>
        <td>Sandwich</td>
        <td>
            <button type="button" class="btn btn-default"><a href="<?= \Moly\Supports\Facades\Route::of('productEdit', ["sandwich"]) ?>">Edit</a></button>
            <button type="button" class="btn btn-primary">Delete</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>