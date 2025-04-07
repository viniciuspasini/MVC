<?php $this->layout('template', ['title' => $title]) ?>
    
<h1>Login</h1>

<form action="/login" method="post">
    <input type="text" placeholder="email" name="email">
    <input type="text" placeholder="password" name="password">
    <button type="submit">login</button>
</form>