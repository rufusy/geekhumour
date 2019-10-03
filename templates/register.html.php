<div style='margin-top:50px;' class="row">

    <?php if(!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?=$error?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>

    <form action="" method="post" class="col s12">
        <div class="row">
            <div class="input-field col s12">
                <input id="name" type="text" class="validate" name="author[name]" value="<?=$author['name'] ?? ''?>">
                <label for="name">Name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="email" type="email" class="validate" name="author[email]" value="<?=$author['email'] ?? ''?>">
                <label for="email">Email</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="password" type="password" class="validate" name="author[password]" value="<?=$author['password'] ?? ''?>">
                <label for="password">Password</label>
            </div>
        </div>
        <div class="row">
            <input class="btn waves-effect waves-light" type="submit" value="register" name="submit">
        </div>
    </form>
</div>