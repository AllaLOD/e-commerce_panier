<h2 class="text-center my-5">Messages reçus</h2>

<div class="container">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Civilité</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Sujet</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($contacts as $contact): ?>
                <tr>
                    <td><?= $contact->id ?></td>
                    <td>
                        <?php if($contact->civilite == 1):  ?>
                        Madame
                        <?php else: ?>
                        Monsieur
                        <?php endif; ?>
                    </td>
                    <td><?= $contact->nom ?></td>
                    <td><?= $contact->email ?></td>
                    <td><?= $contact->objet ?></td>
                    <td><?= $contact->message ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>