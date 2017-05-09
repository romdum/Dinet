<section class="add_info">
    <header>
        <h2>Mes infos</h2>
    </header>
    <form action="<?= admin_url('admin-post.php?action=post_add_info') ?>" method="post">
        <div>
            <label for="taille">Taille</label>
            <input type="text" placeholder="Taille" name="taille" id="taille" value="<?= $Patient->get_height() ?>">
        </div>
        <div>
            <label for="poids">Poids</label>
            <input type="number" placeholder="Poids" name="poids" id="poids" value="<?= $Patient->get_weight() ?>">
        </div>
        <input type="submit" value="Enregistrer" class="save_info">
    </form>
</section>
