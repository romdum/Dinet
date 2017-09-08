<section class="dinet_last_food">
    <header>
        <h2>Dernières consommations</h2>
    </header>
    <table class="dinet_last_food_table widefat striped" id="table_last_food">
        <thead>
            <tr>
                <th>Date</th>
                <th>Nom</th>
                <th>Quantité (g)</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="dinet_last_food_table_body">
            <?php foreach ( $FoodPagination->get_last_eaten_food( $Patient->get_user_id(), $limit ) as $food ): ?>
                <tr class="">
                    <td><?= date_format( date_create( $food['eat_date'] ), 'd-m-Y' ) ?></td>
                    <td><?= $food['Désignation'] ?></td>
                    <td><?= $food['quantity'] ?></td>
                    <td>
                        <button type="button" class="btn-delete" data-food-user-id="<?= $food['id'] ?>" name="delete-food"><span class="dashicons dashicons-trash"></span></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
