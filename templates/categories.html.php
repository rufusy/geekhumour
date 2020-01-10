<p><?=$totalCategories;?> categories of jokes have been submitted to this database.</p>
<?php foreach ($categories as $category): ?>
    <blockquote>
        <p>
            <?=htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8')?>
            <a href="/category/edit?id=<?=$category->id;?>">Edit</a>
            <form action="/category/delete" method="POST">
                <input type="hidden" name="id" value="<?=$category->id;?>">
                <input type="submit" value="Delete">
            </form>
        </p>
    </blockquote> 
<?php endforeach; ?>