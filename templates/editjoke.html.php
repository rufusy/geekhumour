<div style='margin-top:50px;' class="row">
    <?php if($user->id == $joke->authorid || $user->hasPermission(\Ninja\Ijdb\Entity\Author::EDIT_JOKES)):?> 
        <form class="col s12" action="/joke/update" method="post">
            <div class="row">
                <input type="hidden" name="joke[id]" value="<?=$joke->id ?? '';?>">
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="joke[joketext]" class="materialize-textarea">
                        <?=$joke->joketext ?? '';?>
                    </textarea>
                </div>
            </div>

            <p>Select categories for this joke:</p>
            <?php foreach ($categories as $category): ?>
                <p>
                    <label>
                        <?php if($joke->hasCategory($category->id)):?>
                            <input type="checkbox"  
                                    name="category[]" checked
                                    value="<?=$category->id;?>" />
                        <?php else:?>
                            <input type="checkbox"  
                                    name="category[]"
                                    value="<?=$category->id;?>" />
                        <?php endif;?>

                        <span><?=$category->name;?></span>
                    </label>
                </p>
            <?php endforeach; ?>

            <div class="row">
                <input class="btn waves-effect waves-light" type="submit" value="submit" name="submit">
            </div>
        </form>
    <?php else:?>
        <p>You may only edit jokes you posted!!</p>
    <?php endif;?>
</div>

