        <main>
            <section class="patient_list">
                <header>
                    <h2>Liste des patients</h2>
                    <a href="<?= admin_url( 'user-new.php' ) ?>"><button type="button" name="button" class="button button-primary">Ajouter</button></a>
                </header>
                <table class="widefat striped">
                    <thead>
                        <th>Identifiant</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de création</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php foreach( get_users( ['role__not_in' => ['administrator']] ) as $user ):
                            $PatientCtrl = new \Dinet\Patient\PatientCtrl();
                            $PatientCtrl->setPatient( new \Dinet\Patient\Patient( $user->ID ) );
                            $PatientCtrl->load();
                            ?>
                            <tr>
                                <td><?= $PatientCtrl->getPatient()->getLogin() ?></td>
                                <td><?= $PatientCtrl->getPatient()->getFirstName() ?></td>
                                <td><?= $PatientCtrl->getPatient()->getLastName() ?></td>
                                <td><?= $PatientCtrl->getPatient()->getRegisteredDate() ?></td>
                                <td style="width:50px">
                                    <a href="<?= admin_url('admin.php?page=dinet_patient_record&patient_id='.$PatientCtrl->getPatient()->getUserId()) ?>"><span class="dashicons dashicons-welcome-write-blog"></span></a>
                                    <a href="<?= admin_url('admin.php?page=dinet_patient_settings&patient_id='.$PatientCtrl->getPatient()->getUserId()) ?>"><span class="dashicons dashicons-admin-generic"></span></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </body>
</html>
