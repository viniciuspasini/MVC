<?php $this->layout('template', ['title' => $title]) ?>
    
<h1>Login</h1>

<form action="/user/2" method="post">

    <?= csfr() ?>
    <?= method('DELETE') ?>

    <input type="text" placeholder="email" name="email">
    <?= flash('email') ?>
    <br><br>

    <input type="text" placeholder="password" name="password">
    <?= flash('password') ?>
    <br><br>

     <button type="submit">login</button>
</form>