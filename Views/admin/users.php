<div class="container">
<h1 class="text-center my-5" >Gérer les utilisateurs</h1>

<table class="table table-striped">
    <thead>
        <th>ID</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Email</th>
        <th>Supprimer</th>
        <th>Modifier</th>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->nom ?></td>
                <td><?= $user->prenom ?></td>
                <td><?= $user->email ?></td>
                <td><a href="/admin/supprimeUser/<?= $user->id ?>" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a></td>
                <td><a href="/admin/modifierUser/<?= $user->id ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>   
</table>
</div>

