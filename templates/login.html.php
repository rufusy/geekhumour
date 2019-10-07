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
                <input id="email" type="email" class="validate" name="email">
                <label for="email">Email</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="password" type="password" class="validate" name="password">
                <label for="password">Password</label>
            </div>
        </div>
        <div class="row">
            <input class="btn waves-effect waves-light" type="submit" value="login" name="submit">
        </div>
        <div class="row">
            <p>Don't have an account? <a href="/author/register">Click here to register an account</a></p>
        </div>
    </form>
</div>