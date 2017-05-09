        <main class="dinet_add_food">
            <h2>Ajouter un aliment</h2>
            <form action="<?= admin_url('admin-post.php?action=post_add_food') ?>" method="post">
                <div class="dinet_add_new_food">
                   <div>
                        <div class="dinet_info_add_new_food">
                            <label for="food_category">Catégorie</label>
                            <select name="category" id="food_category">
                            <?php
                            foreach ($food->get_categories() as $category):
                            ?>
                                <option value='<?= $category[0] ?>'><?= $category[0] ?></option>;
                            <?php
                            endforeach;
                            ?>
                            </select>
                        </div>
                    <?php
                    foreach($food->get_all_info() as $key => $info):
                    ?>
                    <div class="dinet_info_add_new_food">
                        <label for="<?= $key ?>"><?= $info ?></label>
                        <input type="text" name="<?= $key ?>" id="<?= $key ?>">
                    </div>
                    <?php
                    endforeach;
                    ?>
                    </div>
                </div>
                <input type="submit" value="Ajouter" class="button-primary">
            </form>
        </main>
    </body>
</html>
