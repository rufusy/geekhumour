
<div class="row">
    <form class="col s12" action="" method="post">
        <div class="row">
            <input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? '';?>">
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea name="joke[joketext]" class="materialize-textarea">
                    <?=$joke['joketext'] ?? '';?>
                </textarea>
            </div>
        </div>
        <div class="row">
            <input class="btn waves-effect waves-light" type="submit" value="submit" name="submit">
        </div>
    </form>
</div>