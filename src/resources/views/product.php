<?php $this->layout('template', ['title' => $title, 'product' => $product]) ?>

<h1>Products</h1>

<?php
    if ($product){
        ?>
        <h3><?=$product?></h3>
        <?php

    }else{
        ?>
        <ul>
            <li><a href="/product/mouse">Mouse</a></li>
            <li><a href="/product/teclado">Teclado</a></li>
            <li><a href="/product/monitor">Monitor</a></li>
        </ul>
        <?php
    }
?>