<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <?php
    $item = $this->get('product');
    ?>

    <input type="hidden" name="id" value="<?php echo $item['id'] ?>">
    <label for="sku">sku</label>
    <input type="text" name="sku" value="<?php echo $item['sku'] ?>">

    <label for="name">name</label>
    <input type="text" name="name" value="<?php echo $item['name'] ?>">

    <label for="price">price</label>
    <input type="text" name="price" value="<?php echo $item['price'] ?>">

    <label for="qty">qty</label>
    <input type="text" name="qty" value="<?php echo $item['qty'] ?>">

    <label for="description">description</label>
    <input type="text" name="description" value="<?php echo $item['description'] ?>">


    <input type="submit" value="Submit">


</form>
