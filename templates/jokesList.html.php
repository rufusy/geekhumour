<h5><?=$category->name;?> jokes</h5>

<?php foreach ($jokes as $joke): ?>
    <blockquote>
        <p>
            <?=htmlspecialchars($joke->joketext, ENT_QUOTES, 'UTF-8')?>
            (by
            <a href="mailto:<?=htmlspecialchars($joke->getAuthor()->email, ENT_QUOTES, 'UTF-8');?>">
                <?= htmlspecialchars($joke->getAuthor()->name, ENT_QUOTES, 'UTF-8');?>
            </a>)
            on <?php 
                    $date = new DateTime($joke->jokedate);
                    echo $date->format('jS F Y');
                ?>
        </p>
    </blockquote>
<?php endforeach; ?>