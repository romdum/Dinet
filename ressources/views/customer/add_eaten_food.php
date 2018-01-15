<section class="dinet_add_eaten_food">
    <header>
        <h2>J'ai mangé ...</h2>
    </header>
    <input type="text" placeholder="Rechercher..." id="search_bar" class="search_bar">
    <table class="widefat striped" id="table_food" data-page="0">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Quantité (g)</th>
        </tr>
        </thead>

		<?php foreach ( $FoodPagination->get_food() as $Food ): ?>
            <tr class="food_item">
                <td><?= $Food->get_designation() ?></td>
                <td><?= $Food->get_groupe() ?></td>
                <td>
                    <input type="number" class="quantity">
                    <input type="button" value="+" data-food-id="<?= $Food->get_id() ?>" class="add_input">
                </td>
            </tr>
			<?php endforeach; ?>
    </table>

    <button id="prev_food" class="pagination_button">Précédent</button>
    <button id="next_food" class="pagination_button">Suivant</button>
</section>
</main>
<div class="toast_add_eaten_food" id="dinet_toast" style="display: none;"></div>
