<?php
/**
 * @var \Dinet\Monitoring\FoodListCtrl $FoodPagination
 * @var \Dinet\Monitoring\Food $Food
 * @var string $nonceNameAddEatenFood
 */

?>
<section class="dinet_add_eaten_food">
    <header>
        <h2>J'ai mangé ...</h2>
    </header>
    <input type="text" placeholder="Rechercher..." id="search_bar" class="search_bar">
    <table class="widefat striped table_food" id="table_food" data-page="0">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Quantité (g)</th>
            <th>Date</th>
            <th>Niveau de faim</th>
            <th colspan="2" style="text-align: center">
                Émotions
                <ul style="display: flex;justify-content: space-around">
                    <li>Avant</li>
                    <li>Après</li>
                </ul>
            </th>
            <th></th>
        </tr>
        </thead>

		<?php foreach ( $FoodPagination->getFoodList()->getList() as $Food ): ?>
            <tr class="food_item">
                <td class="food_description"><?= $Food->getDesignation() ?></td>
                <td><?= $Food->getGroup() ?></td>
                <td>
                    <input type="number" class="quantity"/>
                </td>
                <td style="display: flex">
                    <input type="date" name="eat_date" value="<?= date( 'Y-m-d') ?>"/>
                    <input type="time" name="eat_hour" value="<?= date( 'H:i') ?>"/>
                </td>
                <td>
                    <select name="hungry_level">
                        <option>Niveau de faim</option>
                        <?php for( $i = 1; $i <= 10; $i++ ): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
                <td><input type="text" name="feeling_before" placeholder="Émotions avant"></td>
                <td><input type="text" name="feeling_after" placeholder="Émotions après"></td>
                <td>
                    <input type="button" value="Ajouter" class="add_input"/>
                    <input type="hidden" id="food-id" name="food-id" value="<?= $Food->getId() ?>">
                </td>
            </tr>
			<?php endforeach; ?>
    </table>
    <button id="prev_food" class="pagination_button">Précédent</button>
    <button id="next_food" class="pagination_button">Suivant</button>
</section>
